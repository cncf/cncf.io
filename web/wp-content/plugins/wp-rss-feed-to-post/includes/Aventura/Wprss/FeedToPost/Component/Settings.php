<?php

namespace Aventura\Wprss\FeedToPost\Component;

use Aventura\Wprss\Core;
use WPRSS_FTP_Settings;

/**
 * Settings handler class for the SpinnerChief addon.
 *
 * @since 3.7
 */
class Settings extends Core\Model\SettingsAbstract implements ComponentInterface
{
    const TAB_SLUG          = 'ftp_settings';
    const MAIN_OPTION_NAME  = 'wprss_settings_ftp';

    /**
     * Registers hooks to the loader.
     *
     * @todo Hook in the registration when refactoring.
     * @since 3.7
     */
    public function hook()
    {
        // Add the settings tab
//        $this->on('!wprss_options_tabs', array($this, 'addTab'), null, 100);
        // Register the settings option, sections and fields
//        $this->on('!wprss_admin_init', array($this, 'register'));

        parent::hook();
    }

    /**
     * Gets the default values.
     *
     * @since 3.7
     * @return array
     */
    protected function _getDefaultValues()
    {
        return array(
        );
    }
    
    /**
     * Gets the settings sections and fields.
     *
     * @since 3.7
     * @return array An assoc array containing the sections in the first level, and the label and fields in the second level.
     */
    protected function _getSectionsFields()
    {
        $arr = array(
            'general'           => array( // This is a section. See `getSectionId()` for how it gets transformed into an actual section name.
                'label'             => $this->__('General Settings'),
                'header'            => $this->__('General settings about imported posts.'),
                // If 'header' is present, it will be used. If it's a callable, its return value will be used.
                'fields'            => array( // An array of fields, by field code
                    'post_type'         => array(
                        'label'             => $this->__('Post Type'),
                        'type'              => 'select',
                        // Type can be one of the existing renderer types (select, checkbox, number, text), or make your own! See `_getFieldRenderers()`
                        'value'             => $this->createCommand(array($this, 'getApiLoginOptions')),
                        // If no value, it is automatically taken from the local data with the field's ID as key!
                        // If value is present, it will be used. If it's a callable, its return value will be used.
                    )
                ),
            ),
        );
        return $arr;
    }

    /**
     * An example of how to register a settings page for rendering.
     * Will not get registered until hooked in.
     * 
     * @since 3.7
     * @see hook()
     */
    protected function _registerSettingsPage()
    {
        // Add action to register field sections to tab
        $this->on('!wprss_add_settings_fields_sections',
            array($this, '_renderSettingsPage'), 10, 1);
    }

    /**
     * An example of how to add custom renderers.
     * @since 3.7
     */
    protected function _getFieldRenderers()
    {
//        $renderers = parent::_getFieldRenderers();
//        $renderers['spc_api_credentials'] = $this->createCommand(array($this, 'renderLoginFields'));
//        return $renderers;
    }

    /**
     * Returns all post types.
     * @see WPRSS_FTP_Settings::get_post_types()
     * 
     * @since 3.7
     * @return array
     */
    public function getPostTypes()
    {
        return WPRSS_FTP_Settings::get_post_types();
    }

    /**
     * Validates the submitted settings.
     * 
     * Must return a potentially sanitized array of settings.
     *
     * @since 3.7
     * @param  array $settings The submitted settings.
     * @return array           The new, sanitized settings.
     */
    public function validate($settings)
    {
        return $settings;
    }

    public function getSectionId($code)
    {
        $sectionId = parent::getSectionId($code);
        return "wprss_{$sectionId}";
    }

    /**
     * @since 1.0
     * @param callable $callable The callback that the command represents.
     * @param array $args The arguments for the callback.
     * @return Core\Model\CommandInterface
     */
    public function createCommand($callable, $args = array())
    {
        return $this->getPlugin()->getFactory()->createCommand($callable, $args);
    }
}
