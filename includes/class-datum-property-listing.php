<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://arqamsaleem.wordpress.com
 * @since      1.0.0
 *
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/includes
 * @author     Arqam Saleem <arqamsaleem@gmail.com>
 */
class Datum_Property_Listing {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Datum_Property_Listing_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DATUM_PROPERTY_LISTING_VERSION' ) ) {
			$this->version = DATUM_PROPERTY_LISTING_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'datum-property-listing';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->register_ajax_callbacks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Datum_Property_Listing_Loader. Orchestrates the hooks of the plugin.
	 * - Datum_Property_Listing_i18n. Defines internationalization functionality.
	 * - Datum_Property_Listing_Admin. Defines all hooks for the admin area.
	 * - Datum_Property_Listing_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-datum-property-listing-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-datum-property-listing-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-datum-property-listing-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-datum-property-listing-public.php';

		$this->loader = new Datum_Property_Listing_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Datum_Property_Listing_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Datum_Property_Listing_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Datum_Property_Listing_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'built_admin_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Datum_Property_Listing_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}
	/**
	 * Ajax hooks registration callback.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function register_ajax_callbacks() {
		add_action( 'wp_ajax_callback_save_form_data', array( $this, 'callback_save_form_data' ) );
		//add_action( 'wp_ajax_nopriv_callback_save_form_data', array( $this, 'callback_save_form_data' ) );
		add_action( 'wp_ajax_callback_import_csv_file', array( $this, 'callback_import_csv_file' ) );
		//add_action( 'wp_ajax_nopriv_callback_import_csv_file', array( $this, 'callback_import_csv_file' ) );
		add_action( 'wp_ajax_callback_edit_property', array( $this, 'callback_edit_property' ) );
		//add_action( 'wp_ajax_nopriv_callback_edit_property', array( $this, 'callback_edit_property' ) );
		add_action( 'wp_ajax_callback_delete_property', array( $this, 'callback_delete_property' ) );
		add_action( 'wp_ajax_callback_update_property', array( $this, 'callback_update_property' ) );
		//add_action( 'wp_ajax_nopriv_callback_delete_property', array( $this, 'callback_delete_property' ) );
	}

	/**
	 * Ajax callback to get submitted data and prepare to save in the database.
	 *
	 * @since    1.0.0
	 */
	public function callback_save_form_data() {

		/** Verifying nonce **/
		if ( ! check_ajax_referer( 'datum-property-listing-nonce', 'security', false ) ) {

			wp_send_json_error( esc_html__( 'Invalid security token sent.', 'datum-property-listing' ) );
		}

		$received_data = array();
		
		$received_data['name']			= sanitize_text_field( $_POST['postedData']['name'] );
		$received_data['type']			= sanitize_text_field( $_POST['postedData']['type'] );
		$received_data['price']			= sanitize_text_field( $_POST['postedData']['price'] );
		$received_data['district']		= sanitize_text_field( $_POST['postedData']['district'] );
		$received_data['longitude']		= sanitize_text_field( $_POST['postedData']['longitude'] );
		$received_data['latitude']		= sanitize_text_field( $_POST['postedData']['latitude'] );
		$received_data['picture']		= sanitize_text_field( $_POST['postedData']['picture'] );

		$validate_message_escaped = $this->validate_form_data( $received_data );
		
		if ( isset( $validate_message_escaped ) && strlen( $validate_message_escaped ) > 1 ) {
			wp_send_json_error( __( $validate_message_escaped, 'datum-property-listing' ) );
		}
		
		if( ! empty( $received_data ) ) {
			$result = $this->save_form_data( $received_data );
		}

		if( $result ) {
			wp_send_json( esc_html__( 'Property is added Successfully', 'datum-property-listing' ) );
		}
		else{
			wp_send_json_error( esc_html__( 'action failed', 'datum-property-listing' ) );
		}
		die();
	}
	
	/**
	 * Ajax callback to update property data in the database.
	 * 
	 * It will receive the updated data for an existing property
	 * and will prepare it to update into the database.
	 *
	 * @since    1.0.0
	 */
	public function callback_update_property() {

		/** Verifying nonce **/
		if ( ! check_ajax_referer( 'datum-property-listing-nonce', 'security', false ) ) {

			wp_send_json_error( esc_html__( 'Invalid security token sent.', 'datum-property-listing' ) );
		}

		$received_data = array();
		
		$received_data['name']			= sanitize_text_field( $_POST['postedData']['name'] );
		$received_data['property_id']	= sanitize_text_field( $_POST['postedData']['propertyId'] );
		$received_data['type']			= sanitize_text_field( $_POST['postedData']['type'] );
		$received_data['price']			= sanitize_text_field( $_POST['postedData']['price'] );
		$received_data['district']		= sanitize_text_field( $_POST['postedData']['district'] );
		$received_data['longitude']		= sanitize_text_field( $_POST['postedData']['longitude'] );
		$received_data['latitude']		= sanitize_text_field( $_POST['postedData']['latitude'] );
		$received_data['picture']		= sanitize_text_field( $_POST['postedData']['picture'] );

		$validate_message_escaped = $this->validate_form_data( $received_data );
		
		if ( isset( $validate_message_escaped ) && strlen( $validate_message_escaped ) > 1 ) {
			wp_send_json_error( __( $validate_message_escaped, 'datum-property-listing' ) );
		}
		
		if( ! empty( $received_data ) ) {
			$result = $this->update_form_data( $received_data );
		}

		if( $result ) {
			wp_send_json( esc_html__( 'Property is updated Successfully', 'datum-property-listing' ) );
		}
		else {
			wp_send_json_error( esc_html__( 'action failed', 'datum-property-listing' ) );
		}
		die();
	}
	
	/**
	 * Ajax callback to Edit property in the database.
	 * 
	 * It will call upon edit button click and will fetch
	 * the record and will populate it into the update form.
	 *
	 * @since    1.0.0
	 */
	public function callback_edit_property() {

		/** Verifying nonce **/
		if ( ! check_ajax_referer( 'datum-property-listing-nonce', 'security', false ) ) {

			wp_send_json_error( esc_html__( 'Invalid security token sent.', 'datum-property-listing' ) );
		}
		
		$current_property_id = sanitize_text_field( $_POST['rowID'] );

		$result = $this->get_property( $current_property_id );

		if( $result ) {
			wp_send_json( $result );
		}
		else{
			wp_send_json_error( esc_html__( 'action failed', 'datum-property-listing' ) );
		}
		die();
	}
	
	/**
	 * Ajax callback to delete property from database.
	 *
	 * @since    1.0.0
	 */
	public function callback_delete_property() {

		/** Verifying nonce **/
		if ( ! check_ajax_referer( 'datum-property-listing-nonce', 'security', false ) ) {

			wp_send_json_error( esc_html__( 'Invalid security token sent.', 'datum-property-listing' ) );
		}
		
		$current_property_id = sanitize_text_field( $_POST['rowID'] );

		$result = $this->delete_form_data( $current_property_id );

		if( $result ) {
			wp_send_json( esc_html__( 'Property is deleted Successfully', 'datum-property-listing' ) );
		}
		else{
			wp_send_json_error( esc_html__( 'action failed', 'datum-property-listing' ) );
		}
		die();
	}

	/**
	 * Ajax callback to import CSV file.
	 * 
	 * This function will receive .csv file from AJAX
	 * and will import it into the database.
	 *
	 * @since    1.0.0
	 */
	public function callback_import_csv_file() {
		global $wpdb;

		/** Verifying nonce **/
		if ( ! check_ajax_referer( 'datum-property-listing-nonce', 'security', false ) ) {
			wp_send_json_error( esc_html__( 'Invalid security token sent.', 'datum-property-listing' ) );
		}

		$table_name = $wpdb->prefix . 'datum_property_listing';
		$import_count = 0;

		$uploaded_file = wp_upload_bits( $_FILES['dplFile']["name"], null, file_get_contents( $_FILES['dplFile']["tmp_name"] ));
		$csv_to_array = array_map( 'str_getcsv', file( $uploaded_file['url'] ) );
		
		foreach ( $csv_to_array as $key => $value ) {
			if ( $key == 0 )
			  continue;
			
			  $data = array( 
				'name' 		=> $value[1],
				'type'		=> $value[2],
				'price'		=> $value[3],
				'district'	=> $value[4],
				'latitude'	=> $value[5],
				'longitude'	=> $value[6],
				'picture'	=> $value[7],

			);	

			$status = $wpdb->insert( $table_name, $data );
			if ( $status ) {
				$import_count++;
			}

			/* $get1 = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
			$get2 = $wpdb->get_row( "SELECT * FROM $table_name WHERE province_title='$province_title'", OBJECT );*/
			
			/* if (isset( $get1 ) or isset( $get2 )) {
				continue;
			}
			else{
				
			}  */
			
		}
		if( $import_count > 0 ) {
			wp_send_json( esc_html__( "$import_count Properties are imported Successfully", 'datum-property-listing' ) );
		}
		else{
			wp_send_json_error( esc_html__( 'action failed', 'datum-property-listing' ) );
		}

		die();
	}

	/**
	 * Saving submitted data to the database.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function save_form_data( $form_data ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'datum_property_listing';
		
		$data = array( 
			'name'		=> $form_data['name'],
			'type'		=> $form_data['type'],
			'price'		=> $form_data['price'],
			'district'	=> $form_data['district'],
			'latitude'	=> $form_data['latitude'],
			'longitude'	=> $form_data['longitude'],
			'picture'	=> $form_data['picture'],
		);
		
		$status = $wpdb->insert( $table_name, $data );
		return $status;
	}
	
	/**
	 * Update submitted data to the database for
	 * a specific property.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function update_form_data( $form_data ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'datum_property_listing';
		
		$data = array( 
			'name'		=> $form_data['name'],
			'type'		=> $form_data['type'],
			'price'		=> $form_data['price'],
			'district'	=> $form_data['district'],
			'latitude'	=> $form_data['latitude'],
			'longitude'	=> $form_data['longitude'],
			'picture'	=> $form_data['picture'],
		);
		$where = array( 'id' => $form_data['property_id'] );

		$status = $wpdb->update( $table_name, $data, $where );
		//$status = $wpdb->insert( $table_name, $data );
		
		return $status;
	}
	
	/**
	 * Get property from the database.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function get_property( $property_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'datum_property_listing';
		
		$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $property_id ) );

		return $result;
	}
	
	/**
	 * Deleting data from the database.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function delete_form_data( $property_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'datum_property_listing';
		
		$status = $wpdb->delete( 
			$table_name, 
			['id' => $property_id],
			['%d'], // verifying id format
		);


		return $status;
	}

	/**
	 * Function to validate data submit through the enquiry form.
	 *
	 * @since    1.0.0
	 */
	public function validate_form_data( $data_to_validate ) {
		$notices = '';
		$allowed_types = array( 'land', 'home', 'condos', 'business', 'commercial' );

		if ( empty( $data_to_validate['name'] ) || strlen( $data_to_validate['name'] ) > 100 ) {
			$notices = $notices.'<li>' . esc_html__( 'Name is not valid.', 'datum-property-listing' ) . '</li>';
		}
		//if ( empty( $data_to_validate['type'] ) || in_array( $data_to_validate['type'], $allowed_types ) ) {
		if ( empty( $data_to_validate['type'] ) ) {
			$notices = $notices.'<li>' . esc_html__( 'Type is not valid. '.$data_to_validate['type'], 'datum-property-listing' ) . '</li>';
		}
		if ( empty( $data_to_validate['price'] ) ) {
			$notices = $notices.'<li>' . esc_html__( 'Price is empty.', 'datum-property-listing' ) . '</li>';
		}
		if ( empty( $data_to_validate['district'] ) ) {
			$notices = $notices.'<li>' . esc_html__( 'District is empty.', 'datum-property-listing' ) . '</li>';
		}
		if ( empty( $data_to_validate['longitude'] ) ) {
			$notices = $notices.'<li>' . esc_html__( 'Longitude is empty.', 'datum-property-listing' ) . '</li>';
		}
		if ( empty( $data_to_validate['latitude'] ) ) {
			$notices = $notices.'<li>' . esc_html__( 'Latitude is empty.', 'datum-property-listing' ) . '</li>';
		}
		if ( empty( $data_to_validate['picture'] ) ) {
			$notices = $notices.'<li>' . esc_html__( 'Picture is empty.', 'datum-property-listing' ) . '</li>';
		}

		return $notices;
	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Datum_Property_Listing_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
