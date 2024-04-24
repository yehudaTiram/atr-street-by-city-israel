<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://atarimtr.co.il
 * @since             1.0.0
 * @package           Atr_Street_By_City_Israel
 *
 * @wordpress-plugin
 * Plugin Name:       ATR Street By City Israel
 * Plugin URI:        https://atarimtr.co.il
 * Description:       Add a dropdown to select a street by city in Israel for any form with city-street (or city only) fields (Woocommerce,Contact form 7, Elementor). 
 * Version:           1.0.0
 * Author:            Yehuda Tiram
 * Author URI:        https://atarimtr.co.il/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       atr-street-by-city-israel
 * Domain Path:       /languages
 */
/** 
 * Cities data is from https://data.gov.il/dataset/citiesandsettelments. 
 * Streets data is from https://data.gov.il/dataset/321. 
 * API documentation https://docs.ckan.org/en/latest/maintaining/datastore.html#ckanext.datastore.logic.action.datastore_search. 
 * Adapted to Contact form 7 from https://codepen.io/tombigel/pen/LYbxPRa BY Tom B https://codepen.io/tombigel */
/** These fields must be present in the form.
 * <label> בחרו עיר:
 *   [text city-choice id:city-choice] </label>
 * <label> בחרו רחוב:
 * [text street-choice id:street-choice] </label>
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
define( 'ATR_STREET_BY_CITY_ISRAEL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-atr-street-by-city-israel-activator.php
 */
function activate_atr_street_by_city_israel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-atr-street-by-city-israel-activator.php';
	Atr_Street_By_City_Israel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-atr-street-by-city-israel-deactivator.php
 */
function deactivate_atr_street_by_city_israel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-atr-street-by-city-israel-deactivator.php';
	Atr_Street_By_City_Israel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_atr_street_by_city_israel' );
register_deactivation_hook( __FILE__, 'deactivate_atr_street_by_city_israel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-atr-street-by-city-israel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_atr_street_by_city_israel() {

	$plugin = new Atr_Street_By_City_Israel();
	$plugin->run();

}
run_atr_street_by_city_israel();
