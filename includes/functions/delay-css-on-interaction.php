<?php

if ( !defined('ABSPATH') ) exit;

include('lib/ori-dom-parser.php');


function delay_css_advanced_keyword_included($content, $keywords) {
    foreach ($keywords as $keyword) {
        if (strpos($content, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

function delay_css_advanced_rewrite_html($html) {
    try {
        // Process only GET requests
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		  return $html;
		}
		
		// check empty
        if (!isset($html) || trim($html) === '') {
            return $html;
        }
        
        // return if content is XML
        if (strcasecmp(substr($html, 0, 5), '<?xml') === 0) {
            return $html;
        }

        // Check if the code is HTML, otherwise return
        if (trim($html)[0] !== "<") {
            return $html;
        }

		
		// Default Exclude pages
        if ( is_user_logged_in() ) {
            return $html;
        }
		

        // Parse HTML
        $newHtml = str_get_html($html);

        // Not HTML, return original
        if (!is_object($newHtml)) {
            return $html;
        }
		
 		
 		foreach ($newHtml->find("link[rel='stylesheet']") as $style) {
			
			$handle = $style->id;
			$href = $style->href;
			$media = $style->media;
			$rel = $style->rel;
			
			$delay_css = "<link rel='". esc_html( $rel ) . "' id='". esc_html( $handle ) . "' on-delay data-href='". esc_url( $href ) . "' media='". esc_html( $media ) . "'/>";
			
			// start for frontpage
			$delay_css_advanced_frontpage = get_option('opm_css_options')['tw_delay_css_before_user_interaction_front_page_list'];
			$delay_css_advanced_frontpage = explode("\n", str_replace("\r", "", $delay_css_advanced_frontpage) );
            if (delay_css_advanced_keyword_included($style->outertext, $delay_css_advanced_frontpage )) {
                if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_home'] ) {
					if ( is_front_page() ) {
						$style->outertext="";
						$style->outertext .= "$delay_css";	
					}
            	}
			} // ending frontpage
			
			// start for pages
			$delay_css_advanced_pages = get_option('opm_css_options')['tw_delay_css_before_user_interaction_pages_list'];
			$delay_css_advanced_pages = explode("\n", str_replace("\r", "", $delay_css_advanced_pages) );
            if (delay_css_advanced_keyword_included($style->outertext, $delay_css_advanced_pages )) {
                if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_pages'] ) {
					if ( is_page() && !is_front_page() ) {
						$style->outertext="";
						$style->outertext .= "$delay_css";	
					}
            	}
			} // ending pages
			
			// start for single_post
			$delay_css_advanced_single_post = get_option('opm_css_options')['tw_delay_css_before_user_interaction_single_post_list'];
			$delay_css_advanced_single_post = explode("\n", str_replace("\r", "", $delay_css_advanced_single_post) );
            if (delay_css_advanced_keyword_included($style->outertext, $delay_css_advanced_single_post )) {
                if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_single_post'] ) {
					if ( is_singular( 'post' ) ) {
						$style->outertext="";
						$style->outertext .= "$delay_css";	
					}
            	}
			} // ending single_post
			
			// start for product
			$delay_css_advanced_product = get_option('opm_css_options')['tw_delay_css_before_user_interaction_product_page_list'];
			$delay_css_advanced_product = explode("\n", str_replace("\r", "", $delay_css_advanced_product) );
			if (delay_css_advanced_keyword_included($style->outertext, $delay_css_advanced_product )) {
                if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_product'] ) {
					if ( is_product() ) {
						$style->outertext="";
						$style->outertext .= "$delay_css";
					}		
            	}
			} // ending product
		
			// start for shop
			$delay_css_advanced_shop = get_option('opm_css_options')['tw_delay_css_before_user_interaction_shop_page_list'];
			$delay_css_advanced_shop = explode("\n", str_replace("\r", "", $delay_css_advanced_shop) );
			if (delay_css_advanced_keyword_included($style->outertext, $delay_css_advanced_shop )) {
                if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_shop'] ) {
					if ( is_shop() ) {
						$style->outertext="";
						$style->outertext .= "$delay_css";
					}	
            	}
			} // ending shop
			
			// start for product categories
			$delay_css_advanced_product_cat = get_option('opm_css_options')['tw_delay_css_before_user_interaction_product_cat_page_list'];
			$delay_css_advanced_product_cat = explode("\n", str_replace("\r", "", $delay_css_advanced_product_cat) );
			if (delay_css_advanced_keyword_included($style->outertext, $delay_css_advanced_product_cat )) {
                if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_product_cat'] ) {
					if ( is_product_category() ) {
						$style->outertext="";
						$style->outertext .= "$delay_css";	
					}
            	}
			}// ending product categories
			
			
		}
		
        
        return $newHtml;
    } catch (Exception $e) {
        return $html;
    }
}

if (!is_admin()) {
    ob_start("delay_css_advanced_rewrite_html");
}

function print_delay_css_interaction_inline_script(){
	
	$delay_css_interaction_js = 'const loadStylesTimer=setTimeout(loadStyles,5e6),userInteractionEvents=["mouseover","mousemove","mousedown","mouseup","click","keydown","touchstart","touchmove","wheel"];function triggerStyleLoader(){loadStyles(),clearTimeout(loadStylesTimer),userInteractionEvents.forEach(function(e){window.removeEventListener(e,triggerStyleLoader,{passive:!0})})}function loadStyles(){document.querySelectorAll("link[on-delay]").forEach(function(e){e.setAttribute("href",e.getAttribute("data-href"))})}userInteractionEvents.forEach(function(e){window.addEventListener(e,triggerStyleLoader,{passive:!0})});';
	
	$delay_css_interaction_js_handle = 'om-delay-css-advanced-js-extra';
	
	$delay_css_interaction_js_type = 'nowprocket';
		
		if ( is_user_logged_in() ) {
			return;
		}
		
		$delay_css_interaction_script = '<script id="%s" data-type="%s">%s</script>'. PHP_EOL;
		
		// front-page
		if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_home'] ) {
			if ( is_front_page() ) {
				
				printf( $delay_css_interaction_script, esc_html( $delay_css_interaction_js_handle ), esc_html( $delay_css_interaction_js_type ), wp_kses_data( $delay_css_interaction_js ) );
				
			}
		}
	
		// product-pages
		if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_product'] ) {
			if ( is_product() ) {
				
				printf( $delay_css_interaction_script, esc_html( $delay_css_interaction_js_handle ), esc_html( $delay_css_interaction_js_type ), wp_kses_data( $delay_css_interaction_js ) );
				
			}
		}
	
		// shop-page	
		if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_shop'] ) {
			if ( is_shop() ) {
				
				printf( $delay_css_interaction_script, esc_html( $delay_css_interaction_js_handle ), esc_html( $delay_css_interaction_js_type ), wp_kses_data( $delay_css_interaction_js ) );
				
			}
		}
	
		// product-category-pages	
		if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_product_cat'] ) {
			if ( is_product_category() ) {
				
				printf( $delay_css_interaction_script, esc_html( $delay_css_interaction_js_handle ), esc_html( $delay_css_interaction_js_type ), wp_kses_data( $delay_css_interaction_js ) );
				
			}
		}
	
		// pages
		if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_pages'] ) {
			if ( is_page() && !is_front_page() ) {
				
				printf( $delay_css_interaction_script, esc_html( $delay_css_interaction_js_handle ), esc_html( $delay_css_interaction_js_type ), wp_kses_data( $delay_css_interaction_js ) );
				
			}
		}
	
		// single_posts
		if ( get_option('opm_css_options')['tw_delay_css_before_user_interaction_single_post'] ) {
			if ( is_singular( 'post' ) ) {
				
				printf( $delay_css_interaction_script, esc_html( $delay_css_interaction_js_handle ), esc_html( $delay_css_interaction_js_type ), wp_kses_data( $delay_css_interaction_js ) );
				
			}
		}
	
	
}
add_action('wp_print_footer_scripts', 'print_delay_css_interaction_inline_script', 999);