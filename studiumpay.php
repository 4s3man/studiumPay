<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.dono.ls
 * @since             1.0.0
 * @package           Studiumpay
 *
 * @wordpress-plugin
 * Plugin Name:       StudiumPayment24
 * Plugin URI:        none
 * Description:       Pugin for przelewy24 payment
 * Version:           1.0.0
 * Author:            Jakub Kułaga
 * Author URI:        none
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       studiumpay
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
define( 'STUDIUMPAY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-studiumpay-activator.php
 */
function activate_studiumpay() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-studiumpay-activator.php';
	Studiumpay_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-studiumpay-deactivator.php
 */
function deactivate_studiumpay() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-studiumpay-deactivator.php';
	Studiumpay_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_studiumpay' );
register_deactivation_hook( __FILE__, 'deactivate_studiumpay' );

/**
 * Loads przelewy24 class
 */
require plugin_dir_path( __FILE__ ) . 'includes/libraries/Przelewy24/class_przelewy24.php';
/**

 * Loads formidable with dependencies
 */
require plugin_dir_path( __FILE__ ) . 'includes/libraries/Formidable-master/autoload.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-studiumpay.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_studiumpay() {

	$plugin = new Studiumpay();
	$plugin->run();

}
run_studiumpay();
