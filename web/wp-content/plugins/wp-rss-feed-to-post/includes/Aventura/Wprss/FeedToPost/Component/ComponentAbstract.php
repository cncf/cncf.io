<?php

namespace Aventura\Wprss\FeedToPost\Component;

use Aventura\Wprss\Core;


/**
 * Common functionality for all Feed to Post components.
 *
 * @method \Aventura\Wprss\FeedToPost\Addon getPlugin() Gets the Feed to Post add-on instance
 * @since 3.7
 */
abstract class ComponentAbstract extends Core\Plugin\ComponentAbstract implements ComponentInterface
{
}