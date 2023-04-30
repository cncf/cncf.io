<?php
namespace ShortPixel\ShortQ\DataProvider;
use ShortPixel\ShortQ\Item as Item;
use ShortPixel\ShortQ\ShortQ as ShortQ;


/* WP Mysql DataProvider
*
*/
class MysqlDataProvider implements DataProvider
{
   protected $qName; // Limit is 30 chars!
   protected $slug;  // Limit is 30 chars!

   protected $table;

   protected $query_size_limit = 10000;  // in strlen characters.

   /* Constructor */
   public function __construct($slug, $qName)
   {
      global $wpdb;
      $this->slug = $slug;
      $this->qName = $qName;

      $this->table = $wpdb->prefix . 'shortpixel_queue';
   }

   public function enqueue($items)
   {
      global $wpdb;
      if (! is_array($items))
        return false;
       // start higher to allow priority additions easily.
      $list_order = (10 + $this->itemCount());
      $now = $this->timestamptoSQL();

      $sql = 'INSERT IGNORE INTO ' . $this->table . ' (queue_name, plugin_slug, value, item_count, list_order, item_id, updated, created) VALUES ';
      $values = array();
      foreach ($items as $item)
      {
        $item_id = (int) $item->item_id;
        $item_count = (int) $item->item_count;
        $value = $item->getRaw('value'); // value;

        $order = (! is_null($item->list_order)) ? $item->list_order : $list_order;

        $values[] = $wpdb->prepare('(%s, %s, %s,%d, %d, %d, %s, %s)', $this->qName, $this->slug, $value, $item_count, $order, $item_id, $now, $now);
        if (! isset($item->list_order))
          $list_order++;

      }
      $sql .= implode( ",\n", $values );
      $result = $wpdb->query($sql, $values);

      if (! $this->checkQueryOK())
      {
        return false;
      }

      return $result;
   }

   /* Check item consistency and check if items are not already in this queue. Must be unique */
   protected function prepareItems($items)
   {
      global $wpdb;

      $items_ids = array();
      foreach($items as $key => $item)
      {
         if (isset($item['id']))
          $items_ids[] = $item['id'];
        else // no id, no q
          unset($items[$key]);
      }
   }

   /* Dequeue an item (return it) via specific parameters. Sets a new status after grabbing these records.
   *
   * @param $args Array
            numitems - number of records to pull
            status   - Array - the statusses to pull
            newstatus - To which status said items should be put
            orderby  - how to order the records [not implemented]

      @return Recordset of Items gotten.
   */
   public function dequeue($args = array())
   {
      $defaults = array(
          'numitems' => 1, // pass -1 for all.
          'status' => ShortQ::QSTATUS_WAITING,
          'newstatus' => ShortQ::QSTATUS_DONE,
          'orderby' => 'list_order',
          'order' => 'ASC',
          'priority' => false,  // array('operator' => '<', 'value' => 10);
      );

      $args = wp_parse_args($args, $defaults);

      if (is_array($args['status']))
        $args['status'] = implode(',', $args['status']);

      $items = $this->queryItems(array(
        'numitems' => $args['numitems'],
        'status' => $args['status'],
        'orderby' => $args['orderby'],
        'order' => $args['order'],
        'priority' => $args['priority'],
      ));

      $id_array = array_keys($items);

      // Update status if results yielded.
      if ($args['status'] !== $args['newstatus'] && count($id_array) > 0)
      {
        $now = $this->timestamptoSQL();
        $this->updateRecords(array('status' => $args['newstatus'], 'updated' => $now), array('id' => $id_array));
        foreach($items as $index => $item)
        {
          $item->status = $args['newstatus']; // update status to new situation.
          $item->updated = $now;
          $items[$index] = $item;
        }
      }
      if ($args['newstatus'] == ShortQ::QSTATUS_DELETE)
      {
          $this->removeRecords(array('status' => ShortQ::QSTATUS_DELETE));
      }
      // @todo is Status = QSTATUS_DELETE, remove all records after putting them to this status.

      return array_values($items); // array values resets the id index returns by queryItems
   }

   private function timestampToSQL($timestamp = 0)
   {
      if (! is_numeric($timestamp))
        return $timestamp; // possible already date;

      if ($timestamp == 0)
        $timestamp = time();

      $date =  date('Y-m-d H:i:s', $timestamp);

      return $date;
   }

   /*
   * @return Array
   */
   private function queryItems($args = array())
   {
     $defaults = array(
       'status' => ShortQ::QSTATUS_ALL,
       'orderby' => 'list_order',
       'order' => 'ASC',
       'numitems' => -1,
       'item_id' => false,
       'updated' => false, // updated since (Unix Timestamp) ( or array with operator)
       'priority' => false, // number (or array with operator)
     );

     $args = wp_parse_args($args, $defaults);

     global $wpdb;
     $prepare = array();

     $sql = 'SELECT * from ' . $this->table . ' where queue_name = %s and plugin_slug = %s ';
     $prepare[] = $this->qName;
     $prepare[] = $this->slug;

     if ($args['status'] <> ShortQ::QSTATUS_ALL)
     {
       $sql .= 'and status = %d ';
       $prepare[] = $args['status'];
     }

     if ($args['item_id'] !== false && intval($args['item_id']) > 0)
     {
       $sql .= 'and item_id = %d ';
       $prepare[] = intval($args['item_id']);
     }

     if ($args['updated'])
     {
       $operator = '=';

       if (is_array($args['updated']))
       {
           $operator = isset($args['updated']['operator']) ? ($args['updated']['operator']) : $operator;
           $value = isset($args['updated']['value']) ? $args['updated']['value'] : false;
       }
       else
       {
           $value = $args['updated'];
       }

       $sql .= 'and updated ' . $operator . ' %s ';
       $prepare[] = $this->timestamptoSQL($value);
     }

     if ($args['priority'])
     {
        $operator = '=';

        if (is_array($args['priority']))
        {
            $operator = isset($args['priority']['operator']) ? ($args['priority']['operator']) : $operator;
            $value = isset($args['priority']['value']) ? $args['priority']['value'] : false;
        }
        else
        {
            $value = $args['priority'];
        }

        $sql .= 'and list_order ' . $operator . ' %d ';
        $prepare[] = $value;
     }

     if ($args['orderby'])
     {
       $order = (strtoupper($args['order']) == 'ASC') ? 'ASC ' : 'DESC ';
       $sql .= 'order by ' . $args['orderby'] . ' ' . $order;

      // $prepare[] = $args['orderby'];
     }


     if ($args['numitems'] > 0)
     {
        $sql .= 'limit %d ';
        $prepare[] = $args['numitems'];
     }

     $sql = $wpdb->prepare($sql, $prepare);

     $result = $wpdb->get_results($sql, ARRAY_A);

     $items = array();

     foreach($result as $index => $row)
     {
       $item = new Item();
       $id = $row['id'];
       foreach($row as $name => $value)
       {
         if (property_exists($item, $name))
         {
            $item->$name = $value;
          }
       }
       $items[$id] = $item;
     }

     return $items;
   }

   /** Updates a set of items from queue without pulling or returning those records.
   *
   *  @return int Number of Records Updated
   */
   public function alterQueue($data, $fields, $operators)
   {

    return $this->updateRecords($data, $fields, $operators);

   }

   /** Updates one queued item, for instance in case of failing, or status update
   *
   * @param $item_id int The Uniq Id of the item to update
   * @param $field Array An array of fields in key => pair format to be updated.
   */
   public function itemUpdate(Item $item, $fields)
   {
      $result = $this->updateRecords($fields, array('item_id' => $item->item_id));
      if ($result == 1 )
        return true;
      else
        return false;
   }

   public function getItem($item_id)
   {
       $items = $this->queryItems(array('item_id' => $item_id));

       if (count($items) == 0)
          return false;
       else
         return array_shift($items);
   }

   public function getItems($args)
   {
      return $this->queryItems($args);
   }

   /* Counts Items in Database Queue
   * @param Status Mixed When supplied with ShortQ Status Constant it will count this status, will count all with ShortQ:QSTATUS_ALL.
   * When given 'countbystatus' it will return an array with  ShortQ Status as key and the count as value
     @return Mixed Either count int, or Array.
   */
   public function itemCount($status = ShortQ::QSTATUS_WAITING)
   {
      global $wpdb;
      if (is_numeric($status) && $status != ShortQ::QSTATUS_ALL)
      {
        $sql = 'SELECT count(*) FROM ' . $this->table . ' WHERE queue_name = %s and plugin_slug = %s and status = %d ';
        $count = $wpdb->get_var($wpdb->prepare($sql, $this->qName, $this->slug, $status));
      }
      elseif ($status == ShortQ::QSTATUS_ALL) // full queue, with records from all status.
      {
        $sql = 'SELECT count(*) FROM ' . $this->table . ' WHERE queue_name = %s and plugin_slug = %s ';
        $count = $wpdb->get_var($wpdb->prepare($sql, $this->qName, $this->slug));
      }
      elseif ($status == 'countbystatus')
      {
        $sql = 'SELECT count(id) as count, status FROM ' . $this->table . ' WHERE queue_name = %s and plugin_slug = %s group by status';
        $rows = $wpdb->get_results($wpdb->prepare($sql, $this->qName, $this->slug), ARRAY_A);
        $count = array();

        foreach($rows as $row)
        {
           $count[$row['status']] = $row['count'];
        }

      }

      if (!empty($wpdb->last_error))
      {
        $this->handleError($wpdb->last_error);
        return 0;
      }

      return $count;
   }

   /* Counts Sum of Items in the Database Queue
   * @param Status Mixed When supplied with ShortQ Status Constant it will count this status, will count all with ShortQ:QSTATUS_ALL.
   * When given 'countbystatus' it will return an array with  ShortQ Status as key and the count as value
     @return Mixed Either count int, or Array.
   */
   public function itemSum($status = ShortQ::QSTATUS_WAITING)
   {
      global $wpdb;
      if (is_numeric($status) && $status != ShortQ::QSTATUS_ALL)
      {
        $sql = 'SELECT SUM(item_count) FROM ' . $this->table . ' WHERE queue_name = %s and plugin_slug = %s and status = %d ';
        $count = (int) $wpdb->get_var($wpdb->prepare($sql, $this->qName, $this->slug, $status));
      }
      elseif ($status == ShortQ::QSTATUS_ALL) // full queue, with records from all status.
      {
        $sql = 'SELECT SUM(item_count) FROM ' . $this->table . ' WHERE queue_name = %s and plugin_slug = %s ';
        $count = (int) $wpdb->get_var($wpdb->prepare($sql, $this->qName, $this->slug));
      }
      elseif ($status == 'countbystatus')
      {
        $sql = 'SELECT SUM(item_count) as count, status FROM ' . $this->table . ' WHERE queue_name = %s and plugin_slug = %s group by status';
        $rows = $wpdb->get_results($wpdb->prepare($sql, $this->qName, $this->slug), ARRAY_A);
        $count = array();

        foreach($rows as $row)
        {
           $count[$row['status']] = (int) $row['count'];
        }

      }

      if (!empty($wpdb->last_error))
      {
        $this->handleError($wpdb->last_error);
        if ($status == 'countbystatus')
          return array();
        else
          return 0;
      }

      return $count;
   }


   /** Update records
   *
   * @param $Data Array. Data array to change, to WP standards
   * @param $where Array. Data Array on conditions, to WP standards
   * @param $operators Array. Maps of Field => Operator to use anything else than standard = in the where query.
   * @return int Amount of records updates, or null|false
   */
   private function updateRecords($data, $where, $operators = array() )
   {
      global $wpdb;
      $update_sql = 'UPDATE ' . $this->table . ' set updated = %s';
      if (isset($data['updated']))
      {
          $placeholders = array($this->timestamptoSQL($data['updated']));
          unset($data['updated']);
      }
      else
          $placeholders = array($this->timestamptoSQL());

			// Certain older SQL servers like to auto-update created date, creating a mess.
			if (! isset($data['created']))
			{
				 $update_sql .= ', created = created';
			}

      foreach($data as $field => $value)
      {
        $update_sql .= ' ,' . $field . ' = %s ';
        $placeholders[] =  $value;
      }

      $update_sql .= ' WHERE queue_name = %s and plugin_slug = %s ';
      $placeholders[] = $this->qName;
      $placeholders[] = $this->slug;

      foreach ($where as $field => $value)
      {
        if (is_array($value))
        {
          $vals = implode( ', ', array_fill( 0, count( $value ), '%s' ));
          $update_sql .= ' AND ' . $field . ' in (' . $vals . ' ) ';
          $placeholders = array_merge($placeholders, $value);
        }
        else {
          $operator = isset($operators[$field]) ? $operators[$field] : '=';
          $update_sql .= ' AND ' . $field . ' = %s';
          $placeholders[] = $value;
        }
      }
      $update_sql = $wpdb->prepare($update_sql, $placeholders);

      $result = $wpdb->query($update_sql);
      return $result;
   }

   /** @todo Accept array or ItemIDS to remove
   * @param $args Array . Array of options:
   *  'Status' : remove items with selected ShortQ QSTATUS
   *  'All' : Set to true to remove all from this queue ( sep. argument is safety feature )
   * 'Item_id' : Delete by this item id
   * 'Items' : Array of Item ID's.
   */
   public function removeRecords($args)
   {
     $defaults = array(
        'status' => null,
        'all' => false,
        'item_id' => null,
        'items' => null,
     );

     global $wpdb;
     $args = wp_parse_args($args, $defaults);

     $data = array($this->qName, $this->slug);
     $delete_sql = 'DELETE FROM ' . $this->table . ' where queue_name = %s and plugin_slug = %s';

     if (! is_null($args['status']))
     {
        $data[] = intval($args['status']);
        $delete_sql .= ' and status = %s';
     }
     elseif (! is_null($args['item_id']))
     {
       $data[] = $args['item_id'];
       $delete_sql .= ' and item_id = %s';
     }
     elseif(! is_null($args['items']) && count($args['items']) > 0)
     {
       $items = $args['items'];
       $vals = implode( ', ', array_fill( 0, count( $items ), '%d' ));
       $delete_sql .= ' AND item_id in (' . $vals .  ' ) ';
       $data = array_merge($data, $items);
     }
     elseif ($args['all'] === true)
     {
        // do nothing, query already here for full delete.
     }
     else {
       return false; // prevent accidents if all is not set explicitly.
     }

     $delete_sql = $wpdb->prepare($delete_sql, $data);
     $result = $wpdb->query($delete_sql);
     return $result;
   }

   /** Checks if database table properly exists
   * https://wordpress.stackexchange.com/questions/220275/wordpress-unit-testing-cannot-create-tables
   * @return Boolean Yes or no
   */
   private function check()
   {
     global $wpdb;
     $sql = $wpdb->prepare("
              SHOW TABLES LIKE %s
              ", $this->table);

      $result = intval($wpdb->query($sql));

      if ($result == 0)
        return false;
      else {
        return true;
      }
      // if something something, install.
   }

   public function install($nocheck = false)
   {
     if ($nocheck === false && true === $this->check())
        return true;

     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

     global $wpdb;
     $prefix = $wpdb->prefix;

     $charset = $wpdb->get_charset_collate();
      $sql = "CREATE TABLE `" . $this->table . "` (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                queue_name VARCHAR(30) NOT NULL,
                plugin_slug VARCHAR(30) NOT NULL,
                status int(11) NOT NULL DEFAULT 0,
                list_order int(11) NOT NULL,
                item_id bigint unsigned NOT NULL,
                item_count INT DEFAULT 1,
                value longtext NOT NULL,
                tries int(11) NOT NULL DEFAULT 0,
                created timestamp ,
                updated timestamp,
                PRIMARY KEY  (id),
                KEY queue_name (queue_name),
                KEY plugin_slug (plugin_slug),
                KEY status (status),
                KEY item_id (item_id),
                KEY list_order (list_order)
                ) $charset; ";

			$result = dbDelta($sql);

      $sql = "SHOW INDEX FROM " . $this->table . " WHERE Key_name = 'uq_" . $prefix . "'";
      $result = $wpdb->get_results($sql);
      if (is_null($result) || count($result) == 0)
      {
         $sql = 'ALTER TABLE '. $this->table . ' ADD CONSTRAINT UNIQUE uq_' . $prefix . '(plugin_slug,queue_name,item_id)';
         $wpdb->query($sql);
      }

      return $this->check();
   }

   public function uninstall()
   {
     global $wpdb;
     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

     // Check if table exists, if not, return.
     if (! $this->check())
        return false;

     $sql = 'SELECT count(*) as cnt FROM ' . $this->table;
     $records = $wpdb->get_var($sql);


     // Don't remove table on any doubt.
     if (is_null($records) || intval($records) <> 0)
        return false;

     $sql = ' DROP TABLE IF EXISTS ' . $this->table;

     $wpdb->query($sql);

     return $this->check();
   }

   private function checkQueryOK($override_check = false)
   {
      global $wpdb;

      if (!empty($wpdb->last_error))
      {
        $this->handleError($wpdb->last_error, $override_check);
        return false;
      }

      return true;
   }

   private function handleError($error, $override_check = false)
   {
     global $wpdb;

     // check if table is there.
     if (! $override_check)
     {
       if (! $this->check())
        $this->install();
     }

     // If the error contains something 'unknown' a field might be missing, do a hard DbDelta.
     if (strpos(strtolower($error), 'unknown') !== false)
     {
      $this->install(true);
     }

     $this->install();

     // @todo Add error log here
   }


}
