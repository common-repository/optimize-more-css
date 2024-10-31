<?php

if ( !defined('ABSPATH') ) exit;

include('lib/ori-dom-parser.php');


function remove_css_keyword_included($content, $keywords) {
    foreach ($keywords as $keyword) {
        if (strpos($content, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

function remove_css_rewrite_html($html) {
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
        $removeCSSHtml = str_get_html($html);

        // Not HTML, return original
        if (!is_object($removeCSSHtml)) {
            return $html;
        }
 		
 		foreach ($removeCSSHtml->find("link[rel],style,style[type='text/css']") as $style) {
			
			// start for frontpage
			$remove_css_frontpage = get_option('opm_css_options')['tw_remove_css_front_page_list'];
			$remove_css_frontpage = explode("\n", str_replace("\r", "", $remove_css_frontpage) );
            if (remove_css_keyword_included($style->outertext, $remove_css_frontpage )) {
                if ( get_option('opm_css_options')['tw_remove_css_home'] ) {
					if ( is_front_page() ) {
						$style->outertext='';
					}
            	}
			} // ending frontpage
			
			// start for product
			$remove_css_product = get_option('opm_css_options')['tw_remove_css_product_page_list'];
			$remove_css_product = explode("\n", str_replace("\r", "", $remove_css_product) );
			if (remove_css_keyword_included($style->outertext, $remove_css_product )) {
                if ( get_option('opm_css_options')['tw_remove_css_product'] ) {
					if ( is_product() ) {
						$style->outertext='';
					}
            	}
			} // ending product
			
			// start for shop
			$remove_css_shop = get_option('opm_css_options')['tw_remove_css_shop_page_list'];
			$remove_css_shop = explode("\n", str_replace("\r", "", $remove_css_shop) );
			if (remove_css_keyword_included($style->outertext, $remove_css_shop )) {
                if ( get_option('opm_css_options')['tw_remove_css_shop'] ) {
					if ( is_shop() ) {
						$style->outertext='';
					}
            	}
			} // ending shop
			
			// start for product categories
			$remove_css_product_cat = get_option('opm_css_options')['tw_remove_css_product_cat_page_list'];
			$remove_css_product_cat = explode("\n", str_replace("\r", "", $remove_css_product_cat) );
			 if (remove_css_keyword_included($style->outertext, $remove_css_product_cat )) {
                if ( get_option('opm_css_options')['tw_remove_css_product_cat'] ) {
					if ( is_product_category() ) {
						$style->outertext='';
					}
            	}
			} // ending product categories
			
			// start for pages
			$remove_css_pages = get_option('opm_css_options')['tw_remove_css_pages_list'];
			$remove_css_pages = explode("\n", str_replace("\r", "", $remove_css_pages) );
			if (remove_css_keyword_included($style->outertext, $remove_css_pages )) {
                if ( get_option('opm_css_options')['tw_remove_css_pages'] ) {
					if ( is_page() && !is_front_page() ) {
						$style->outertext='';
					}
            	}
			} // ending pages
			
			
			// start for single post
			$remove_css_single_post = get_option('opm_css_options')['tw_remove_css_single_post_list'];
			$remove_css_single_post = explode("\n", str_replace("\r", "", $remove_css_single_post) );
			if (remove_css_keyword_included($style->outertext, $remove_css_single_post )) {
                if ( get_option('opm_css_options')['tw_remove_css_single_post'] ) {
					if ( is_singular( 'post' ) ) {
						$style->outertext='';
					}
            	}
			} // ending single post
					
    					
		}
	
		
		if ( !empty( $remove_css_frontpage ) ) {
			if ( is_front_page() ) {
        		$removeCSSHtml = preg_replace([
        		        	'/^\h*\v+/m'],
        		            [''], $removeCSSHtml);
			}
		}
		
		if ( !empty( $remove_css_product ) ) {
			if ( is_product() ) {
        		$removeCSSHtml = preg_replace([
        		        	'/^\h*\v+/m'],
        		            [''], $removeCSSHtml);
			}
		}
		
			
		if ( !empty( $remove_css_shop ) ) {
			if ( is_shop() ) {
        		$removeCSSHtml = preg_replace([
        		        	'/^\h*\v+/m'],
        		            [''], $removeCSSHtml);
			}
		}
		
		if ( !empty( $remove_css_product_cat ) ) {
			if ( is_product_category() ) {
        		$removeCSSHtml = preg_replace([
        		        	'/^\h*\v+/m'],
        		            [''], $removeCSSHtml);
			}
		}
		
		if ( !empty( $remove_css_pages ) ) {
			if ( is_page() && !is_front_page() ) {
        		$removeCSSHtml = preg_replace([
        		        	'/^\h*\v+/m'],
        		            [''], $removeCSSHtml);
			}
		}
		
		if ( !empty( $remove_css_single_post ) ) {
			if ( is_singular( 'post' ) ) {
        		$removeCSSHtml = preg_replace([
        		        	'/^\h*\v+/m'],
        		            [''], $removeCSSHtml);
			}
		}
		
		
        return $removeCSSHtml;
		
    } catch (Exception $e) {
        return $html;
    }
}

if (!is_admin()) {
    ob_start("remove_css_rewrite_html");
}
