<?php

if (!defined('WPINC')) {
    die;
}


class OPM_CSS_Delay {

    public function __construct()
    {
		
		add_action( 'init', array($this, 'delay_css_interaction'), PHP_INT_MAX);		
		
    }

    
    public function delay_css_interaction()
    {

        if ( !opm_css_field_setting('tw_delay_css_before_user_interaction') || is_user_logged_in() ) {
            return;
        }
        
		require_once(OPM_CSS_FUNCTIONS_DIR . 'delay-css-on-interaction.php');
		
    }
    
    	
}