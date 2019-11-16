<?php

namespace Aventura\Wprss\FeedToPost\Component;

use Aventura\Wprss\Core;

/**
 * Something that can be used as an assets controller.
 *
 * @since 3.7
 */
class Assets extends Core\Model\AssetsAbstract implements ComponentInterface
{
    /** @since 3.7 */
    const CSS_URI = WPRSS_FTP_CSS;
    /** @since 3.7 */
    const HANDLE_PREFIX = 'wprss-f2p-';

    /**
     * {@inheritdoc}
     * 
     * An example of how to add scripts.
     *
     * @todo Implement when refactoring.
     * @since 3.7
     * @return \Aventura\Wprss\FeedToPost\Component\Assets
     */
    public function enqueueAdminScripts()
    {
//        $this->registerScript('admin-scripts', 'admin-scripts.css', array(), $this->getPlugin()->getVersion());
//        $this->enqueueScript('admin-scripts');
    }

    /**
     * {@inheritdoc}
     * 
     * An example of how to add styles.
     *
     * @todo Implement when refactoring.
     * @since 3.7
     * @return \Aventura\Wprss\FeedToPost\Component\Assets
     */
    public function enqueueAdminStyles()
    {
        $this->registerStyle('admin-styles', 'admin-styles.css', array(), $this->getPlugin()->getVersion());
        $this->enqueueStyle('admin-styles');
    }

    /**
     * {@inheritdoc}
     *
     * @since 3.7
     * @return \Aventura\Wprss\FeedToPost\Component\Assets
     */
    public function enqueuePublicScripts()
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since 3.7
     * @return \Aventura\Wprss\FeedToPost\Component\Assets
     */
    public function enqueuePublicStyles()
    {
        return $this;
    }
}
