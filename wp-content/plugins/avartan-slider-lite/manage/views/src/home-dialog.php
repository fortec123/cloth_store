<?php
if (!defined('ABSPATH'))
    exit();
?>
<!--Delete Slider Dialog-->
<div id="dialog_delete_slider_confirm" title="<?php esc_attr_e( 'Delete Slider?', 'avartan-slider-lite' ); ?>" class="as-delete-dialog">
    <span><i class="fas fa-exclamation-triangle as-danger"></i> <?php _e( 'This slide will be permanently deleted and cannot be recovered. Are you sure?', 'avartan-slider-lite' ); ?></span>
</div>

<!--Create New Slider Dialog-->
<div id="dialog_create_new_slider" title="<?php esc_attr_e( 'Create New Slider', 'avartan-slider-lite' ); ?>">
    <div class="as-dialog-tabs">
        <ul>
            <li><a href="#as_tab_new_slider"><?php _e( 'New Slider', 'avartan-slider-lite' ); ?></a></li>
            <li><a href="#as_tab_default_template"><?php _e( 'Default Templates', 'avartan-slider-lite' ); ?></a></li>
        </ul>
        <div class="as-tabs-content">
            <!--Create new slider-->
            <div class="as-tab-info as-text-center" id="as_tab_new_slider">
                <div class="as-tab-block-wrap">
                <a class="as-slider-build-block active" title="<?php esc_attr_e( 'Standard Slider', 'avartan-slider-lite' ); ?>" href="?page=avs_standard_slider">
                    <span class="as-brand-logo">
                        <span class="as-setting-icon"></span>
                    </span>
                    <span class="as-brand-logo-label"><?php _e( 'Standard Slider', 'avartan-slider-lite' ); ?></span>
                </a>
                <a class="as-slider-build-block as-pro-version" title="<?php esc_attr_e( 'Post Based Slider', 'avartan-slider-lite' ); ?>" href="javascript:void(0)">
                    <span class="as-brand-logo">
                        <span class="as-post-based-icon"></span>
                    </span>
                    <span class="as-brand-logo-label"><?php _e( 'Post Based Slider', 'avartan-slider-lite' ); ?></span>
                </a> 
                <a class="as-slider-build-block as-pro-version" title="<?php esc_attr_e( 'WooCommerce Slider', 'avartan-slider-lite' ); ?>" href="javascript:void(0)">
                    <span class="as-brand-logo"><span class="as-woo-icon"></span></span>
                    <span class="as-brand-logo-label"><?php _e( 'WooCommerce Slider', 'avartan-slider-lite' ); ?></span>
                </a>
                </div>
            </div>
            <!--Default Templates-->
            <div class="as-tab-info as-text-center" id="as_tab_default_template">
                <div class="as-template-block">
                    <?php
                    if($default_template){                        
                        foreach ($default_template as $template => $template_value) {
                            ?>
                            <div class="as-template-wrapper">
                                <div class="as-template-image as-<?php echo $template; ?>"></div>
                                <div class="as-template-desc">
                                    <span><?php echo $template_value['name']; ?></span>
                                    <a class="as-template-icon as-download-default-template as-pro-version" href="javascript:void(0)"><i class="fas fa-download"></i></a>
                                    <a href="<?php echo $template_value['link']; ?>" target="_blank" class="as-template-icon"><i class="fas fa-search"></i></a>
                                </div>
                            </div>
                            <?php                            
                        }                        
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Advance Embadded Slider Dialog-->
<div id="dialog_advance_embadded_slider" title="<?php _e( 'Advance Embadded Slider', 'avartan-slider-lite' ); ?>">
    <div class="as-form as-form-horizontal">
        <div class="as-form-control-group">
            <label><?php _e( 'Shortcode', 'avartan-slider-lite' ); ?></label>
            <div class="as-form-control">
                <input type="text" id="embadded_shortcode" placeholder="<?php esc_attr_e( 'Shortcode', 'avartan-slider-lite' ); ?>" readonly="readonly" value="shortcode" onClick="this.select();" />
            </div>
        </div>
        <div class="as-form-control-group">
            <label><?php _e( 'PHP', 'avartan-slider-lite' ); ?></label>
            <div class="as-form-control">
                <input type="text" id="embadded_php" placeholder="<?php esc_attr_e( 'PHP', 'avartan-slider-lite' ); ?>" readonly="readonly" value="php" onClick="this.select();" />
            </div>
        </div>
    </div>
</div>