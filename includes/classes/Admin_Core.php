<?php

if (!defined('WPINC')) {
    die;
}

class OPM_CSS_Admin_Core
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_option_menu'));
        
        add_action('admin_head', array($this, 'add_menu_style'));
        
		add_filter('plugin_action_links_' . OPM_CSS_BASENAME, [$this, 'plugin_setting_links']);
		add_filter('plugin_row_meta', array($this, 'plugin_row_links'), 10, 2);
    }

    /**
     * Add opm_css to setting menu
     *
     * @return void
     */
    public function add_option_menu()
    {
        if ( !is_plugin_active( 'optimize-more-images/optimize-more-images.php' ) ) {
            
		$menu = add_menu_page(
            __('Optimize More! - CSS', 'opm_css'),		// Page title
            __('Optimize More!', 'opm_css'),		// Menu name
            'manage_options', 					// Permissions
            'optimize-more-css',					// Menu slug
            array($this, 'view'),
			'dashicons-superhero'
        );

        add_action('load-' . $menu, array($this, 'load'));
        
        $menu = add_submenu_page( 'optimize-more-css', OPM_CSS_NAME, OPM_CSS_PLUGIN_NAME, 'manage_options', 'admin.php?page=optimize-more-css', '', 0);
        
        }
		
		if ( is_plugin_active( 'optimize-more-images/optimize-more-images.php' ) ) {
        
        $menu = add_menu_page(
            __('Optimize More! - CSS', 'opm_css'),		// Page title
            __('Optimize More!', 'opm_css'),		// Menu name
            'manage_options', 					// Permissions
            'optimize-more-css',					// Menu slug
            array($this, 'view')
        );

        add_action('load-' . $menu, array($this, 'load'));
		
		$menu = add_submenu_page( 'optimize-more-css', OPM_CSS_NAME, OPM_CSS_PLUGIN_NAME, 'manage_options', 'admin.php?page=optimize-more-css', '', 0);
			
		}
		
    }
    
    
    public function add_menu_style() {
        
            ?>
            <style>#adminmenu li.toplevel_page_optimize-more-css.menu-icon-generic,
            #adminmenu li#toplevel_page_optimize-more-css ul.wp-submenu li:last-child {
            	display:none!important
            }</style>
            <?php
            
    }
    
	
	/* add settings on plugin list */
	public function plugin_setting_links($links)
    {
        $links = array_merge(array(
            '<a href="' . esc_url(admin_url('/admin.php?page=optimize-more-css')) . '">' . __('Settings', 'opm_css') . '</a>',
        ), $links);
        
        return $links;
    }
    
    public function plugin_row_links($links, $file)
      {
        if ($file !== OPM_CSS_BASENAME ) {
          return $links;
        }
    
        $pro_link = '<a target="_blank" href="https://thinkweb.dev/speed-optimization/" title="' . __('Optimize More', 'opm_css') . '">' . __('Optimize More!', 'opm_css') . '</a>';
    
        $links[] = $pro_link;
    
        return $links;
      } // plugin_meta_links

    /**
     * opm_css setting menu page is loaded
     *
     * @return void
     */
    public function load()
    {

        do_action("opm_css_load-page");

        // Register scripts
        add_action("admin_enqueue_scripts", array($this, 'enqueue_scripts'));

        //check store;
        $this->store();
    }

    public function enqueue_scripts()
    {

        $setting_js = 'js/admin-settings.js';
        wp_register_script(
            'opm_css-admin-settings',
            OPM_CSS_ASSETS_URL . $setting_js,
            OPM_CSS_VERSION
        );

        $jquery_validate = 'js/jquery.validate.min.js';
        wp_register_script(
            'jquery-validate',
            OPM_CSS_ASSETS_URL . $jquery_validate,
            array('jquery'),
            OPM_CSS_VERSION
        );

        $ays_before_js = 'js/ays-beforeunload-shim.js';
        wp_register_script(
            'ays-beforeunload-shim',
            OPM_CSS_ASSETS_URL . $ays_before_js,
            array('jquery'),
            OPM_CSS_VERSION
        );

        $areyousure_js = 'js/jquery-areyousure.js';
        wp_register_script(
            'jquery-areyousure',
            OPM_CSS_ASSETS_URL . $areyousure_js,
            array('jquery'),
            OPM_CSS_VERSION
        );

        $setting_css = 'css/admin-settings.css';
        wp_register_style(
            'opm_css-admin-settings',
            OPM_CSS_ASSETS_URL . $setting_css,
            OPM_CSS_VERSION . '2'
        );


        wp_enqueue_script(array('ays-beforeunload-shim', 'jquery-areyousure', 'opm_css-admin-settings'));
        wp_enqueue_style(array('opm_css-admin-settings'));
		
		// custom admin settings
		wp_register_style('opm_css-custom-admin-settings', OPM_CSS_ASSETS_URL . 'css/admin-custom-settings.css');
		wp_enqueue_style('opm_css-custom-admin-settings');
		

        wp_localize_script(
            'opm_css-admin-settings',
            'opm_css_settings',
            array(
                'adminurl' => admin_url("index.php"),
                'opm_css_ajax_nonce' => wp_create_nonce("opm_css_ajax_nonce")
            )
        );
    }

    private function store()
    {
        do_action('opm_css_save_before_validation');

        if (!isset($_POST['opm_css-settings'])) {
            return;
        }

        if (isset($_POST['opm_css-action']) && $_POST['opm_css-action'] == 'reset') {
            return;
        }
        //  nonce checking
        if (!isset($_POST['opm_css-settings_nonce'])
            || !wp_verify_nonce($_POST['opm_css-settings_nonce'], 'opm_css-settings-action')) {

            print 'Sorry, your nonce did not verify.';
            exit;
        }

        opm_css()->Settings()->store();
        return;
    }

    public function view()
    {
        $opm_css = opm_css();
        $view = $opm_css->get_active_view();
        $opm_css->admin_view($view);
    }
    
    
}