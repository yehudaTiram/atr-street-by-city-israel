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
		$currentPageId = get_queried_object_id();
		$cities_input = null;
		$options = get_option($this->plugin_name);
		var_dump($options);
		
		if ($options) {
			$parsed_street_city_settings = $this->parse_street_city_settings($options);
			$inputs_structure = $this->populate_inputs_structure($parsed_street_city_settings, $currentPageId);
		}
		var_dump($inputs_structure);
		// If no inputs structure found, return
		if($inputs_structure == null){
			return;
		}		
?>
		<script>
			window.addEventListener("load", (event) => {
				setCityAndStreet()
			});

			function setCityAndStreet() {
				// input elements
				const citiesInput = document.getElementById("<?php echo $inputs_structure["city_dropdown"]["input_id"]; ?>");
				const streetsInput = document.getElementById("<?php echo $inputs_structure["street_dropdown"]["input_id"]; ?>");

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

	public function populate_inputs_structure($parsed_settings, $current_page_id)
	{
		// Check for settings with page ID		
		foreach ($parsed_settings as $setting) {
			// Check for matching page ID first
			if ($setting['page_id'] == $current_page_id) {
				return array(
					'city_dropdown' => array(
						'input_id' => $setting['city_input_id'],
						// Additional configuration for city dropdown (if needed)
					),
					'street_dropdown' => array(
						'input_id' => $setting['street_input_id'],
						// Additional configuration for street dropdown (if needed)
					)
				);
			}
		}

		// If no match for current page ID, check for settings without page ID
		foreach ($parsed_settings as $setting) {
			if (empty($setting['page_id'])) {
				return array(
					'city_input_id' => $setting['city_input_id'],
					'street_input_id' => $setting['street_input_id']
				);
			}
		}

		// If nothing found, return null
		return null;
	}



	/**
	 * Parse the street and city settings from the admin settings
	 * @param array $settings
	 * @return array
	 */
	public function parse_street_city_settings($settings)
	{
		$parsed_settings = array();
		if (isset($settings['atr_street_city_input_list']) && !empty($settings['atr_street_city_input_list'])) {
			$lines = explode("\n", $settings['atr_street_city_input_list']);
			foreach ($lines as $line) {
				$values = explode(",", trim($line)); // Trim whitespace and explode by comma
				if (count($values) === 3) { // Ensure three values
					$parsed_settings[] = array(
						'page_id' => $values[0],
						'city_input_id' => $values[1],
						'street_input_id' => $values[2]
					);
				}
			}
		}
		return $parsed_settings;
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
