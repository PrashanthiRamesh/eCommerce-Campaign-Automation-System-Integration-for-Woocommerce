<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       concordia.ca
 * @since      1.0.0
 *
 * @package    Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce
 * @subpackage Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce/includes
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
 * @package    Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce
 * @subpackage Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce/includes
 * @author     Team SPM <team_spm@gmail.com>
 */
class Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
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

	//The namespace and version for the REST SERVER
	protected $my_namespace = 'campaignit/v';
	protected $my_version   = '1';

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
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ecommerce-campaign-automation-system-integration-for-woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_rest_api_hook();	//rest api hook init

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ecommerce-campaign-automation-system-integration-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ecommerce-campaign-automation-system-integration-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ecommerce-campaign-automation-system-integration-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ecommerce-campaign-automation-system-integration-for-woocommerce-public.php';

		$this->loader = new Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_i18n();

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

		$plugin_admin = new Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Rest API Initiate
	 */

	public function define_rest_api_hook(){
			$this->loader->add_action('rest_api_init', $this, 'integrate');
	}


	public function integrate(){
			$namespace = $this->my_namespace . $this->my_version;
			$base      = 'integrate';
			register_rest_route( $namespace, '/' . $base, array(
					array(
							'methods'         => \WP_REST_Server::READABLE,
							'callback'        => array( $this, 'test' ),
				 ),
					array(
							'methods'         => \WP_REST_Server::CREATABLE,
							'callback'        => array( $this, 'get_all' ),
					)
			)  );
	}

	public function test(){
			return 'yay';
	}

	public function get_all( \WP_REST_Request $request ){
			$remote_params= $request->get_body_params();
			$remote_email=$remote_params['woo-email'];
			$remote_user_name=$remote_params['woo-username'];
			$remote_password=$remote_params['woo-password'];
			if(!isset($remote_user_name) || !isset($remote_password) || !isset($remote_email)){
					return new \WP_Error('Fail','Provide woo-email, woo-username and woo-password',array('status'=>401));
			}
			$user=get_user_by('email', $remote_email);
			if($user->user_login==$remote_user_name){		// compare username
					if ( $user && wp_check_password( $remote_password, $user->data->user_pass, $user->ID) ){		//compare md5 hash of password
							return array('integration'=>true);		//return all data
					}else{
							return new \WP_Error('Fail','Incorrect Password'.$user->user_pass_md5,array('status'=>401));
					}
			}else{
					return new \WP_Error('Fail','Incorrect Username'.$current_user->user_login,array('status'=>401));
			}
	}

}
