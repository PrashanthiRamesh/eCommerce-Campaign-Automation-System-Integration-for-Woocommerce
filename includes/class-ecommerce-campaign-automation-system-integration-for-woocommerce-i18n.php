<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       concordia.ca
 * @since      1.0.0
 *
 * @package    Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce
 * @subpackage Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce
 * @subpackage Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce/includes
 * @author     Team SPM <team_spm@gmail.com>
 */
class Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ecommerce-campaign-automation-system-integration-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
