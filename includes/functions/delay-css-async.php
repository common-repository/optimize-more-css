<?php

if ( !defined('ABSPATH') ) exit;

include('lib/ori-dom-parser.php');


function delay_css_async_keyword_included($content, $keywords) {
    foreach ($keywords as $keyword) {
        if (strpos($content, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

function delay_css_async_rewrite_html($html) {
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
        if ( is_user_logged_in() /* || is_cart() || is_checkout() || is_wc_endpoint_url() */ ) {
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
			
			$preload = "preload";
			$media_print = "print";
			$onload = "this.onload=null;this.removeAttribute('media');";
			
			
			$preload_tags = '<link rel="'. esc_html( $preload ) . '" as="style" id="'. esc_html( $handle ) . '" href="'. esc_url( $href ) . '">';
			
			$async_tags = '<link rel="'. esc_html( $rel ) . '" id="'. esc_html( $handle ) . '" href="'. esc_url( $href ) . '" media="'. esc_html( $media_print ) . '" onload="'. wp_kses_data( $onload ) . '">';
			
			$noscript_tags = '<noscript><link rel="'. esc_html( $rel ) . '" id="'. esc_html( $handle ) . '" href="'. esc_url( $href ) . '" media="'. esc_html( $media ) . '"></noscript>';
			
			
			// start for frontpage
			$delay_css_frontpage = get_option('opm_css_options')['tw_delay_css_front_page_list'];
			$delay_css_frontpage = explode("\n", str_replace("\r", "", $delay_css_frontpage) );
			
			$delay_css_home_page = get_option('opm_css_options')['tw_delay_css_home'];
			
            if (delay_css_async_keyword_included($style->outertext, $delay_css_frontpage )) {
                if ( ( $delay_css_home_page ) ) {
					if ( is_front_page() ) {
					    $style->outertext="";
						$style->outertext .= $preload_tags;
						$style->outertext .= $async_tags;
						$style->outertext .= $noscript_tags;
						
					}
            	}
			} // ending frontpage
			
			// start for pages
			$delay_css_pages = get_option('opm_css_options')['tw_delay_css_pages_list'];
			$delay_css_pages = explode("\n", str_replace("\r", "", $delay_css_pages) );
			
			$delay_css_on_pages = get_option('opm_css_options')['tw_delay_css_pages'];
			
            if (delay_css_async_keyword_included($style->outertext, $delay_css_pages )) {
                if ( ( $delay_css_on_pages ) ) {
					if ( is_page() && !is_front_page() ) {
					    $style->outertext="";
						$style->outertext .= $preload_tags;
						$style->outertext .= $async_tags;
						$style->outertext .= $noscript_tags;
						
					}
            	}
			} // ending pages
			
			// start for single_post
			$delay_css_single_post = get_option('opm_css_options')['tw_delay_css_single_post_list'];
			$delay_css_single_post = explode("\n", str_replace("\r", "", $delay_css_single_post) );
			
			$delay_css_on_single_post = get_option('opm_css_options')['tw_delay_css_single_post'];
			
            if (delay_css_async_keyword_included($style->outertext, $delay_css_single_post )) {
                if ( ( $delay_css_on_single_post ) ) {
					if ( is_singular( 'post' ) ) {
					    $style->outertext="";
						$style->outertext .= $preload_tags;
						$style->outertext .= $async_tags;
						$style->outertext .= $noscript_tags;
						
					}
            	}
			} // ending single_post
			
			// start for product
			$delay_css_product = get_option('opm_css_options')['tw_delay_css_product_page_list'];
			$delay_css_product = explode("\n", str_replace("\r", "", $delay_css_product) );
			
			$delay_css_product_page = get_option('opm_css_options')['tw_delay_css_product'];
			
			if (delay_css_async_keyword_included($style->outertext, $delay_css_product )) {
                if ( ( $delay_css_product_page ) ) {
					if ( is_product() ) {
						$style->outertext="";
						//$style->outertext .= $preload_tags;
						$style->outertext .= $async_tags;
						$style->outertext .= $noscript_tags;
					}
            	}
			} // ending product
			
			// start for shop
			$delay_css_shop = get_option('opm_css_options')['tw_delay_css_shop_page_list'];
			$delay_css_shop = explode("\n", str_replace("\r", "", $delay_css_shop) );
			
			$delay_css_shop_page = get_option('opm_css_options')['tw_delay_css_shop'];
			
			if (delay_css_async_keyword_included($style->outertext, $delay_css_shop )) {
                if ( ( $delay_css_shop_page ) ) {
					if ( is_shop() ) {
						$style->outertext="";
						//$style->outertext .= $preload_tags;
						$style->outertext .= $async_tags;
						$style->outertext .= $noscript_tags;
					}
            	}
			} // ending shop
			
			// start for product categories
			$delay_css_product_cat = get_option('opm_css_options')['tw_delay_css_product_cat_page_list'];
			$delay_css_product_cat = explode("\n", str_replace("\r", "", $delay_css_product_cat) );
			
			$delay_css_product_cat_page = get_option('opm_css_options')['tw_delay_css_product_cat'];
			
			if (delay_css_async_keyword_included($style->outertext, $delay_css_product_cat )) {
                if ( ( $delay_css_product_cat_page ) ) {
					if ( is_product_category() ) {
						$style->outertext="";
						//$style->outertext .= $preload_tags;
						$style->outertext .= $async_tags;
						$style->outertext .= $noscript_tags;
					}
            	}
			} // ending product categories
			
		} // end foreach
		
		
		
        
        return $newHtml;
    } catch (Exception $e) {
        return $html;
    }
}

if (!is_admin()) {
    ob_start("delay_css_async_rewrite_html");
}