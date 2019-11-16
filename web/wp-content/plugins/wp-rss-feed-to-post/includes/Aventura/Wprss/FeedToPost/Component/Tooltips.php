<?php

namespace Aventura\Wprss\FeedToPost\Component;

/**
 * Class for handling the help tooltips.
 *
 * @since 3.7
 */
class Tooltips extends ComponentAbstract
{

	/**
	 * The field prefix.
	 *
     * @since 3.7
	 */
	const FIELD_PREFIX = 'field_f2p_';

    /**
     * An example of how to add tooltips.
     * They will not actually get registered, until _register() is run.
     * 
     * @see hook()
     * @since 3.7
     */
	protected function _construct()
    {
		// Define the tooltips
		$tooltips = array(
			// General section options
			'enabled'				=>	$this->__( 'Enables the spinning of imported posts using the SpinnerChief API.' ),
		);
		// Add the tooltip entries to the data array
		foreach ($tooltips as $key => $value) {
			$this->setDataUsingMethod( $key, $value );
		}
	}

    /**
     * {@inheritdoc}
     *
     * @todo Register again when refactoring.
     * @since 3.7
     * @return Tooltips This instance.
     */
    public function hook()
    {
        parent::hook();
//        $this->_register();

        return $this;
    }

	/**
	 * Registers the tooltips to the core's help class.
     *
     * @since 3.7
	 */
	protected function _register() {
        if ($help = $this->getHelp()) {
            $help->add_tooltips( $this->getAllTooltips(), static::FIELD_PREFIX );
        }

        return $this;
	}

	/**
	 * Alias method for `getData()`, for code readability and clarity.
	 *
     * @since 1.0
	 * @see getData()
	 * @uses getData()
	 * @return array All the tooltip entries as an assoc array, with IDs as array keys and text as array values.
	 */
	public function getAllTooltips() {
		return $this->getData();
	}

	/**
	 * Renders the tooltip with the given key.
	 *
     * @since 1.0
	 * @return string The rendered HTML for the tooltip.
	 */
	public function doTooltip( $key ) {
		return $this->getHelp()->do_tooltip( static::FIELD_PREFIX . $key );
	}

    /**
     * @since 1.0
     * @return WPRSS_Help|null The help module of WPRSS if available; otherwise `null`.
     */
    public function getHelp()
    {
        return class_exists('WPRSS_Help')
            ? \WPRSS_Help::get_instance()
            : null;
    }

}
