<?php
// The data models.
namespace ShortPixel\ShortPixelLogger;


class DebugItem
{
    protected $time;
    protected $level;
    protected $message;
    protected $data = array();
    protected $caller = false; // array when filled

    protected $model;

    const LEVEL_ERROR = 1;
    const LEVEL_WARN = 2;
    const LEVEL_INFO = 3;
    const LEVEL_DEBUG = 4;

    public function __construct($message, $args)
    {
        $this->level = $args['level'];
        $data = $args['data'];

        $this->message = $message;
        $this->time = microtime(true);

        $this->setCaller();

        // Add message to data if it seems to be some debug variable.
        if (is_object($this->message) || is_array($this->message))
        {
          $data[] = $this->message;
          $this->message = __('[Data]');
        }
        if (is_array($data) && count($data) > 0)
        {
          $dataType = $this->getDataType($data);
          if ($dataType == 1)  // singular
          {
              $this->data[] = print_r($data, true);
          }
          if ($dataType == 2) //array or object.
          {
						$count = false;
						if (gettype($data) == 'array')
							 $count = count($data);
						elseif(gettype($data) == 'object')
							 $count = count(get_object_vars($data));

						$firstLine = 	 ucfirst(gettype($data)) . ':';
						if ($count !== false)
							$firstLine .= ' (' . $count . ')';

						$this->data[] = $firstLine;

            foreach($data as $index => $item)
            {
              if (is_object($item) || is_array($item))
              {
                $this->data[] = print_r($index, true) . ' ( ' . ucfirst(gettype($item)) . ') => ' . print_r($item, true);
              }
            }
          }
        } // if
        elseif (! is_array($data)) // this leaves out empty default arrays
        {
           $this->data[] = print_r($data, true);
        }
    }

    public function getData()
    {
      return array('time' => $this->time, 'level' => $this->level, 'message' => $this->message, 'data' => $this->data, 'caller' => $this->caller);
    }

    /** Test Data Array for possible values
    *
    * Data can be a collection of several debug vars, a single var, or just an normal array. Test if array has single types,
    * which is a sign the array is not a collection.
    */
    protected function getDataType($data)
    {
        $single_type = array('integer', 'boolean', 'string');
        if (in_array(gettype(reset($data)), $single_type))
        {
          return 1;
        }
        else
        {
          return 2;
        }
    }

    public function getForFormat()
    {
      $data = $this->getData();
      switch($this->level)
      {
          case self::LEVEL_ERROR:
            $level = 'ERR';
            $color = "\033[31m";
          break;
          case self::LEVEL_WARN:
            $level = 'WRN';
            $color = "\033[33m";
          break;
          case self::LEVEL_INFO:
            $level = 'INF';
            $color = "\033[37m";
          break;
          case self::LEVEL_DEBUG:
            $level = 'DBG';
            $color = "\033[37m";
          break;

      }
      $color_end = "\033[0m";

      $data['color'] = $color;
      $data['color_end'] = $color_end;
      $data['level'] = $level;

      return $data;

      //return array('time' => $this->time, 'level' => $level, 'message' => $this->message, 'data' => $this->data, 'color' => $color, 'color_end' => $color_end, 'caller' =>  $this->caller);

    }

    protected function setCaller()
    {
        if(PHP_VERSION_ID < 50400) {
          $debug=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        } else {
          $debug=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,5);
        }

        $i = 4;
        if (isset($debug[$i]))
        {
          $info = $debug[$i];
          $line = isset($info['line']) ? $info['line'] : 'Line unknown';
          $file = isset($info['file']) ? basename($info['file']) : 'File not set';

          $this->caller = array('line' => $line, 'file' => $file, 'function' => $info['function']);
        }


    }


}
