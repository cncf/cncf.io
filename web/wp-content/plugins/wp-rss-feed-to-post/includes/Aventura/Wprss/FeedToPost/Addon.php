<?php

namespace Aventura\Wprss\FeedToPost;

use Aventura\Wprss\Core;

/**
 * Main class for the SpinnerChief add-on.
 *
 * @since 3.7
 * @method ComponentFactory getFactory() Gets the FeedToPost component factory.
 */
class Addon extends Core\Plugin\AddonAbstract
{

    const BASENAME_WPRACORE = 'wp-rss-aggregator/wp-rss-aggregator.php';

	/**
	 * The minimum core version required.
	 */
	const CORE_MIN_VERSION = \WPRSS_FTP::WPRSS_MIN_VERSION;

	/**
	 * Text domain for i18n
	 */
	const TEXT_DOMAIN = WPRSS_TEXT_DOMAIN;

    const CODE = 'ftp';
    const VERSION = WPRSS_FTP_VERSION;

	/**
	 * @var \Aventura\Wprss\FeedToPost\Addon
	 */
	protected static $instance = NULL;

	/**
	 * @var Component\Settings
	 */
	protected $_settings = NULL;

	/**
	 * @var Component\Assets
	 */
	protected $_assets;

	/**
	 * @var Component\Tooltips
	 */
	protected $_tooltips;

    protected $_factory;

    /**
     * @since 3.7
     */
    public function hook() {
		$this->on( '!admin_init', array($this, 'checkPluginDependency') );

        // These hook themselves in automatically on creation
        $this->getSettings();
		$this->getAssets();
        $this->getTooltips();
    }

	/**
	 * Gets the settings class instance.
	 *
     * @since 3.7
	 * @return Component\Settings
	 */
	public function getSettings() {
        if (is_null($this->_settings)) {
            $this->_settings = $this->getFactory()->createSettings();
        }

		return $this->_settings;
	}

	/**
	 * Gets the assets controller instance.
	 *
     * @since 3.7
	 * @return Component\Assets
	 */
	public function getAssets() {
        if (is_null($this->_assets)) {
            $this->_assets = $this->getFactory()->createAssets();
        }
		return $this->_assets;
	}

	/**
	 * Gets the help tooltips instance.
	 *
     * @since 3.7
	 * @return Component\Tooltips
	 */
	public function getTooltips() {
        if (is_null($this->_tooltips)) {
            $this->_tooltips = $this->getFactory()->createTooltips();
        }
		return $this->_tooltips;
	}

	/**
	 * Checks if the plugins required are active and at the appropriate version.
	 *
     * @since 3.7
	 */
	public function checkPluginDependency()
    {
		if ( !static::isPluginActive( static::BASENAME_WPRACORE )
                || version_compare( WPRSS_VERSION, static::CORE_MIN_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'showCoreDependencyBrokenNotice' ) );
			$this->deactivate();
			return;
		}
	}

	/**
	 * Renders a view and returns the render as a string. Does not echo the view.
	 *
     * @since 3.7
	 * @param  string $view    The view name.
	 * @param  array  $viewbag Date to be included for the view.
	 *
	 * @return string          The rendered view contents.
	 */
	public function renderView( $view, $viewbag = array() ) {
		$viewfile = WPRSS_FTP_INC . 'view-' . $view . '.php';
		if ( ! is_file( $viewfile ) ) return '';
		ob_start();
		require $viewfile;
		return ob_get_clean();
	}

	/**
	 * Shows an admin notice that notifies the user that this add-on requires the core WP RSS Aggregator, and also shows the
	 * minimum required version.
     *
     * @since 3.7
	 */
	public function showCoreDependencyBrokenNotice()
    {
        echo static::_getNoticeHtml(
            $this->__(array(
                'The <strong>%1$s</strong> add-on requires the <strong>%2$s</strong> plugin at version <strong>%3$s</strong> or later to work correctly.',
                $this->getName(),
                'WP RSS Aggregator',
                static::CORE_MIN_VERSION
            )),
            'error'
        );
	}

	/**
	 * Shows an admin notice that notifies the user that this add-on requires Feed to Post, and also shows the
	 * minimum required version.
     *
     * @since 3.7
	 */
	public function showF2pDependencyBrokenNotice()
    {
        echo static::_getNoticeHtml(
            $this->__(array(
                'The <strong>%1$s</strong> add-on requires the <strong>%2$s</strong> plugin at version <strong>%3$s</strong> or later to work correctly.',
                $this->getName(),
                'WP RSS Aggregator - Feed to Post',
                static::FTP_MIN_VERSION
            )),
            'error'
        );
	}


    /**
     * Get the HTML of an admin notice.
     *
     * @since 3.7
     * @param string $message The message of the notice.
     * @param string $noticeClass The HTML class for the notice element. Currently, the possible values are 'updated'
     *  ("success" style), 'update-nag' ("warning" style and not full-width) or 'error'.
     */
    static protected function _getNoticeHtml($message, $noticeClass = 'updated')
    {
        ?>
		<div class="<?php echo $noticeClass ?>">
			<p><?php echo $message ?></p>
		</div>
        <?php
    }

}
