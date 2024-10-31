<?php
$views = array(
        "async" => __('Async'),
		"delay" => __('Delay'),
		"preload" => __('Preload'),
		"remove" => __('Remove')
    );
?>

<div class="opm_css-plugin-wrapper">

    <div class="opm_css_header">
                <h1 class="opm_css_page_title"><?php echo esc_html(OPM_CSS_NAME); ?><span>Built for Speed | <?php echo esc_html(OPM_CSS_VERSION); ?></span></h1>
            </div>
    <div class="opm_css_wrapper opm_css_wrapper">
        <div class="opm_css_messages">
            <?php do_action("opm_css_messages");?>
            <span></span>
        </div>
    	
    	<div class="opm_css-navigation navigation flex">
    	    
                <ul class="nav">
                    <?php
                    foreach($views as $slug => $view):
                    ?>
                    <li>
                        <a href="#tab-<?php echo esc_html( $slug ) ?>" data-tab="tab-<?php echo esc_html( $slug ) ?>" id="opm_css_tab-<?php echo esc_html( $slug ) ?>"<?php esc_html( $slug ) == 'delay' ? ' class="current"' : ''?>><?php _e($view, 'opm_css'); ?></a>
                    </li>
                    <?php
                    endforeach;
                    ?>
                    <?php do_action("opm_css_after_menu_tab"); ?>
                </ul>
                
                <ul class="mt-auto small-padding">
                    <li><a href="#tab-import-settings" data-tab="tab-import-settings" id="opm_css_tab_import-settings"><?php _e('Import Settings')?></a></li>
                    <li><a href="<?php echo esc_url(admin_url('admin.php?page=optimize-more-css=opm_css&opm_css-action=export')) ?>" class="opm_css-ignore"><?php _e('Export Settings') ?></a></li>
                    <li><a href="<?php echo esc_url(admin_url('admin.php?page=optimize-more-css=opm_css&opm_css-action=reset')) ?>" class="opm_css-ignore reset-confirm"><?php _e('Reset Plugin')?></a></li>
                </ul>
                
        </div>
    	
        <form method="post" enctype="multipart/form-data" class="opm_css-form" action="<?php echo opm_css()->admin_url(); ?>" >
            <?php wp_nonce_field('opm_css-settings-action', 'opm_css-settings_nonce'); ?>
            
            <div class="opm_css_content">
                <?php
                
                do_action("opm_css_before_body");
                
                foreach ($views as $slug => $view) :
                    print '<section class="tab-'. esc_html( $slug ) .'" id="'. esc_html( $slug ) .'">';
                    opm_css()->admin_view( 'parts/' . esc_html( $slug ));
                    print '</section>';
                endforeach;
                
                do_action("opm_css_after_body");
                ?>
            </div>
    		
    	<div class="opm_css-save-settings">
                    <input type="submit" value="<?php _e('Save Changes', 'opm_css') ?>" class="button button-primary button-large" name="opm_css-settings" />
        </div>
        </form>
        
        <div class="opm_css_sidebar">
            <?php opm_css()->admin_view('parts/partials/sidebar'); ?>
        </div>
        
    </div>

</div>
<?php
wp_enqueue_media();
