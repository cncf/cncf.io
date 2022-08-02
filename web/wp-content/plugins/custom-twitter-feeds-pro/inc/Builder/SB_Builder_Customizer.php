<?php
/**
 * Customizer Builder
 *
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder;

if(!defined('ABSPATH'))	exit;

class SB_Builder_Customizer{


	/**
	 * Controls Classes Array
	 *
	 *
	 * @since 2.0
	 * @access private
	 *
	 * @var array
	 */
	public static $controls_classes = [];


	/**
	 * Get controls list.
	 *
	 * Getting controls list
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return array
	*/
	public static function get_controls_list(){
		return [
			'actionbutton',
			'checkbox',
			'checkboxsection',
			'datepicker',
			'colorpicker',
			'number',
			'select',
			'switcher',
			'text',
			'textarea',
			'toggle',
			'toggleset',
			'heading',
			'separator',
			'customview',
			'coloroverride',
			'togglebutton',
			'hidden',
			'imagechooser',
			'checkboxlist',
			'notice'
		];
	}

	/**
	 * Register Controls
	 *
	 * Including Control
	 *
	 * @since 2.0
	 * @access public
	 *
	*/
	public static function register_controls(){
		$controls_list = self::get_controls_list();
		foreach ($controls_list as $control) {
			$controlClassName = 'SB_'.ucfirst($control).'_Control';
			$cls_name = __NAMESPACE__.''.'\Controls\\'.$controlClassName;
			$control_class = new $cls_name();
			self::$controls_classes[$control] = $control_class;
		}
	}

	/**
	 * Print Controls Vue JS Tempalte
	 *
	 * Including Control
	 *
	 * @since 2.0
	 * @access public
	 *
	*/
	public static function get_controls_templates($editingType){
		$controls_list = self::get_controls_list();
		foreach ($controls_list as $control) {
			self::$controls_classes[$control]->print_control_wrapper($editingType);
		}
	}
}