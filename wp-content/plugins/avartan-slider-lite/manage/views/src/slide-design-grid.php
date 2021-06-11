<?php
if (!defined('ABSPATH'))
    exit();
$bgstyle = '';
$bgoverlaystyle = '';
$bgclass = '';
$bgpattern_overlay = '';

$bg_options = AvartanSliderLiteFunctions::getVal($params_slide,'background',array());
$bgtype = AvartanSliderLiteFunctions::getVal($bg_options,'type','transparent');
$slider_type = 'standard-slider';

switch ($bg_type) {
    case 'solid_color' :
        //Get Background Solid Color
        $bgcolor = AvartanSliderLiteFunctions::getVal($bg_options,'bgcolor','transparent');
        $bgstyle .= 'background:' . $bgcolor . ';';
        break;

    case 'gradient_color' :
        //Get Background Gradient Color
        $bg_gradient = AvartanSliderLiteFunctions::getVal($bg_options,'bggradient',array());
        $bg_color = AvartanSliderLiteFunctions::getVal($bg_gradient,'color_range','transparent');
        $bg_angel = AvartanSliderLiteFunctions::getVal($bg_gradient,'angle',0);
        $bgcolorArr = explode('<==>', $bg_color);
        $detColor1 = (count($bgcolorArr) > 0 && isset($bgcolorArr[0]) ? $bgcolorArr[0] : 'rgba(0,0,0,0)');

        $bgstyle .= 'background:'.$detColor1.';';
        if(count($bgcolorArr) > 1) {
            $bgstyle .= 'background:-webkit-linear-gradient('.$bg_angel.'deg,'.implode(',', $bgcolorArr).');';
            $bgstyle .= 'background:-o-linear-gradient('.$bg_angel.'deg,'.implode(',', $bgcolorArr).');';
            $bgstyle .= 'background:-moz-linear-gradient('.$bg_angel.'deg,'.implode(',', $bgcolorArr).');';
            $bgstyle .= 'background:linear-gradient('.$bg_angel.'deg,'.implode(',', $bgcolorArr).');';
        }
        break;

    case 'featured_image' :     //Get Pst feature image
        $bgstyle .= 'background-color:transparent;';
        $bgstyle .= 'background-image:none;';
        $bgstyle .= 'background-position: center center;';
        $bgstyle .= 'background-repeat: no-repeat;';
        $bgstyle .= 'background-size: cover;';
        break;

    case 'image' :              //Get Background Image
        $bgstyle .= 'background-color:transparent;';

        $bg_img = AvartanSliderLiteFunctions::getVal($bg_options,'image',array());
        $bgimage_src = AvartanSliderLiteFunctions::getVal($bg_img,'source','');
        $bgimage_pos = AvartanSliderLiteFunctions::getVal($bg_img,'position','center center');
        $bgimage_posx = AvartanSliderLiteFunctions::getVal($bg_img,'position_x',0);
        $bgimage_posy = AvartanSliderLiteFunctions::getVal($bg_img,'position_y',0);
        $bgimage_repeat = AvartanSliderLiteFunctions::getVal($bg_img,'repeat','no-repeat');
        $bgimage_size = AvartanSliderLiteFunctions::getVal($bg_img,'size','cover');
        $bgimage_sizex = AvartanSliderLiteFunctions::getVal($bg_img,'size_x',100);
        $bgimage_sizey = AvartanSliderLiteFunctions::getVal($bg_img,'size_y',100);

        if ($bgimage_src != '') {
            $bgstyle .= 'background-image:url(' . $bgimage_src . ');';

            if ($bgimage_pos == 'percentage') {
                $bgimage_pos = $bgimage_posx . '% ' . $bgimage_posy . '%';
            }
            $bgstyle .= 'background-position:' . $bgimage_pos . ';';

            $bgstyle .= 'background-repeat:' . $bgimage_repeat . ';';

            $bgimage_size = ((!empty($bgImgOptions) && isset($bgImgOptions->size)) ? $bgImgOptions->size : 'cover');
            if ($bgimage_size == 'percentage') {
                $bgimage_size = $bgimage_sizex . '% ' . $bgimage_sizey . '%';
            }
            $bgstyle .= 'background-size:' . $bgimage_size . ';';
        }
        break;

    case 'youtube_video' :
        //Get Background Youtube Video
        $bgYtOptions = AvartanSliderLiteFunctions::getVal($bg_options,'youtube',array());
        $bgYSrc = AvartanSliderLiteFunctions::getVal($bgYtOptions,'source','');

        $bgYPoster = AvartanSliderLiteFunctions::getVal($bgYtOptions,'poster',array());
        $bgYPSrc = AvartanSliderLiteFunctions::getVal($bgYPoster,'source','');

        if ($bgYSrc != '') {
            $bgclass = ' as-slide-videobg';
        }

        $bgstyle .= 'background-color:transparent;';

        if ($bgYPSrc != '') {
            $bgstyle .= 'background-image:url(' . $bgYPSrc . ');';
            $bgstyle .= 'background-position:center center;';
            $bgstyle .= 'background-repeat:no-repeat;';
            $bgstyle .= 'background-size:cover;';
        }
        break;

    case 'vimeo_video' :
        //Get Background Youtube Video
        $bgViOptions = AvartanSliderLiteFunctions::getVal($bg_options,'vimeo',array());
        $bgVSrc = AvartanSliderLiteFunctions::getVal($bgViOptions,'source','');

        $bgVPoster = AvartanSliderLiteFunctions::getVal($bgViOptions,'poster',array());
        $bgVPSrc = AvartanSliderLiteFunctions::getVal($bgVPoster,'source','');
        if ($bgVSrc != '') {
            $bgclass = ' as-slide-videobg';
        }
        $bgstyle .= 'background-color:transparent;';

        if ($bgVPSrc != '') {
            $bgstyle .= 'background-image:url(' . $bgVPSrc . ');';
            $bgstyle .= 'background-position:center center;';
            $bgstyle .= 'background-repeat:no-repeat;';
            $bgstyle .= 'background-size:cover;';
        }
        break;

    case 'html5_video' :
        //Get Background Youtube Video
        $bgHtOptions = AvartanSliderLiteFunctions::getVal($bg_options,'html5',array());
        $bgHMp4 = AvartanSliderLiteFunctions::getVal($bgHtOptions,'mp4','');
        $bgHWebm = AvartanSliderLiteFunctions::getVal($bgHtOptions,'webm','');
        $bgHOgv = AvartanSliderLiteFunctions::getVal($bgHtOptions,'ogv','');

        $bgHPoster = AvartanSliderLiteFunctions::getVal($bgHtOptions,'poster',array());
        $bgHPSrc = AvartanSliderLiteFunctions::getVal($bgHPoster,'source','');

        if ($bgHMp4 != '' || $bgHWebm != '' || $bgHOgv != '') {
            $bgclass = ' as-slide-videobg';
        }
        $bgstyle .= 'background-color:transparent;';

        if ($bgHPSrc != '') {
            $bgstyle .= 'background-image:url(' . $bgHPSrc . ');';
            $bgstyle .= 'background-position:center center;';
            $bgstyle .= 'background-repeat:no-repeat;';
            $bgstyle .= 'background-size:cover;';
        }
        break;
}
//Custom CSS
$slide_custom_css = AvartanSliderLiteFunctions::getVal($params_slide,'custom_css','');
$remove_n = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), "<br/>", $slide_custom_css);
$breaks = array("<br />", "<br>", "<br/>");
$custom_css = str_ireplace($breaks, "\r\n", $remove_n);
$bgstyle .= $custom_css;

//Overlay
$bg_overlay = AvartanSliderLiteFunctions::getVal($params_slide,'overlay',array());

$bgcolor_overlay_opt = AvartanSliderLiteFunctions::getVal($bg_overlay,'color',array());
$bgoverlay_type = AvartanSliderLiteFunctions::getVal($bgcolor_overlay_opt,'type','solid_color');

switch ($bgoverlay_type) {
    case 'solid_color' :
        //Get Background Solid Color
        $bgcolor = AvartanSliderLiteFunctions::getVal($bgcolor_overlay_opt,'bgcolor','transparent');
        $bgoverlaystyle .= 'background-color:'.$bgcolor.';';
        break;

    case 'gradient_color' :
        //Get Background Gradient Color
        $bgoverlay_gradient = AvartanSliderLiteFunctions::getVal($bgcolor_overlay_opt,'bggradient',array());
        $bggradient_overlay_cr = AvartanSliderLiteFunctions::getVal($bgoverlay_gradient,'color_range','');
        $bggradient_overlay_angle = AvartanSliderLiteFunctions::getVal($bgoverlay_gradient,'angle',0);

        $bgcolorArr = explode('<==>', $bggradient_overlay_cr);
        $detColor1 = (count($bgcolorArr) > 0 && isset($bgcolorArr[0]) ? $bgcolorArr[0] : 'rgba(0,0,0,0)');

        $bgoverlaystyle .= 'background:'.$detColor1.';';
        if(count($bgcolorArr) > 1) {
            $bgoverlaystyle .= 'background:-webkit-linear-gradient('.$bggradient_overlay_angle.'deg,'.implode(',', $bgcolorArr).');';
            $bgoverlaystyle .= 'background:-o-linear-gradient('.$bggradient_overlay_angle.'deg,'.implode(',', $bgcolorArr).');';
            $bgoverlaystyle .= 'background:-moz-linear-gradient('.$bggradient_overlay_angle.'deg,'.implode(',', $bgcolorArr).');';
            $bgoverlaystyle .= 'background:linear-gradient('.$bggradient_overlay_angle.'deg,'.implode(',', $bgcolorArr).');';
        }
        break;
}

//Pattern Overlay
$bgpattern_overlay_origin = AvartanSliderLiteFunctions::getVal($bg_overlay,'pattern','pattern0');
$bgpattern_overlay = 'as-pattern ' . $bgpattern_overlay_origin;

//Get google font family
$font_family = AvartanSliderLiteFunctions::getArrFontFamilies();
?>

<!--Slide Editor section-->
<div class="as-panel as-panel-editor">
    <div class="as-panel-body">
        <div class="as-editor-header">
            <div class="as-editor-tabs">
                <ul>
                    <li><a href="#as_editor_design"><span class="fas fa-pencil-alt"></span><?php _e('Design', 'avartan-slider-lite'); ?></a></li>
                    <li><a href="#as_editor_animation"><span class="far fa-edit"></span><?php _e('Animation', 'avartan-slider-lite'); ?></a></li>
                    <li><a href="#as_editor_attributesLink"><span class="fas fa-wrench"></span><?php _e('Attributes & Link', 'avartan-slider-lite'); ?></a></li>
                    <li><a href="#as_editor_advanced"><span class="fas fa-link"></span><?php _e('Advanced', 'avartan-slider-lite'); ?></a></li>
                    <li><a href="#as_editor_parallax"><span class="fas fa-paragraph"></span><?php _e('Parallax / 3D', 'avartan-slider-lite'); ?></a></li>
                </ul>
                <div class="as-editor-tabs-content">
                    <!--Design Editor Settings-->
                    <div class="as-tab-info" id="as_editor_design">
                        <div class="as-editor-design-block as-editor-form-inline">
                            <div class="as-editor-design-row as-image-layer-hide as-video-layer-hide">
                                <div class="as-form-control-group">
                                    <div class="as-form-control as-pro-version">
                                        <select class="as-slide-font-family" title="<?php esc_attr_e('Font Family', 'avartan-slider-lite'); ?>" data-class="as-font-family">
                                            <?php
                                            $old_version = '';
                                            $cnt = 0;
                                            foreach($font_family as $key => $value) {
                                                if($value['version'] != $old_version) {
                                                    if($cnt > 0) {
                                                        echo '</optgroup>';
                                                    }
                                                    echo '<optgroup label="' . $value['version'] . '">';
                                                    $old_version = $value['version'];
                                                }
                                                echo "<option value='" . $value['label'] . "'";
                                                if($value['status']) {
                                                    echo ' selected="selected"';
                                                }
                                                echo ">" . $value['label'] . "</option>";
                                                $cnt++;
                                            }
                                            if($cnt == count($font_family)) {
                                                echo '</optgroup>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-font-size-icon" title="<?php esc_attr_e('Font Size', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" min="0" step="1" value="20" class="as-slide-font-size as-text-number" title="<?php esc_attr_e('Font Size', 'avartan-slider-lite'); ?>" onkeypress="return avsIsNumberKey(event);" style="width: 68px;" /><span class="lbl_px">px</span>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-line-height-icon" title="<?php esc_attr_e('Line Height', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" min="0" step="1" value="16" readonly="readonly" class="as-slide-line-height as-text-number as-pro-version" title="<?php esc_attr_e('Line Height', 'avartan-slider-lite'); ?>" onkeypress="return avsIsNumberKey(event);" style="width: 68px;" /><span class="lbl_px">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row as-image-layer-hide as-video-layer-hide">
                                <div class="as-form-control-group">
                                    <div class="as-form-control as-pro-version">
                                        <select class="as-editor-select as-font-weight" title="<?php esc_attr_e('Font Weight', 'avartan-slider-lite'); ?>" data-class="as-font-weight">
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="300">300</option>
                                            <option value="400">400</option>
                                            <option value="500">500</option>
                                            <option value="600">600</option>
                                            <option value="700">700</option>
                                            <option value="800">800</option>
                                            <option value="900">900</option>
                                            <option value="bold"><?php _e('Bold', 'avartan-slider-lite'); ?></option>
                                            <option value="normal" selected="selected"><?php _e('Normal', 'avartan-slider-lite'); ?></option>
                                        </select>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-checkbox-toggle as-font-italic">
                                            <input type="checkbox" title="<?php esc_attr_e('Font Italic', 'avartan-slider-lite'); ?>" name="as_font_italic" class="as-slide-font-italic"  />
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <select class="as-editor-select as-text-transform" title="<?php esc_attr_e('Font Transform', 'avartan-slider-lite'); ?>" data-class="as-text-transform">
                                            <option selected="selected" value="none"><?php _e('None', 'avartan-slider-lite'); ?></option>
                                            <option value="capitalize"><?php _e('Capitalize', 'avartan-slider-lite'); ?></option>
                                            <option value="uppercase"><?php _e('Uppercase', 'avartan-slider-lite'); ?></option>
                                            <option value="lowercase"><?php _e('Lowercase', 'avartan-slider-lite'); ?></option>
                                            <option value="full-width"><?php _e('Full Width', 'avartan-slider-lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-letter-spacing-icon" title="<?php esc_attr_e('Letter Spacing', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" min="0" step="1" value="1" readonly="readonly" class="as-slide-letter-spacing as-text-number as-pro-version" title="<?php esc_attr_e('Letter Spacing', 'avartan-slider-lite'); ?>" onkeypress="return avsIsNumberKey(event);" style="width: 60px;" /><span class="lbl_px">px</span>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <div class="as-form-control as-pro-version">
                                        <select class="as-editor-select as-white-space" title="<?php esc_attr_e('White Space', 'avartan-slider-lite'); ?>" data-class="as-white-space">
                                            <option selected="selected" value="nowrap"><?php _e('nowrap', 'avartan-slider-lite'); ?></option>
                                            <option value="normal"><?php _e('Normal', 'avartan-slider-lite'); ?></option>
                                            <option value="pre"><?php _e('Pre', 'avartan-slider-lite'); ?></option>
                                            <option value="pre-line"><?php _e('Pre Line', 'avartan-slider-lite'); ?></option>
                                            <option value="pre-wrap"><?php _e('Pre Wrap', 'avartan-slider-lite'); ?></option>
                                            <option value="inherit"><?php _e('Inherit', 'avartan-slider-lite'); ?></option>
                                            <option value="initial"><?php _e('Initial', 'avartan-slider-lite'); ?></option>
                                            <option value="unset"><?php _e('Unset', 'avartan-slider-lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <div class="as-form-control as-pro-version">
                                        <select class="as-editor-select as-font-decoration" title="<?php esc_attr_e('Text Decoration', 'avartan-slider-lite'); ?>" data-class="as-font-decoration">
                                            <option value="none" selected="selected"><?php _e('None', 'avartan-slider-lite'); ?></option>
                                            <option value="underline"><?php _e('Underline', 'avartan-slider-lite'); ?></option>
                                            <option value="overline"><?php _e('Overline', 'avartan-slider-lite'); ?></option>
                                            <option value="line-through"><?php _e('Line Through', 'avartan-slider-lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group as-image-layer-hide as-video-layer-hide">
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-textAlign-btn as-text-align-left">
                                            <input type="radio" checked="" name="as_textAlign_btn" title="<?php esc_attr_e('Align Left', 'avartan-slider-lite'); ?>" class="as-slide-text-align" value="left"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-textAlign-btn as-text-align-center">
                                            <input type="radio" name="as_textAlign_btn" title="<?php esc_attr_e('Align Center', 'avartan-slider-lite'); ?>" class="as-slide-text-align" value="center"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-textAlign-btn as-text-align-right">
                                            <input type="radio" name="as_textAlign_btn" title="<?php esc_attr_e('Align Right', 'avartan-slider-lite'); ?>" class="as-slide-text-align" value="right"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-textAlign-btn as-text-align-justify">
                                            <input type="radio" name="as_textAlign_btn" title="<?php esc_attr_e('Align Justify', 'avartan-slider-lite'); ?>" class="as-slide-text-align" value="justify"/>
                                        </label>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <div class="as-form-control as-image-layer-hide as-video-layer-hide">
                                        <input type="text" value="#000000" class="as-font-color as-color-picker" data-alpha="true" data-custom-width="0" title="<?php esc_attr_e('Font Color', 'avartan-slider-lite'); ?>"/>
                                    </div>
                                    <div class="as-form-control as-image-layer-hide as-video-layer-hide">
                                        <input type="text" value="" class="as-background-color as-color-picker" data-alpha="true" data-custom-width="0" title="<?php esc_attr_e('Background Color', 'avartan-slider-lite'); ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="as-editor-design-block as-editor-form-inline">
                            <div class="as-editor-design-row as-border-function" >
                                <div class="as-form-control-group">
                                    <label class="as-border-icon" title="<?php esc_attr_e('Border Style', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-slide-border-width as-text-number as-pro-version" title="<?php esc_attr_e('Border Width', 'avartan-slider-lite'); ?>" style="width: 45px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <select class="as-slide-border-style as-editor-selectText" title="<?php esc_attr_e('Border Style', 'avartan-slider-lite'); ?>" data-class="as-editor-selectText">
                                            <option value="none" selected="selected"><?php _e('None', 'avartan-slider-lite'); ?></option>
                                            <option value="dotted"><?php _e('Dotted', 'avartan-slider-lite'); ?></option>
                                            <option value="dashed"><?php _e('Dashed', 'avartan-slider-lite'); ?></option>
                                            <option value="solid"><?php _e('Solid', 'avartan-slider-lite'); ?></option>
                                            <option value="double"><?php _e('Double', 'avartan-slider-lite'); ?></option>
                                            <option value="groove"><?php _e('Groove', 'avartan-slider-lite'); ?></option>
                                            <option value="ridge"><?php _e('Ridge', 'avartan-slider-lite'); ?></option>
                                            <option value="inset"><?php _e('Inset', 'avartan-slider-lite'); ?></option>
                                            <option value="outset"><?php _e('Outset', 'avartan-slider-lite'); ?></option>
                                        </select>
                                    </div>
                                    <div class="as-form-control as-pro-color">
                                        <input type="text" value="#000000" readonly="readonly" class="as-slide-borderColor as-color-picker" data-alpha="true" data-custom-width="0" title="<?php esc_attr_e('Border Color', 'avartan-slider-lite'); ?>"/>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-checkbox-toggle as-individual-border">
                                            <input type="checkbox" class="as-slide-individual-border" name="as_individual_border" title="<?php esc_attr_e('Individual Border', 'avartan-slider-lite'); ?>" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="as-individual-border-wrap ">
                                <div class="as-editor-design-row">
                                    <div class="as-form-control-group">
                                        <label class="as-border-right-icon"></label>
                                        <div class="as-form-control">
                                            <input type="text" value="0" readonly="readonly" class="as-slide-border-right-width as-pro-version" title="<?php esc_attr_e('Border Right Width', 'avartan-slider-lite'); ?>" style="width: 45px;"/><span class="lbl_px">px</span>
                                        </div>
                                        <div class="as-form-control as-pro-version">
                                            <select class="as-slide-border-right-style as-editor-selectText" title="<?php esc_attr_e('Border Right Style', 'avartan-slider-lite'); ?>" data-class="as-editor-selectText">
                                                <option value="none" selected="selected"><?php _e('None', 'avartan-slider-lite'); ?></option>
                                                <option value="dotted"><?php _e('Dotted', 'avartan-slider-lite'); ?></option>
                                                <option value="dashed"><?php _e('Dashed', 'avartan-slider-lite'); ?></option>
                                                <option value="solid"><?php _e('Solid', 'avartan-slider-lite'); ?></option>
                                                <option value="double"><?php _e('Double', 'avartan-slider-lite'); ?></option>
                                            </select>
                                        </div>
                                        <div class="as-form-control as-pro-color">
                                            <input type="text" value="#000000" readonly="readonly" class="as-slide-right-borderColor as-color-picker" data-alpha="true" data-custom-width="0" title="<?php esc_attr_e('Border Right Color', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="as-editor-design-row">
                                    <div class="as-form-control-group">
                                        <label class="as-border-bottom-icon"></label>
                                        <div class="as-form-control">
                                            <input type="text" value="0" readonly="readonly" class="as-slide-border-bottom-width as-pro-version" title="<?php esc_attr_e('Border Bottom Width', 'avartan-slider-lite'); ?>" style="width: 45px;"/><span class="lbl_px">px</span>
                                        </div>
                                        <div class="as-form-control as-pro-version">
                                            <select class="as-slide-border-bottom-style as-editor-selectText" title="<?php esc_attr_e('Border Bottom Style', 'avartan-slider-lite'); ?>" data-class="as-editor-selectText">
                                                <option value="none" selected="selected"><?php _e('None', 'avartan-slider-lite'); ?></option>
                                                <option value="dotted"><?php _e('Dotted', 'avartan-slider-lite'); ?></option>
                                                <option value="dashed"><?php _e('Dashed', 'avartan-slider-lite'); ?></option>
                                                <option value="solid"><?php _e('Solid', 'avartan-slider-lite'); ?></option>
                                                <option value="double"><?php _e('Double', 'avartan-slider-lite'); ?></option>
                                            </select>
                                        </div>
                                        <div class="as-form-control as-pro-color">
                                            <input type="text" value="#000000" readonly="readonly" class="as-slide-bottom-borderColor as-color-picker" data-alpha="true" data-custom-width="0" title="<?php esc_attr_e('Border Bottom Color', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="as-editor-design-row">
                                    <div class="as-form-control-group">
                                        <label class="as-border-left-icon"></label>
                                        <div class="as-form-control">
                                            <input type="text" value="0" readonly="readonly" class="as-slide-border-left-width as-pro-version" title="<?php esc_attr_e('Border Left Width', 'avartan-slider-lite'); ?>" style="width: 45px;"/><span class="lbl_px">px</span>
                                        </div>
                                        <div class="as-form-control as-pro-version">
                                            <select class="as-slide-border-left-style as-editor-selectText" title="<?php esc_attr_e('Border Left Style', 'avartan-slider-lite'); ?>" data-class="as-editor-selectText">
                                                <option value="none" selected="selected"><?php _e('None', 'avartan-slider-lite'); ?></option>
                                                <option value="dotted"><?php _e('Dotted', 'avartan-slider-lite'); ?></option>
                                                <option value="dashed"><?php _e('Dashed', 'avartan-slider-lite'); ?></option>
                                                <option value="solid"><?php _e('Solid', 'avartan-slider-lite'); ?></option>
                                                <option value="double"><?php _e('Double', 'avartan-slider-lite'); ?></option>
                                            </select>
                                        </div>
                                        <div class="as-form-control as-pro-color">
                                            <input type="text" readonly="readonly" value="#000000" readonly="readonly" class="as-slide-left-borderColor as-color-picker" data-alpha="true" data-custom-width="0" title="<?php esc_attr_e('Border Left Color', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <label class="as-border-radius-icon" title="<?php esc_attr_e('Border Radius', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-border-radius-top-left as-text-number as-pro-version" title="<?php esc_attr_e('Border Radius Top Left', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-border-radius-top-right as-text-number as-pro-version" title="<?php esc_attr_e('Border Radius Top Right', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-border-radius-bottom-right as-text-number as-pro-version" title="<?php esc_attr_e('Border Radius Bottom Right', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-border-radius-bottom-left as-text-number as-pro-version" title="<?php esc_attr_e('Border Radius Bottom Left', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <label class="as-padding-icon" title="<?php esc_attr_e('Padding', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-slide-top-padding as-text-number as-pro-version" title="<?php esc_attr_e('Top Padding', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-slide-right-padding as-text-number as-pro-version" title="<?php esc_attr_e('Right Padding', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-slide-bottom-padding as-text-number as-pro-version" title="<?php esc_attr_e('Bottom Padding', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-slide-left-padding as-text-number as-pro-version" title="<?php esc_attr_e('Left Padding', 'avartan-slider-lite'); ?>" style="width: 58px;"/><span class="lbl_px">px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="as-editor-design-block as-editor-form-inline">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <label class="as-box-shadow-icon" title="<?php esc_attr_e('Element Offset', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-box-shadow-hoffset as-text-number as-pro-version" title="<?php esc_attr_e('Horizontal Offset', 'avartan-slider-lite'); ?>" style="width: 50px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-box-shadow-voffset as-text-number as-pro-version" title="<?php esc_attr_e('Verticle Offset', 'avartan-slider-lite'); ?>" style="width: 50px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-box-shadow-blur as-text-number as-pro-version" title="<?php esc_attr_e('Blur', 'avartan-slider-lite'); ?>" style="width: 50px;"/><span class="lbl_px">px</span>
                                    </div>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-box-shadow-spread as-text-number as-pro-version" title="<?php esc_attr_e('spread', 'avartan-slider-lite'); ?>" style="width: 50px;"/><span class="lbl_px">px</span>
                                    </div>
                                </div>
                                <div class="as-form-control-group as-pro-color">
                                    <input type="text" value="#000000" readonly="readonly" class="as-box-shadow-color as-color-picker" data-alpha="true" data-custom-width="0" title="<?php esc_attr_e('Box Shadow Color', 'avartan-slider-lite'); ?>"/>
                                </div>

                                <div class="as-form-control-group as-pro-version">
                                    <select class="as-box-shadow-type as-editor-selectText" title="<?php esc_attr_e('Box Shadow Type', 'avartan-slider-lite'); ?>" data-class="as-editor-boxShadowType">
                                        <option value="outset" selected="selected"><?php _e('Outset', 'avartan-slider-lite'); ?></option>
                                        <option value="inset"><?php _e('Inset', 'avartan-slider-lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <label class="as-position-x-icon" title="<?php esc_attr_e('X Position', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0" class="as-slide-x-position as-text-number" title="<?php esc_attr_e('X Position', 'avartan-slider-lite'); ?>" onkeypress="return avsIsNumberKey(event);" style="width: 50px;"/><span class="lbl_px">px</span>
                                        <input type="hidden" value="0" class="as-slide-xaix" />
                                        <input type="hidden" value="0" class="as-layer-rotate-angle" />
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-position-y-icon" title="<?php esc_attr_e('Y Position', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0" class="as-slide-y-position as-text-number" title="<?php esc_attr_e('Y Position', 'avartan-slider-lite'); ?>" onkeypress="return avsIsNumberKey(event);" style="width: 50px;"/><span class="lbl_px">px</span>
                                        <input type="hidden" value="0" class="as-slide-yaix" />
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-layer-width-icon" title="<?php esc_attr_e('Layer Width', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0"  readonly="readonly"class="as-video-layer-show as-slide-layer-width as-text-number as-pro-version" title="<?php esc_attr_e('Layer Width', 'avartan-slider-lite'); ?>" onkeypress="return avsIsNumberKey(event);" style="width: 50px;"/><span class="lbl_px">px</span>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-layer-height-icon" title="<?php esc_attr_e('Layer Height', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control">
                                        <input type="text" value="0" readonly="readonly" class="as-video-layer-show as-slide-layer-height as-text-number as-pro-version" title="<?php esc_attr_e('Layer Height', 'avartan-slider-lite'); ?>" onkeypress="return avsIsNumberKey(event);" style="width: 50px;"/><span class="lbl_px">px</span>
                                    </div>
                                </div>
                                <div class="as-form-control-group as-video-layer-hide">
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-checkbox-toggle as-width-height-btn as-full-width">
                                            <input type="checkbox" name="as_full_width_btn" title="<?php esc_attr_e('Full Width', 'avartan-slider-lite'); ?>" value="full_width" class="as-slide-elememt-full-width" />
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-checkbox-toggle as-width-height-btn as-full-height">
                                            <input type="checkbox" name="as_full_height_btn" title="<?php esc_attr_e('Full Height', 'avartan-slider-lite'); ?>" value="full_height" class="as-slide-elememt-full-height" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group as-video-layer-hide">
                                    <label class="as-layer-behavior-icon" title="<?php esc_attr_e('Layer Behavior', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control as-pro-version">
                                        <select class="as-slide-layer-behavior as-editor-selectText" title="<?php esc_attr_e('Layer Behavior', 'avartan-slider-lite'); ?>" data-class="as-editor-layer-behavior">
                                            <option value="grid" selected="selected"><?php _e('Grid', 'avartan-slider-lite'); ?></option>
                                            <option value="slide"><?php _e('Slide', 'avartan-slider-lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-layer-hor-align-icon" title="<?php esc_attr_e('Align Horizontal', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-layerAlign-btn as-layer-align-left as-active">
                                            <input type="radio" checked="" name="as_layerAlign_btn" value="left" class="as-element-layer-alignment" title="<?php esc_attr_e('Align Left', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-layerAlign-btn as-layer-align-center">
                                            <input type="radio" name="as_layerAlign_btn" value="center" class="as-element-layer-alignment" title="<?php esc_attr_e('Align Center', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-layerAlign-btn as-layer-align-right">
                                            <input type="radio" name="as_layerAlign_btn" value="right" class="as-element-layer-alignment" title="<?php esc_attr_e('Align Right', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                </div>
                                <div class="as-form-control-group">
                                    <label class="as-layer-ver-align-icon" title="<?php esc_attr_e('Align Verticle', 'avartan-slider-lite'); ?>"></label>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-layerVerticleAlign-btn as-layer-align-top as-active">
                                            <input type="radio" checked="" name="as_layer_verticle_Align_btn" value="top" class="as-element-verticle-alignment" title="<?php esc_attr_e('Align Top', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-layerVerticleAlign-btn as-layer-align-middle">
                                            <input type="radio" name="as_layer_verticle_Align_btn" value="middle" class="as-element-verticle-alignment" title="<?php esc_attr_e('Align Middle', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-radio-toggle as-layerVerticleAlign-btn as-layer-align-bottom">
                                            <input type="radio" name="as_layer_verticle_Align_btn" value="bottom" class="as-element-verticle-alignment" title="<?php esc_attr_e('Align Bottom', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Animation Editor Settings-->
                    <div class="as-tab-info" id="as_editor_animation">
                        <div class="as-editor-animation-block as-editor-form-inline as-delayTime-animation">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('Delay', 'avartan-slider-lite'); ?></label>
                                        <input class="as-editor-animation-delay as-text-number" type="text" onkeypress="return avsIsNumberKey(event);" title="<?php esc_attr_e('Delay', 'avartan-slider-lite'); ?>" value="0" step="1" min="0" style="width: 70px;" /><span class="lbl_px">ms</span>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('Time', 'avartan-slider-lite'); ?></label>
                                        <input class="as-editor-animation-time as-text-number" type="text" onkeypress="return avsIsNumberKey(event);" title="<?php esc_attr_e('Time', 'avartan-slider-lite'); ?>" value="0" step="1" min="0" style="width: 70px;"/><span class="lbl_px">ms</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="as-editor-animation-block as-editor-form-inline as-inOut-animation">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('In Animation', 'avartan-slider-lite'); ?></label>
                                        <select class="as-editor-animation-in as-editor-selectText" title="<?php esc_attr_e('In Animation', 'avartan-slider-lite'); ?>" data-class="as-editor-animation-in-select">
                                            <?php
                                            if(is_array($slide_animation_array) && !empty($slide_animation_array)) {
                                                foreach ($slide_animation_array as $key => $value) {
                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('Out Animation', 'avartan-slider-lite'); ?></label>
                                        <select class="as-editor-animation-out as-editor-selectText" title="<?php esc_attr_e('Out Animation', 'avartan-slider-lite'); ?>" data-class="as-editor-animation-out-select">
                                            <?php
                                            if(is_array($slide_animation_array) && !empty($slide_animation_array)) {
                                                foreach ($slide_animation_array as $key => $value) {
                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="as-editor-animation-block as-editor-form-inline as-easyInOut-animation">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control as-pro-show">
                                        <label><?php _e('Ease In', 'avartan-slider-lite'); ?></label>
                                        <select class="as-editor-animation-ease-in as-editor-selectText" title="<?php esc_attr_e('Ease In', 'avartan-slider-lite'); ?>" data-class="as-editor-animation-ease-in-select">
                                            <?php
                                            if(is_array($animations) && !empty($animations)) {
                                                foreach ($animations as $key => $value) {
                                                    echo '<option class="as-pro-version" value="'.$key.'">'.$value[0].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control as-pro-version">
                                        <label><?php _e('Ease Out', 'avartan-slider-lite'); ?></label>
                                        <select class="as-editor-animation-ease-out as-editor-selectText" title="<?php esc_attr_e('Ease Out', 'avartan-slider-lite'); ?>" data-class="as-editor-animation-ease-out-select">
                                            <?php
                                            if(is_array($animations) && !empty($animations)) {
                                                foreach ($animations as $key => $value) {
                                                    echo '<option value="'.$key.'">'.$value[0].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="as-editor-animation-block as-editor-form-inline as-speed-animation">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('Start Speed', 'avartan-slider-lite'); ?></label>
                                        <input class="as-editor-animation-startspeed as-text-number" type="text" onkeypress="return avsIsNumberKey(event);" title="<?php esc_attr_e('Start Speed', 'avartan-slider-lite'); ?>" value="0" step="1" min="0" style="width: 70px;"/><span class="lbl_px">ms</span>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('End Speed', 'avartan-slider-lite'); ?></label>
                                        <input class="as-editor-animation-endspeed as-text-number" type="text" onkeypress="return avsIsNumberKey(event);" title="<?php esc_attr_e('End Speed', 'avartan-slider-lite'); ?>" value="0" step="1" min="0" style="width: 70px;"/><span class="lbl_px">ms</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Attributes & Link Editor Settings-->
                    <div class="as-tab-info" id="as_editor_attributesLink">
                        <div class="as-editor-attrLink-block as-editor-form-inline">
                            <div class="as-idClass-attribute">
                                <div class="as-editor-design-row">
                                    <div class="as-form-control-group">
                                        <div class="as-form-control">
                                            <label><?php _e('ID', 'avartan-slider-lite'); ?></label>
                                            <input type="text" value="" class="as-editor-attribute-id" placeholder="<?php esc_attr_e('ID', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('ID', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="as-editor-design-row">
                                    <div class="as-form-control-group">
                                        <div class="as-form-control">
                                            <label><?php _e('Classes', 'avartan-slider-lite'); ?></label>
                                            <input type="text" value="" class="as-editor-attribute-classes" placeholder="<?php esc_attr_e('Classes', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Classes', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="as-titleRelAlt-attribute">
                                <div class="as-editor-design-row">
                                    <div class="as-form-control-group">
                                        <div class="as-form-control">
                                            <label><?php _e('Title', 'avartan-slider-lite'); ?></label>
                                            <input type="text" value="" class="as-editor-attribute-title" placeholder="<?php esc_attr_e('Title', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Title', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="as-editor-design-row">
                                    <div class="as-form-control-group">
                                        <div class="as-form-control">
                                            <label><?php _e('Rel', 'avartan-slider-lite'); ?></label>
                                            <input type="text" value="" class="as-editor-attribute-rel" placeholder="<?php esc_attr_e('Rel', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Rel', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="as-editor-design-row as-editor-altText">
                                    <div class="as-form-control-group">
                                        <div class="as-form-control">
                                            <label><?php _e('Alt', 'avartan-slider-lite'); ?></label>
                                            <input type="text" value="" class="as-editor-attribute-alt" placeholder="<?php esc_attr_e('Alt', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Alt', 'avartan-slider-lite'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="as-editor-attrLink-block as-editor-form-inline as-link-attribute">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('Link Type', 'avartan-slider-lite'); ?></label>
                                        <select class="as-editor-linktype as-editor-selectText" title="<?php esc_attr_e('Link Type', 'avartan-slider-lite'); ?>" data-class="as-editor-linktype">
                                            <option class="as-pro-version" value="nolink"><?php _e('No Link', 'avartan-slider-lite'); ?></option>
                                            <option value="simpleLink"><?php _e('Simple Link', 'avartan-slider-lite'); ?></option>
                                            <option class="as-pro-version" disabled="" value="nextSlide"><?php _e('Next Slide', 'avartan-slider-lite'); ?></option>
                                            <option class="as-pro-version" disabled="" value="previousSlide"><?php _e('Previous Slide', 'avartan-slider-lite'); ?></option>
                                            <option class="as-pro-version" disabled="" value="scrollBelowSlider"><?php _e('Scroll Below Slider', 'avartan-slider-lite'); ?></option>
                                            <?php
                                            $slide_pos = 2;
                                            foreach ($slides as $slide_single) {
                                                $all_slide_data = maybe_unserialize($slide_single->getParams());
                                                if($id != $slide_single->getID()){
                                                ?>
                                                    <option class="as-pro-version" disabled="" value="<?php echo $slide_single->getID(); ?>"><?php echo '#'.$slide_pos. ' ' . __('Slide', 'avartan-slider-lite'); ?></option>
                                                <?php
                                                $slide_pos++;
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group as-editor-link-type as-editor-simplelink-type">
                                    <div class="as-form-control">
                                        <label><?php _e('Link URL', 'avartan-slider-lite'); ?></label>
                                        <input type="text" value="" class="as-editor-linkUrl" placeholder="<?php esc_attr_e('URL', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('URL', 'avartan-slider-lite'); ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <label><?php _e('Target', 'avartan-slider-lite'); ?></label>
                                        <div class="as-toggle-indicator as-linkTarget-toggle" title="Target">
                                            <input class="link_target_same_window" id="link_target_same_window_1" type="radio" value="same_tab" name="link_target">
                                            <label for="link_target_same_window_1"><?php _e('Same Tab', 'avartan-slider-lite'); ?></label>
                                            <input class="link_target_new_window" id="link_target_new_window_0" type="radio" checked="" value="new_tab" name="link_target">
                                            <label for="link_target_new_window_0"><?php _e('New Tab', 'avartan-slider-lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Advanced Editor Settings-->
                    <div class="as-tab-info" id="as_editor_advanced">
                        <div class="as-editor-advanced-block as-editor-form-inline">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <label><?php _e('Show On Device', 'avartan-slider-lite'); ?></label>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-checkbox-toggle as-showOnDevice-btn as-show-desktop as-device-active" title="<?php esc_attr_e('Desktop', 'avartan-slider-lite'); ?>">
                                            <input checked="checked" type="checkbox" value="show_on_desktop" class="show-on-desktop-view" title="<?php esc_attr_e('Desktop', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                    <div class="as-form-control as-pro-version">
                                        <label class="as-checkbox-toggle as-showOnDevice-btn as-show-mobile as-device-active" title="<?php esc_attr_e('Mobile', 'avartan-slider-lite'); ?>">
                                            <input checked="checked" type="checkbox" value="show_on_mobile" class="show-on-mobile-view" title="<?php esc_attr_e('Mobile', 'avartan-slider-lite'); ?>"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <label><?php _e('Hide Under Width', 'avartan-slider-lite'); ?></label>
                                    <div class="as-form-control as-pro-version">
                                        <div class="as-toggle-indicator as-hideUnderWidth-toggle" title="<?php esc_attr_e('Hide Under Width', 'avartan-slider-lite'); ?>">
                                            <input id="hide_under_width_on" type="radio" value="1" name="hide_under_width">
                                            <label for="hide_under_width_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                            <input id="hide_under_width_off" type="radio" checked="" value="0" name="hide_under_width">
                                            <label for="hide_under_width_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="as-editor-advanced-block as-editor-form-inline">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <label><?php _e('Advance CSS', 'avartan-slider-lite'); ?></label>
                                    <div class="as-form-control">
                                        <textarea class="as-advance-css" title="<?php esc_attr_e('Advance CSS', 'avartan-slider-lite'); ?>" placeholder="<?php esc_attr_e('Advance CSS', 'avartan-slider-lite'); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Parallax Editor Settings-->
                    <?php
                    //Parallax
                    $parallax_options = AvartanSliderLiteFunctions::getVal($slider_option,'parallax',array());
                    $pEnable = 0;
                    $TdEnable = 0;
                    $db_parallax_level = '';
                    $default_3d_depth = 40;
                    ?>
                    <div class="as-tab-info" id="as_editor_parallax">
                        <div class="as-editor-parallax-block as-editor-form-inline">
                            <div class="as-editor-design-row">
                                <div class="as-form-control-group">
                                    <div class="as-form-control">
                                        <?php
                                        if ($pEnable == 1 && $TdEnable != 1) {
                                            ?>
                                            <label><?php _e('Layer Parallax Depth'); ?></label>
                                            <select class="as-layer-parallax-level as-editor-selectText as-pro-version" data-class="as-layer-parallax-level-select">
                                                <option value=""><?php _e('No Parallax', 'avartan-slider-lite'); ?></option>
                                                <?php
                                                $parallax_depth = 0;
                                                for ($x = 1; $x <= 15; $x++) {
                                                    $parallax_depth = $parallax_depth + 5;
                                                    $db_name = 'slider_parallax_depth_' . $x;
                                                    $parallax_value = $parallax_depth;
                                                    ?>
                                                    <option value="<?php echo $x; ?>">
                                                        <?php echo $x . '-(' . $parallax_value . '%)'; ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        } else if ($pEnable == 1 && $TdEnable == 1) {
                                            ?>
                                            <label><?php _e('Layer 3D Depth', 'avartan-slider-lite'); ?></label>
                                            <select class="as-layer-parallax-level as-editor-selectText as-pro-version" data-class="as-layer-parallax-level-select">
                                                <option value=""><?php _e('Default 3D Depth', 'avartan-slider-lite'); ?></option>
                                                <?php
                                                $parallax_depth = 0;
                                                for ($x = 1; $x <= 15; $x++) {
                                                    $parallax_depth = $parallax_depth + 5;
                                                    $db_name = 'slider_parallax_depth_' . $x;
                                                    $parallax_value = $parallax_depth;
                                                    ?>
                                                    <option value="<?php echo $x; ?>">
                                                        <?php echo $x . '-(' . $parallax_value . '%)'; ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        } else {
                                            echo '<span style="display:block;color: #ff0000;">';
                                            _e('Parallax effect is disable from Slider Setting, parallax will be ignored.', 'avartan-slider-lite');
                                            echo '</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                    if ($pEnable == 1 && $TdEnable == 1) {
                                    ?>
                                    <div class="as-form-control-group as-layer-attach-to-div">
                                        <div class="as-form-control">
                                            <label><?php _e('Attach to', 'avartan-slider-lite'); ?></label>
                                            <select class="as-layer-3d-level-attach as-editor-selectText as-pro-version">
                                                <option value="layers"><?php _e('Layers 3D Group', 'avartan-slider-lite'); ?></option>
                                                <option value="bg"><?php _e('Background 3D Group', 'avartan-slider-lite'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $desktop_width = AvartanSliderLiteFunctions::getVal($slider_option,'start_width',1280);
        $mobile_width = AvartanSliderLiteFunctions::getVal($slider_option,'mobile_grid_width',480);
        $mobile_height = AvartanSliderLiteFunctions::getVal($slider_option,'mobile_grid_height',720);
        $desktop_height = AvartanSliderLiteFunctions::getVal($slider_option,'start_height',650);
        $slider_layout = AvartanSliderLiteFunctions::getVal($slider_option,'layout','full-width');
        if($slider_layout == 'fixed'){
            $editor_width = $desktop_width + 70;
            $editor_height = $desktop_height + 70;
           ?>
          <script type="text/javascript">
                jQuery(document).ready(function() {
                    save_needed = false;
                    jQuery('.as-form-control').each(function() {
                        var $avsSelect = jQuery(this).find('select');
                        var $avsInput = jQuery(this).find('input');

                        jQuery(document).on('change', $avsSelect, function () {
                            save_needed = true;
                        });
                        jQuery($avsInput).on('change paste keyup',function() {
                            save_needed = true;
                        });
                    });
                    avsAddPreventLeave();
                });

                jQuery(window).load(function() {

                    var window_width = jQuery('.as-editor-content-area_wrap').width();
                    var desktop_width = '<?php echo $desktop_width + 70; ?>';
                    var editor_height = '<?php echo $editor_height; ?>';
                    if(desktop_width > window_width ){
                        jQuery(".as-editor-area").css("width",desktop_width+"px");
                        jQuery(".as-editor-area").css("height",editor_height+"px");
                    }
                    else{
                        jQuery(".as-editor-area").css("width","100%");
                        jQuery(".as-editor-area").css("height",editor_height+"px");
                    }

                });

            </script>
        <?php
        }else{
            $editor_height = $desktop_height + 70;
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    save_needed = false;
                    jQuery('.as-form-control').each(function() {
                        var $avsSelect = jQuery(this).find('select');
                        var $avsInput = jQuery(this).find('input');

                        jQuery(document).on('change', $avsSelect, function () {
                            save_needed = true;
                        });
                        jQuery($avsInput).on('change paste keyup',function() {
                            save_needed = true;
                        });
                    });
                    avsAddPreventLeave();
                })

                jQuery(window).load(function() {
                    var desktop_width = '<?php echo $desktop_width + 70; ?>';

                    var window_width = jQuery('.as-editor-content-area_wrap').width();
                    if(desktop_width > window_width){
                        jQuery('.as-editor-area').width(desktop_width);
                    } else {
                        <?php
                            $editor_style = "style=width:100%;height:" . $editor_height . "px;";
                        ?>
                    }
                    avsEditorMeasurement();
                });

            </script>
            <?php
        }
        $element_style = "style=width:" . $desktop_width . "px;height:" . $desktop_height . "px;";
        ?>
        <div class="as-editor-content-area_wrap">
            <input type="hidden" name="slider_width" class="as-slider-mobile-width" value="<?php echo esc_attr($mobile_width); ?>">
            <input type="hidden" name="slider_mobile_height" class="as-slider-mobile-height" value="<?php echo esc_attr($mobile_height); ?>">
            <input type="hidden" name="slider_width" class="as-slider-width" value="<?php echo esc_attr($desktop_width); ?>">
            <input type="hidden" name="slider_height" class="as-slider-height" value="<?php echo esc_attr($desktop_height); ?>">
            <div class="as-editor-area" <?php echo isset($editor_style) ? $editor_style : ''; ?> data-slider-layout="<?php echo $slider_layout; ?>">
                <!--Ruler Design-->
                <div class="as-horline"><div class="as-horMeasure">0</div></div>
                <div class="as-verline"><div class="as-verMeasure">0</div></div>

                <div class="as-horGrid"><ul class="as-gridMeasure"></ul></div>
                <div class="as-verGrid"><ul class="as-gridMeasure"></ul></div>


                <div class="as-bottom-horline"><div class="as-bottom-horMeasure">0</div></div>
                <div class="as-right-verline"><div class="as-right-verMeasure">0</div></div>

                <div class="as-bottom-horGrid"><ul class="as-gridMeasure"></ul></div>
                <div class="as-right-verGrid"><ul class="as-gridMeasure"></ul></div>


                <!--Editor Content area Design-->
                <div class="as-slide-bg-default-image">
                    <?php
                    if($slider_layout == 'fixed'){
                    ?>
                     <div class="as-slide-editing-area<?php echo $slider_layout == 'fixed' ? ' fixed' :''; ?>" <?php echo $element_style; ?>>
                        <div class="as-editor-content-area<?php echo $bgclass; ?>" style="<?php echo $bgstyle; ?>"></div>
                        <div class="as-slide-overlay <?php echo $bgpattern_overlay; ?>"></div>
                        <div class="as-slide-background-color" style="<?php echo $bgoverlaystyle; ?>"></div>
                        <div class="as-slide-elements">
                            <?php
                                if(isset($slide_layers) && $slide_layers != '') {

                                    $slide_layers = AvartanSliderLiteFunctions::jsonEncodeForClientSide($slide_layers);
                                    ?>
                                    <script>
                                        avsGetAllLayers('<?php echo $slide_layers; ?>');
                                    </script>
                                    <?php
                                }
                            ?>
                        </div>
                        <div id="guide-h" class="guide"></div>
                        <div id="guide-v" class="guide"></div>
                    </div>
                    <?php
                    } else {
                    ?>
                    <div class="as-editor-content-area<?php echo $bgclass; ?>" style="<?php echo $bgstyle; ?>"></div>
                    <div class="as-slide-overlay <?php echo $bgpattern_overlay; ?>"></div>
                    <div class="as-slide-background-color" style="<?php echo $bgoverlaystyle; ?>"></div>
                    <div class="as-slide-editing-area<?php echo $slider_layout == 'fixed' ? ' fixed' :''; ?>" <?php echo $element_style; ?>>
                        <div class="as-slide-elements">
                            <?php
                                if(isset($slide_layers) && $slide_layers != '') {
                                    $slide_layers = AvartanSliderLiteFunctions::jsonEncodeForClientSide($slide_layers);
                            ?>
                                    <script>
                                        avsGetAllLayers('<?php echo $slide_layers; ?>');
                                    </script>
                            <?php
                                }
                            ?>
                        </div>
                        <div id="guide-h" class="guide"></div>
                        <div id="guide-v" class="guide"></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="as-editor-footer">
            <div class="as-editor-footer-menu as-layer-menu">
                <div class="as-editor-addNewLayer">
                    <a href="javascript:void(0);" title="<?php esc_attr_e('Add New Layer', 'avartan-slider-lite'); ?>"><i class="fas fa-database"></i> <?php _e('Add New Layer', 'avartan-slider-lite'); ?></a>
                    <ul>
                        <li><a class="as-add-text-element"><i class="fas fa-text-width"></i> <span><?php _e('Text/HTML', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-add-image-element"><i class="far fa-image"></i> <span><?php _e('Image', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-add-video-element"><i class="fas fa-video"></i> <span><?php _e('Video', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-add-shortcode-element as-pro-version"><i class="fas fa-code"></i> <span><?php _e('Shortcode', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-add-button-element as-pro-version"><i class="far fa-square"></i> <span><?php _e('Button', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-add-icon-element as-pro-version"><i class="fas fa-th"></i> <span><?php _e('Icon', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-add-shape-element as-pro-version"><i class="fas fa-clone"></i> <span><?php _e('Shape', 'avartan-slider-lite'); ?></span></a></li>
                    </ul>
                </div>
                <div class="as-editor-layer-detail">
                    <div class="as-layer-text-element">
                        <div class="as-form as-editor-form-horizontal">
                            <div class="as-form-control-group">
                                <div class="as-form-control">
                                    <textarea class="as-text-element-text" placeholder="<?php esc_attr_e('Text Element', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Text Element', 'avartan-slider-lite'); ?>"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="as-layer-video-element">
                        <div class="as-tab-video-element">
                            <ul>
                                <li><a href="#as_tab_video_sources"><i class="fas fa-random"></i> <?php _e('Sources', 'avartan-slider-lite'); ?></a></li>
                                <li><a href="#as_tab_video_settings"><i class="fas fa-cog"></i> <?php _e('Settings', 'avartan-slider-lite'); ?></a></li>
                                <li><a href="#as_tab_video_preview"><i class="fas fa-search"></i> <?php _e('Preview', 'avartan-slider-lite'); ?></a></li>
                            </ul>
                            <div class="as-tabs-content">
                                <!--Video Sources-->
                                <div class="as-tab-info" id="as_tab_video_sources">
                                    <div class="as-form as-editor-form-horizontal">
                                        <div class="as-form-control-group">
                                            <label><?php _e('Choose Video Type', 'avartan-slider-lite'); ?></label>
                                            <div class="as-form-control">
                                                <button class="as-btn as-youtube as-video-type as-active" value="youtube" title="<?php esc_attr_e('YouTube Video Type', 'avartan-slider-lite'); ?>"><?php _e('YouTube', 'avartan-slider-lite'); ?></button>
                                                <button class="as-btn as-vimeo as-video-type" value="vimeo" title="<?php esc_attr_e('Vimeo Video Type', 'avartan-slider-lite'); ?>"><?php _e('Vimeo', 'avartan-slider-lite'); ?></button>
                                                <button class="as-btn as-html5 as-video-type" value="html5" title="<?php esc_attr_e('HTML5 Video Type', 'avartan-slider-lite'); ?>"><?php _e('HTML5', 'avartan-slider-lite'); ?></button>
                                            </div>
                                        </div>
                                        <div class="as-video-type-youtube">
                                            <input type="hidden" value="" class="as-editor-videoId" />
                                            <div class="as-form-control-group">
                                                <label><?php _e('Youtube ID or URL', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control">
                                                    <input type="text" value="" class="as-editor-youtubeUrl" placeholder="<?php esc_attr_e('Youtube ID or URL', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Youtube ID or URL', 'avartan-slider-lite'); ?>"/>
                                                </div>
                                                <button class="as-btn as-active as-editor-youtubeUrl-search" title="<?php esc_attr_e('Search', 'avartan-slider-lite'); ?>"><?php _e('Search', 'avartan-slider-lite'); ?></button>
                                                <span><?php _e('Example', 'avartan-slider-lite'); ?>: zxEEkm_qKjI </span>
                                            </div>
                                        </div>
                                        <div class="as-video-type-vimeo">
                                            <div class="as-form-control-group">
                                                <label><?php _e('Vimeo ID or URL', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control">
                                                    <input type="text" value="" class="as-editor-vimeoUrl" placeholder="<?php esc_attr_e('Vimeo ID or URL', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Vimeo ID or URL', 'avartan-slider-lite'); ?>"/>
                                                </div>
                                                <button class="as-btn as-active as-editor-vimeoUrl-search" title="<?php esc_attr_e('Search', 'avartan-slider-lite'); ?>"><?php _e('Search', 'avartan-slider-lite'); ?></button>
                                                <span><?php _e('Example', 'avartan-slider-lite'); ?>: 35545973 </span>
                                            </div>
                                        </div>
                                        <div class="as-video-type-html5">
                                            <div class="as-form-control-group">
                                                <label><?php _e('MP4', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control">
                                                    <input type="text" value="" class="as-editor-htmlMp4" placeholder="<?php esc_attr_e('MP4', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('MP4', 'avartan-slider-lite'); ?>"/>
                                                </div>
                                                <button class="as-btn as-active as-editor-video-upload as-editor-mp4-video-source as-pro-version" title="<?php esc_attr_e('Search', 'avartan-slider-lite'); ?>"><?php _e('Set Video', 'avartan-slider-lite'); ?></button>
                                            </div>
                                            <div class="as-form-control-group as-no-padding">
                                                <label>&nbsp;</label>
                                                <div class="as-form-control"><?php _e('Example', 'avartan-slider-lite'); ?>: http://media.w3.org/2010/05/sintel/trailer.mp4</div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('WEBM', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control">
                                                    <input type="text" value="" class="as-editor-htmlWebm" placeholder="<?php esc_attr_e('WEBM', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('WEBM', 'avartan-slider-lite'); ?>"/>
                                                </div>
                                                <button class="as-btn as-active as-editor-video-upload as-editor-webm-video-source as-pro-version" title="<?php esc_attr_e('Search', 'avartan-slider-lite'); ?>"><?php _e('Set Video', 'avartan-slider-lite'); ?></button>
                                            </div>
                                            <div class="as-form-control-group as-no-padding">
                                                <label>&nbsp;</label>
                                                <div class="as-form-control"><?php _e('Example', 'avartan-slider-lite'); ?>: http://media.w3.org/2010/05/sintel/trailer.webm</div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('OGV', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control">
                                                    <input type="text" value="" class="as-editor-htmlOgv" placeholder="<?php esc_attr_e('OGV', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('OGV', 'avartan-slider-lite'); ?>"/>
                                                </div>
                                                <button class="as-btn as-active as-editor-video-upload as-editor-ogv-video-source as-pro-version" title="<?php esc_attr_e('Search', 'avartan-slider-lite'); ?>"><?php _e('Set Video', 'avartan-slider-lite'); ?></button>
                                            </div>
                                            <div class="as-form-control-group as-no-padding">
                                                <label>&nbsp;</label>
                                                <div class="as-form-control"><?php _e('Example', 'avartan-slider-lite'); ?>: http://media.w3.org/2010/05/sintel/trailer.ogv</div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label></label>
                                                <button class="as-btn as-active as-editor-html5Url-search" title="<?php esc_attr_e('Search', 'avartan-slider-lite'); ?>"><?php _e('Search', 'avartan-slider-lite'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Video Settings-->
                                <div class="as-tab-info" id="as_tab_video_settings">
                                    <div class="as-form as-editor-form-horizontal">
                                        <div class="as-form-group">
                                            <div class="as-form-control-group">
                                                <label><?php _e('Full Screen', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-fullscreen-toggle" title="<?php esc_attr_e('Full Screen', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_fullscreen" id="video_fullscreen_on" value="1"/>
                                                        <label for="video_fullscreen_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_fullscreen" id="video_fullscreen_off" value="0" checked/>
                                                        <label for="video_fullscreen_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group as-video-force-cover">
                                                <label><?php _e('Force Cover', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-forcecover-toggle" title="<?php esc_attr_e('Force Cover', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_forcecover" id="video_forcecover_on" value="1" />
                                                        <label for="video_forcecover_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_forcecover" id="video_forcecover_off" value="0" checked/>
                                                        <label for="video_forcecover_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group as-video-aspect-ratio">
                                                <label><?php _e('Aspect Ratio', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-screensize-txtbox as-pro-version">
                                                    <select class="as-video-aspectRatio" title="<?php esc_attr_e('Aspect Ratio', 'avartan-slider-lite'); ?>">
                                                        <option selected="selected" value="16:9">16:9</option>
                                                        <option value="4:3">4:3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('Loop Video', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-loopVideo-toggle" title="<?php esc_attr_e('Loop Video', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_loopVideo" id="video_loopVideo_on" value="1" />
                                                        <label for="video_loopVideo_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_loopVideo" id="video_loopVideo_off" value="0" checked/>
                                                        <label for="video_loopVideo_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('Auto Play', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-autoplay-toggle" title="<?php esc_attr_e('Auto Play', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_autoplay" id="video_autoplay_on" value="1" />
                                                        <label for="video_autoplay_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_autoplay" id="video_autoplay_off" value="0" checked/>
                                                        <label for="video_autoplay_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group as-video-firstTime">
                                                <label><?php _e('Only First Time', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-firstTime-toggle" title="<?php esc_attr_e('Only First Time', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_firstTime" id="video_firstTime_on" value="1" />
                                                        <label for="video_firstTime_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_firstTime" id="video_firstTime_off" value="0" checked/>
                                                        <label for="video_firstTime_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="as-form-group">
                                            <div class="as-form-control-group">
                                                <label><?php _e('Allow Full Screen', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-allowFullscreen-toggle" title="<?php esc_attr_e('Full Screen', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_allowFullscreen" id="video_allowFullscreen_on" value="1" />
                                                        <label for="video_allowFullscreen_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_allowFullscreen" id="video_allowFullscreen_off" value="0" checked/>
                                                        <label for="video_allowFullscreen_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('Next Slide on End', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-next-slide-toggle" title="<?php esc_attr_e('Next Slide on End', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_nextSlide" id="video_nextSlide_on" value="1" />
                                                        <label for="video_nextSlide_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_nextSlide" id="video_nextSlide_off" value="0" checked/>
                                                        <label for="video_nextSlide_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('Hide Controls', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-hideControl-toggle" title="<?php esc_attr_e('Hide Controls', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_hideControl" id="video_hideControl_on" value="1" />
                                                        <label for="video_hideControl_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_hideControl" id="video_hideControl_off" value="0" checked/>
                                                        <label for="video_hideControl_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('Mute', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-mute-toggle" title="<?php esc_attr_e('Mute', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_mute" id="video_mute_on" value="1" />
                                                        <label for="video_mute_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_mute" id="video_mute_off" value="0" checked/>
                                                        <label for="video_mute_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('Show Poster On Pause', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-posterOnPause-toggle" title="<?php esc_attr_e('Show Poster On Pause', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_posterOnPause" id="video_posterOnPause_on" value="1" />
                                                        <label for="video_posterOnPause_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_posterOnPause" id="video_posterOnPause_off" value="0" checked/>
                                                        <label for="video_posterOnPause_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="as-form-control-group">
                                                <label><?php _e('Video Force Rewind', 'avartan-slider-lite'); ?></label>
                                                <div class="as-form-control as-pro-version">
                                                    <div class="as-toggle-indicator as-video-forceRewind-toggle" title="<?php esc_attr_e('Video Force Rewind', 'avartan-slider-lite'); ?>">
                                                        <input type="radio" name="video_forceRewind" id="video_forceRewind_on" value="1" />
                                                        <label for="video_forceRewind_on"><?php _e('On', 'avartan-slider-lite'); ?></label>
                                                        <input type="radio" name="video_forceRewind" id="video_forceRewind_off" value="0" checked/>
                                                        <label for="video_forceRewind_off"><?php _e('Off', 'avartan-slider-lite'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Video Preview-->
                                <div class="as-tab-info" id="as_tab_video_preview">
                                    <div class="as-form as-editor-form-horizontal">
                                        <div class="as-form-control-group">
                                            <label><?php _e('Image', 'avartan-slider-lite'); ?></label>
                                            <div class="as-form-control">
                                                <input type="text" value="" class="as-editor-videoImg" placeholder="<?php esc_attr_e('Image', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Image', 'avartan-slider-lite'); ?>"/>
                                            </div>
                                            <button class="as-btn as-active as-preview-image-element-upload-button" value="<?php esc_attr_e('Choose Image', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Choose Image', 'avartan-slider-lite'); ?>"><?php _e('Choose Image', 'avartan-slider-lite'); ?></button>
                                            <button class="as-btn as-btn-red as-remove-preview-image-element-upload-button" value="<?php esc_attr_e('Remove', 'avartan-slider-lite'); ?>" title="<?php esc_attr_e('Remove', 'avartan-slider-lite'); ?>"><?php _e('Remove', 'avartan-slider-lite'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="as-editor-action-icon">
                <button class="as-btn as-edit-layer as-btn-disabled" title="<?php esc_attr_e('Edit Layer', 'avartan-slider-lite'); ?>" disabled="disabled" ><i class="fas fa-pencil-alt"></i></button>
                <button class="as-btn as-duplicate-layer as-btn-disabled" title="<?php esc_attr_e('Duplicate Layer', 'avartan-slider-lite'); ?>"><i class="far fa-clipboard"></i></button>
                <button class="as-btn as-delete-layer as-btn-disabled" title="<?php esc_attr_e('Delete Layer', 'avartan-slider-lite'); ?>"><i class="fas fa-trash-alt"></i></button>
            </div>
            <div class="as-pull-right">
                <?php
                $mobile_custom_size = AvartanSliderLiteFunctions::getVal($slider_option,'mobile_custom_size',0);
                if($mobile_custom_size == 1){
                ?>
                <script type="text/javascript">
                    var slide_mobile_width = '<?php echo AvartanSliderLiteFunctions::getVal($slider_option,'mobile_grid_width',480); ?>';
                    var slide_mobile_height = '<?php echo AvartanSliderLiteFunctions::getVal($slider_option,'mobile_grid_height',720); ?>';
                    var slide_desktop_width = '<?php echo AvartanSliderLiteFunctions::getVal($slider_option,'start_width',1280); ?>';
                    var slide_desktop_height = '<?php echo AvartanSliderLiteFunctions::getVal($slider_option,'start_height',650); ?>';
                </script>
                <div class="as-editor-responsive-icon">
                    <a href="javascript:void(0);" class='as-editor-mobile-icon as-pro-version' title="<?php esc_attr_e('Mobile View', 'avartan-slider-lite'); ?>"><i class="fas fa-mobile-alt"></i></a>
                    <a href="javascript:void(0);" class="as-editor-desktop-icon as-active" title="<?php esc_attr_e('Desktop View', 'avartan-slider-lite'); ?>"><i class="fas fa-desktop"></i></a>
                </div>
                <?php
                }
                ?>
                <div class="as-editor-footer-menu as-snapto-menu">
                    <a href="javascript:void(0);" title="<?php esc_attr_e('Snap To', 'avartan-slider-lite'); ?>"><i class="fas fa-align-justify"></i>  <?php _e('Snap To', 'avartan-slider-lite'); ?></a>
                    <ul>
                        <li><a class="as-snapto-option as-pro-version as-active" href="javascript:void(0);" data-helper="none"><span><?php _e('None', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-snapto-option as-pro-version" href="javascript:void(0);" data-helper="grid"><span><?php _e('Grid', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-snapto-option as-pro-version" href="javascript:void(0);" data-helper="layer"><span><?php _e('Layers', 'avartan-slider-lite'); ?></span></a></li>
                    </ul>
                </div>
                <div class="as-editor-footer-menu as-grid-helper-menu">
                    <a href="javascript:void(0);" title="<?php esc_attr_e('Grid Helper', 'avartan-slider-lite'); ?>"><i class="fas fa-th-large"></i> <?php _e('Grid Helper', 'avartan-slider-lite'); ?></a>
                    <ul>
                        <li><a class="as-grid-helper-option as-pro-version as-active" href="javascript:void(0);"><span><?php _e('None', 'avartan-slider-lite'); ?></span></a></li>
                        <li><a class="as-grid-helper-option as-pro-version" data-helper="10" href="javascript:void(0);"><span>10 x 10</span></a></li>
                        <li><a class="as-grid-helper-option as-pro-version" data-helper="25" href="javascript:void(0);"><span>25 x 25</span></a></li>
                        <li><a class="as-grid-helper-option as-pro-version" data-helper="50" href="javascript:void(0);"><span>50 x 50</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>