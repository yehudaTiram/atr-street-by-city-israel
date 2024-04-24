<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://atarimtr.co.il
 * @since      1.0.0
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Atr_Street_By_City_Israel
 * @subpackage Atr_Street_By_City_Israel/public
 * @author     Yehuda Tiram <yehuda@atarimtr.co.il>
 */
class Atr_Street_By_City_Israel_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function set_input_elements()
	{
		// Get the current page ID
		$currentPageId = get_the_ID();
		$cities_input = null;
		$streets_input = null;
		$options = $this->get_options();
		if ($options) {
			if ((isset($options['default_atr_city_input'])) && (!empty($options['default_atr_city_input']))) {
				$default_atr_city_input = $options['default_atr_city_input'];
			}
			else {
				$default_atr_city_input = 'city-choice';
			}
			if ((isset($options['default_atr_street_input'])) && (!empty($options['default_atr_street_input']))) {
				$default_atr_street_input = $options['default_atr_street_input'];
			}
			else {
				$default_atr_street_input = 'street-choice';
			}
		}
		switch ($currentPageId) {
			case 422:
				$cities_input = 'billing_city';
				$streets_input = 'billing_address_1';
				break;
			default:
				$cities_input = $default_atr_city_input;
				$streets_input = $default_atr_street_input;
				break;
		}

		// Use the $ageValue variable as needed in your plugin

?>
		<script>
			window.addEventListener("load", (event) => {
				setCityAndStreet()
			});

			function setCityAndStreet() {
				// input elements
				const citiesInput = document.getElementById("<?php echo $cities_input; ?>");
				const streetsInput = document.getElementById("<?php echo $streets_input; ?>");

				if (!streetsInput) {
					if (!citiesInput) {
						return;
					}
					setupInputLists(citiesInput, '');
					createListContainers(citiesInput, '');
					populateCitiesPopulateStreetsOnChange(citiesInput);
				} else {
					setupInputLists(citiesInput, streetsInput);
					createListContainers(citiesInput, streetsInput);
					populateCitiesPopulateStreetsOnChange(citiesInput);
				}
			}
		</script>
<?php
	}

	/**
	 * Options getter
	 * @return array Options, either saved or default ones.
	 */
	public function get_options()
	{

		$options = get_option($this->plugin_name);
		if (isset($this->settings)) {
			if (!$options && is_array($this->settings)) {
				$options = array();
				foreach ($this->settings as $section => $data) {
					foreach ($data['fields'] as $field) {
						$options[$field['id']] = $field['default'];
					}
				}

				add_option($this->plugin_name, $options);
			}
		}


		return $options;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/atr-street-by-city-israel-public.css', array(), rand(100, 100000), 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/atr-street-by-city-israel-public.js', array('jquery'), rand(100, 100000), false);
	}
}
