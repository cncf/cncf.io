<?php

namespace Aventura\Wprss\FeedToPost;

use Aventura\Wprss\Core;

/**
 * Default FeedToPost component factory.
 * Decides what classes should be initialized as components, and how.
 *
 * @since 3.7
 */
class ComponentFactory extends Core\Plugin\ComponentFactoryAbstract implements Core\Plugin\ComponentInterface
{
    protected function _construct()
    {
        parent::_construct();
        $this->setBaseNamespace('\\Aventura\\Wprss\\FeedToPost\\Component');
    }

    /**
     * @since 3.7
     * @return Component\Settings
     */
    public function createSettings(array $data = array())
    {
        return $this->createComponent('Settings', $this->getPlugin(), $data);
    }

    /**
     * @since 3.7
     * @return Component\HelpTooltips
     */
    public function createTooltips(array $data = array())
    {
        return $this->createComponent('Tooltips', $this->getPlugin(), $data);
    }

    /**
     * @since 3.7
     * @param array $data
     * @return Component\Assets
     */
    public function createAssets(array $data = array())
    {
        return $this->createComponent('Assets', $this->getPlugin(), $data);
    }

    /**
     * Creates a command that can be called.
     *
     * @since 3.7
     * @param callable|null $callable The callable for the command.
     * @param array|null $args The arguments for the command.
     * @return Core\Model\CommandInterface
     */
    public function createCommand($callable = null, $args = null)
    {
        $data = array();
        if (!is_null($callable)) {
            $data['function'] = $callable;
        }
        if (!is_null($args)) {
            $data['args'] = $args;
        }

        return new Core\Model\Command($data);
    }

    /**
     * @since 3.7.3
     *
     * @return \Aventura\Wprss\Core\Model\Regex\HtmlEncoder The new encoder instance.
     */
    public function createRegexEncoder()
    {
        return new \Aventura\Wprss\Core\Model\Regex\HtmlEncoder();
    }
}
