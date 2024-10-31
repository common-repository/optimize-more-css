<?php
	
/**
* Plugin Name: Optimize More! - CSS
* Description: Optimize CSS Delivery: Load CSS Asynchronously, Delay CSS until User Interaction, Preload Critical CSS, and Remove Unused CSS Files. Part of ThinkWeb's Performance Pack.
* Author: ThinkWeb!
* Author URI: https://thinkweb.dev/
* Version: 1.0.3
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: opm_css
*/


if (!defined('ABSPATH')) exit; // Exit if accessed directly


define('OPM_CSS_NAME', 'Optimize More! - CSS');
define('OPM_CSS_PLUGIN_NAME', 'CSS');
define('OPM_CSS_VERSION', '1.0.3');
define("OPM_CSS_DIR", plugin_dir_path(__FILE__));
define("OPM_CSS_ASSETS_URL", plugin_dir_url(__FILE__) . 'assets/');
define("OPM_CSS_PUBLIC_URL", plugin_dir_url(__FILE__) . 'public/');
define("OPM_CSS_CLASSES_DIR", plugin_dir_path(__FILE__) . 'includes/classes/');
define("OPM_CSS_FUNCTIONS_URL", plugin_dir_url(__FILE__) . 'includes/functions/');
define("OPM_CSS_FUNCTIONS_DIR", plugin_dir_path(__FILE__) . 'includes/functions/');
define("OPM_CSS_PARSER_DIR", plugin_dir_path(__FILE__) . 'includes/functions/lib/');
define("OPM_CSS_BASENAME", plugin_basename(__FILE__));
define("OPM_CSS_ASSETS_DIR", OPM_CSS_DIR . 'assets/');


include_once(OPM_CSS_DIR . 'includes/classes/Loader.php');
include_once(OPM_CSS_DIR . 'includes/Functions.php');



global $opm_css;

if (!function_exists('opm_css')) :
    function opm_css()
    {
        global $opm_css;

        $opm_css = opm_css_Loader::getInstance();

        return $opm_css;
    }
endif;

opm_css();