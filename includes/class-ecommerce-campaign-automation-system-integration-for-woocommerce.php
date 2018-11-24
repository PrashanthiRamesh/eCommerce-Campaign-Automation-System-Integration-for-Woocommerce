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

		/*
		* Update Last seen of user
		*/
		$this->loader->add_action('wp_footer',$this, 'user_last_login');

	}

	function user_last_login( $user_login, $user ) {
	update_user_meta( $user->ID, 'last_login', time() );
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
			$base="integrate";
			$base_products = 'woo/get/all/products';
			$base_categories = 'woo/get/all/categories';
			$base_orders = 'woo/get/all/orders';
			$base_customers = 'woo/get/all/customers';
			$base_abandoned_cart = 'woo/get/all/abandoned_carts';
			register_rest_route( $namespace, '/' . $base, array(
					array(
							'methods'         => \WP_REST_Server::READABLE,
							'callback'        => array( $this, 'test' ),
					)
			)  );
			register_rest_route( $namespace, '/' . $base_products, array(
					array(
							'methods'         => \WP_REST_Server::CREATABLE,
							'callback'        => array( $this, 'get_all_products' ),
					)
			)  );
			register_rest_route( $namespace, '/' . $base_categories, array(
					array(
							'methods'         => \WP_REST_Server::CREATABLE,
							'callback'        => array( $this, 'get_all_categories' ),
					)
			)  );
			register_rest_route( $namespace, '/' . $base_orders, array(
					array(
							'methods'         => \WP_REST_Server::CREATABLE,
							'callback'        => array( $this, 'get_all_orders' ),
					)
			)  );
			register_rest_route( $namespace, '/' . $base_customers, array(
					array(
							'methods'         => \WP_REST_Server::CREATABLE,
							'callback'        => array( $this, 'get_all_customers' ),
					)
			)  );
			register_rest_route( $namespace, '/' . $base_abandoned_cart, array(
					array(
							'methods'         => \WP_REST_Server::CREATABLE,
							'callback'        => array( $this, 'get_all_abandoned_carts' ),
					)
			)  );

	}

	public function test(){
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM wp_woocommerce_sessions");

		return $results;
	}

	public function get_all_products( \WP_REST_Request $request ){
			$remote_params= $request->get_body_params();
			$remote_email=$remote_params['woo-email'];
			$remote_user_name=$remote_params['woo-username'];
			$remote_password=$remote_params['woo-password'];
			if(!isset($remote_user_name) || !isset($remote_password) || !isset($remote_email)){
					return new \WP_Error('Fail','Provide woo-email, woo-username and woo-password',array('status'=>401));
			}
			$user=get_user_by('email', $remote_email);
			if($user->user_login==$remote_user_name){		// compare username
					if ( $user && wp_check_password( $remote_password, $user->data->user_pass, $user->ID) ){ //compare md5 hash of password
					$user_meta = get_user_meta($user->ID); 	// Get the user object.
					$user_level=$user_meta['wp_user_level'][0];
							if( $user_level==10 ){		//check if user is admin
								return $this->get_products();		//return all data
							}else{
								return new \WP_Error('Fail','Ops ! You are not Authorised to access the requested information.'.$user->user_pass_md5,array('status'=>401));
							}
					}else{
							return new \WP_Error('Fail','Incorrect Password'.$user->user_pass_md5,array('status'=>401));
					}
			}else{
					return new \WP_Error('Fail','Incorrect Username'.$current_user->user_login,array('status'=>401));
			}
	}

	public function get_all_categories( \WP_REST_Request $request ){
			$remote_params= $request->get_body_params();
			$remote_email=$remote_params['woo-email'];
			$remote_user_name=$remote_params['woo-username'];
			$remote_password=$remote_params['woo-password'];
			if(!isset($remote_user_name) || !isset($remote_password) || !isset($remote_email)){
					return new \WP_Error('Fail','Provide woo-email, woo-username and woo-password',array('status'=>401));
			}
			$user=get_user_by('email', $remote_email);
			if($user->user_login==$remote_user_name){		// compare username
					if ( $user && wp_check_password( $remote_password, $user->data->user_pass, $user->ID) ){ //compare md5 hash of password
					$user_meta = get_user_meta($user->ID); 	// Get the user object.
					$user_level=$user_meta['wp_user_level'][0];
							if( $user_level==10 ){		//check if user is admin
								return $this->get_categories();		//return all data
							}else{
								return new \WP_Error('Fail','Ops ! You are not Authorised to access the requested information.'.$user->user_pass_md5,array('status'=>401));
							}
					}else{
							return new \WP_Error('Fail','Incorrect Password'.$user->user_pass_md5,array('status'=>401));
					}
			}else{
					return new \WP_Error('Fail','Incorrect Username'.$current_user->user_login,array('status'=>401));
			}
	}

	public function get_all_orders( \WP_REST_Request $request ){
			$remote_params= $request->get_body_params();
			$remote_email=$remote_params['woo-email'];
			$remote_user_name=$remote_params['woo-username'];
			$remote_password=$remote_params['woo-password'];
			if(!isset($remote_user_name) || !isset($remote_password) || !isset($remote_email)){
					return new \WP_Error('Fail','Provide woo-email, woo-username and woo-password',array('status'=>401));
			}
			$user=get_user_by('email', $remote_email);
			if($user->user_login==$remote_user_name){		// compare username
					if ( $user && wp_check_password( $remote_password, $user->data->user_pass, $user->ID) ){ //compare md5 hash of password
					$user_meta = get_user_meta($user->ID); 	// Get the user object.
					$user_level=$user_meta['wp_user_level'][0];
							if( $user_level==10 ){		//check if user is admin
								return $this->get_orders();		//return all data
							}else{
								return new \WP_Error('Fail','Ops ! You are not Authorised to access the requested information.'.$user->user_pass_md5,array('status'=>401));
							}
					}else{
							return new \WP_Error('Fail','Incorrect Password'.$user->user_pass_md5,array('status'=>401));
					}
			}else{
					return new \WP_Error('Fail','Incorrect Username'.$current_user->user_login,array('status'=>401));
			}
	}

	public function get_all_customers( \WP_REST_Request $request ){
			$remote_params= $request->get_body_params();
			$remote_email=$remote_params['woo-email'];
			$remote_user_name=$remote_params['woo-username'];
			$remote_password=$remote_params['woo-password'];
			if(!isset($remote_user_name) || !isset($remote_password) || !isset($remote_email)){
					return new \WP_Error('Fail','Provide woo-email, woo-username and woo-password',array('status'=>401));
			}
			$user=get_user_by('email', $remote_email);
			if($user->user_login==$remote_user_name){		// compare username
					if ( $user && wp_check_password( $remote_password, $user->data->user_pass, $user->ID) ){ //compare md5 hash of password
					$user_meta = get_user_meta($user->ID); 	// Get the user object.
					$user_level=$user_meta['wp_user_level'][0];
							if( $user_level==10 ){		//check if user is admin
								return $this->get_customers();		//return all data
							}else{
								return new \WP_Error('Fail','Ops ! You are not Authorised to access the requested information.'.$user->user_pass_md5,array('status'=>401));
							}
					}else{
							return new \WP_Error('Fail','Incorrect Password'.$user->user_pass_md5,array('status'=>401));
					}
			}else{
					return new \WP_Error('Fail','Incorrect Username'.$current_user->user_login,array('status'=>401));
			}
	}

	public function get_all_abandoned_carts( \WP_REST_Request $request ){
			$remote_params= $request->get_body_params();
			$remote_email=$remote_params['woo-email'];
			$remote_user_name=$remote_params['woo-username'];
			$remote_password=$remote_params['woo-password'];
			if(!isset($remote_user_name) || !isset($remote_password) || !isset($remote_email)){
					return new \WP_Error('Fail','Provide woo-email, woo-username and woo-password',array('status'=>401));
			}
			$user=get_user_by('email', $remote_email);
			if($user->user_login==$remote_user_name){		// compare username
					if ( $user && wp_check_password( $remote_password, $user->data->user_pass, $user->ID) ){ //compare md5 hash of password
					$user_meta = get_user_meta($user->ID); 	// Get the user object.
					$user_level=$user_meta['wp_user_level'][0];
							if( $user_level==10 ){		//check if user is admin
								return $this->get_abandoned_carts();		//return all data
							}else{
								return new \WP_Error('Fail','Ops ! You are not Authorised to access the requested information.'.$user->user_pass_md5,array('status'=>401));
							}
					}else{
							return new \WP_Error('Fail','Incorrect Password'.$user->user_pass_md5,array('status'=>401));
					}
			}else{
					return new \WP_Error('Fail','Incorrect Username'.$current_user->user_login,array('status'=>401));
			}
	}

	public function get_products(){
		$args     = array( 'post_type' => 'product', 'posts_per_page' => -1 );
		$woo_products = get_posts( $args );
		$products=array();
		foreach ($woo_products as $woo_product) {
			$product_id=$woo_product->ID;
			$product= wc_get_product( $product_id);
			$products[]=array(
				'id'=>$product_id,
				'name'=>$product->name,
				'sku'=>$product->get_sku(),
				'price'=>$product->get_price(),
				'categories'=>$this->get_woo_categories($product->get_category_ids())
			);
		}
		return $products;
	}

	public function get_categories(){
		$args = array(
		'taxonomy'   => "product_cat"
		);
		$product_categories = get_terms($args);
			foreach ($product_categories as $product_category) {
				$categories[]=array(
					'id'=>$product_category->term_id,
					'name'=>$product_category->name
				);
			}
		return $categories;
	}

	public function get_woo_categories($ids){
		$categories=array();
		foreach ($ids as $id) {
			$term = get_term_by( 'id', $id, 'product_cat', 'ARRAY_A' );
	 		$categories[]=array(
				'id'=>$id,
				'name'=>$term['name']
			);
		}
		return $categories;
	}

	public function get_customers(){
				$wp_users = get_users();
				$users=array();
				foreach($wp_users as $wp_user){
					$user = get_userdata( $wp_user->ID );
					$user_meta=get_user_meta($wp_user->ID);
					if($user->roles[0]!='administrator'){
						$last_seen=is_null($user_meta['last_seen'][0])?$user->user_registered:$user_meta['last_seen'][0];
						//  $the_last_seen_date = human_time_diff($last_seen);
						$users[]=array(
							'id'=>$user->ID,
							'email'=>$user->user_email,
							'username'=>$user->user_login,
							'first_name'=>$user_meta['first_name'][0],
							'last_name'=>$user_meta['last_name'][0],
							'created_at'=>$user->user_registered,
							'last_seen'=> $last_seen
						);
					}
				}
				return $users;
	}

	public function get_orders(){
				global $wpdb;
				$sql = "SELECT * FROM $wpdb->posts WHERE post_type='shop_order'";
				$woo_orders = $wpdb->get_results( $sql);
				$order_ids=wp_list_pluck($woo_orders,'ID');
				$orders=array();
				foreach ($order_ids as $order_id){
					$order = new \WC_Order($order_id);
					if($order && gettype($order)=='object') {
							$post_order_items = $order->get_items();
							$order_items = array();
							if (!empty($post_order_items)) {
									foreach ($post_order_items as $post_order_item) {
											$order_item_data = $post_order_item->get_data();
											$product_id = empty($order_item_data['variation_id']) ? $order_item_data['product_id'] : $order_item_data['variation_id'];
											$product = wc_get_product($product_id);
											if (gettype($product) == 'object') {
													$order_items[] = array(
															'r_product_id' => $product_id,
															'sku' => empty($product->get_sku()) ? $product_id : $product->get_sku(),
															'product_name' => $product->get_title(),
															'product_price' => $product->get_price(),
															'item_qty' => $post_order_item->get_quantity(),
																		);

											} else {
													$order_items[] = array(
															'r_product_id' => empty($product_id)?$order_item_data['id']:$product_id,
															'sku' => empty($product_id)?$order_item_data['id']:$product_id,
															'product_name' => $post_order_item->get_name(),
															'product_price' => $post_order_item['line_total'],
															'item_qty' => $post_order_item['qty'],
																											);
											}
									}
							} else {
									return array();
							}
							$billing =array(array(
									'first_name' => $order->get_billing_first_name(),
									'last_name' => $order->get_billing_last_name(),
					 				'email' => $order->get_billing_email(),
									'mobile' => $order->get_billing_phone(),
									'address_1' => $order->get_billing_address_1(),
									'address_2' => $order->get_billing_address_2(),
									'city' => $order->get_billing_city(),
									'state' => $order->get_billing_state(),
									'country' => $order->get_billing_country(),
									'zipcode' => $order->get_billing_postcode()
							)) ;
							$shipping =array(array(
									'first_name' => !empty($order->get_shipping_first_name()) ? $order->get_shipping_first_name() : $order->get_billing_first_name(),
									'last_name' => !empty($order->get_shipping_last_name()) ? $order->get_shipping_last_name() : $order->get_billing_last_name(),
									'email' => $order->get_billing_email(),             //note: No Shipping Email
									'mobile' => $order->get_billing_phone(),            //note: No Shipping Phone
									'address_1' => !empty($order->get_shipping_address_1()) ? $order->get_shipping_address_1() : $order->get_billing_address_1(),
									'address_2' => !empty($order->get_shipping_address_2()) ? $order->get_shipping_address_2() : $order->get_billing_address_2(),
									'city' => !empty($order->get_shipping_city()) ? $order->get_shipping_city() : $order->get_billing_state(),
									'state' => !empty($order->get_shipping_state()) ? $order->get_shipping_state() : $order->get_billing_state(),
									'country' => !empty($order->get_shipping_country()) ? $order->get_shipping_country() : $order->get_billing_country(),
									'zipcode' => !empty($order->get_shipping_postcode()) ? $order->get_shipping_postcode() : $order->get_billing_postcode(),
							)) ;

							$created_at = empty($order->get_date_created()) ? current_time('mysql') : $order->get_date_created()->date('Y-m-d H:i:s');
							$updated_at = empty($order->get_date_modified()) ? current_time('mysql') : $order->get_date_modified()->date('Y-m-d H:i:s');
							$orders[] = array(
									'id' => $order->get_id(),
									'customer_email' => $order->get_billing_email(),
									'customer_name' => $order->get_billing_first_name(),
									'order_total' => $order->get_total(),
									'order_items' => $order_items,
									'shipping' => $shipping,
									'billing' => $billing,
									'created_at' => $created_at,
									'updated_at' => $updated_at,
							);
					}
				}
				return $orders;
	}

	public function get_abandoned_carts(){
		global $wpdb;
		$woo_abandoned_carts = $wpdb->get_results( "SELECT * FROM wp_woocommerce_sessions");
		$abandoned_carts=array();
		foreach ($woo_abandoned_carts as $woo_abandoned_cart) {
			$abandoned=unserialize($woo_abandoned_cart->session_value);
			$abandoned_cart_result=unserialize($abandoned['customer']);
			if($abandoned_cart_result['email']!='prash@gmail.com'){
					$abandoned_carts[]=$abandoned_cart_result;
			}
		}
		return $abandoned_carts;
	}

}
