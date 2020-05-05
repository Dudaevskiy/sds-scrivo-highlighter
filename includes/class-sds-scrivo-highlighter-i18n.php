<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://sdstudio.top
 * @since      1.0.0
 *
 * @package    Sds_Scrivo_Highlighter
 * @subpackage Sds_Scrivo_Highlighter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sds_Scrivo_Highlighter
 * @subpackage Sds_Scrivo_Highlighter/includes
 * @author     Serhii Dudchenko <sdstudiovtop@gmail.com>
 */
class Sds_Scrivo_Highlighter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sds-scrivo-highlighter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
