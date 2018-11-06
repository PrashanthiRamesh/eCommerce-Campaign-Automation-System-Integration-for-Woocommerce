<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              concordia.ca
 * @since             1.0.0
 * @package           Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       eCommerce Campaign Automation System Integration for Woocommerce
 * Plugin URI:        concordia.ca
 * Description:       Integration plugin for CampaignIt and Woocommerce
 * Version:           1.0.0
 * Author:            Team 1 SOEN 6841 Project
 * Author URI:        concordia.ca
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ecommerce-campaign-automation-system-integration-for-woocommerce
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
define( 'CAMPAIGNIT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ecommerce-campaign-automation-system-integration-for-woocommerce-activator.php
 */
function activate_ecommerce_campaign_automation_system_integration_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ecommerce-campaign-automation-system-integration-for-woocommerce-activator.php';
	Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ecommerce-campaign-automation-system-integration-for-woocommerce-deactivator.php
 */
function deactivate_ecommerce_campaign_automation_system_integration_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ecommerce-campaign-automation-system-integration-for-woocommerce-deactivator.php';
	Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ecommerce_campaign_automation_system_integration_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_ecommerce_campaign_automation_system_integration_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ecommerce-campaign-automation-system-integration-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ecommerce_campaign_automation_system_integration_for_woocommerce() {

	$plugin = new Ecommerce_Campaign_Automation_System_Integration_For_Woocommerce();
	$plugin->run();

}
run_ecommerce_campaign_automation_system_integration_for_woocommerce();



  	
