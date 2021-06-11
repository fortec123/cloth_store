<?php
if (!defined('ABSPATH'))
    exit();

$automatic_slide = AvartanSliderLiteFunctions::getVal($slider_option,'automatic_slide',1);
$random_slide = 0;
$pauseon_hover_slide = AvartanSliderLiteFunctions::getVal($slider_option,'pause_on_hover',0);
$enable_swipe = AvartanSliderLiteFunctions::getVal($slider_option,'enable_swipe',1);

//Loader
$loader_options = AvartanSliderLiteFunctions::getVal($slider_option,'loader',array());
$lType = 'default';
$lEnable = 1;
$lStyle = AvartanSliderLiteFunctions::getVal($loader_options,'style','loader1');
$loaderBlock = ($lEnable == 1) ? 'style="display:block;"' : 'style="display:none;"';
$loaderDef = ($lEnable == 1 && $lType == 'default') ? 'style="display:block;"' : 'style="display:none;"';
$loaderUpload = ($lEnable == 1 && $lType != 'default') ? 'style="display:block;"' : 'style="display:none;"';
$lHtml = isset($slider_select_options['loaders'][$lStyle]) ? $slider_select_options['loaders'][$lStyle] : '';
$lWidth = AvartanSliderLiteFunctions::getVal($loader_options,'width','');
$lHeight = AvartanSliderLiteFunctions::getVal($loader_options,'height','');
$lImage =  ($lType == 'default') ? '' : esc_attr($lStyle);
?>
<div class="as-tabs-horizontal">
    <ul>
        <li><a href="#as-tab-general"><?php _e('General', 'avartan-slider-lite'); ?></a></li>
        <li><a href="#as-tab-loader"><?php _e('Loader', 'avartan-slider-lite'); ?></a></li>
    </ul>
    <div class="as-tabs-content">
        <!--Slider General-->
        <div class="as-tab-info" id="as-tab-general">
            <div class="as-form as-form-horizontal">
                <div class="as-form-control-group">
                    <label><?php _e('Automatic Slide', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-automaticSlide-toggle" id="as-slider-automaticSlide">
                            <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    $checked = '';
                                    if($automatic_slide == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <input name="automatic_slide" class="automatic-slide" type="radio" id="automatic_slide_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="automatic_slide_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('The slides loop is automatic.', 'avartan-slider-lite'); ?></span>
                </div>
                <div class="as-form-control-group">
                    <label><?php _e('Random Slide', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-randomSlide-toggle as-pro-version" id="as-slider-randomSlide">
                            <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    $checked = '';
                                    if($random_slide == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <input name="random_slide" class="random-slide" type="radio" id="random_slide_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="random_slide_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('The slide will be visible randomly.', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group">
                    <label><?php _e('Pause On Hover', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-pauseOnHover-toggle" id="as-slider-pauseOnHover">
                            <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    $checked = '';
                                    if($pauseon_hover_slide == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <input name="pause_on_hover_slide" class="pause-on-hover-slide" type="radio" id="pause_on_hover_slide_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="pause_on_hover_slide_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Pause the current slide when hovered.', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group">
                    <label><?php _e('Swipe & Drag', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-swipeDrag-toggle" id="as-slider-enableSwipe">
                            <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    $checked = '';
                                    if($enable_swipe == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <input name="enable_swipe" class="enable-swipe" type="radio" id="enable_swipe_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="enable_swipe_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Enable swipe left, swipe right, drag left, drag right commands.', 'avartan-slider-lite');?></span>
                </div>
            </div>
        </div>
        <!--Slider Loader-->
        <div class="as-tab-info" id="as-tab-loader">
            <div class="as-form as-form-horizontal">
                <div class="as-form-control-group">
                    <label><?php _e('Enable', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-loader-toggle" id="as-slider-enableLoader">
                            <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    $checked = '';
                                    if($lEnable == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <input name="enable_loader" class="enable-loader" type="radio" id="enable_loader_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="enable_loader_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Enable/Disable loader on slider.', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-form-control-group as-loader-type">
                    <label><?php _e('Type', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <select class="as-loaderType">
                            <option <?php echo $lType == 'default' ? 'selected="selected"' : '' ?> value="0"><?php _e('Select Default Loader', 'avartan-slider-lite'); ?></option>
                            <option <?php echo $lType != 'default' ? 'selected="selected"' : '' ?> value="1"><?php _e('Upload New Loader Image', 'avartan-slider-lite'); ?></option>
                        </select>
                    </div>
                    <span class="option-desc"><?php _e('Select Loader Type.', 'avartan-slider-lite');?></span>
                </div>
                <div class="as-loader-style">
                    <div class="as-form-control-group">
                        <label><?php _e('Style', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <a class="as-btn as-btn-default as-loaderStyle" href="javascript:void(0);"><?php _e('Change Loader Style', 'avartan-slider-lite'); ?></a>
                        </div>
                    </div>
                    <div class="as-form-control-group">
                        <label>&nbsp;</label>
                        <div class="as-form-control">
                            <div class="as-selected-loader-style" style="<?php echo $lHtml == '' ? 'display:none;' : 'display:table;' ?>">
                                <input type="hidden" class="as-loader-style-hidden" value="<?php echo esc_attr($lStyle); ?>" />
                                <div class="as-loader-style-html">
                                    <?php echo $lHtml; ?>
                                </div>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Change Loader style from default loader collection.', 'avartan-slider-lite');?></span>
                    </div>
                    <div id="dialog_loader_style" class="as-dialog-ui" title="<?php esc_attr_e('Select Loader', 'avartan-slider-lite'); ?>">
                        <div class="as-loader-style-box">
                            <?php
                            $total_bullets = count($slider_select_options['loaders']);
                            if ($total_bullets > 0) {
                                foreach ($slider_select_options['loaders'] as $key => $loader_html) {
                                    ?>
                                    <div class="as-dialog-loader-style">
                                        <input type="hidden" class="as-loader-style-hidden" value="<?php echo esc_attr($key); ?>" />
                                        <div class="as-loader-style-html">
                                            <?php echo $loader_html; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="as-loader-img">
                    <div class="as-form-control-group">
                        <label><?php _e('Style', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <a class="as-btn as-btn-default as-loaderImg" href="javascript:void(0);" data-width="<?php echo esc_attr($lWidth); ?>" data-height="<?php echo esc_attr($lHeight); ?>"><?php _e('Change Loader Image', 'avartan-slider-lite'); ?></a>
                        </div>
                    </div>
                    <div class="as-form-control-group">
                        <label>&nbsp;</label>
                        <div class="as-form-control">
                            <input type="hidden" class="as-loader-img-hidden" value="<?php echo esc_attr($lImage); ?>" />
                            <?php if ($lImage != '') { ?>
                                <img src="<?php echo esc_attr($lImage); ?>" />
                            <?php } ?>
                        </div>
                        <span class="option-desc"><?php _e('Upload new loader image.', 'avartan-slider-lite');?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>