<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://arqamsaleem.wordpress.com
 * @since      1.0.0
 *
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/admin
 * @author     Arqam Saleem <arqamsaleem@gmail.com>
 */
class Datum_Property_Listing_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Datum_Property_Listing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Datum_Property_Listing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/datum-property-listing-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Datum_Property_Listing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Datum_Property_Listing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 
			$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/datum-property-listing-admin.js', 
			array( 'jquery' ), $this->version, 
			true 
		);
		wp_localize_script( 
			$this->plugin_name,
			'dpl_plugin_ajax_url', 
		 	array( 
		 		'ajax_url' => admin_url( 'admin-ajax.php' ),
		 		'security'  => wp_create_nonce( 'datum-property-listing-nonce' ),
			)
		);

	}

	/**
	 * Callback function to create Plugin's menu in Admin Dashboard,
	 * will passed into the hook in Datum_Property_Listing class.
	 */
	public function built_admin_menu() {
		add_menu_page( 'All properties', 'Datum Listing', 'manage_options', 'dpl_settings', array( $this, 'dpl_setting_page_callback' ));
		add_submenu_page( 'dpl_settings', 'Add new', 'Add new', 'manage_options', 'dpl_settings_add_new', array( $this, 'dpl_settings_add_new_callback' ) );
		add_submenu_page( 'dpl_settings', 'Import Properties', 'Import', 'manage_options', 'dpl_settings_import', array( $this, 'dpl_settings_import_callback' ) );
	}

	/**
	 * Callaback function for admin menu
	 */
	function dpl_setting_page_callback() {
		$plugin_core = new Datum_Property_Listing();
		$results = $plugin_core->get_all_properties_listing();

		load_template( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/datum-property-listing-admin-display.php', 
			true,
			array(
				'entries' => $results[0],
				'total_number_of_pages' => $results[1],
			)
		);
		//load_template( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/datum-property-listing-admin-display.php' );
	}

	/**
	 * Callaback function for admin sub-menu
	 */
	function dpl_settings_add_new_callback() {

		load_template( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/datum-property-listing-add-new.php' );
	}
	
	/**
	 * Callaback function for admin sub-menu
	 */
	function dpl_settings_import_callback() {

		load_template( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/datum-property-listing-import-data.php' );
	}
}
