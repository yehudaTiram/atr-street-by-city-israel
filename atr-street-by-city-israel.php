<?php

/**
 * that starts the plugin.
 *
 * @link              https://atarimtr.co.il
 * @since             1.0.0
 * @package           Atr_Street_By_City_Il
 *
 * @wordpress-plugin
 * Plugin Name:       ATR Street By City Israel
 * Plugin URI:        https://atarimtr.co.il
 * Description:       Select a street by city in Israel. Cities data is from https://data.gov.il/dataset/citiesandsettelments. Streets data is from https://data.gov.il/dataset/321. API documentation https://docs.ckan.org/en/latest/maintaining/datastore.html#ckanext.datastore.logic.action.datastore_search. Adapted to Contact form 7 from https://codepen.io/tombigel/pen/LYbxPRa BY Tom B https://codepen.io/tombigel
 * Version:           1.0.0
 * Author:            Yehuda Tiram
 * Author URI:        https://atarimtr.co.il/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       atr-street-by-city-il
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
function atr_street_by_city_il_assets() {
	wp_enqueue_script( 'atr-street-by-city-israel', plugins_url( 'atr-street-by-city-israel.js' , __FILE__ ), array(), '1.0.0' );

}
add_action( 'wp_enqueue_scripts', 'atr_street_by_city_il_assets', 20 );

