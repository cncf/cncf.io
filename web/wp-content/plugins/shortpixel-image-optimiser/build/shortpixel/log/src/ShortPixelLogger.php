<?php
namespace ShortPixel\ShortPixelLogger;

  /*** Logger class
  *
  * Class uses the debug data model for keeping log entries.
  * Logger should not be called before init hook!
  */
 class ShortPixelLogger
 {
   static protected $instance = null;
   protected $start_time;

   protected $is_active = false;
   protected $is_manual_request = false;
   protected $show_debug_view = false;

   protected $items = array();
   protected $logPath = false;
   protected $logMode = FILE_APPEND;

   protected $logLevel;
   protected $format = "[ %%time%% ] %%color%% %%level%% %%color_end%% \t %%message%%  \t %%caller%% ( %%time_passed%% )";
   protected $format_data = "\t %%data%% ";

   protected $hooks = array();

	 private $logFile; // pointer resource to the logFile.
/*   protected $hooks = array(
      'shortpixel_image_exists' => array('numargs' => 3),
      'shortpixel_webp_image_base' => array('numargs' => 2),
      'shortpixel_image_urls' => array('numargs' => 2),
   ); // @todo monitor hooks, but this should be more dynamic. Do when moving to module via config.
*/

   // utility
   private $namespace;
   private $view;

   protected $template = 'view-debug-box';

   /** Debugger constructor
   *  Two ways to activate the debugger. 1) Define SHORTPIXEL_DEBUG in wp-config.php. Either must be true or a number corresponding to required LogLevel
   *  2) Put SHORTPIXEL_DEBUG in the request. Either true or number.
   */
   public function __construct()
   {
      $this->start_time = microtime(true);
      $this->logLevel = DebugItem::LEVEL_WARN;

      $ns = __NAMESPACE__;
      $this->namespace = substr($ns, 0, strpos($ns, '\\')); // try to get first part of namespace

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
      if (isset($_REQUEST['SHORTPIXEL_DEBUG'])) // manual takes precedence over constants
      {
        $this->is_manual_request = true;
        $this->is_active = true;

				// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
        if ($_REQUEST['SHORTPIXEL_DEBUG'] === 'true')
        {
          $this->logLevel = DebugItem::LEVEL_INFO;
        }
        else {
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
          $this->logLevel = intval($_REQUEST['SHORTPIXEL_DEBUG']);
        }

      }
      else if ( (defined('SHORTPIXEL_DEBUG') && SHORTPIXEL_DEBUG > 0) )
      {
            $this->is_active = true;
            if (SHORTPIXEL_DEBUG === true)
              $this->logLevel = DebugItem::LEVEL_INFO;
            else {
              $this->logLevel = intval(SHORTPIXEL_DEBUG);
            }
      }

      if (defined('SHORTPIXEL_DEBUG_TARGET') && SHORTPIXEL_DEBUG_TARGET || $this->is_manual_request)
      {
          if (defined('SHORTPIXEL_LOG_OVERWRITE')) // if overwrite, do this on init once.
            file_put_contents($this->logPath,'-- Log Reset -- ' .PHP_EOL);

      }

      if ($this->is_active)
      {
        /* On Early init, this function might not exist, then queue it when needed */
        if (! function_exists('wp_get_current_user'))
          add_action('init', array($this, 'initView'));
        else
         $this->initView();
      }

      if ($this->is_active && count($this->hooks) > 0)
          $this->monitorHooks();
   }

   /** Init the view when needed. Private function ( public because of WP_HOOK )
   * Never call directly */
   public function initView()
   {
     $user_is_administrator = (current_user_can('manage_options')) ? true : false;

     if ($this->is_active && $this->is_manual_request && $user_is_administrator )
     {
          $content_url = content_url();
          $logPath = $this->logPath;
          $pathpos = strpos($logPath, 'wp-content') + strlen('wp-content');
          $logPart = substr($logPath, $pathpos);
          $logLink = $content_url . $logPart;

         $this->view = new \stdClass;
         $this->view->logLink = $logLink;
         add_action('admin_footer', array($this, 'loadView'));
     }
   }

   public static function getInstance()
   {
      if ( self::$instance === null)
      {
          self::$instance = new ShortPixelLogger();
      }
      return self::$instance;
   }

   public function setLogPath($logPath)
   {
      $this->logPath = $logPath;
			$this->getWriteFile(true); // reset the writeFile here.
   }
   protected function addLog($message, $level, $data = array())
   {
  //   $log = self::getInstance();

     // don't log anything too low or when not active.
     if ($this->logLevel < $level || ! $this->is_active)
     {
       return;
     }

     // Force administrator on manuals.
     if ( $this->is_manual_request )
     {
        if (! function_exists('wp_get_current_user')) // not loaded yet
          return false;

        $user_is_administrator = (current_user_can('manage_options')) ? true : false;
        if (! $user_is_administrator)
          return false;
     }

     // Check where to log to.
     if ($this->logPath === false)
     {
       $upload_dir = wp_upload_dir(null,false,false);
       $this->logPath = $this->setLogPath($upload_dir['basedir'] . '/' . $this->namespace . ".log");
     }

     $arg = array();
     $args['level'] = $level;
     $args['data'] = $data;

     $newItem = new DebugItem($message, $args);
     $this->items[] = $newItem;

      if ($this->is_active)
      {
          $this->write($newItem);
      }
   }

   /** Writes to log File. */
   protected function write($debugItem, $mode = 'file')
   {
      $items = $debugItem->getForFormat();
      $items['time_passed'] =  round ( ($items['time'] - $this->start_time), 5);
      $items['time'] =  date('Y-m-d H:i:s', (int) $items['time'] );

      if ( ($items['caller']) && is_array($items['caller']) && count($items['caller']) > 0)
      {
          $caller = $items['caller'];
          $items['caller'] = $caller['file'] . ' in ' . $caller['function'] . '(' . $caller['line'] . ')';
      }

      $line = $this->formatLine($items);

			$file = $this->getWriteFile();

      // try to write to file. Don't write if directory doesn't exists (leads to notices)
      if ($file )
      {
				fwrite($file, $line);
//        file_put_contents($this->logPath,$line, FILE_APPEND);
      }
      else {
       // error_log($line);
      }
   }

	 protected function getWriteFile($reset = false)
	 {
		 	if (! is_null($this->logFile) && $reset === false)
			{
					return $this->logFile;
			}
			elseif(is_object($this->logFile))
			{
				fclose($this->logFile);
			}

			$logDir = dirname($this->logPath);
		  if (! is_dir($logDir) || ! is_writable($logDir))
			{
				error_log('ShortpixelLogger: Log Directory is not writable');
				$this->logFile = false;
				return false;
			}

			$file = fopen($this->logPath, 'a');
			if ($file === false)
			{
				 error_log('ShortpixelLogger: File could not be opened / created: ' . $this->logPath);
				 $this->logFile = false;
				 return $file;
			}

			$this->logFile = $file;
			return $file;
	 }

   protected function formatLine($args = array() )
   {
      $line= $this->format;
      foreach($args as $key => $value)
      {
        if (! is_array($value) && ! is_object($value))
          $line = str_replace('%%' . $key . '%%', $value, $line);
      }

      $line .= PHP_EOL;

      if (isset($args['data']))
      {
        $data = array_filter($args['data']);
        if (count($data) > 0)
        {
          foreach($data as $item)
          {
              $line .= $item . PHP_EOL;
          }
        }
      }

      return $line;
   }

   protected function setLogLevel($level)
   {
     $this->logLevel = $level;
   }

   protected function getEnv($name)
   {
     if (isset($this->{$name}))
     {
       return $this->{$name};
     }
     else {
       return false;
     }
   }

   public static function addError($message, $args = array())
   {
      $level = DebugItem::LEVEL_ERROR;
      $log = self::getInstance();
      $log->addLog($message, $level, $args);
   }
   public static function addWarn($message, $args = array())
   {
     $level = DebugItem::LEVEL_WARN;
     $log = self::getInstance();
     $log->addLog($message, $level, $args);
   }
   // Alias, since it goes wrong so often.
   public static function addWarning($message, $args = array())
   {
      self::addWarn($message, $args);
   }
   public static function addInfo($message, $args = array())
   {
     $level = DebugItem::LEVEL_INFO;
     $log = self::getInstance();
     $log->addLog($message, $level, $args);
   }
   public static function addDebug($message, $args = array())
   {
     $level = DebugItem::LEVEL_DEBUG;
     $log = self::getInstance();
     $log->addLog($message, $level, $args);
   }

   /** These should be removed every release. They are temporary only for d'bugging the current release */
   public static function addTemp($message, $args = array())
   {
     self::addDebug($message, $args);
   }

   public static function logLevel($level)
   {
      $log = self::getInstance();
      static::addInfo('Changing Log level' . $level);
      $log->setLogLevel($level);
   }

   public static function getLogLevel()
   {
     $log = self::getInstance();
     return $log->getEnv('logLevel');
   }

   public static function isManualDebug()
   {
        $log = self::getInstance();
        return $log->getEnv('is_manual_request');
   }

   public static function getLogPath()
   {
     $log = self::getInstance();
     return $log->getEnv('logPath');
   }

   /** Function to test if the debugger is active
   * @return boolean true when active.
   */
   public static function debugIsActive()
   {
      $log = self::getInstance();
      return $log->getEnv('is_active');
   }

   protected function monitorHooks()
   {

      foreach($this->hooks as $hook => $data)
      {
        $numargs = isset($data['numargs']) ? $data['numargs'] : 1;
        $prio = isset($data['priority']) ? $data['priority'] : 10;

        add_filter($hook, function($value) use ($hook) {
              $args = func_get_args();
              return $this->logHook($hook, $value, $args); }, $prio, $numargs);
      }
   }

   public function logHook($hook, $value, $args)
   {
      array_shift($args);
      self::addInfo('[Hook] - ' . $hook . ' with ' . var_export($value,true), $args);
      return $value;
   }

   public function loadView()
   {
       // load either param or class template.
       $template = $this->template;

       $view = $this->view;
       $view->namespace = $this->namespace;
       $controller = $this;

       $template_path = __DIR__ . '/' . $this->template  . '.php';
       if (file_exists($template_path))
       {

         include($template_path);
       }
       else {
         self::addError("View $template for ShortPixelLogger could not be found in " . $template_path,
         array('class' => get_class($this)));
       }
   }


 } // class debugController
