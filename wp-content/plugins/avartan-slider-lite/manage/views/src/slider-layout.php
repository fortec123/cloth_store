<?php
if (!defined('ABSPATH'))
    exit();

$layout = AvartanSliderLiteFunctions::getVal($slider_option,'layout','fixed');
$forceFullW = ($layout == 'full-width') ? 'style="display:block;"' : 'style="display:none;"';
$force_full_width = '';
$start_width = AvartanSliderLiteFunctions::getVal($slider_option,'start_width',1280);
$start_height = AvartanSliderLiteFunctions::getVal($slider_option,'start_height',650);
$mobile_grid_width = 480;
$mobile_grid_height = 720;
$mobile_custom_design = 0;
?>
<div class="as-form as-form-horizontal">
    <div class="as-form-control-group as-slider-layout-toggle" id="as-slider-layout">  
        <span><?php _e('Slider Layout Type', 'avartan-slider-lite'); ?></span>
        <div class="as-form-control">
            <div class="as-toggle-indicator as-sliderLayout-toggle">
                <?php
                foreach ($slider_select_options['layout'] as $key => $value) {
                    $class = '';
                    $checked = '';
                    if ($layout == $key) {
                        $checked = 'checked';
                        $class = 'as-active';
                    }
                    ?>
                    <input type="radio" name="as-layout-button" class="as-layout-button <?php echo $class; ?>" id="layout_button_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                    <label for="layout_button_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                    <?php
                }
                ?>
            </div>
        </div>  
        <span class="option-desc"><?php _e('Modify the layout type of the slider.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group as-force-full-width" <?php echo $forceFullW; ?> id="as-force-full-width">
        <span><?php _e('Force full width', 'avartan-slider-lite'); ?></span>
        <div class="as-form-control as-pro-version">
            <div class="as-toggle-indicator as-forceFullWidth-toggle">
                <?php
                foreach ($slider_select_options['boolean'] as $key => $value) {
                    $checked = '';
                    if ($force_full_width == $key) {
                        $checked = 'checked';
                    }
                    ?>
                    <input type="radio" name="force_to_fullwidth" class="force-to-fullwidth" id="force_full_width_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                    <label for="force_full_width_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                    <?php
                }
                ?>
            </div>
        </div>
        <span class="option-desc"><?php _e('If On then it will stretch to slider up to window width otherwise not.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <span class="as-notice"><i class="far fa-hand-point-right"></i> <?php _e('Layer Grid Size', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <div class="as-layout-grid-wrap">
            <div class="as-layout-grid">
                <div class="as-form-control-group as-layout-grid-img">
                    <div class="as-desktop-layout-img">
                        <div class="as-dotted-line-left"></div>
                        <div class="as-dotted-line-right"></div>
                        <div class="as-dotted-line-top"></div>
                        <div class="as-dotted-line-bottom"></div>
                        <div class="as-slider-bg-image"></div>
                    </div>
                </div>
                <div class="as-form-control-group"><span><?php _e('Desktop Large Size', 'avartan-slider-lite'); ?></span></div>
                <div class="as-form-control-group as-layout-width">
                    <div class="as-form-control as-screensize-txtbox">
                        <input type="text" class="as-layout-grid-textbox as-slider-startWidth as-text-number" value="<?php echo esc_attr($start_width); ?>" maxlength="5" onkeypress="return avsIsNumberKey(event);"/>
                        <span class="lbl_px">px</span>
                    </div>
                    <span class="as-layout-measure">X</span>
                    <div class="as-form-control as-screensize-txtbox">
                        <input type="text" class="as-layout-grid-textbox as-slider-startHeight as-text-number" value="<?php echo esc_attr($start_height); ?>" maxlength="5" onkeypress="return avsIsNumberKey(event);"/>
                        <span class="lbl_px">px</span>
                    </div>
                </div>
            </div>
            <div class="as-layout-grid">
                <div class="as-form-control-group as-layout-grid-img">
                    <div class="as-mobile-layout-img">
                        <div class="as-dotted-line-left"></div>
                        <div class="as-dotted-line-right"></div>
                        <div class="as-dotted-line-top"></div>
                        <div class="as-dotted-line-bottom"></div>
                        <div class="as-slider-bg-image"></div>
                    </div>
                </div>
                <div class="as-form-control-group"><span><?php _e('Mobile Size', 'avartan-slider-lite'); ?></span></div>
                <div class="as-form-control-group as-layout-width">
                    <div class="as-form-control as-screensize-txtbox">
                        <input type="text" readonly="readonly" class="as-pro-version as-layout-grid-textbox as-slider-mobileGridWidth as-text-number" maxlength="5" value="<?php echo esc_attr($mobile_grid_width); ?>" onkeypress="return avsIsNumberKey(event);"/>
                        <span class="lbl_px">px</span>
                    </div>
                    <span class="as-layout-measure">X</span>
                    <div class="as-form-control as-screensize-txtbox">
                        <input type="text" readonly="readonly" class="as-pro-version as-layout-grid-textbox as-slider-mobileGridHeight as-text-number" maxlength="5" value="<?php echo esc_attr($mobile_grid_height); ?>" onkeypress="return avsIsNumberKey(event);"/>
                        <span class="lbl_px">px</span>
                    </div>
                </div>
                <div class="as-form-control-group">
                    <span><?php _e('Custom Design', 'avartan-slider-lite'); ?></span>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-custom-design-toggle as-pro-version" id="as-slider-mobileCustomSize">
                            <?php
                            foreach ($slider_select_options['boolean'] as $key => $value) {
                                $checked = '';
                                if ($mobile_custom_design == $key) {
                                    $checked = 'checked';
                                }
                                ?>
                                <input name="mobile_custom_design" class="mobile-custom-design as-pro-version" type="radio" id="mobile_custom_design_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?> />
                                <label for="mobile_custom_design_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="option-desc"><?php _e('The initial width & height of the slider and set responsive based on mobile custom grid size.', 'avartan-slider-lite'); ?></span>
    </div>
</div>