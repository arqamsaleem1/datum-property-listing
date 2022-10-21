<?php

/**
 * Fired during plugin activation
 *
 * @link       https://arqamsaleem.wordpress.com
 * @since      1.0.0
 *
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/includes
 * @author     Arqam Saleem <arqamsaleem@gmail.com>
 */
class Datum_Property_Listing_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

        $table_name = $wpdb->prefix . 'datum_property_listing';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                  id mediumint(9) NOT NULL AUTO_INCREMENT,
                  name varchar (100) DEFAULT '' NOT NULL,
                  type varchar (50) DEFAULT '' NOT NULL,
                  price varchar (100) DEFAULT '' NOT NULL,
                  district varchar (200) DEFAULT '' NOT NULL,
                  latitude varchar (100) DEFAULT '' NOT NULL,
                  longitude varchar (100) DEFAULT '' NOT NULL,
                  picture varchar (100) DEFAULT '' NOT NULL,
                  PRIMARY KEY  (id)
                ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
	}

}
