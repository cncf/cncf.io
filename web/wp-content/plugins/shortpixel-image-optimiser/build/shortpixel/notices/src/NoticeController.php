<?php
namespace ShortPixel\Notices;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

class NoticeController //extends ShortPixelController
{
  protected static $notices = array();
  protected static $instance = null;
  protected static $cssHookLoaded = false; // prevent css output more than once.

  protected $notice_displayed = array();

  public $notice_count = 0;

  protected $has_stored = false;

  protected $notice_option = ''; // The wp_options name for notices here.

  /** For backward compat. Never call constructor directly. */
  public function __construct()
  {
      $ns = __NAMESPACE__;
      $ns = substr($ns, 0, strpos($ns, '\\')); // try to get first part of namespace
      $this->notice_option = $ns . '-notices';

      add_action('wp_ajax_' . $this->notice_option, array($this, 'ajax_action'));

      $this->loadNotices();
      //$this->loadConfig();
  }

  public static function getInstance()
  {
     if ( self::$instance === null)
     {
         self::$instance = new NoticeController();
     }

     return self::$instance;
  }

  /** Reset all notices, before loading them, to ensure on updates / activations one starts fresh */
  public static function resetNotices()
  {
    $ns = __NAMESPACE__;
    $ns = substr($ns, 0, strpos($ns, '\\')); // try to get first part of namespace
    $result = delete_option($ns . '-notices');
  }

  /** Load Notices Config File, if any
  *
  * [ Future Use ]
  */
  public function loadConfig()
  {
    return;
    if (file_exists('../notice_config.json'))
    {
      $config = file_get_contents('../notice_config.json');
      $json_config = json_decode($config);
    }
  }

  public function loadIcons($icons)
  {
      foreach($icons as $name => $icon)
        NoticeModel::setIcon($name, $icon);
  }


  protected function loadNotices()
  {
    $notices = get_option($this->notice_option, false);
    $cnotice = (is_array($notices)) ? count($notices) : 0;

    if ($notices !== false && is_array($notices))
    {
      $checked = array();
      foreach($notices as $noticeObj)
      {
        if (is_object($noticeObj) && $noticeObj instanceOf NoticeModel)
        {
          $checked[] = $noticeObj;
        }
      }
      self::$notices = $checked;
      $this->has_stored = true;
    }
    else {
      self::$notices = array();
      $this->has_stored = false;
    }
    $this->countNotices();
  }


  protected function addNotice($message, $code, $unique)
  {
      $notice = new NoticeModel($message, $code);

      if ($unique)
      {
        foreach(self::$notices as $nitem)
        {
          if ($nitem->message == $notice->message && $nitem->code == $notice->code) // same message.
            return $nitem; // return the notice with the same message.
        }
      }
      self::$notices[] = $notice;
      $this->countNotices();

      $this->update();
      return $notice;
  }

  /** Update the notices to store, check what to remove, returns count.  */
  public function update()
  {
    if (! is_array(self::$notices) || count(self::$notices) == 0)
    {
      if ($this->has_stored)
        delete_option($this->notice_option);

      return 0;
    }

    $new_notices = array();
    foreach(self::$notices as $item)
    {
      if (! $item->isDone() )
      {
        $new_notices[] = $item;
      }
    }

    update_option($this->notice_option, $new_notices);
    self::$notices = $new_notices;

    return $this->countNotices();
  }

  public function countNotices()
  {
      $this->notice_count = count(self::$notices);
      return $this->notice_count;
  }


  public function getNotices()
  {
      return self::$notices;
  }

  public function getNoticesForDisplay()
  {
      $newNotices = array();

      foreach(self::$notices as $notice)
      {
          if ($notice->isDismissed()) // dismissed never displays.
            continue;

          if ($notice->isPersistent())
          {
              $id = $notice->getID();
              if (! is_null($id) && ! in_array($id, $this->notice_displayed))
              {
                $notice->notice_action = $this->notice_option;
                $newNotices[] = $notice;
                $this->notice_displayed[] = $id;
              }

          }
          else
            $newNotices[] = $notice;


      }
      return $newNotices;
  }


  public function getNoticeByID($id)
  {
    foreach(self::$notices as $notice)
    {
      if ($notice->getID() == $id)
        return $notice;
    }

    return false;
  }

  public static function removeNoticeByID($id)
  {
    $noticeController = self::getInstance();

    for($i = 0; $i < count(self::$notices); $i++)
    {
      $item = self::$notices[$i];
      if (is_object($item) && $item->getID() == $id)
      {
        Log::addDebug('Removing notice with ID ' . $id);
        unset(self::$notices[$i]);
      }
      //if ($notice_item )
    }
    $noticeController->update();
  }

  public function ajax_action()
  {
    $response = array('result' => false, 'reason' => '');

    if (isset($_POST['nonce']) && wp_verify_nonce( sanitize_key($_POST['nonce']), 'dismiss') )
    {
       if (isset($_POST['plugin_action']) && 'dismiss' == $_POST['plugin_action'] )
       {
          $id = (isset($_POST['id'])) ? sanitize_text_field( wp_unslash($_POST['id'])) : null;

					if (! is_null($id))
					{
						
          	$notice = $this->getNoticeByID($id);
					}
					else
					{
						$notice = false;
					}

          if(false !== $notice)
          {
            $notice->dismiss();
            $this->update();
            $response['result'] = true;
          }
          else
          {
            Log::addError('Notice not found when dismissing -> ' . $id, self::$notices);
						$response['result']  = false;
            $response['reason'] = ' Notice ' . $id . ' not found. ';
          }

       }

    }
    else
    {
      Log::addError('Wrong Nonce when dismissed notice. ');
      $response['reason'] = 'wrong nonce';
    }
    wp_send_json($response);
  }

  /** Adds a notice, quick and fast method
  * @param String $message The Message you want to notify
  * @param Boolean $unique If unique, check to not repeat notice exact same text in notices.  Discard if so
  * @param int $code A value of messageType as defined in model
  * @returm Object Instance of noticeModel
  */

  public static function addNormal($message, $unique = false)
  {
    $noticeController = self::getInstance();
    $notice = $noticeController->addNotice($message, NoticeModel::NOTICE_NORMAL, $unique);
    return $notice;

  }

  public static function addError($message, $unique = false)
  {
    $noticeController = self::getInstance();
    $notice = $noticeController->addNotice($message, NoticeModel::NOTICE_ERROR, $unique);
    return $notice;

  }

  public static function addWarning($message, $unique = false)
  {
    $noticeController = self::getInstance();
    $notice = $noticeController->addNotice($message, NoticeModel::NOTICE_WARNING, $unique);
    return $notice;
  }

  public static function addSuccess($message, $unique = false)
  {
    $noticeController = self::getInstance();
    $notice = $noticeController->addNotice($message, NoticeModel::NOTICE_SUCCESS, $unique);
    return $notice;

  }

  public static function addDetail($notice, $detail)
  {
    $noticeController = self::getInstance();
    $notice->addDetail($detail);

//   $notice_id = spl_object_id($notice);

    $noticeController->update();
  }

  /** Make a regular notice persistent across multiple page loads
  * @param $notice NoticeModel The Notice to make Persistent
  * @param $key String Identifier of the persistent notice.
  * @param $suppress Int  When dismissed, time to stay dismissed
  * @param $callback Function Callable function
  */
  public static function makePersistent($notice, $key, $suppress = -1, $callback = null)
  {
     $noticeController = self::getInstance();
     $existing = $noticeController->getNoticeByID($key);

     // if this key already exists, don't allow the new notice to be entered into the array. Remove it since it's already created.
     if ($existing)
     {
       for($i = 0; $i < count(self::$notices); $i++)
       {
         $item = self::$notices[$i];

         if ($item->message == $notice->message && $item->getID() == null)
         {
           if ($item->message != $existing->message) // allow the persistent message to be updated, if something else is served on this ID
           {
              $existing->message = $item->message;
           }
           unset(self::$notices[$i]);
         }
         //if ($notice_item )
       }
     }
     else
     {
       $notice->setPersistent($key, $suppress, $callback); // set this notice persistent.
     }

     $noticeController->update();
  }

  public function admin_notices()
  {
      if ($this->countNotices() > 0)
      {
          if (! self::$cssHookLoaded)
          {
            add_action('admin_print_footer_scripts', array($this, 'printNoticeStyle'));
            self::$cssHookLoaded = true;
          }
          foreach($this->getNoticesForDisplay() as $notice)
          {
            echo $notice->getForDisplay();
          }
      }
      $this->update(); // puts views, and updates
  }


  public function printNoticeStyle()
  {
     if (file_exists(__DIR__ . '/css/notices.css'))
     {
       echo '<style>' . esc_html(file_get_contents(__DIR__ . '/css/notices.css')) . '</style>';
     }
     else {
       Log::addDebug('Notices : css/notices.css could not be loaded');
     }
  }




}
