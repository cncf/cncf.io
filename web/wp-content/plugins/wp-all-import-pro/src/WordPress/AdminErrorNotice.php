<?php

namespace Wpai\WordPress;


/**
 * Class AdminErrorNotice
 * @package Wpai\WordPress
 */
class AdminErrorNotice extends AdminNotice {

    /**
     * @return mixed|string
     */
    public function getType() {
        return 'error';
    }
}