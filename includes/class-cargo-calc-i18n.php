<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://portfolio.infoblog72.ru
 * @since      1.0.0
 *
 * @package    Cargo_Calc
 * @subpackage Cargo_Calc/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cargo_Calc
 * @subpackage Cargo_Calc/includes
 * @author     Oleg Grebenev <admin@infoblog72.ru>
 */
class Cargo_Calc_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cargo-calc',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
