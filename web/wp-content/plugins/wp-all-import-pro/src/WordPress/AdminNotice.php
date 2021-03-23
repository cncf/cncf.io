<?php

namespace Wpai\WordPress;


/**
 * Class AdminNotice
 * @package Wpai\WordPress
 */
abstract class AdminNotice {

    /**
     * @var
     */
    protected $message;

    /**
     * AdminNotice constructor.
     * @param $message
     */
    public function __construct($message) {
        $this->message = $message;
    }

    /**
     *
     */
    public function showNotice() {
        ?>
        <div class="<?php echo $this->getType();?>"><p>
                <?php echo $this->message; ?>
            </p></div>
        <?php
    }

    /**
     *
     */
    public function render() {
        add_action('admin_notices', array($this, 'showNotice'));
    }

    /**
     * @return mixed
     */
    abstract function getType();
}