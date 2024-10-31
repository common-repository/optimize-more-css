<div class="opm_css-input-group show-hide-group flex-full-width" style="padding-bottom: 8px;">
        <div class="opm_css-input" style="padding-top: 24px;">
            <input class="opm_css-toggle opm_css-toggle-light main-toggle show-hide" data-show-hide="1" id="tw_remove_css" name="tw_remove_css" value="1" type="checkbox"
            <?php checked(opm_css_field_setting( 'tw_remove_css'), 1, true) ?>/>
            <label class="opm_css-toggle-btn" for="tw_remove_css"></label>
            <label class="toggle-label" for="tw_remove_css">
                <?php _e('Enable', 'opm_css') ?>
            </label>
            <div class="opm_css-help">
                <?php _e('Enable Remove Unused CSS file(s)', 'opm_css') ?>
                <?php _e('*use keywords', 'opm_css') ?>
            </div>
        </div>
        <div id="" class="show-hide-content padding-left-0 pb-10 mb-15 border-bottom-light">
            <div class="flex flex grid-col-2">
                <div class="opm_css-input-group toggle-group flex-50 pt-8 pb-8">
                    <input class="opm_css-toggle opm_css-toggle-light main-toggle" data-revised="1" id="tw_remove_css_home" name="tw_remove_css_home" value="1" type="checkbox"
                    <?php checked(opm_css_field_setting( 'tw_remove_css_home'), 1, true) ?>/>
                    <label class="opm_css-toggle-btn" for="tw_remove_css_home"></label>
                    <label class="toggle-label" for="tw_remove_css_home">
                        <?php _e('Homepage', 'opm_css') ?>
                    </label>

                    <div class="sub-fields padding-left-0">
                        <!-- start of sub fields container -->

                        <div class="opm_css-input-group">
                            <div class="opm_css-input">
                                <textarea class="textarea-custom" rows="6" name="tw_remove_css_front_page_list"><?php echo opm_css_field_setting('tw_remove_css_front_page_list') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of sub fields container -->
                </div>
                <!-- end input toggle group -->
                
                <!-- start pages -->
                <div class="opm_css-input-group toggle-group flex-50 pt-8 pb-8">
                    <input class="opm_css-toggle opm_css-toggle-light main-toggle" data-revised="1" id="tw_remove_css_pages" name="tw_remove_css_pages" value="1" type="checkbox"
                    <?php checked(opm_css_field_setting( 'tw_remove_css_pages'), 1, true) ?>/>
                    <label class="opm_css-toggle-btn" for="tw_remove_css_pages"></label>
                    <label class="toggle-label" for="tw_remove_css_pages">
                        <?php _e('Pages except homepage', 'opm_css') ?>
                    </label>

                    <div class="sub-fields padding-left-0">
                        <!-- start of sub fields container -->

                        <div class="opm_css-input-group">
                            <div class="opm_css-input">
                                <textarea class="textarea-custom" rows="6" name="tw_remove_css_pages_list"><?php echo opm_css_field_setting('tw_remove_css_pages_list') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of sub fields container -->
                </div>
                <!-- end pages -->
                
                <!-- start single_post -->
                <div class="opm_css-input-group toggle-group flex-50 pt-8 pb-8">
                    <input class="opm_css-toggle opm_css-toggle-light main-toggle" data-revised="1" id="tw_remove_css_single_post" name="tw_remove_css_single_post" value="1" type="checkbox"
                    <?php checked(opm_css_field_setting( 'tw_remove_css_single_post'), 1, true) ?>/>
                    <label class="opm_css-toggle-btn" for="tw_remove_css_single_post"></label>
                    <label class="toggle-label" for="tw_remove_css_single_post">
                        <?php _e('Single Post', 'opm_css') ?>
                    </label>

                    <div class="sub-fields padding-left-0">
                        <!-- start of sub fields container -->

                        <div class="opm_css-input-group">
                            <div class="opm_css-input">
                                <textarea class="textarea-custom" rows="6" name="tw_remove_css_single_post_list"><?php echo opm_css_field_setting('tw_remove_css_single_post_list') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of sub fields container -->
                </div>
                <!-- end single_post -->

                <div class="opm_css-input-group toggle-group flex-50 pt-8 pb-8">
                    <input class="opm_css-toggle opm_css-toggle-light main-toggle" data-revised="1" id="tw_remove_css_product" name="tw_remove_css_product" value="1" type="checkbox"
                    <?php checked(opm_css_field_setting( 'tw_remove_css_product'), 1, true) ?>/>
                    <label class="opm_css-toggle-btn" for="tw_remove_css_product"></label>
                    <label class="toggle-label" for="tw_remove_css_product">
                        <?php _e('Product Page', 'opm_css') ?>
                    </label>

                    <div class="sub-fields padding-left-0">
                        <!-- start of sub fields container -->

                        <div class="opm_css-input-group">
                            <div class="opm_css-input">
                                <textarea class="textarea-custom" rows="6" name="tw_remove_css_product_page_list"><?php echo opm_css_field_setting('tw_remove_css_product_page_list') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of sub fields container -->
                </div>
                <!-- end input toggle group -->
                
                <div class="opm_css-input-group toggle-group flex-50 pt-8 pb-8">
                    <input class="opm_css-toggle opm_css-toggle-light main-toggle" data-revised="1" id="tw_remove_css_shop" name="tw_remove_css_shop" value="1" type="checkbox"
                    <?php checked(opm_css_field_setting( 'tw_remove_css_shop'), 1, true) ?>/>
                    <label class="opm_css-toggle-btn" for="tw_remove_css_shop"></label>
                    <label class="toggle-label" for="tw_remove_css_shop">
                        <?php _e('Shop Page', 'opm_css') ?>
                    </label>

                    <div class="sub-fields padding-left-0">
                        <!-- start of sub fields container -->

                        <div class="opm_css-input-group">
                            <div class="opm_css-input">
                                <textarea class="textarea-custom" rows="6" name="tw_remove_css_shop_page_list"><?php echo opm_css_field_setting('tw_remove_css_shop_page_list') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of sub fields container -->
                </div>
                <!-- end input toggle group -->
                
                <div class="opm_css-input-group toggle-group flex-50 pt-8 pb-8">
                    <input class="opm_css-toggle opm_css-toggle-light main-toggle" data-revised="1" id="tw_remove_css_product_cat" name="tw_remove_css_product_cat" value="1" type="checkbox"
                    <?php checked(opm_css_field_setting( 'tw_remove_css_product_cat'), 1, true) ?>/>
                    <label class="opm_css-toggle-btn" for="tw_remove_css_product_cat"></label>
                    <label class="toggle-label" for="tw_remove_css_product_cat">
                        <?php _e('Product Category Pages', 'opm_css') ?>
                    </label>

                    <div class="sub-fields padding-left-0">
                        <!-- start of sub fields container -->

                        <div class="opm_css-input-group">
                            <div class="opm_css-input">
                                <textarea class="textarea-custom" rows="6" name="tw_remove_css_product_cat_page_list"><?php echo opm_css_field_setting('tw_remove_css_product_cat_page_list') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end of sub fields container -->
                </div>
                <!-- end input toggle group -->
                
            </div>
            <!-- end flex wraper -->
        </div>
        <!-- end body wraper -->
    </div>