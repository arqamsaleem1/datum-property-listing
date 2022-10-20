<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://arqamsaleem.wordpress.com
 * @since      1.0.0
 *
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/includes
 * @author     Arqam Saleem <arqamsaleem@gmail.com>
 */
class Datum_Property_Listing_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'datum-property-listing',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
