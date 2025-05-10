<?php

/**
 *  The admin-facing settings of the plugin.
 *
 * @link       https://atarimtr.co.il
 * @since      1.0.0
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Atr_Street_By_City_Israel_Admin
 * @subpackage Atr_Street_By_City_Israel_Admin/admin
 * @author     Yehuda Tiram <yehuda@atarimtr.co.il>
 */


class Atr_Street_By_City_Israel_Admin_Settings
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
     * The slug of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_slug    The current version of this plugin.
     */
    private $plugin_slug;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $settings;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $options;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $dir;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $file;

    /*
     * Fired during plugins_loaded (very very early),
     * so don't miss-use this, only actions and filters,
     * current ones speak for themselves.
     */
    public function __construct($plugin_name, $plugin_slug, $file)
    {
        $this->file = $file;
        $this->plugin_slug = $plugin_slug;
        $this->plugin_name = $plugin_name;

        // Initialise settings
        add_action('admin_init', array($this, 'init'));

        // Add settings page to menu
        add_action('admin_menu', array($this, 'atr_sbci_add_menu_item'));

        // Add settings link to plugins page
        add_filter('plugin_action_links_' . plugin_basename($this->file), array($this, 'add_settings_link'));
    }

    /**
     * Initialise settings
     * @return void
     */
    public function init()
    {
        $this->settings = $this->atr_sbci_settings_fields();
        $this->options = $this->atr_sbci_get_options();
        $this->atr_sbci_register_settings();
    }

    /**
     * Add settings page to admin menu
     * @return void
     */
    public function atr_sbci_add_menu_item()
    {
        $page = add_options_page(__('ATR Street By City Israel', 'atr-street-by-city-israel'), __('ATR Street By City Israel', 'atr-street-by-city-israel'), 'manage_options', $this->plugin_name, array($this, 'atr_sbci_settings_page'));
    }
    /**
     * Add settings link to plugin list table
     * @param  array $links Existing links
     * @return array 		Modified links
     */
    public function atr_sbci_add_action_links($links)
    {
        $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=' . $this->plugin_name)) . '">' . __('Settings', 'atr-street-by-city-israel') . '</a>';
        $links[] = '<a href="http://atarimtr.co.il" target="_blank">' . __('More plugins by Yehuda Tiram', 'atr-street-by-city-israel') . '</a>';
        return $links;
    }

    /**
     * Build settings fields
     * @return array Fields to be displayed on settings page
     */
    private function atr_sbci_settings_fields()
    {
        $settings['easy'] = array(
            'title'                    => __('General', 'atr-street-by-city-israel'),
            'description'            => __('Define fields id to have the cities and streets drop down. Note: only 1 city and 1 street field is possible in a page.', 'atr-street-by-city-israel'),
            'fields'                => array(
                array(
                    'id'             => 'default_atr_city_input',
                    'label'            => __('Write default input ID for cities', 'atr-street-by-city-israel'),
                    'description'    => __('If you fill this, the dropdown will populate it as cities dropdown in every form that has this field ID.', 'atr-street-by-city-israel'),
                    'type' => 'text',
                    'default' => '',
                    'placeholder' => ''
                ),
                array(
                    'id'             => 'default_atr_street_input',
                    'label'            => __('Write default input ID for streets', 'atr-street-by-city-israel'),
                    'description'    => __('If you fill this, the dropdown will populate it as streets dropdown in every form that has this field ID.', 'atr-street-by-city-israel'),
                    'type' => 'text',
                    'default' => '',
                    'placeholder' => ''
                ),

                array(
                    'id'             => 'atr_street_city_input_list',
                    'label'            => __('Write page ID,cities input ID,streets input ID (comma separated). Each page in new line.', 'atr-street-by-city-israel'),
                    'description'    => __('In each line you set the page ID and the city and street id of the text boxes you want to have the dropdowns', 'atr-street-by-city-israel'),
                    'type' => 'textarea',
                    'default' => '',
                    'placeholder' => 'page_id,city_input_id,street_input_id'
                ),


            )
        );

        $settings = apply_filters('plugin_settings_fields', $settings);

        return $settings;
    }

    /**
     * Options getter
     * @return array Options, either saved or default ones.
     */
    public function atr_sbci_get_options()
    {
        $options = get_option($this->plugin_name);
        if (!$options && is_array($this->settings)) {
            $options = array();
            foreach ($this->settings as $section => $data) {
                foreach ($data['fields'] as $field) {
                    $options[$field['id']] = $field['default'];
                }
            }

            add_option($this->plugin_name, $options);
        } elseif ($options && is_array($this->settings)) {
            foreach ($this->settings as $section => $data) {
                foreach ($data['fields'] as $field) {
                    if (!array_key_exists($field['id'], $options)) {
                        $options[$field['id']] = $field['default'];
                    }
                }
            }

            add_option($this->plugin_name, $options);
        }


        return $options;
    }

    /**
     * Register plugin settings
     * @return void
     */
    public function atr_sbci_register_settings()
    {
        if (is_array($this->settings)) {

            register_setting($this->plugin_slug, $this->plugin_slug, array($this, 'validate_fields'));

            foreach ($this->settings as $section => $data) {

                // Add section to page
                add_settings_section($section, $data['title'], array($this, 'atr_sbci_settings_section'), $this->plugin_slug);

                foreach ($data['fields'] as $field) {

                    // Add field to page
                    add_settings_field($field['id'], $field['label'], array($this, 'atr_sbci_display_field'), $this->plugin_slug, $section, array('field' => $field));
                }
            }
        }
    }

    public function atr_sbci_settings_section($section)
    {
        $html = '<p> ' . $this->settings[$section['id']]['description'] . '</p>' . "\n";
        //echo esc_html($html);
        echo wp_kses_post($html);
    }

    /**
     * Generate HTML for displaying fields
     * @param  array $args Field data
     * @return void
     */
    public function atr_sbci_display_field($args)
    {

        $field = $args['field'];

        $html = '';

        $option_name = $this->plugin_slug . "[" . $field['id'] . "]";

        $data = (isset($this->options[$field['id']])) ? $this->options[$field['id']] : '';

        switch ($field['type']) {

            case 'text':
                $html .= '<input id="' . esc_attr($field['id']) . '" type="' . $field['type'] . '" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '" value="' . sanitize_text_field($data) . '"/>' . "\n";
                break;

            case 'textarea':
                $html .= '<textarea id="' . $field['id'] . '" rows="15" cols="150" name="' . $option_name . '" placeholder="' . $field['placeholder'] . '">' . $data . '</textarea><br/>' . "\n";
                break;

        }

        switch ($field['type']) {
            default:
                $html .= '<label for="' . esc_attr($field['id']) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
                break;
        }
        $allowed_tags = wp_kses_allowed_html('post'); // Get default allowed tags
        $allowed_tags['input'] = array('type' => true, 'id' => true, 'name' => true, 'placeholder' => true, 'value' => true); // Add allowed attributes for input
        $allowed_tags['textarea'] = array('type' => true, 'id' => true, 'name' => true, 'placeholder' => true, 'value' => true, 'rows' => true, 'cols' => true); // Add allowed attributes for textarea
        echo wp_kses($html, $allowed_tags);;
    }

    /**
     * Validate individual settings field
     * @param  array $data Inputted value
     * @return array       Validated value
     */
    public function validate_fields($data)
    {
        if ($data['atr_street_city_input_list'] != '') {
            $data['atr_street_city_input_list'] = sanitize_textarea_field($data['atr_street_city_input_list']);
        }
        return $data;
    }

    /**
     * Check if WooCommerce is activated
     */

    private function is_woocommerce_activated()
    {
        if (class_exists('woocommerce')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Load settings page content
     * @return void
     */
    public function atr_sbci_settings_page()
    {
        // Build page HTML output
        // If you don't need tabbed navigation just strip out everything between the <!-- Tab navigation --> tags.
?>
        <div class="wrap" id="<?php echo esc_attr($this->plugin_slug); ?>">
            <h2><?php esc_html_e('ATR Street By City Israel Settings', 'atr-street-by-city-israel'); ?></h2>
            <p><?php esc_html_e('Settings.', 'atr-street-by-city-israel'); ?></p>

            <!-- Tab navigation starts -->
            <h2 class="nav-tab-wrapper settings-tabs hide-if-no-js">
                <?php
                foreach ($this->settings as $section => $data) {
                    echo '<a href="#' . esc_attr($section) . '" class="nav-tab">' . esc_attr($data['title']) . '</a>';
                }
                ?>
            </h2>
            <?php $this->do_script_for_tabbed_nav(); ?>
            <!-- Tab navigation ends -->

            <form action="options.php" method="POST">
                <?php settings_fields($this->plugin_slug); ?>
                <div class="settings-container">
                    <?php do_settings_sections($this->plugin_slug); ?>
                </div>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php
    }

    /**
     * Print jQuery script for tabbed navigation
     * @return void
     */
    private function do_script_for_tabbed_nav()
    {
        // Very simple jQuery logic for the tabbed navigation.
        // Delete this function if you don't need it.
        // If you have other JS assets you may merge this there.
    ?>
        <script>
            jQuery(document).ready(function($) {
                var headings = jQuery('.settings-container > h2, .settings-container > h3');
                var paragraphs = jQuery('.settings-container > p');
                var tables = jQuery('.settings-container > table');
                var triggers = jQuery('.settings-tabs a');

                triggers.each(function(i) {
                    triggers.eq(i).on('click', function(e) {
                        e.preventDefault();
                        triggers.removeClass('nav-tab-active');
                        headings.hide();
                        paragraphs.hide();
                        tables.hide();

                        triggers.eq(i).addClass('nav-tab-active');
                        headings.eq(i).show();
                        paragraphs.eq(i).show();
                        tables.eq(i).show();
                    });
                })

                triggers.eq(0).click();
            });
        </script>
<?php
    }
}
