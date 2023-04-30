<?php
namespace ShortPixel\ShortQ\Tests;

class Tests{

    protected $items = array();
  //  protected $text_items = array('test1','test2','test3','test4','test5','test6','test7');

    protected $q;

    public function __construct($q)
    {
        global $wpdb;
        $wpdb->show_errors();
        $this->startView();

        $q->setOptions(array('is_debug' => true));

        echo "<PRE> START STATUS "; print_r($q->getStatus()); echo "</PRE>";

        for ($i = 0; $i < 10; $i++)
        {
           $id = rand(0, 1000);
           $this->items[] = array('id' => $id, 'value' => $id);
        }

        $deq_number = rand(1, 5);
        $q->setOption('numitems', $deq_number);

        $this->q = $q;
      //  $this->uninstall();

        if ( $this->q->hasItems())
        {
          echo "ITEMS FOUND: " . $this->q->itemCount() . "<BR>";
          $this->runTestQ();
        }
        else {
            $this->addItems();
            $this->runTestQ();
        //  $this->addItems();
        }

        $this->results();

        echo "<PRE> END STATUS "; print_r($q->getStatus()); echo "</PRE>";
        $this->endView();
    }

    public function addItems()
    {
      print_r($this->items);
      $this->q->enqueue($this->items);
    }

    public function runTestQ()
    {
       $this->deQueueBasic();
    }

    public function deQueueBasic()
    {
      while($this->q->hasItems())
      {
        $item = $this->q->deQueue();
        echo "ITEM FROM THA Q "; var_dump($item);
      }
    }

    public function uninstall()
    {
      $this->q->uninstall();
    }

    //public function deQueu

    public function results()
    {
        global $wpdb;
        echo $wpdb->last_error;
    }

    public function startView()
    {
      ?>
      <div class='debug' style='margin: 100px 0 100px 250px; background: #fff;'>
      <?php
    }

    public function endView()
    {
      ?>
      </div>
      <?php
    }

} // class
