<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://atarimtr.co.il
 * @since      1.0.0
 *
 * @package    Atr_Street_By_City_Israel
 * @subpackage Atr_Street_By_City_Israel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Atr_Street_By_City_Israel
 * @subpackage Atr_Street_By_City_Israel/admin
 * @author     Yehuda Tiram <yehuda@atarimtr.co.il>
 */
class Atr_Street_By_City_Israel_Admin {

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
		$this->load_dependencies();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/atr-street-by-city-israel-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/atr-street-by-city-israel-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Load the required dependencies for the Admin facing functionality.
	 * Registers the admin settings and page.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for admin settings of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) .  'admin/class-atr-street-by-city-israel-admin-settings.php';
	}

}
