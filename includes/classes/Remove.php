<?php

if (!defined('WPINC')) {
    die;
}


class OPM_CSS_Remove {

    public function __construct()
    {
		
		add_action( 'init', array($this, 'remove_css'), PHP_INT_MAX);
		
		
    }

    
	
	public function remove_css()
    {

        if ( !opm_css_field_setting('tw_remove_css')  ) {
            return;
        }
		
		require_once(OPM_CSS_FUNCTIONS_DIR . 'remove-css.php');
		
    }

	
}