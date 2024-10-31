<?php

if (!defined('WPINC')) {
    die;
}


class OPM_CSS_Async {

    public function __construct()
    {
		
		add_action( 'init', array($this, 'delay_css_async'), PHP_INT_MAX);		
		
    }

    
	
	public function delay_css_async()
    {

        if ( !opm_css_field_setting('tw_delay_css') || is_user_logged_in() ) {
            return;
        }
        
		require_once(OPM_CSS_FUNCTIONS_DIR . 'delay-css-async.php');
		
    }
    
    	
}