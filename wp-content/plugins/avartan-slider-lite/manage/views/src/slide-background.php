<?php
if (!defined('ABSPATH'))
    exit();

//Background
$bg_options = AvartanSliderLiteFunctions::getVal($params_slide,'background',array());
$bg_type = AvartanSliderLiteFunctions::getVal($bg_options,'type','transparent');
$bg_type = ($bg_type == 'featured_image' && $slider_type == 'standard-slider') ? 'transparent' : $bg_type;

//Hide and show blocks
$bg_color = $bg_type == 'solid_color' ? 'style="display:block;"' : 'style="display:none;"';
$bg_gd = $bg_type == 'gradient_color' ? 'style="display:none;"' : 'style="display:none;"';
$bg_image = $bg_type == 'image' ? 'style="display:block;"' : 'style="display:none;"';
$bg_yt = $bg_type == 'youtube_video' ? 'style="display:none;"' : 'style="display:none;"';
$bg_vi = $bg_type == 'vimeo_video' ? 'style="display:none;"' : 'style="display:none;"';
$bg_ht = $bg_type == 'html5_video' ? 'style="display:none;"' : 'style="display:none;"';

//Get Background Solid Color
$bgcolor = AvartanSliderLiteFunctions::getVal($bg_options,'bgcolor','transparent');

//Get Background Gradient Color
$bg_gradient = array();
$bggradient_cr = '';
$bggradient_angle = 0;

//Get Background Image
$bg_img = AvartanSliderLiteFunctions::getVal($bg_options,'image',array());
$bgimage_src = AvartanSliderLiteFunctions::getVal($bg_img,'source','');
$bgimage_alt = '';
$bgimage_title = '';
$bgimage_pos = AvartanSliderLiteFunctions::getVal($bg_img,'position','center center');
$bgimage_posx = AvartanSliderLiteFunctions::getVal($bg_img,'position_x',0);
$bgimage_posy = AvartanSliderLiteFunctions::getVal($bg_img,'position_y',0);
$bgimage_repeat = AvartanSliderLiteFunctions::getVal($bg_img,'repeat','no-repeat');
$bgimage_size = AvartanSliderLiteFunctions::getVal($bg_img,'size','cover');
$bgimage_sizex = AvartanSliderLiteFunctions::getVal($bg_img,'sizex',100);
$bgimage_sizey = AvartanSliderLiteFunctions::getVal($bg_img,'sizey',100);

//Get Background Youtube Video
$bgYSrc = '';
$bgYFC = 0;
$bgYRatio = '16:9';

$bgYPSrc = '';
$bgYPAlt = '';
$bgYPTitle = '';

$bgYSLoop = 0;
$bgYSNS = 0;
$bgYSFR = 0;
$bgYSMute = 0;

$bgYRS = ($bg_type == 'youtube_video' && $bgYFC != 0) ? 'style="display:block;"' : 'style="display:none;"';

//Get Background Vimeo Video
$bgVSrc = '';
$bgVFC = 0;
$bgVRatio = '16:9';

$bgVPSrc = '';
$bgVPAlt = '';
$bgVPTitle = '';

$bgVSLoop = 0;
$bgVSNS = 0;
$bgVSFR = 0;
$bgVSMute = 0;

$bgVRS = ($bg_type == 'vimeo_video' && $bgVFC != 0) ? 'style="display:block;"' : 'style="display:none;"';

//Get Background HTML5 Video
$bgHMp4 = '';
$bgHWebm = '';
$bgHOgv = '';
$bgHFC = 1;
$bgHRatio = '16:9';

$bgHPSrc = '';
$bgHPAlt = '';
$bgHPTitle = '';

$bgHSLoop = 0;
$bgHSNS = 0;
$bgHSFR = 0;
$bgHSMute = 0;

$bgHRS = ($bg_type == 'html5_video' && $bgHFC != 0) ? 'style="display:block;"' : 'style="display:none;"';

//Get color overlay info
$bgoverlay_type = 'solid_color';

$bgoverlay_color = $bgoverlay_type == 'solid_color' ? 'style="display:block;"' : 'style="display:none;"';
$bgoverlay_gd = $bgoverlay_type == 'gradient_color' ? 'style="display:block;"' : 'style="display:none;"';

//SOLID COLOR OVERLAY
$bgcolor_overlay = '';

//GRADIENT COLOR OVERLAY
$bggradient_overlay_cr = '';
$bggradient_overlay_angle = 0;

//PATTERN OVERLAY
$bgpattern_overlay_origin = 'pattern0';
$bgpattern_overlay = 'as-pattern ' . $bgpattern_overlay_origin;

//Ker Burns value
$enable_kenburns = 'off';
$kb_scale_start = 100;
$kb_scale_end = 100;
$kb_horizontal_from = 0;
$kb_horizontal_to = 0;
$kb_vertical_from = 0;
$kb_vertical_to = 0;
$kb_rotation_start = 0;
$kb_rotation_end = 0;
$kb_easing = 'Linear.easeNone';
$kb_easing_time = 10000;
?>
<div class="as-form as-form-horizontal">
    <div class="as-tabs-horizontal">
        <ul class="ui-tabs-nav">
            <li class="ui-state-default"><a href="#as_tab_source_settings"><?php _e('Source & Settings', 'avartan-slider-lite'); ?></a></li>
            <li class="as-slide-parallax-show-hide ui-state-default"><a href="#as_tab_parallax"><?php _e('Parallax/3D', 'avartan-slider-lite'); ?></a></li>
            <li class="as-slide-kenburns-show-hide ui-state-default"><a href="#as_tab_kenburns"><?php _e('Ken Burns', 'avartan-slider-lite'); ?></a></li>
            <li class="ui-state-default"><a href="#as_tab_overlay"><?php _e('Overlay', 'avartan-slider-lite'); ?></a></li>
        </ul>
        <div class='as-tabs-content'>
            <div id='as_tab_source_settings' class="as-tab-info">
                <div class="as-form-control-group">
                    <?php
                    if($slider_type == 'standard-slider') {
                        foreach ($slide_select_options['background']['background_type'] as $key => $val) {
                            if($key == 'featured_image') {
                                unset($slide_select_options['background']['background_type'][$key]);
                            }
                        }
                    }
                    ?>
                    <label><?php _e('Background Type', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <select class="as-slide-bg-type">
                            <?php
                                foreach ($slide_select_options['background']['background_type'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bg_type == $key) {
                                        echo ' selected="selected"';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <span class="option-desc"><?php _e('Select slide background type.', 'avartan-slider-lite'); ?></span>
                </div>
                <!--Background Type - Solid Color-->
                <div class="as-form-control-group as-bgtype-solidColor">
                    <label><?php _e('BG Color', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <input type="text" value="<?php echo esc_attr($bgcolor); ?>" class="as-slide-bgcolor as-color-picker" data-alpha="true" data-custom-width="0" />
                    </div>
                    <span class="option-desc"><?php _e('Select background color.', 'avartan-slider-lite'); ?></span>
                </div>
                <!--Background Type - Gradient Color-->
                <div class="as-bgtype-gradientColor">
                    <?php
                    $bgcolorArr = explode('<==>', $bggradient_cr);
                    $detColor1 = (count($bgcolorArr) > 0 && isset($bgcolorArr[0]) ? $bgcolorArr[0] : '');
                    $detColor2 = (count($bgcolorArr) > 0 && isset($bgcolorArr[1]) ? $bgcolorArr[1] : '');
                    ?>
                    <div class="as-form-control-group">
                        <label><?php _e('BG Gradient Color', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-color">
                            <input type="text" readonly="readonly" value="<?php echo esc_attr($detColor1); ?>" class="as-slide-gradientColor as-color-picker" data-alpha="true" data-custom-width="0" />
                        </div>
                        <span class="option-desc"><?php _e('Select gradient color.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group as-gradient-block">
                        <label>&nbsp;</label>
                        <div class="as-form-control as-pro-color">
                            <input type="text" value="<?php echo esc_attr($detColor2); ?>" readonly="readonly" class="as-slide-gradientColor as-color-picker" data-alpha="true" data-custom-width="0" />
                            <button class="as-add-bgGradient as-pro-version"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <?php
                    if (isset($bgcolorArr) && count($bgcolorArr) > 2) {
                        for ($i = 2; $i < count($bgcolorArr); $i++) {
                            ?>
                            <div class="as-form-control-group as-gradient-block">
                                <label>&nbsp;</label>
                                <div class="as-form-control as-pro-color">
                                    <input type="text" value="<?php echo esc_attr($bgcolorArr[$i]); ?>" readonly="readonly" class="as-slide-gradientColor as-color-picker" data-alpha="true" data-custom-width="0" />
                                    <button class="as-remove-bgGradient"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="as-form-control-group">
                        <label><?php _e('BG Gradient Angle', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-slide-gradientAngle as-text-number as-pro-version" readonly="readonly" type="text" onkeypress="return avsIsNumberKey(event);" value="<?php echo esc_attr($bggradient_angle); ?>" min="0" />
                            <span class="lbl_px"><?php _e('deg', 'avartan-slider-lite'); ?></span>
                        </div>
                        <span class="option-desc"><?php _e('Set slide background gradient angle.', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
                <!--Background Type - Image-->
                <div class="as-bgtype-image">
                    <div class="as-form-control-group">
                        <label><?php _e('BG Image', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <button data-source="<?php echo esc_attr($bgimage_src); ?>" data-alt="<?php echo esc_attr($bgimage_alt); ?>" class="as-btn as-btn-default as-slide-bg-image"><?php _e('Select Image', 'avartan-slider-lite'); ?></button>
                        </div>
                        <span class="option-desc"><?php _e('Select background image.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Alter Text', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" class="as-slide-alter-text as-pro-version" value="<?php echo esc_attr($bgimage_alt); ?>" placeholder="<?php esc_attr_e('Alter Text', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <span class="option-desc"><?php _e('Alter attribute for background image.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Image Title', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" class="as-slide-image-title as-pro-version" value="<?php echo esc_attr($bgimage_title); ?>" placeholder="<?php esc_attr_e('Image Title', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <span class="option-desc"><?php _e('Title attribute for background image.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('BG Position', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <select class="as-slide-bgpos">
                                <?php
                                foreach ($slide_select_options['background']['position'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bgimage_pos == $key) {
                                        echo ' selected="selected"';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                            <?php
                            $disp_position = "display:none;";
                            if ($bgimage_pos == 'percentage') {
                                $disp_position = "display:inline;";
                            }
                            ?>
                        </div>
                        <div class="as-form-control as-slide-bgpos-p" style="<?php echo $disp_position; ?>">
                            <input class="as-slide-bgpos-x" type="number" onkeypress="return avsIsNumberKey(event);" name="bg_position_x" value="<?php echo esc_attr($bgimage_posx); ?>" max='100' min="0" placeholder="<?php _e('Background Position X', 'avartan-slider-lite')?>">
                        </div>
                        <div class="as-form-control as-slide-bgpos-p" style="<?php echo $disp_position; ?>">
                            <input class="as-slide-bgpos-y" type="number" onkeypress="return avsIsNumberKey(event);" name="bg_position_y" value="<?php echo esc_attr($bgimage_posy); ?>" max='100' min="0" placeholder="<?php _e('Background Position Y', 'avartan-slider-lite')?>">
                        </div>
                        <span class="option-desc"><?php _e('Set backgound image position. Default : Center Center', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('BG Size', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <select class="as-slide-bgsize">
                                <?php
                                foreach ($slide_select_options['background']['size'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bgimage_size == $key) {
                                        echo ' selected="selected"';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                            <?php
                            $disp_size = "display:none;";
                            if ($bgimage_size == 'percentage') {
                                $disp_size = "display:inline;";
                            }
                            ?>
                        </div>
                        <div class="as-form-control as-slide-bgsize-p" style="<?php echo $disp_size; ?>">
                            <input class="as-slide-bgsize-x" type="number" onkeypress="return avsIsNumberKey(event);" value="<?php echo esc_attr($bgimage_sizex); ?>" max='100' min="0" placeholder="<?php _e('Background Size X', 'avartan-slider-lite')?>" />
                        </div>
                        <div class="as-form-control as-slide-bgsize-p" style="<?php echo $disp_size; ?>">
                            <input class="as-slide-bgsize-y" type="number" onkeypress="return avsIsNumberKey(event);" value="<?php echo esc_attr($bgimage_sizey); ?>" max='100' min="0" placeholder="<?php _e('Background Size Y', 'avartan-slider-lite')?>" />
                        </div>
                        <span class="option-desc"><?php _e('Set backgound image size. Default : Cover', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('BG Repeat', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <select class="as-slide-bgrepeat" name="as-slide-bgrepeat">
                                <?php
                                foreach ($slide_select_options['background']['repeat'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bgimage_repeat == $key) {
                                        echo ' selected="selected"';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <span class="option-desc"><?php _e('Set backgound image repeat. Default : No Repeat', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
                <!--Background Type - YouTube Video-->
                <div class="as-bgtype-youTubeVideo" <?php echo $bg_yt; ?>>
                    <div class="as-form-control-group">
                        <label><?php _e('Youtube ID or URL', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" value="<?php echo esc_attr($bgYSrc); ?>" class="as-slide-youtube-source as-video-source as-align-vmiddle as-pro-version" placeholder="<?php esc_attr_e('Youtube ID or URL', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <button data-source="<?php echo esc_attr($bgYPSrc); ?>" data-alt="<?php echo esc_attr($bgYPAlt); ?>" data-title="<?php echo esc_attr($bgYPTitle); ?>" class="as-video-poster as-pro-version"><?php _e('Set Poster', 'avartan-slider-lite'); ?></button>
                        <span class="option-desc"><?php _e('Example: zxEEkm_qKjI', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Force Cover', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <div class="as-toggle-indicator as-slide-video-forcecover as-pro-version" title="<?php esc_attr_e('Force Cover', 'avartan-slider-lite'); ?>">
                                <?php
                                $bgvideo_forcecover = 0;
                                if ($bgYFC) {
                                    $bgvideo_forcecover = $bgYFC;
                                }
                                foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                    $checked = '';
                                    if ($bgvideo_forcecover == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                <input type="radio" name="bgvideo_forcecover" class="yt-bgvideo_forcecover as-pro-version" id="bgvideo_forcecover_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="bgvideo_forcecover_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set Yes then video display forcefully in fullwidth.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Aspect Ratio', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <select class="as-slide-video-aspectratio as-pro-version">
                                <?php
                                $video_aspect_ratio = array(
                                    '16:9' => '16:9',
                                    '4:3' => '4:3',
                                );
                                foreach ($video_aspect_ratio as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bgYRatio == $key) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <span class="option-desc"><?php _e('Select aspect ratio of video.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Video Settings', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Loop Video', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-youtube-loop as-pro-version" title="<?php esc_attr_e('Youtube Loop', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_youtube_loop = 0;
                                    if ($bgYSLoop) {
                                        $slide_youtube_loop = $bgYSLoop;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_youtube_loop == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_youtube_loop" class="as-slide-video-loop as-pro-version" id="slide_youtube_loop_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_youtube_loop_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Next Slide on End', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-youtube-next-slide as-pro-version" title="<?php esc_attr_e('Next Slide on End', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_youtube_next_slide = 0;
                                    if ($bgYSNS) {
                                        $slide_youtube_next_slide = $bgYSNS;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_youtube_next_slide == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_youtube_next_slide" class="as-slide-next-slide-on-video-end as-pro-version" id="slide_youtube_next_slide_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_youtube_next_slide_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Force Rewind', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-youtube-force-rewind as-pro-version" title="<?php esc_attr_e('Force Rewind', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_youtube_force_rewind = 0;
                                    if ($bgYSFR) {
                                        $slide_youtube_force_rewind = $bgYSFR;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_youtube_force_rewind == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_youtube_force_rewind" class="as-slide-video-force-rewind as-pro-version" id="slide_youtube_force_rewind_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_youtube_force_rewind_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Mute', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-youtube-force-rewind as-pro-version" title="<?php esc_attr_e('Force Rewind', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_youtube_video_mute = 0;
                                    if ($bgYSMute) {
                                        $slide_youtube_video_mute = $bgYSMute;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_youtube_video_mute == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_youtube_video_mute" class="as-slide-video-mute as-pro-version" id="slide_youtube_video_mute_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_youtube_video_mute_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set video settings.', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
                <!--Background Type - Vimeo Video-->
                <div class="as-bgtype-vimeoVideo">
                    <div class="as-form-control-group">
                        <label><?php _e('Vimeo ID or URL', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" value="<?php echo esc_attr($bgVSrc); ?>" class="as-slide-vimeo-source as-video-source as-pro-version" placeholder="<?php esc_attr_e('Vimeo ID or URL', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <button data-source="<?php echo esc_attr($bgVPSrc); ?>" data-alt="<?php echo esc_attr($bgVPAlt); ?>" data-title="<?php echo esc_attr($bgVPTitle); ?>" class="as-video-poster as-pro-version"><?php _e('Set Poster', 'avartan-slider-lite'); ?></button>
                        <span class="option-desc"><?php _e('Example', 'avartan-slider-lite'); ?>: 35545973</span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Force Cover', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <div class="as-toggle-indicator as-slide-vimeo-forcecover as-pro-version" title="<?php esc_attr_e('Force Cover', 'avartan-slider-lite'); ?>">
                                <?php
                                $vimeo_forcecover = 0;
                                if ($bgVFC) {
                                    $vimeo_forcecover = $bgVFC;
                                }
                                foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                    $checked = '';
                                    if ($vimeo_forcecover == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                <input type="radio" name="vimeo_forcecover" class="vimeo_forcecover as-pro-version" id="vimeo_forcecover_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="vimeo_forcecover_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set Yes then video display forcefully in fullwidth.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Aspect Ratio', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <select class="as-slide-vimeo-aspectratio as-pro-version">
                                <?php
                                foreach ($video_aspect_ratio as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bgVRatio == $key) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <span class="option-desc"><?php _e('Select aspect ratio of video.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vimeo Settings', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Loop Video', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-vimeo-loop as-pro-version" title="<?php esc_attr_e('Youtube Loop', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_vimeo_loop = 0;
                                    if ($bgVSLoop) {
                                        $slide_vimeo_loop = $bgVSLoop;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_vimeo_loop == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_vimeo_loop" class="as-slide-video-loop as-pro-version" id="slide_vimeo_loop_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_vimeo_loop_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Next Slide on End', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-vimeo-next-slide as-pro-version" title="<?php esc_attr_e('Next Slide on End', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_vimeo_next_slide = 0;
                                    if ($bgVSNS) {
                                        $slide_vimeo_next_slide = $bgVSNS;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_vimeo_next_slide == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_vimeo_next_slide" class="as-slide-next-slide-on-video-end as-pro-version" id="slide_vimeo_next_slide_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_vimeo_next_slide_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Force Rewind', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-vimeo-force-rewind as-pro-version" title="<?php esc_attr_e('Force Rewind', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_vimeo_force_rewind = 0;
                                    if ($bgVSFR) {
                                        $slide_vimeo_force_rewind = $bgVSFR;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_vimeo_force_rewind == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_vimeo_force_rewind" class="as-slide-video-force-rewind as-pro-version" id="slide_vimeo_force_rewind_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_vimeo_force_rewind_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Mute', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-vimeo-force-rewind as-pro-version" title="<?php esc_attr_e('Force Rewind', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_vimeo_video_mute = 0;
                                    if ($bgVSMute) {
                                        $slide_vimeo_video_mute = $bgVSMute;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_vimeo_video_mute == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_vimeo_video_mute" class="as-slide-video-mute as-pro-version" id="slide_vimeo_video_mute_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_vimeo_video_mute_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set video settings.', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
                <!--Background Type - HTML5 Video-->
                <div class="as-bgtype-htmlVideo">
                    <div class="as-form-control-group">
                        <label><?php _e('MP4','avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" value="<?php echo  esc_attr($bgHMp4); ?>" class="as-slide-mp4-source as-video-source as-pro-version" placeholder="<?php esc_attr_e('MP4', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('MP4', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <button class="as-video-upload as-slide-mp4-source as-pro-version"><?php _e('Set Video','avartan-slider-lite'); ?></button>
                        <span class="option-desc"><?php _e('Example', 'avartan-slider-lite'); ?>: http://media.w3.org/2010/05/sintel/trailer.mp4</span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('WEBM','avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" value="<?php echo esc_attr($bgHWebm); ?>" class="as-slide-webm-source as-video-source as-pro-version" placeholder="<?php esc_attr_e('WEBM', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('WEBM', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <button class="as-video-upload as-slide-webm-source as-pro-version"><?php _e('Set Video','avartan-slider-lite'); ?></button>
                        <span class="option-desc"><?php _e('Example', 'avartan-slider-lite'); ?>: http://media.w3.org/2010/05/sintel/trailer.webm</span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('OGV','avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" value="<?php echo esc_attr($bgHOgv); ?>" class="as-slide-ogv-source as-video-source as-pro-version" placeholder="<?php esc_attr_e('OGV', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('OGV', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <button class="as-video-upload as-slide-ogv-source as-pro-version"><?php _e('Set Video','avartan-slider-lite'); ?></button>
                        <span class="option-desc"><?php _e('Example', 'avartan-slider-lite'); ?>: http://media.w3.org/2010/05/sintel/trailer.ogv</span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Poster Image','avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input type="text" readonly="readonly" value="<?php echo esc_attr($bgHPSrc); ?>" class="as-slide-html5-poster-url as-pro-version" placeholder="<?php esc_attr_e('Poster Image', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Poster Image', 'avartan-slider-lite'); ?>"/>
                        </div>
                        <button data-source="<?php echo esc_attr($bgHPSrc); ?>" data-alt="<?php echo esc_attr($bgHPAlt); ?>" data-title="<?php echo esc_attr($bgHPTitle); ?>" class="as-video-poster as-pro-version" title="<?php esc_attr_e('Set Poster', 'avartan-slider-lite'); ?>"><?php _e('Set Poster', 'avartan-slider-lite'); ?></button>
                        <span class="option-desc"><?php _e('Example', 'avartan-slider-lite'); ?>: http://media.w3.org/2010/05/sintel/poster.png</span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Force Cover', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <div class="as-toggle-indicator as-slide-htmlvideo-forcecover as-pro-version" title="<?php esc_attr_e('Force Cover', 'avartan-slider-lite'); ?>">
                                <?php
                                $htmlvideo_forcecover = 0;
                                if ($bgHFC) {
                                    $htmlvideo_forcecover = $bgHFC;
                                }
                                foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                    $checked = '';
                                    if ($htmlvideo_forcecover == $key) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <input type="radio" name="htmlvideo_forcecover" class="htmlvideo_forcecover as-pro-version" id="htmlvideo_forcecover_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                    <label for="htmlvideo_forcecover_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set Yes then video display forcefully in fullwidth.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Aspect Ratio', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-version">
                            <select class="as-slide-htmlvideo-aspectratio as-pro-version">
                                <?php
                                foreach ($video_aspect_ratio as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($bgHRatio == $key) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <span class="option-desc"><?php _e('Select aspect ratio of video.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group">
                        <label><?php _e('Vimeo Settings', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Loop Video', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-html5-loop as-pro-version" title="<?php esc_attr_e('Youtube Loop', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_html5_loop = 0;
                                    if ($bgHSLoop) {
                                        $slide_html5_loop = $bgHSLoop;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_html5_loop == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_html5_loop" class="as-slide-video-loop as-pro-version" id="slide_html5_loop_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_html5_loop_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Next Slide on End', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-html5-next-slide as-pro-version" title="<?php esc_attr_e('Next Slide on End', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_html5_next_slide = 0;
                                    if ($bgHSNS) {
                                        $slide_html5_next_slide = $bgHSNS;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_html5_next_slide == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_html5_next_slide" class="as-slide-next-slide-on-video-end as-pro-version" id="slide_html5_next_slide_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_html5_next_slide_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Force Rewind', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-html5-force-rewind as-pro-version" title="<?php esc_attr_e('Force Rewind', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_html5_force_rewind = 0;
                                    if ($bgHSFR) {
                                        $slide_html5_force_rewind = $bgHSFR;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_html5_force_rewind == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_html5_force_rewind" class="as-slide-video-force-rewind as-pro-version" id="slide_html5_force_rewind_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_html5_force_rewind_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="video-setting-wrap">
                                <label class="video-setting-label">
                                <?php _e('Mute', 'avartan-slider-lite'); ?>
                                </label>
                                <div class="as-toggle-indicator as-slide-video-html5-force-rewind as-pro-version" title="<?php esc_attr_e('Force Rewind', 'avartan-slider-lite'); ?>">
                                <?php
                                    $slide_html5_video_mute = 0;
                                    if ($bgHSMute) {
                                        $slide_html5_video_mute = $bgHSMute;
                                    }
                                    foreach ($slide_select_options['background']['boolean'] as $key => $value) {
                                        $checked = '';
                                        if ($slide_html5_video_mute == $key) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="slide_html5_video_mute" class="as-slide-video-mute as-pro-version" id="slide_html5_video_mute_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>/>
                                        <label for="slide_html5_video_mute_<?php echo esc_attr($key); ?>"><?php echo esc_attr($value[0]); ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <span class="option-desc"><?php _e('Set video settings.', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
            </div>
            <div id='as_tab_parallax' class="as-tab-info">
                <div class="as-form-control-group">
                    <?php
                        echo '<span style="display:block;color: #ff0000;">';
                        _e('Parallax effect is disable from Slider Setting, parallax will be ignored.','avartan-slider-lite');
                        echo '</span>';
                    ?>
                </div>
            </div>
            <div id='as_tab_kenburns' class="as-tab-info">
                <div class="as-form-control-group">
                    <label><?php _e('Ken Burns', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <div class="as-toggle-indicator as-slide-link-toggle">
                            <input type="radio" <?php checked($enable_kenburns, 'on'); ?> id="as_slide_kenburns_1" value="on" class="as-slide-kenburns" name="as_slide_kenburns">
                            <label for="as_slide_kenburns_1"><?php _e('On', 'avartan-slider-lite'); ?></label>
                            <input type="radio" <?php checked($enable_kenburns, 'off'); ?> id="as_slide_kenburns_0" value="off" class="as-slide-kenburns" name="as_slide_kenburns">
                            <label for="as_slide_kenburns_0"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Enable/Disable ken burns/pan zoom effect.', 'avartan-slider-lite'); ?></span>
                </div>
                <div class="as-form-control-group as-hide-ken-burns">
                    <label><?php _e('Scale in', 'avartan-slider-lite'); ?> %</label>
                    <div class="as-form-control as-pro-version">
                        <label style="width:40px"><?php _e('From', 'avartan-slider-lite'); ?></label>
                        <input type="text" readonly="readonly" value="<?php echo esc_attr($kb_scale_start); ?>" name="as_slide_scale_start" class="as-slide-scale-start" onkeypress="return avsIsNumberKey(event);" style="min-width: 60px;width:60px;margin-right: 15px;">
                        <label style="width:20px"><?php _e('To', 'avartan-slider-lite'); ?></label>
                        <input type="text" readonly="readonly" value="<?php echo esc_attr($kb_scale_end); ?>" name="as_slide_scale_end" class="as-slide-scale-end" onkeypress="return avsIsNumberKey(event);" style="width:60px;min-width: 60px;">
                    </div>
                </div>
                <div class="as-form-control-group as-hide-ken-burns">
                    <label><?php _e('Horizontal Offsets', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control as-pro-version">
                        <label style="width:40px"><?php _e('From', 'avartan-slider-lite'); ?></label>
                        <input type="text" readonly="readonly" value="<?php echo esc_attr($kb_horizontal_from); ?>" name="as_slide_horizontal_offset_from" class="as-slide-horizontal-offset-from" onkeypress="return avsIsNumberKey(event);" style="min-width: 60px;width:60px;margin-right: 15px;">
                        <label style="width:20px"><?php _e('To', 'avartan-slider-lite'); ?></label>
                        <input type="text" readonly="readonly" value="<?php echo esc_attr($kb_horizontal_to); ?>" name="as_slide_horizontal_offset_to" class="as-slide-horizontal-offset-to" onkeypress="return avsIsNumberKey(event);" style="width:60px;min-width: 60px;">
                    </div>
                </div>
                <div class="as-form-control-group as-hide-ken-burns">
                    <label><?php _e('Vertical Offsets', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control as-pro-version">
                        <label style="width:40px"><?php _e('From', 'avartan-slider-lite'); ?></label>
                        <input type="text" readonly="readonly" value="<?php echo esc_attr($kb_vertical_from); ?>" name="as_slide_vertical_offset_from" class="as-slide-vertical-offset-from" onkeypress="return avsIsNumberKey(event);" style="min-width: 60px;width:60px;margin-right: 15px;">
                        <label style="width:20px"><?php _e('To', 'avartan-slider-lite'); ?></label>
                        <input type="text" readonly="readonly" value="<?php echo esc_attr($kb_vertical_to); ?>" name="as_slide_vertical_offset_to" class="as-slide-vertical-offset-to" onkeypress="return avsIsNumberKey(event);" style="width:60px;min-width: 60px;">
                    </div>
                </div>
                <div class="as-form-control-group as-hide-ken-burns">
                    <label><?php _e('Rotation', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control as-pro-version">
                        <label style="width:40px"><?php _e('From', 'avartan-slider-lite'); ?></label>
                        <input type="text" value="<?php echo esc_attr($kb_rotation_start); ?>" name="as_slide_rotation_start" class="as-slide-rotation-start" onkeypress="return avsIsNumberKey(event);" style="min-width: 60px;width:60px;margin-right: 15px;">
                        <label style="width:20px"><?php _e('To', 'avartan-slider-lite'); ?></label>
                        <input type="text" value="<?php echo esc_attr($kb_rotation_end); ?>" name="as_slide_rotation_end" class="as-slide-rotation-end" onkeypress="return avsIsNumberKey(event);" style="width:60px;min-width: 60px;">
                    </div>
                </div>
                <div class="as-form-control-group as-hide-ken-burns">
                    <label><?php _e('Easing', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <select class="as-slide-kenburn-easing">
                            <?php
                            $kb_easing_effect = $animations;
                            unset($kb_easing_effect['default']);
                            foreach ($kb_easing_effect as $key => $value) {
                                echo '<option class="as-pro-version" value="' . $key . '"';
                                if ( $kb_easing == $key) {
                                    echo ' selected';
                                }
                                echo '>' . $value[0] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="as-form-control-group as-hide-ken-burns">
                    <label><?php _e('Duration', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <input class="as-slide-kenburn-easing-time as-text-number as-pro-version" type="text" readonly="readonly" value="<?php echo esc_attr($kb_easing_time); ?>" onkeypress="return avsIsNumberKey(event);" min="0">
                        <span class="lbl_px">ms</span>
                    </div>
                </div>
            </div>
            <div id='as_tab_overlay' class="as-tab-info">
                <div class="as-form-control-group">
                    <label><?php _e('Color Overlay Type', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control">
                        <select class="as-slide-overlay-type as-pro-version">
                            <?php
                            foreach ($slide_select_options['background']['bgoverlay_type'] as $key => $value) {
                                echo '<option value="' . $key . '"';
                                if ($bgoverlay_type == $key) {
                                    echo ' selected="selected"';
                                }
                                echo '>' . $value[0] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <span class="option-desc"><?php _e('Set color overlay on background image or color.', 'avartan-slider-lite'); ?><br><?php _e('Default : transparent', 'avartan-slider-lite'); ?></span>
                </div>
                <div class="as-form-control-group as-overlay-solidcolor" <?php echo $bgoverlay_color; ?>>
                    <label><?php _e('Select Color', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control as-pro-color">
                        <input type="text" readonly="readonly" value="<?php echo esc_attr($bgcolor_overlay); ?>" class="as-slide-overlaySolidColor as-color-picker" data-alpha="true" data-custom-width="0" />
                    </div>
                    <span class="option-desc"><?php _e('Select overlay color.', 'avartan-slider-lite'); ?></span>
                </div>
                <div class="as-overlay-gradientColor" <?php echo $bgoverlay_gd; ?>>
                    <?php
                    $bgcolorOArr = explode('<==>', $bggradient_overlay_cr);
                    $detOColor1 = (count($bgcolorOArr) > 0 && isset($bgcolorOArr[0]) ? $bgcolorOArr[0] : '');
                    $detOColor2 = (count($bgcolorOArr) > 0 && isset($bgcolorOArr[1]) ? $bgcolorOArr[1] : '');
                    ?>
                    <div class="as-form-control-group">
                        <label><?php _e('Gradient Color Overlay', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control as-pro-color">
                            <input type="text" readonly="readonly" value="<?php echo esc_attr($detOColor1); ?>" class="as-slide-gradientOverlay as-color-picker" data-alpha="true" data-custom-width="0" />
                        </div>
                        <span class="option-desc"><?php _e('Select gradient color overlay.', 'avartan-slider-lite'); ?></span>
                    </div>
                    <div class="as-form-control-group as-gradient-block">
                        <label>&nbsp;</label>
                        <div class="as-form-control as-pro-color">
                            <input type="text" value="<?php echo esc_attr($detOColor2); ?>" class="as-slide-gradientOverlay as-color-picker" data-alpha="true" data-custom-width="0" />
                            <button class="as-add-overlayGradient as-pro-version"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <?php
                    if (isset($bgcolorOArr) && count($bgcolorOArr) > 2) {
                        for ($i = 2; $i < count($bgcolorOArr); $i++) {
                            ?>
                            <div class="as-form-control-group as-gradient-block">
                                <label>&nbsp;</label>
                                <div class="as-form-control as-pro-color">
                                    <input type="text" value="<?php echo esc_attr($bgcolorOArr[$i]); ?>" class="as-slide-gradientOverlay as-color-picker" data-alpha="true" data-custom-width="0" />
                                    <button class="as-remove-overlayGradient"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="as-form-control-group">
                        <label><?php _e('Gradient Overlay Angle', 'avartan-slider-lite'); ?></label>
                        <div class="as-form-control">
                            <input class="as-slide-gradientOverlayAngle as-text-number as-pro-version" type="text" readonly="readonly" onkeypress="return avsIsNumberKey(event);" value="<?php echo esc_attr($bggradient_overlay_angle); ?>" min="0" />
                            <span class="lbl_px">deg</span>
                        </div>
                        <span class="option-desc"><?php _e('Set gradient overlay angle.', 'avartan-slider-lite'); ?></span>
                    </div>
                </div>
                <div class="as-form-control-group">
                    <label><?php _e('Patterns Overlay', 'avartan-slider-lite'); ?></label>
                    <div class="as-form-control as-pattern-block">
                        <a href="javascript:void(0);" class="as-slide-overlayPattern as-pattern-picker" title="<?php esc_attr_e('Select Pattern', 'avartan-slider-lite'); ?>">
                            <span class="<?php echo $bgpattern_overlay_origin; ?>"></span>
                        </a>
                        <div class="as-pattern-collection">
                            <?php
                            foreach ($slide_select_options['background']['pattern'] as $key => $value) {
                                $pattern_active = '';
                                if ($bgpattern_overlay_origin == $value) {
                                    $pattern_active = 'as-active';
                                }
                                echo '<span data-class="' . $value . '" class="as-pro-version ' . $value . ' ' . $pattern_active . '"></span>';
                            }
                            ?>
                        </div>
                    </div>
                    <span class="option-desc"><?php _e('Set Pattern overlay on background image or color.', 'avartan-slider-lite'); ?><br><?php _e('Default : none', 'avartan-slider-lite'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>