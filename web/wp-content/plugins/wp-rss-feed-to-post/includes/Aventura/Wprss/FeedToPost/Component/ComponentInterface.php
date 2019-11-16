<?php

namespace Aventura\Wprss\FeedToPost\Component;

use Aventura\Wprss\Core;

/**
 * An interface for something that can be a Feed to Post component.
 *
 * @since 3.7
 */
interface ComponentInterface extends Core\Plugin\ComponentInterface
{
    
    /**
     * @since 3.7
     * @return \Aventura\Wprss\FeedToPost\Addon
     */
    public function getPlugin();
}