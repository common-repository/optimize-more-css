<?php

if ( !defined('ABSPATH') ) exit;

include('lib/ori-dom-parser.php');


function preload_css_keyword_included($content, $keywords) {
    foreach ($keywords as $keyword) {
        if (strpos($content, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

function preload_css_rewrite_html($html) {
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
        
        $tw_preload_css_front_page_target = get_option('opm_css_options')['tw_preload_css_front_page_list'];
	 	$tw_preload_css_front_page_list = explode("\n", str_replace("\r", "", $tw_preload_css_front_page_target ) );
		
		$tw_preload_css_product_page_target = get_option('opm_css_options')['tw_preload_css_product_page_list'];
	 	$tw_preload_css_product_page_list = explode("\n", str_replace("\r", "", $tw_preload_css_product_page_target ) );
		
		$tw_preload_css_shop_page_target = get_option('opm_css_options')['tw_preload_css_shop_page_list'];
	 	$tw_preload_css_shop_page_list = explode("\n", str_replace("\r", "", $tw_preload_css_shop_page_target ) );
		
		$tw_preload_css_product_cat_page_target = get_option('opm_css_options')['tw_preload_css_product_cat_page_list'];
	 	$tw_preload_css_product_cat_page_list = explode("\n", str_replace("\r", "", $tw_preload_css_product_cat_page_target ) );
		
		$tw_preload_css_pages_target = get_option('opm_css_options')['tw_preload_css_pages_list'];
	 	$tw_preload_css_pages_list = explode("\n", str_replace("\r", "", $tw_preload_css_pages_target ) );
	 	
	 	$tw_preload_css_single_post_target = get_option('opm_css_options')['tw_preload_css_single_post_list'];
	 	$tw_preload_css_single_post_list = explode("\n", str_replace("\r", "", $tw_preload_css_single_post_target ) );
		
		
		foreach ($newHtml->find("link[rel='stylesheet']") as $style) {
			
		$source = $style->href;
		
		$preload_tags = PHP_EOL . "<link rel='preload' as='style' href='". esc_url( $source ) . "'>";
			
			// start front page
			 if ( get_option('opm_css_options')['tw_preload_css_home'] ) {
				
				if ( is_front_page() ) {
					
					if (preload_css_keyword_included($style->outertext, $tw_preload_css_front_page_list )) {
					
							// $preload_tags = PHP_EOL . "<link rel='preload' as='style' href='$source'>";
							
							$newHtml->find('title', 0)->outertext .= $preload_tags;
							
						
					}
	 
				}
				
			}
			// end front page
			
			
			// start product pages
			 if ( get_option('opm_css_options')['tw_preload_css_product'] ) {
				
				if ( is_product() ) {
					
					if (preload_css_keyword_included($style->outertext, $tw_preload_css_product_page_list )) {
					
							$newHtml->find('title', 0)->outertext .= $preload_tags;
						
					}
	 
				}
				
			}
			// end product pages
			
			
			// start shop page
			 if ( get_option('opm_css_options')['tw_preload_css_shop'] ) {
				
				if ( is_shop() ) {
					
					if (preload_css_keyword_included($style->outertext, $tw_preload_css_shop_page_list )) {
					
							$newHtml->find('title', 0)->outertext .= $preload_tags;
						
					}
	 
				}
				
			}
			// end shop page
			
			// start product category pages
			 if ( get_option('opm_css_options')['tw_preload_css_product_cat'] ) {
				
				if ( is_product_category() ) {
				    
					
					if (preload_css_keyword_included($style->outertext, $w_preload_css_product_cat_page_list )) {
					
							$newHtml->find('title', 0)->outertext .= $preload_tags;
						
					}
	 
				}
				
			}
			// end product category pages
			
			
			// start pages
			 if ( get_option('opm_css_options')['tw_preload_css_pages'] ) {
				
				if ( is_page() && !is_front_page() ) {
					
					if (preload_css_keyword_included($style->outertext, $tw_preload_css_pages_list )) {
					
							$newHtml->find('title', 0)->outertext .= $preload_tags;
						
					}
	 
				}
				
			}
			// end pages
			
			// start single post
			 if ( get_option('opm_css_options')['tw_preload_css_single_post'] ) {
				
				if ( is_singular( 'post' ) ) {
					
					if (preload_css_keyword_included($style->outertext, $tw_preload_css_single_post_list )) {
					
							$newHtml->find('title', 0)->outertext .= $preload_tags;
						
					}
	 
				}
				
			}
			// end single post
			
		
		}

		
		return $newHtml;
		
    } catch (Exception $e) {
        return $html;
    }
}

if (!is_admin()) {
    ob_start("preload_css_rewrite_html");
}