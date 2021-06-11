<?php
if (!defined('ABSPATH'))
    exit();

$nav_options = AvartanSliderLiteFunctions::getVal($slider_option,'navigation',array());

//Arrows
$arrows_options = AvartanSliderLiteFunctions::getVal($nav_options,'arrows',array());
$aEnable = AvartanSliderLiteFunctions::getVal($arrows_options,'enable',0);
$navArrowStyle = ($aEnable == 1) ? 'style="display:table-row;"' : 'style="display:none;"';
$aStyle = AvartanSliderLiteFunctions::getVal($arrows_options,'style','arrows1');
$aHtml = isset($slider_select_options['arrows'][$aStyle]) ? $slider_select_options['arrows'][$aStyle] : '';

$left_arrow_options = 'left';
$lhPos = 'left';
$lvPos = 'center';
$lhOffset = 20;
$lvOffset = 0;

$right_arrow_options = 'right';
$rhPos = 'right';
$rvPos = 'center';
$rhOffset = 20;
$rvOffset = 0;
        
//Bullets
$bullets_options = AvartanSliderLiteFunctions::getVal($nav_options,'bullets',array());
$bEnable = AvartanSliderLiteFunctions::getVal($bullets_options,'enable',0);
$navBulletStyle = ($bEnable == 1) ? 'style="display:block;"' : 'style="display:none;"';
$bulletStyle = AvartanSliderLiteFunctions::getVal($bullets_options,'style','navigation1');
$bulletHTML = isset($slider_select_options['bullets'][$bulletStyle]) ? $slider_select_options['bullets'][$bulletStyle] : '';
$bulletInnerStyle = (isset($slider_select_options['bullets'][$bulletStyle][1]) && $slider_select_options['bullets'][$bulletStyle][1]) ? 'display:block;' : 'display:none;';
$bdirection = 'horizontal';
$bgap = 10;
$navHPosition = AvartanSliderLiteFunctions::getVal($bullets_options,'hPos','center');
$navVPosition = 'bottom';
$hOffset = 0;
$vOffset = 20;
?>
<div class="as-tabs-horizontal">
    <ul>
        <li><a href="#as-tab-arrows"><?php _e('Arrows', 'avartan-slider-lite'); ?></a></li>
        <li><a href="#as-tab-bullets"><?php _e('Bullets', 'avartan-slider-lite'); ?></a></li>
    </ul>
    <div class="as-tabs-content">
        <div class="as-tab-info" id="as-tab-arrows">
            <div class="as-form as-form-horizontal">
                <div class="as-form-control-group">
                    <label><?php _e('Enable', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-nav-arrows-toggle" id="as-slider-enableArrows">
                            <?php
                            foreach ($slider_select_options['boolean'] as $key => $value) {
                                $checked = '';
                                if ($aEnable == $key) {
                                    $checked = 'checked';
                                }
                                ?>
                            <input name="enable_navigation" class="enable-navigation" type="radio" id="enable_navigation_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                <label for="enable_navigation_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                <?php
                            }
                            
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Show the navigation arrows on slider.', 'avartan-slider-lite'); ?><br><b><?php _e('Note'); ?>&nbsp;:&nbsp;</b><?php _e('In Avartan Slider Lite plugin we are providing images for arrow and in Avartan Slider Pro plugin we are providing CSS3 arrow.','avartan-slider-lite') ?></span>
                </div>
                <div class="as-tab-arrows-enabled">
                    <div class="as-form-control-group">
                        <label><?php _e('Style', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <a class="as-btn as-btn-default as-arrowStyle" href="javascript:void(0);"><?php _e('Change Arrows Style', 'avartan-slider-lite'); ?></a>
                        </div>
                    </div>
                    <div class="as-form-control-group">
                        <label>&nbsp;</label>
                        <div class="as-form-control">
                            <div class="as-selected-arrow-style">
                                <input type="hidden" class="as-arrow-style-hidden" value="<?php echo esc_attr($aStyle); ?>" />
                                <div class="as-nav-arrows">
                                    <?php echo $aHtml; ?>
                                </div>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Select Previous and Next arrows to display on slider.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div id="dialog_arrows_style" class="as-dialog-ui" title="<?php esc_attr_e('Select Arrows', 'avartan-slider-lite'); ?>">
                        <div class="as-arrow-style-box">
                            <?php
                            $total_arrows = count($slider_select_options['arrows']);
                            if ($total_arrows > 0) {
                                foreach ($slider_select_options['arrows'] as $key => $arrows) {
                                    ?>
                                    <div class="as-dialog-arrow-style">
                                        <input type="hidden" class="as-arrows-style-hidden" value="<?php echo esc_attr($key); ?>" />
                                        <div class="as-nav-arrows">
                                            <?php echo $arrows; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="as-form-control-group">
                        <span class="as-notice"><i class="far fa-hand-point-right"></i> <?php _e('Left Arrow', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Horizontal Position', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <div class="as-toggle-indicator as-left-hpos-toggle" id="as-left-hpos-toggle">
                                <?php
                                foreach ($slider_select_options['navHPosition'] as $key => $value) {
                                    $checked = '';
                                    if ($lhPos == $key) {
                                        $checked = ' checked';
                                        $active = ' active';
                                    }
                                    ?>
                                <input type="radio" name="left_hpos" class="left-hpos" id="left_hpos_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?> />
                                <label class="<?php echo $active; ?>" for="left_hpos_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set horizontal position for left arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vertical Position', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <div class="as-toggle-indicator as-left-vpos-toggle" id="as-left-vpos-toggle">
                                <?php
                                foreach ($slider_select_options['navVPosition'] as $key => $value) {
                                    $checked = '';
                                    if ($lvPos == $key) {
                                        $checked = ' checked';
                                        $active = ' active';
                                    }
                                    ?>
                                    <input type="radio" name="left_vpos" class="left-vpos" id="left_vpos_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?> />
                                    <label class="<?php echo $active; ?>" for="left_vpos_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set vertical position for left arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Horizontal Offset', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-slider-arrowLHOffset as-text-number as-pro-version" value="<?php echo esc_attr($lhOffset); ?>" type="text" readonly="readonly" value="0" onkeypress="return avsIsNumberKey(event);" min="0" />
                            <span class="lbl_px">px</span>
                        </div>
                        <span class="option-desc"><?php _e('Set horizontal offset for left arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vertical Offset', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-slider-arrowLVOffset as-text-number as-pro-version" value="<?php echo esc_attr($lvOffset); ?>" type="text" readonly="readonly" value="0" onkeypress="return avsIsNumberKey(event);" min="0" />
                            <span class="lbl_px">px</span>
                        </div>
                        <span class="option-desc"><?php _e('Set vertical offset for left arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <span class="as-notice"><i class="far fa-hand-point-right"></i> <?php _e('Right Arrow', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Horizontal Position', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <div class="as-toggle-indicator as-right-hpos-toggle" id="as-right-hpos-toggle">
                                <?php
                                foreach ($slider_select_options['navHPosition'] as $key => $value) {
                                    $checked = '';
                                    if ($rhPos == $key) {
                                        $checked = ' checked';
                                        $active = ' active';
                                    }
                                    ?>
                                    <input type="radio" name="right_hpos" class="right-hpos" id="right_hpos_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?> />
                                    <label class="<?php echo $active; ?>" for="right_hpos_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set horizontal position for right arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vertical Position', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <div class="as-toggle-indicator as-right-vpos-toggle" id="as-right-vpos-toggle">
                                <?php
                                foreach ($slider_select_options['navVPosition'] as $key => $value) {
                                    $checked = '';
                                    if ($rvPos == $key) {
                                        $checked = ' checked';
                                        $active = ' active';
                                    }
                                    ?>
                                    <input type="radio" name="right_vpos" class="right-vpos" id="right_vpos_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?> />
                                    <label class="<?php echo $active; ?>" for="right_vpos_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set vertical position for right arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Horizontal Offset', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-slider-arrowRHOffset as-text-number as-pro-version" value="<?php echo esc_attr($rhOffset); ?>" type="text" readonly="readonly" value="0" onkeypress="return avsIsNumberKey(event);" min="0" />
                            <span class="lbl_px">px</span>
                        </div>
                        <span class="option-desc"><?php _e('Set horizontal offset for right arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vertical Offset', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-slider-arrowRVOffset as-text-number as-pro-version" value="<?php echo esc_attr($rvOffset); ?>" type="text" readonly="readonly" value="0" onkeypress="return avsIsNumberKey(event);" min="0" />
                            <span class="lbl_px">px</span>
                        </div>
                        <span class="option-desc"><?php _e('Set vertical offset for right arrow.', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="as-tab-info" id="as-tab-bullets">
            <div class="as-form as-form-horizontal">
                <div class="as-form-control-group">
                    <label><?php _e('Enable', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-nav-bullets-toggle">
                            <?php
                            foreach ($slider_select_options['boolean'] as $key => $value) {
                                $checked = '';
                                if($bEnable == $key) {
                                    $checked = 'checked';
                                }
                                ?>
                                <input name="enable_nav_bullets" class="enable-nav-bullets" type="radio" id="enable_nav_bullets_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                <label for="enable_nav_bullets_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Show bullets on slide.', 'avartan-slider-lite'); ?></span>
                </div>
                <div class="as-tab-bullets-enabled" <?php echo $navBulletStyle; ?>>
                    <div class="as-form-control-group">
                        <label><?php _e('Style', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <a class="as-btn as-btn-default as-bulletStyle" href="javascript:void(0);"><?php _e('Change Bullets Style', 'avartan-slider-lite'); ?></a>
                        </div>
                    </div>
                    <div class="as-form-control-group">
                        <label>&nbsp;</label>
                        <div class="as-form-control">
                            <div class="as-selected-bullet-style">
                                <input type="hidden" class="as-bullet-style-hidden" value="<?php echo esc_attr($bulletStyle); ?>" />
                                <div class="as-bullets-wrap">
                                    <?php echo $bulletHTML; ?>
                                </div>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Select navigation to display on slider.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div id="dialog_bullets_style" class="as-dialog-ui" title="<?php esc_attr_e('Select Bullets', 'avartan-slider-lite'); ?>">
                        <div class="as-bullet-style-box">
                            <?php
                            $total_bullets = count($slider_select_options['bullets']);
                            if ($total_bullets > 0) {
                                foreach ($slider_select_options['bullets'] as $key => $bullets_val) {
                                    ?>
                                    <div class="as-dialog-bullet-style">
                                        <input type="hidden" class="as-bullet-style-hidden" value="<?php echo esc_attr($key); ?>" />
                                        <div class="as-bullets-wrap">
                                            <?php echo $bullets_val; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="as-form-control-group" <?php echo $navBulletStyle; ?>>
                        <label><?php _e('Direction', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <select class="as-bullet-direction as-slider-bulletsDirection">
                                <?php
                                foreach ($slider_select_options['navDirection'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bdirection == $key) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <span class="option-desc"><?php _e('Set navigation bullets direction.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group" <?php echo $navBulletStyle; ?>>
                        <label><?php _e('Gap', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-bullet-gap as-text-number as-pro-version" type="text" onkeypress="return avsIsNumberKey(event);" min="0" value="<?php echo esc_attr($bgap); ?>">
                            <span class="lbl_px">px</span>
                        </div>
                        <span class="option-desc"><?php _e('The gap between bullets.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Horizontal Position', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <div class="as-toggle-indicator as-bullet-hpos-toggle" id="as-bullet-hpos-toggle">
                                <?php
                                foreach ($slider_select_options['navHPosition'] as $key => $value) {
                                    $checked = '';
                                    if ($navHPosition == $key) {
                                        $checked = ' checked';
                                        $active = ' active';
                                    }
                                    ?>
                                    <input type="radio" name="bullet_hpos" class="bullet-hpos" id="bullet_hpos_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?> />
                                    <label class="<?php echo $active; ?>" for="bullet_hpos_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set horizontal position for bullets.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vertical Position', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <div class="as-toggle-indicator as-bullet-vpos-toggle" id="as-bullet-vpos-toggle">
                                <?php
                                foreach ($slider_select_options['navVPosition'] as $key => $value) {
                                    $checked = '';
                                    if ($navVPosition == $key) {
                                        $checked = ' checked';
                                        $active = ' active';
                                    }
                                    ?>
                                    <input type="radio" name="bullet_vpos" class="bullet-vpos" id="bullet_vpos_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?> />
                                    <label for="bullet_vpos_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set vertical position for bullets.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Horizontal Offset', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-bullet-horizontal-offset as-text-number as-pro-version" readonly="readonly" value="<?php echo esc_attr($hOffset); ?>" type="text" value="0" onkeypress="return avsIsNumberKey(event);" min="0">
                            <span class="lbl_px">px</span>
                        </div>
                        <span class="option-desc"><?php _e('Set horizontal offset for bullets.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vertical Offset', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-bullet-verticle-offset as-text-number as-pro-version" readonly="readonly" value="<?php echo esc_attr($vOffset); ?>" type="text" value="0" onkeypress="return avsIsNumberKey(event);" min="0">
                            <span class="lbl_px">px</span>
                        </div>
                        <span class="option-desc"><?php _e('Set vertical offset for bullets.', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>