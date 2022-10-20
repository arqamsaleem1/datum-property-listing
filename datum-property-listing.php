<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://arqamsaleem.wordpress.com
 * @since             1.0.0
 * @package           Datum_Property_Listing
 *
 * @wordpress-plugin
 * Plugin Name:       Datum Property Listing
 * Plugin URI:        https://allshorevirtualstaffing.com
 * Description:       This plugins provides ability to add property listing on your WordPress website.
 * Version:           1.0.0
 * Author:            Arqam Saleem
 * Author URI:        https://arqamsaleem.wordpress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       datum-property-listing
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DATUM_PROPERTY_LISTING_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-datum-property-listing-activator.php
 */
function activate_datum_property_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-datum-property-listing-activator.php';
	Datum_Property_Listing_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-datum-property-listing-deactivator.php
 */
function deactivate_datum_property_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-datum-property-listing-deactivator.php';
	Datum_Property_Listing_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_datum_property_listing' );
register_deactivation_hook( __FILE__, 'deactivate_datum_property_listing' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-datum-property-listing.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_datum_property_listing() {

	$plugin = new Datum_Property_Listing();
	$plugin->run();

}
run_datum_property_listing();
