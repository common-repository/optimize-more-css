<?php

if (!defined('WPINC')) {
    die;
}


class OPM_CSS_Preload {

    public function __construct()
    {
		
		add_action( 'init', array($this, 'preload_css'), PHP_INT_MAX);
		add_action( 'init', array($this, 'preload_font'), PHP_INT_MAX);
		
    }

    
	
	public function preload_css()
    {

        if ( !opm_css_field_setting('tw_preload_css')  ) {
            return;
        }
        
		require_once(OPM_CSS_FUNCTIONS_DIR . 'preload-css.php');
		
    }
    
    
    public function preload_font()
    {

        if ( !opm_css_field_setting('tw_preload_font')  ) {
            return;
        }
		
		require_once(OPM_CSS_FUNCTIONS_DIR . 'preload-font.php');
		
    }


	
}