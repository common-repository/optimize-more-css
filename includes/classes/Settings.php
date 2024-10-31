<?php

if (!defined('WPINC')) {
    die;
}

class OPM_CSS_Settings {
    
    private $settings;

    function __construct()
    {
        $this->init_settings();
        add_action('init', array($this, 'init'));
        add_action('opm_css_after_body', array($this, 'add_import_html'));
    }

    public function init()
    {
        // check or initiate import
        $this->import();

        if (!isset($_GET['opm_css-action'])) {
            return;
        }

        // check or initiate reset
        $this->reset_plugin();

        // check or initiate export
        $this->export();

    }

    public function get($key = "", $default = false)
    {
        if (!isset($this->settings[$key])) {
            return $default;
        }

        $value = opm_css_removeslashes($this->settings[$key]);
        if (empty($value) || is_null($value)) {
            return false;
        }

        if (is_array($value) && count($value) == 0) {
            return false;
        }

        return $value;
    }

    public function reset()
    {
        $this->settings = array();
    }

    public function setAll($value)
    {
        $this->settings = $value;
    }

    public function getAll()
    {
        return $this->settings;
    }

    public function set($key, $value)
    {
        $this->settings[$key] = $value;
    }

    public function remove($key)
    {
        if (isset($this->settings[$key])) {
            unset($this->settings[$key]);
        }
    }

    public function save()
    {
        update_option("opm_css_options", $this->settings);
		
    }

    public function store()
    {
        do_action('opm_css_before_saving', $this);
        $this->reset();
        $this->set('version', OPM_CSS_VERSION);

        foreach ($this->keys() as $key) {
            $setting_value = '';
            if (isset($_POST[$key])) {
                $setting_value = opm_css_kses($_POST[$key]);
            }
            $this->set($key, $setting_value);
        }

        $placeholder = ''; // use the same method used by preview wizard
        do_action('opm_css_save_addtional_settings', $this, $placeholder);

        $this->save();

        do_action('opm_css_after_saving', $this);

        OPM_CSS_Queue('Settings saved.');
        wp_redirect(opm_css()->admin_url());
        exit;
    }

    public function init_settings()
    {
        $settings = get_option("opm_css_options", false);

        if (!$settings) {
            $settings = $this->default_options();
        }

        $this->settings = $settings;
		
    }

    public function add_import_html()
    {
        opm_css()->admin_view('parts/import-settings');
    }

    public function import()
    {
        if (!isset($_POST['opm_css-settings_nonce'])) return;

        if (!is_admin() && !current_user_can('manage_options')) {
            return;
        }

        if (!isset($_POST['opm_css-settings']) && !isset($_FILES['import_file'])) {
            return;
        }

        if (!isset($_FILES['import_file'])) {
            return;
        }

        if ($_FILES['import_file']['size'] == 0 && $_FILES['import_file']['name'] == '') {
            return;
        }

        // check nonce
        if (!wp_verify_nonce($_POST['opm_css-settings_nonce'], 'opm_css-settings-action')) {

           OPM_CSS_Queue('Sorry, your nonce did not verify.', 'error');
            wp_redirect(opm_css()->admin_url());
            exit;
        }

        $import_field = 'import_file';
        $temp_file_raw = $_FILES[$import_field]['tmp_name'];
        $temp_file = esc_attr($temp_file_raw);
        $arr_file_type = $_FILES[$import_field];
        $uploaded_file_type = $arr_file_type['type'];
        $allowed_file_types = array('application/json');


        if (!in_array($uploaded_file_type, $allowed_file_types)) {
            OPM_CSS_Queue('Upload a valid .json file.', 'error');
            wp_redirect(opm_css()->admin_url());
            exit;
        }

        $settings = (array)json_decode(
            file_get_contents($temp_file),
            true
        );

        unlink($temp_file);

        if (!$settings) {

            OPM_CSS_Queue('Nothing to import, please check your json file format.', 'error');
            wp_redirect(opm_css()->admin_url());
            exit;

        }

        $this->setAll($settings);
        $this->save();

        OPM_CSS_Queue('Your Import has been completed.');

        wp_redirect(opm_css()->admin_url());
        exit;
    }


    public function export()
    {
        if (!isset($_GET['opm_css-action']) || (isset($_GET['opm_css-action']) && $_GET['opm_css-action'] != 'export')) {
            return;
        }

        $settings = $this->getAll();

        if (!is_array($settings)) {
            $settings = array();
        }

        $settings = json_encode($settings);

        header('Content-disposition: attachment; filename=opm_css-settings.json');
        header('Content-type: application/json');
        print $settings;
        exit;
    }

    public function reset_plugin()
    {
        global $wpdb;

        if ($_GET['opm_css-action'] != 'reset') {
            return;
        }

        delete_option("opm_css_options");
        $wpdb->get_results($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s", 'opm_css_o_%'));

        OPM_CSS_Queue('Settings reset.');
        wp_redirect(opm_css()->admin_url());
        exit;
    }

    public function keys()
    {
        return array_keys($this->default_options());
    }

    public function get_default_option($key)
    {
        $settings = $this->default_options();
        return isset($settings[$key]) ? $settings[$key] : null;
    }

    public function default_options()
    {

        $settings = array(
	        
			// delay css async
			'tw_delay_css' => false,
			'tw_delay_css_home' => false,
			'tw_delay_css_product' => false,
			'tw_delay_css_shop' => false,
			'tw_delay_css_product_cat' => false,
			'tw_delay_css_pages' => false,
			'tw_delay_css_single_post' => false,
			'tw_delay_css_front_page_list' => '',
			'tw_delay_css_product_page_list' => '',
			'tw_delay_css_shop_page_list' => '',
			'tw_delay_css_product_cat_page_list' => '',
			'tw_delay_css_pages_list' => '',
			'tw_delay_css_single_post_list' => '',
			// delay css on interaction
			'tw_delay_css_before_user_interaction' => false,
			'tw_delay_css_before_user_interaction_home' => false,
			'tw_delay_css_before_user_interaction_product' => false,
			'tw_delay_css_before_user_interaction_shop' => false,
			'tw_delay_css_before_user_interaction_product_cat' => false,
			'tw_delay_css_before_user_interaction_pages' => false,
			'tw_delay_css_before_user_interaction_single_post' => false,
			'tw_delay_css_before_user_interaction_front_page_list' => '',
			'tw_delay_css_before_user_interaction_product_page_list' => '',
			'tw_delay_css_before_user_interaction_shop_page_list' => '',
			'tw_delay_css_before_user_interaction_product_cat_page_list' => '',
			'tw_delay_css_before_user_interaction_pages_list' => '',
			'tw_delay_css_before_user_interaction_single_post_list' => '',
			// preload css
			'tw_preload_css' => false,
			'tw_preload_css_home' => false,
			'tw_preload_css_product' => false,
			'tw_preload_css_shop' => false,
			'tw_preload_css_product_cat' => false,
			'tw_preload_css_pages' => false,
			'tw_preload_css_single_post' => false,
			'tw_preload_css_front_page_list' => '',
			'tw_preload_css_product_page_list' => '',
			'tw_preload_css_shop_page_list' => '',
			'tw_preload_css_product_cat_page_list' => '',
			'tw_preload_css_pages_list' => '',
			'tw_preload_css_single_post_list' => '',
			// remove css
			'tw_remove_css' => false,
			'tw_remove_css_home' => false,
			'tw_remove_css_product' => false,
			'tw_remove_css_shop' => false,
			'tw_remove_css_product_cat' => false,
			'tw_remove_css_pages' => false,
			'tw_remove_css_single_post' => false,
			'tw_remove_css_front_page_list' => '',
			'tw_remove_css_product_page_list' => '',
			'tw_remove_css_shop_page_list' => '',
			'tw_remove_css_product_cat_page_list' => '',
			'tw_remove_css_pages_list' => '',
			'tw_remove_css_single_post_list' => ''
			
			
        );
        
        return apply_filters('opm_css_setting_fields', $settings);
    }
}