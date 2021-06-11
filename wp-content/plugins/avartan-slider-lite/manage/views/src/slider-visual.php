<?php
if (!defined('ABSPATH'))
    exit();

$bg_type = AvartanSliderLiteFunctions::getVal($slider_option,'background_type_color','transparent');
$display_bgcolor = ($bg_type == 'transparent' ? 'style="display:none"' : 'style="display:block"');
$shadow_enable = AvartanSliderLiteFunctions::getVal($slider_option,'show_shadow_bar',0);
$shadow_style = AvartanSliderLiteFunctions::getVal($slider_option,'shadow_class','shadow1');
$navigation_options = AvartanSliderLiteFunctions::getVal($slider_option,'navigation',array());
$arrows_options = AvartanSliderLiteFunctions::getVal($navigation_options,'arrows',array());
$navBulletOptions = AvartanSliderLiteFunctions::getVal($navigation_options,'bullets',array());

$slider_hide = 0;
$def_ele = 0;
$ele_all = 0;
$arrow_hide = 360;
$bullet_hide = 360;
$show_timer_bar = 0;
$timer_bar_position = 'top_pos';
?>
<div class="as-tabs-horizontal">
    <ul>
        <li><a href="#as-tab-appearance"><?php _e('Appearance', 'avartan-slider-lite'); ?></a></li>
        <li><a href="#as-tab-mobile"><?php _e('Mobile', 'avartan-slider-lite'); ?></a></li>
        <li><a href="#as-tab-timerbar"><?php _e('Timer Bar', 'avartan-slider-lite'); ?></a></li>
    </ul>
    <div class="as-tabs-content">
        <div class="as-tab-info" id="as-tab-appearance">
            <div class="as-form as-form-horizontal">
                <div class="as-form-control-group">
                    <label>
                        <?php _e('Background Color', 'avartan-slider-lite'); ?>
                    </label>
                    <div class="as-form-control">
                        <select id="as-slider-background-type-color" class="as-slider-bgcolor">
                            <option value="0" <?php echo $bg_type == 'transparent' ? 'selected="selected"' : '' ?>><?php _e('Transparent', 'avartan-slider-lite'); ?></option>
                            <option value="1" <?php echo ($bg_type != '' && $bg_type != 'transparent') ? 'selected="selected"' : '' ?>><?php _e('Color', 'avartan-slider-lite'); ?></option>
                        </select>
                    </div>
                    <span class="option-desc"><?php _e('The background of slider.', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group as-slider-bg-colorpicker" <?php echo $display_bgcolor; ?>>
                    <label></label>
                    <div class="as-form-control">
                        <input type="text" id="as-slider-background-type-color-picker-input" value="<?php echo ($bg_type != '' && $bg_type != 'transparent') ? esc_attt($bg_type) : '' ?>" class="as-slider-bgcolorpicker as-color-picker" data-alpha="true" data-custom-width="0" />
                    </div>
                </div>
                <div class="as-form-control-group">
                    <label>
                        <?php _e('Shadow', 'avartan-slider-lite'); ?>
                    </label>
                    <div class="as-form-control">
                        <select class="as-slider-shadow as-slider-shadow-type">
                            <option value="0" <?php echo $shadow_enable == 0 ? 'selected="selected"' : '' ?>><?php _e('None', 'avartan-slider-lite'); ?></option>
                            <option value="1" <?php echo $shadow_enable == 1 ? 'selected="selected"' : '' ?> ><?php _e('Shadow', 'avartan-slider-lite'); ?></option>
                        </select>
                    </div>
                    <span class="option-desc"><?php _e('Choose to display shadow.', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group as-slider-shadow-img">
                    <label></label>
                    <div class="as-form-control">
                        <input class="as-slider-default-shadow as-button as-is-default" type="hidden" value="<?php esc_attr_e('Select Default Shadow', 'avartan-slider-lite'); ?>" data-shadow-class="<?php echo esc_attr($shadow_style); ?>" />
                        <?php
                        $shadow_path = AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/shadow/';
                        $total_shadow = count($slider_select_options['shadow']);
                        if ($total_shadow > 0) {
                            foreach ($slider_select_options['shadow'] as $shadow_val) {
                                $class = '';
                                if (strtolower($shadow_val) == $shadow_style) {
                                    $class = 'as-active';
                                }
                                ?>
                                <div class="as-shadow-img <?php echo $class; ?>">
                                    <img data-shadow-class="<?php echo $shadow_val; ?>" src="<?php echo $shadow_path.strtolower($shadow_val).'.png'; ?>" alt="Slider Shadow"/>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="as-tab-info" id="as-tab-mobile">
            <div class="as-form as-form-horizontal">
                <div class="as-form-control-group">
                    <label>
                        <?php _e('Hide Slider', 'avartan-slider-lite'); ?>
                    </label>
                    <div class="as-form-control">
                        <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-hide-slider as-text-number as-pro-version" value="<?php echo esc_attr($slider_hide); ?>" />
                        <span class="lbl_px">px</span>
                    </div>
                    <span class="option-desc"><?php _e('Hide slider after define width. Default : 0px', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group">
                    <label>
                        <?php _e('Hide Defined Elements', 'avartan-slider-lite'); ?>
                    </label>
                    <div class="as-form-control">
                        <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-hide-define-ele as-text-number as-pro-version" value="<?php echo esc_attr($def_ele); ?>" />
                        <span class="lbl_px">px</span>
                    </div>
                    <span class="option-desc"><?php _e('Hide defined elements after define width. Default : 0px', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group">
                    <label>
                        <?php _e('Hide All Elements', 'avartan-slider-lite'); ?>
                    </label>
                    <div class="as-form-control">
                        <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-hide-all-ele as-text-number as-pro-version" value="<?php echo esc_attr($ele_all); ?>" />
                        <span class="lbl_px">px</span>
                    </div>
                    <span class="option-desc"><?php _e('Hide all elements after define width. Default : 0px', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group">
                    <label>
                        <?php _e('Hide Arrows', 'avartan-slider-lite'); ?>
                    </label>
                    <div class="as-form-control">
                        <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-hide-arrows as-text-number as-pro-version" value="<?php echo esc_attr($arrow_hide); ?>" />
                        <span class="lbl_px">px</span>
                    </div>
                    <span class="option-desc"><?php _e('Hide arrows after define width. Default : 360px', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group">
                    <label>
                        <?php _e('Hide Bullets', 'avartan-slider-lite'); ?>
                    </label>
                    <div class="as-form-control">
                        <input type="text" min="0" readonly="readonly" onkeypress="return avsIsNumberKey(event);" class="as-hide-bullets as-text-number as-pro-version" value="<?php echo esc_attr($bullet_hide); ?>" />
                        <span class="lbl_px">px</span>
                    </div>
                    <span class="option-desc"><?php _e('Hide bullets after define width. Default : 360px', 'avartan-slider-lite');?></span>
                </div>
            </div>
        </div>
        <div class="as-tab-info" id="as-tab-timerbar">
            <div class="as-form as-form-horizontal">
                <div class="as-form-control-group">
                    <label><?php _e('Show Timer Bar', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-timerbar-toggle as-pro-version" id="as-slider-showTimerBar">
                            <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    $checked = '';
                                    if($show_timer_bar == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <input name="show_timer_bar" class="show-timer-bar" type="radio" id="show_timer_bar_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="show_timer_bar_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Draw the timer bar during the slide execution.', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group as-timerbar-position">
                    <label><?php _e('Timer Bar Position', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control as-pro-version">
                        <select class="as-slider-timerBarPosition">
                            <?php
                                foreach ($slider_select_options['timerBarPosition'] as $key => $value) {
                                    $selected = '';
                                    if($timer_bar_position == $key) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $key; ?>">
                                        <?php echo $value[0]; ?>
                                    </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <span class="option-desc"><?php _e('Set the timer bar position.', 'avartan-slider-lite');?></span>
                </div>
            </div>
        </div>
    </div>
</div>