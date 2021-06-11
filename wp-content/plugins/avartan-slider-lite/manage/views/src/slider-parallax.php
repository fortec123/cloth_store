<?php
if (!defined('ABSPATH'))
    exit();

$parallax_options = array();
$pEnable = 0;
$TdEnable = 0;
$enable_3d_shadow = 0;
$enable_3d_background = 0;
$enable_slider_overflow_hidden = 0;
$enable_layer_overflow_hidden = 0;
$default_3d_depth = 10;
$slider_mouse_event = 'mouse';
$parallax_origin = 'enterpoint';
$slider_parallax_animation_speed = 400;
?>
<div class="as-form as-form-horizontal">
    <div class="as-form-control-group">
        <label><?php _e('Enable Parallax/3D', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <div class="as-toggle-indicator as-pro-version" id="as-slider-parallax-effect">
                <?php
                foreach ($slider_select_options['boolean'] as $key => $value) {
                    $checked = '';
                    if ($pEnable == $key) {
                        $checked = 'checked';
                    }
                    ?>
                    <input name="enable_parallax_3d" class="enable-parallax-3d <?php if($key == 1){ echo '1as-pro-version'; } ?>" type="radio" id="enable_parallax_3d_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                    <label for="enable_parallax_3d_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="as-slide-parallax-setting" style="display: inline-block;width: 100%;">
        <div class="as-form-control-group">
            <label><?php _e('Enable 3D', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <div class="as-toggle-indicator as-pro-version" id="as-slider-parallax-3d-effect">
                    <?php
                    foreach ($slider_select_options['boolean'] as $key => $value) {
                        $checked = '';
                        if ($TdEnable == $key) {
                            $checked = 'checked';
                        }
                        ?>
                        <input name="enable_3d" class="enable-3d" type="radio" id="enable_3d_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                        <label for="enable_3d_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <span class="option-desc"><?php _e('Enable rotating effect of slider.', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group as-3d-effect-show">
            <span class="as-notice"><i class="far fa-hand-point-right"></i><?php _e('3D Settings', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group as-3d-effect-show">
            <label><?php _e('3D Shadow', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <div class="as-toggle-indicator as-pro-version" id="as-slider-3d-shadow">
                    <?php
                    foreach ($slider_select_options['boolean'] as $key => $value) {
                        $checked = '';
                        if ($enable_3d_shadow == $key) {
                            $checked = 'checked';
                        }
                        ?>
                        <input name="enable_3d_shadow" class="enable-3d-shadow" type="radio" id="enable_3d_shadow_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                        <label for="enable_3d_shadow_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <span class="option-desc"><?php _e('Enable 3D shadow', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group as-3d-effect-show">
            <label><?php _e('3D BG Disabled', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <div class="as-toggle-indicator as-pro-version">
                    <?php
                    foreach ($slider_select_options['boolean'] as $key => $value) {
                        $checked = '';
                        if ($enable_3d_background == $key) {
                            $checked = 'checked';
                        }
                        ?>
                        <input name="enable_3d_background" class="enable-3d-background" type="radio" id="enable_3d_background_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                        <label for="enable_3d_background_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <span class="option-desc"><?php _e('Enable background 3D effect', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group as-3d-effect-show">
            <label><?php _e('Slider Overflow Hidden', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <div class="as-toggle-indicator as-pro-version">
                    <?php
                    foreach ($slider_select_options['boolean'] as $key => $value) {
                        $checked = '';
                        if ($enable_slider_overflow_hidden == $key) {
                            $checked = 'checked';
                        }
                        ?>
                        <input name="enable_slider_overflow_hidden" class="enable-slider-overflow-hidden" type="radio" id="enable_slider_overflow_hidden_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                        <label for="enable_slider_overflow_hidden_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <span class="option-desc"><?php _e('Hide slides and layers when go outside of slider ', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group as-3d-effect-show">
            <label><?php _e('Layers Overflow Hidden', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <div class="as-toggle-indicator as-pro-version">
                    <?php
                    foreach ($slider_select_options['boolean'] as $key => $value) {
                        $checked = '';
                        if ($enable_layer_overflow_hidden == $key) {
                            $checked = 'checked';
                        }
                        ?>
                        <input name="enable_layer_overflow_hidden" class="enable-layer-overflow-hidden" type="radio" id="enable_layer_overflow_hidden_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                        <label for="enable_layer_overflow_hidden_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <span class="option-desc"><?php _e('Hide layers when layers go outside of slide', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group as-3d-effect-show">
            <label><?php _e('Default 3D Depth', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-slider-default-3d-depth as-text-number as-pro-version" value="<?php echo esc_attr($default_3d_depth); ?>" />
                <span class="lbl_px">px</span>
            </div>
        </div>
        <div class="as-form-control-group">
            <span class="as-notice"><i class="far fa-hand-point-right"></i><?php _e('Mouse Sensibility', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group as-3d-effect-hide">
            <label><?php _e('Mouse Event', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <select class="as-slider-mouse-event as-pro-version">
                    <option <?php selected($slider_mouse_event, 'mouse'); ?> value="mouse"><?php _e('Mouse Move', 'avartan-slider-lite'); ?></option>
                    <option <?php selected($slider_mouse_event, 'scroll'); ?> value="scroll"><?php _e('Scroll Position', 'avartan-slider-lite'); ?></option>
                    <option <?php selected($slider_mouse_event, 'mouse+scroll'); ?> value="mouse+scroll"><?php _e('Move and Scroll', 'avartan-slider-lite'); ?></option>
                </select>
            </div>
        </div>
        <div class="as-form-control-group as-3d-effect-hide">
            <label><?php _e('Parallax Origin', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <select class="as-slider-parallax-origin as-pro-version">
                    <option <?php selected($parallax_origin, 'enterpoint'); ?> value="enterpoint"><?php _e('Mouse Enter Point', 'avartan-slider-lite'); ?></option>
                    <option <?php selected($parallax_origin, 'slidercenter'); ?> value="slidercenter"><?php _e('Slider Center', 'avartan-slider-lite'); ?></option>
                </select>
            </div>
        </div>
        <div class="as-form-control-group">
            <label><?php _e('Animation Speed', 'avartan-slider-lite'); ?></label>
            <div class="as-form-control">
                <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-pro-version as-slider-parallax-animation-speed as-text-number" value="<?php echo esc_attr($slider_parallax_animation_speed); ?>" />
                <span class="lbl_px">ms</span>
            </div>
            <span class="option-desc"><?php _e('Animation speed when mouse hover or scroll.', 'avartan-slider-lite'); ?></span>
        </div>
        <div class="as-form-control-group">
            <span class="as-notice"><i class="far fa-hand-point-right"></i><?php _e('Parallax Levels', 'avartan-slider-lite'); ?></span>
        </div>
        <?php
        $parallax_depth = 0;
        for ($x = 1; $x <= 15; $x++) {
            $parallax_depth = $parallax_depth + 5;
            $db_name = 'slider_parallax_depth_' . $x;
            $parallax_options = AvartanSliderLiteFunctions::getVal($parallax_options,$db_name,$parallax_depth);
            ?>
            <div class="as-form-control-group">
                <label><?php _e('Level Depth ', 'avartan-slider-lite') . $x; ?></label>
                <div class="as-form-control">
                    <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-pro-version as-slider-parallax-depth-<?php echo $x; ?> as-text-number" value="<?php echo esc_attr($parallax_options); ?>" />
                </div>
                <?php if($x == 1) { ?>
                    <span class="option-desc"><?php _e('In 3D animation level depth is strength of the effect and the smaller value comes to the front, and the higher value goes to the background.', 'avartan-slider-lite'); ?></span>
                <?php } ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>