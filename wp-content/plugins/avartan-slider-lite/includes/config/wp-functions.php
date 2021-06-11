<?php

if (!defined('ABSPATH'))
    exit();

class AvartanSliderLiteWPFunctions {

    public static $urlSite;
    public static $urlAdmin;

    const SORTBY_NONE = "none";
    const SORTBY_ID = "ID";
    const SORTBY_AUTHOR = "author";
    const SORTBY_TITLE = "title";
    const SORTBY_SLUG = "name";
    const SORTBY_DATE = "date";
    const SORTBY_LAST_MODIFIED = "modified";
    const SORTBY_RAND = "rand";
    const SORTBY_COMMENT_COUNT = "comment_count";
    const SORTBY_MENU_ORDER = "menu_order";
    const ORDER_DIRECTION_ASC = "ASC";
    const ORDER_DIRECTION_DESC = "DESC";
    const THUMB_SMALL = "thumbnail";
    const THUMB_MEDIUM = "medium";
    const THUMB_LARGE = "large";
    const THUMB_FULL = "full";
    const STATE_PUBLISHED = "publish";
    const STATE_DRAFT = "draft";

    /**
     * Init the static variables
     *
     * @since 1.3
     */
    public static function initStaticVars() {

        self::$urlAdmin = admin_url();
        if (substr(self::$urlAdmin, -1) != "/")
            self::$urlAdmin .= "/";
    }


    /**
     * Get single post
     *
     * @since 1.3
     * @param integer $postID
     * @return array $arrPost
     */
    public static function getPost($postID) {
        $post = get_post($postID);
        if (empty($post))
            AvartanSliderLiteFunctions::throwError(__("Post with id:", 'avartan-slider-lite') . $postID . __("not found", 'avartan-slider-lite'));

        $arrPost = $post->to_array();
        return($arrPost);
    }
    
    /**
     * Filter setting from old version to new version
     *
     * @since 1.3
     * @param object|array $settings
     * @param text $type
     * @return array $settings
     */
    public static function filterSettings($settings, $type) {
        
        if ($type == 'layer') {
            
            $settings = AvartanSliderLiteFunctions::convertStdClassToArray($settings);

            $current_version = AvartanSliderLiteFunctions::getVal($settings, 'current_version', '1');
            if ($current_version >= 1.3 && !isset($settings['animation_ease_in']) && !isset($settings['font_color'])) return $settings;
            
            $oldSettings = $settings;
            
            
            
            $layer_type = AvartanSliderLiteFunctions::getVal($settings, 'type', 'text');
            
            $settings = AvartanSliderLiteWPFunctions::filterIndividualToAdvaceStyle($settings,$layer_type);
            
            if($layer_type == 'button' || $layer_type == 'icon' || $layer_type == 'shape'){
                $settings['type'] = 'text';
                if($layer_type == 'button' && isset($oldSettings['button_text'])) {
                    $settings['text'] = $oldSettings['button_text'];
                }
            }
           
            //Calculate data
            $settings = self::removeParameters($settings, 'layer');

            if(isset($settings['type'])){
                if(in_array($settings['type'], array('button','icon','shape','shortcode')))
                    return array();
            }

            $settings['x_position'] = (isset($oldSettings['x_position']['desktop']) ? AvartanSliderLiteFunctions::getDataMode($oldSettings, 'x_position', 'desktop', $oldSettings, 'data_left', 100) : AvartanSliderLiteFunctions::getDataDetail($oldSettings, 'x_position', $oldSettings, 'data_left', 100));
            
            $settings['y_position'] = (isset($oldSettings['y_position']['desktop']) ? AvartanSliderLiteFunctions::getDataMode($oldSettings, 'y_position', 'desktop', $oldSettings, 'data_top', 100) : AvartanSliderLiteFunctions::getDataDetail($oldSettings, 'y_position', $oldSettings, 'data_top', 100));
            
            $settings['alignto'] = AvartanSliderLiteFunctions::getDataMode($oldSettings, 'layer_behavior', 'desktop', $oldSettings, 'layer_behavior', 'grid');
            $settings['align_hor'] = AvartanSliderLiteFunctions::getDataMode($oldSettings, 'layer_alignment', 'desktop', $oldSettings, 'layer_alignment', 'left');
            $settings['align_vert'] = AvartanSliderLiteFunctions::getDataMode($oldSettings, 'layer_verticle_alignment', 'desktop', $oldSettings, 'layer_verticle_alignment', 'top');
            
            //Animation
            $data_time = AvartanSliderLiteFunctions::getDataDetail($settings, 'animation_time', $oldSettings, 'data_time', '');
            if ($data_time == 'all' || $data_time == '') {
                $settings['animation_time'] = 0;
            } else {
                $settings['animation_time'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'animation_time', $oldSettings, 'data_time', '');
            }
            $settings['animation_delay'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'animation_delay', $oldSettings, 'data_delay', 300);
            $settings['animation_in'] = self::filterVal(strtolower(AvartanSliderLiteFunctions::getDataDetail($settings, 'animation_in', $oldSettings, 'data_in', 'fade')),'animation');
            if($settings['animation_in'] == 'notransition') $settings['animation_in'] = 'fade';
            $settings['animation_out'] = self::filterVal(strtolower(AvartanSliderLiteFunctions::getDataDetail($settings, 'animation_out', $oldSettings, 'data_out', 'fade')),'animation');
            if($settings['animation_out'] == 'notransition') $settings['animation_out'] = 'fade';
            $settings['animation_startspeed'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'animation_startspeed', $oldSettings, 'data_easeIn', 300);
            $settings['animation_endspeed'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'animation_endspeed', $oldSettings, 'data_easeOut', 300);

            //Advanced
            $settings['advance_style'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'advance_style', $oldSettings, 'custom_css', '');

            //Attributes
            $settings['attribute_id'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_id', $oldSettings, 'attr_id', '');
            $settings['attribute_class'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_class', $oldSettings, 'attr_class', '');
            $settings['attribute_title'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_title', $oldSettings, 'attr_title', '');
            $settings['attribute_rel'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_rel', $oldSettings, 'attr_rel', '');
            $settings['attribute_alt'] = '';

            //Action
            $link = AvartanSliderLiteFunctions::getVal($oldSettings, 'link', '');
            if (trim($link) != '')
                $oldSettings['link_type'] = 'simpleLink';
            $settings['attribute_link_type'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_link_type', $oldSettings, 'link_type', 'nolink');
            $settings['attribute_link_url'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_link_url', $oldSettings, 'link', '');
            $settings['attribute_link_target'] = self::filterVal(AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_link_target', $oldSettings, 'link_new_tab', 'same_tab'), 'link');

            // Extra Common
            switch ($layer_type) {
                case 'text':
                    $settings['text'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'text', $oldSettings, 'inner_html', '');
                    $settings['width'] = 'auto';
                    $settings['height'] = 'auto';
                    $settings['image_src'] = '';
                    $settings['video_type'] = '';
                    $settings['video_id'] = '';
                    $settings['youtube_url'] = '';
                    $settings['vimeo_url'] = '';
                    $settings['html5_mp4_url'] = '';
                    $settings['html5_webm_url'] = '';
                    $settings['html5_ogv_url'] = '';
                    $settings['editor_video_image'] = '';
                    
                    break;
                case 'image':
                    $settings['text'] = '';
                    $settings['video_type'] = '';
                    $settings['image_src'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'image_src', $oldSettings, 'image_src', '');
                    
                    $settings['width'] = (isset($oldSettings['width']['desktop']) ? AvartanSliderLiteFunctions::getDataMode($oldSettings, 'width', 'desktop', $oldSettings, 'image_width', '') : AvartanSliderLiteFunctions::getDataDetail($oldSettings, 'width', $oldSettings, 'image_width', ''));
                    $settings['height'] = (isset($oldSettings['height']['desktop']) ? AvartanSliderLiteFunctions::getDataMode($oldSettings, 'height', 'desktop', $oldSettings, 'image_height', '') : AvartanSliderLiteFunctions::getDataDetail($oldSettings, 'height', $oldSettings, 'image_height', ''));
                    
                    $settings['attribute_alt'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_alt', $oldSettings, 'image_alt', '');
                    $settings['attribute_title'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_title', $oldSettings, 'image_title', '');
                    $settings['video_id'] = '';
                    $settings['youtube_url'] = '';
                    $settings['vimeo_url'] = '';
                    $settings['html5_mp4_url'] = '';
                    $settings['html5_webm_url'] = '';
                    $settings['html5_ogv_url'] = '';
                    $settings['editor_video_image'] = '';
                    break;
                case 'video':
                    $settings['image_src'] = '';
                    $settings['text'] = '';
                    $video_type = AvartanSliderLiteFunctions::getVal($oldSettings, 'video_type', 'youtube');
                    $video_type = ($video_type == 'H') ? 'html5' : (($video_type == 'V') ? 'vimeo' : (($video_type == 'Y') ? 'youtube' : $video_type));
                    $settings['video_fullscreen'] = self::filterVal(AvartanSliderLiteFunctions::getDataDetail($settings, 'video_fullscreen', $oldSettings, 'video_full_width', 0),'num');
                    
                    $settings['video_type'] = $video_type;
                    switch($video_type) {
                        case 'youtube' : 
                            $settings['vimeo_url'] = '';
                            $settings['html5_mp4_url'] = '';
                            $settings['html5_webm_url'] = '';
                            $settings['html5_ogv_url'] = '';
                            $settings['youtube_url'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'youtube_url', $oldSettings, 'video_link', '');
                            $settings['video_id'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'video_id', $oldSettings, 'video_id', '');
                            $settings['editor_video_image'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'editor_video_image', $oldSettings, 'video_preview_img_src', '');
                            break;
                        case 'vimeo' : 
                            $settings['youtube_url'] = '';
                            $settings['html5_mp4_url'] = '';
                            $settings['html5_webm_url'] = '';
                            $settings['html5_ogv_url'] = '';
                            $settings['vimeo_url'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'vimeo_url', $oldSettings, 'video_link', '');
                            $settings['video_id'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'video_id', $oldSettings, 'video_id', '');
                            $settings['editor_video_image'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'editor_video_image', $oldSettings, 'video_preview_img_src', '');
                            break;
                        case 'html5' : 
                            $settings['video_id'] = '';
                            $settings['youtube_url'] = '';
                            $settings['vimeo_url'] = '';
                            $settings['html5_mp4_url'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'html5_mp4_url', $oldSettings, 'video_html5_mp4_video_link', '');
                            $settings['html5_webm_url'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'html5_webm_url', $oldSettings, 'video_html5_webm_video_link', '');
                            $settings['html5_ogv_url'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'html5_ogv_url', $oldSettings, 'video_html5_ogv_video_link', '');
                            $settings['editor_video_image'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'editor_video_image', $oldSettings, 'video_html5_poster_url', '');
                            break;
                    }
                    
                    $settings['width'] = (isset($oldSettings['width']['desktop']) ? AvartanSliderLiteFunctions::getDataMode($oldSettings, 'width', 'desktop', $oldSettings, 'video_width', '320') : AvartanSliderLiteFunctions::getDataDetail($oldSettings, 'width', $oldSettings, 'video_width', '320'));
                    $settings['height'] = (isset($oldSettings['height']['desktop']) ? AvartanSliderLiteFunctions::getDataMode($oldSettings, 'height', 'desktop', $oldSettings, 'video_height', '280') : AvartanSliderLiteFunctions::getDataDetail($oldSettings, 'height', $oldSettings, 'video_height', '280'));
                    
                    $settings['attribute_alt'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_alt', $oldSettings, 'video_preview_img_alt', '');
                    $settings['attribute_title'] = AvartanSliderLiteFunctions::getDataDetail($settings, 'attribute_title', $oldSettings, 'video_preview_img_title', '');
                    break;
                
                default:
                    break;
                
            }
            
            $settings = self::FilterAdvaceStyle($settings);
           
            return $settings;
        }
        else if ($type == 'slide') {
            $settings = AvartanSliderLiteFunctions::convertStdClassToArray($settings);

            $current_version = AvartanSliderLiteFunctions::getVal($settings, 'current_version', '1');
            if ($current_version >= 1.3 && !isset($settings['kenburns']))
                return $settings;

            //Background
            $bg_options = AvartanSliderLiteFunctions::getVal($settings, 'background', array());

            //BG TYPE
            $old_bg_type = '';
            if (isset($settings['background_type_image']) && $settings['background_type_image'] != 'none' && $settings['background_type_image'] != 'undefined')
                $old_bg_type = 'image';
            else {
                if (isset($settings['background_type_color']) && $settings['background_type_color'] != '' && $settings['background_type_color'] != 'transparent')
                    $old_bg_type = 'solid_color';
                else if (isset($settings['background_type_color']) && $settings['background_type_color'] != '' && $settings['background_type_color'] == 'transparent')
                    $old_bg_type = 'transparent';
            }
            if ($old_bg_type == '')
                $settings['background']['type'] = AvartanSliderLiteFunctions::getDataDetail($bg_options, 'type', $settings, 'background_type', 'transparent');
            else
                $settings['background']['type'] = $old_bg_type;
            
            $settings['background']['type'] = self::filterVal($settings['background']['type'], 'bgimage');

            //BG SOLID COLOR
            $settings['background']['bgcolor'] = AvartanSliderLiteFunctions::getDataDetail($bg_options, 'bgcolor', $settings, 'background_type_color', 'transparent');

            //BG Image
            $bg_img = AvartanSliderLiteFunctions::getVal($bg_options, 'image', array());
            $settings['background']['image']['source'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'source', $settings, 'background_type_image', '');
            $settings['background']['image']['position'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'position', $settings, 'background_property_position', 'center center');
            $settings['background']['image']['position_x'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'position_x', $settings, 'background_property_position_x', 0);
            $settings['background']['image']['position_y'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'position_y', $settings, 'background_property_position_y', 0);
            $settings['background']['image']['repeat'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'repeat', $settings, 'background_repeat', 'no-repeat');
            $settings['background']['image']['size'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'size', $settings, 'background_property_size', 'cover');
            $settings['background']['image']['size_x'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'size_x', $settings, 'background_property_size_x', 100);
            $settings['background']['image']['size_y'] = AvartanSliderLiteFunctions::getDataDetail($bg_img, 'size_y', $settings, 'background_property_size_y', 100);

            //Animation
            $settings['data_animation'] = self::filterVal(strtolower(AvartanSliderLiteFunctions::getDataDetail($settings, 'data_animation', $settings, 'data_in', 'fade')), 'animation');
            if($settings['data_animation'] == 'notransition') $settings['data_animation'] = 'fade';
            return self::removeParameters($settings, 'slide');
        }
        else if ($type == 'slider') {
            $settings = AvartanSliderLiteFunctions::convertStdClassToArray($settings);
            $oldSettings = $settings;

            $current_version = AvartanSliderLiteFunctions::getVal($settings, 'current_version', '1');
            if ($current_version >= 1.3 && !isset($settings['parallax']))
                return $settings;

            //Layout
            $settings['start_width'] = AvartanSliderLiteFunctions::getData($settings, 'start_width', 'startWidth', 1280);
            $settings['start_height'] = AvartanSliderLiteFunctions::getData($settings, 'start_height', 'startHeight', 650);
            
            //General
            $settings['automatic_slide'] = AvartanSliderLiteFunctions::getData($settings, 'automatic_slide', 'automaticSlide', 0);
            $settings['pause_on_hover'] = AvartanSliderLiteFunctions::getData($settings, 'pause_on_hover', 'pauseOnHover', 0);
            $settings['enable_swipe'] = AvartanSliderLiteFunctions::getData($settings, 'enable_swipe', 'enableSwipe', 0);

            //Loader
            $loader_options = AvartanSliderLiteFunctions::getVal($oldSettings, 'loader', array());

            $settings['loader']['type'] = AvartanSliderLiteFunctions::getDataDetail($loader_options, 'type', $oldSettings, 'loaderType', 'default');
            $settings['loader']['style'] = self::filterVal(trim(AvartanSliderLiteFunctions::getDataDetail($loader_options, 'style', $oldSettings, 'loaderClass', 'loader1')),'loader');
            
            //Shadowbar
            $settings['show_shadow_bar'] = AvartanSliderLiteFunctions::getData($settings, 'show_shadow_bar', 'showShadowBar', 0);
            $settings['shadow_class'] = AvartanSliderLiteFunctions::getData($settings, 'shadow_class', 'shadowClass', 'shadow1');

            $nav_options = AvartanSliderLiteFunctions::getVal($oldSettings, 'navigation', array());

            //Arrows
            $arrows_options = AvartanSliderLiteFunctions::getVal($nav_options, 'arrows', array());
            $settings['navigation']['arrows']['enable'] = AvartanSliderLiteFunctions::getDataDetail($arrows_options, 'enable', $oldSettings, 'showControls', 0);
            $settings['navigation']['arrows']['style'] = self::filterVal(trim(AvartanSliderLiteFunctions::getDataDetail($arrows_options, 'style', $oldSettings, 'controlsClass', 'arrows1')),'arrows');

            //Bullets
            $bullets_options = AvartanSliderLiteFunctions::getVal($nav_options, 'bullets', array());
            $settings['navigation']['bullets']['enable'] = AvartanSliderLiteFunctions::getDataDetail($bullets_options, 'enable', $settings, 'showNavigation', 0);
            $settings['navigation']['bullets']['style'] = self::filterVal(trim(AvartanSliderLiteFunctions::getDataDetail($bullets_options, 'style', $settings, 'navigationClass', 'navigation1')),'bullets');
            $settings['navigation']['bullets']['hPos'] = self::filterVal(AvartanSliderLiteFunctions::getDataDetail($bullets_options, 'hPos', $settings, 'navigationPosition', 'center'),'bulletpos');
            
            return self::removeParameters($settings, 'slider');
        }
        
        return $settings;
    }

    /**
     * Filter advaced style and update setting
     *
     * @since 1.3
     * @param array $settings
     * @return array $settings
     */
    public static function FilterAdvaceStyle($settings) {
        $advanced_style = $settings['advance_style'];
        $fixed_style = $settings['fixed_style'];
        $final_style = '';
        if($fixed_style != '') {
            $final_style .= $fixed_style;
        }
        if($advanced_style != '') {
            if($fixed_style != '') $final_style .= ';';
            $final_style .= $advanced_style;
        }
        $allcss = explode(';', $final_style);
    
        if ($allcss) {
            $allcss = array_values(array_filter($allcss, function($a){ return preg_match("#\S#", $a);}));        
            foreach ($allcss as $key=>$single_css) {
                if ($single_css != '') {
                    $check_style = array();
                    $check_style = explode(':', $single_css);
                    $css = isset($check_style[0]) ? strtolower(trim($check_style[0])) : '';
                    $css_val = isset($check_style[1]) ? trim($check_style[1]) : '';
                    if ($css == 'font-size') {
                        unset($allcss[$key]);
                        $px_value = self::avsConvertToPX($css_val);
                        $settings['font_size'] = $px_value;
                    } else if ($css == 'line-height') {
                        unset($allcss[$key]);
                        $px_value = self::avsConvertToPX($css_val);
                        $ori = floatval(substr(strtolower($css_val), 0, -2));
                        if (($px_value == '' && $css_val < $settings['font_size']) || $ori <= 2)
                            $px_value = $css_val * $settings['font_size'];
                        $settings['line_height'] = $px_value;
                    } else if ($css == 'color') {
                        unset($allcss[$key]);
                        $settings['font_color'] = $css_val;
                    } else if ($css == 'background-color') {
                        unset($allcss[$key]);
                        $settings['background_color'] = $css_val;
                    } else if ($css == 'background') {
                        unset($allcss[$key]);
                        if ($css_val != '' && stripos($css_val, 'url') === false) { 
                            $settings['background_color'] = trim(trim(str_replace(array("none", "repeat", "scroll"), array("", "", ""), $css_val),'0 0'));
                            if(!is_array($settings['background_color']) && strlen($settings['background_color']) <= 1) $settings['background_color'] = "#000";
                        }
                    } else if ($css == 'width') {
                        unset($allcss[$key]);
                        $px_value = self::avsConvertToPX($css_val);

                        //For image
                        if ($settings['type'] == 'image' && strrpos($css_val, '%') !== false) {
                            echo $ori = floatval(substr(strtolower($css_val), 0, -1));
                            if (isset($settings['width']))
                                $px_value = (($settings['width'] * $ori) / 100);
                        }

                        if ($px_value == '')
                            $px_value = 'auto';
                        $settings['width'] = $px_value;
                    } else if ($css == 'height') {
                        unset($allcss[$key]);
                        $px_value = self::avsConvertToPX($css_val);

                        //For image
                        if ($settings['type'] == 'image' && strrpos($css_val, '%') !== false) {
                            $ori = floatval(substr(strtolower($css_val), 0, -1));
                            if (isset($settings['height']))
                                $px_value = (($settings['height'] * $ori) / 100);
                        }
                        if ($px_value == '')
                            $px_value = 'auto';
                        $settings['height'] = $px_value;
                    } else if ($css == 'top') {
                        unset($allcss[$key]);
                        $px_value = self::avsConvertToPX($css_val);
                        $settings['x_position'] = $px_value;
                    } else if ($css == 'left') {
                        unset($allcss[$key]);
                        $px_value = self::avsConvertToPX($css_val);
                        $settings['y_position'] = $px_value;
                    } 
                }
            }
            $allcss = implode(';', $allcss);
            $settings['advance_style'] = $allcss;
        }
        return $settings;
    }

    public static function removeEle($arr, $key) {
        if (array_key_exists($key, $arr)) {
            unset($arr[$key]);
        } 
        return $arr;
    }

    /**
     * Remove old parameters from array
     *
     * @since 1.3
     * @param array $arr
     * @param string $type
     * @return array $arr
     */
    public static function removeParameters($arr, $type) {
        if ($type == 'layer') {
            $arr = self::removeEle($arr, 'm_image_width');
            $arr = self::removeEle($arr, 'm_image_height');
            $arr = self::removeEle($arr, 'video_aspect_ratio');
            $arr = self::removeEle($arr, 'data_left');
            $arr = self::removeEle($arr, 'm_data_left');
            $arr = self::removeEle($arr, 'data_top');
            $arr = self::removeEle($arr, 'm_data_top');
            $arr = self::removeEle($arr, 'font_family_type');
            $arr = self::removeEle($arr, 'm_font_family_type');
            $arr = self::removeEle($arr, 'font_family');
            $arr = self::removeEle($arr, 'm_font_family');
            $arr = self::removeEle($arr, 'font_size');
            $arr = self::removeEle($arr, 'm_font_size');
            $arr = self::removeEle($arr, 'line_height');
            $arr = self::removeEle($arr, 'm_line_height');
            $arr = self::removeEle($arr, 'font_weight');
            $arr = self::removeEle($arr, 'm_font_weight');
            $arr = self::removeEle($arr, 'font_italic');
            $arr = self::removeEle($arr, 'm_font_italic');
            $arr = self::removeEle($arr, 'text_align');
            $arr = self::removeEle($arr, 'm_text_align');
            $arr = self::removeEle($arr, 'letter_spacing');
            $arr = self::removeEle($arr, 'm_letter_spacing');
            $arr = self::removeEle($arr, 'text_transform');
            $arr = self::removeEle($arr, 'm_text_transform');
            $arr = self::removeEle($arr, 'text_decoration');
            $arr = self::removeEle($arr, 'm_text_decoration');
            $arr = self::removeEle($arr, 'padding_top');
            $arr = self::removeEle($arr, 'm_padding_top');
            $arr = self::removeEle($arr, 'padding_right');
            $arr = self::removeEle($arr, 'm_padding_right');
            $arr = self::removeEle($arr, 'padding_bottom');
            $arr = self::removeEle($arr, 'm_padding_bottom');
            $arr = self::removeEle($arr, 'padding_left');
            $arr = self::removeEle($arr, 'm_padding_left');
            $arr = self::removeEle($arr, 'font_color');
            $arr = self::removeEle($arr, 'm_font_color');
            $arr = self::removeEle($arr, 'font_bg_color');
            $arr = self::removeEle($arr, 'm_font_bg_color');
            $arr = self::removeEle($arr, 'font_border_width');
            $arr = self::removeEle($arr, 'm_font_border_width');
            $arr = self::removeEle($arr, 'font_border_style');
            $arr = self::removeEle($arr, 'm_font_border_style');
            $arr = self::removeEle($arr, 'font_border_color');
            $arr = self::removeEle($arr, 'm_font_border_color');
            $arr = self::removeEle($arr, 'image_width');
            $arr = self::removeEle($arr, 'image_height');
            $arr = self::removeEle($arr, 'image_scale');
            $arr = self::removeEle($arr, 'video_autoplay');
            $arr = self::removeEle($arr, 'video_force_rewind');
            $arr = self::removeEle($arr, 'video_hide_controls');
            $arr = self::removeEle($arr, 'video_mute');
            
            $arr = self::removeEle($arr, 'button_bgcolor');
            $arr = self::removeEle($arr, 'm_button_bgcolor');
            $arr = self::removeEle($arr, 'button_labelcolor');
            $arr = self::removeEle($arr, 'm_button_labelcolor');
            $arr = self::removeEle($arr, 'button_borderwidth');
            $arr = self::removeEle($arr, 'm_button_borderwidth');
            $arr = self::removeEle($arr, 'button_borderstyle');
            $arr = self::removeEle($arr, 'm_button_borderstyle');
            $arr = self::removeEle($arr, 'button_bordercolor');
            $arr = self::removeEle($arr, 'm_button_bordercolor');
            $arr = self::removeEle($arr, 'button_boxshadowcolor');
            $arr = self::removeEle($arr, 'm_button_boxshadowcolor');
            $arr = self::removeEle($arr, 'button_hover_labelcolor');
            $arr = self::removeEle($arr, 'm_button_hover_labelcolor');
            $arr = self::removeEle($arr, 'button_hover_borderwidth');
            $arr = self::removeEle($arr, 'm_button_hover_borderwidth');
            $arr = self::removeEle($arr, 'button_hover_borderstyle');
            $arr = self::removeEle($arr, 'm_button_hover_borderstyle');
            $arr = self::removeEle($arr, 'button_hover_bordercolor');
            $arr = self::removeEle($arr, 'm_button_hover_bordercolor');
            $arr = self::removeEle($arr, 'button_hover_boxshadowcolor');
            $arr = self::removeEle($arr, 'm_button_hover_boxshadowcolor');
            
            $arr = self::removeEle($arr, 'position');
            $arr = self::removeEle($arr, 'ele_width');
            $arr = self::removeEle($arr, 'm_ele_width');
            $arr = self::removeEle($arr, 'ele_height');
            $arr = self::removeEle($arr, 'm_ele_height');
            $arr = self::removeEle($arr, 'button_hover_bgcolor');
            $arr = self::removeEle($arr, 'm_button_hover_bgcolor');
            $arr = self::removeEle($arr, 'bradius_type');
            $arr = self::removeEle($arr, 'm_bradius_type');
            $arr = self::removeEle($arr, 'bradius_top');
            $arr = self::removeEle($arr, 'm_bradius_top');
            $arr = self::removeEle($arr, 'bradius_right');
            $arr = self::removeEle($arr, 'm_bradius_right');
            $arr = self::removeEle($arr, 'bradius_bottom');
            $arr = self::removeEle($arr, 'm_bradius_bottom');
            $arr = self::removeEle($arr, 'bradius_left');
            $arr = self::removeEle($arr, 'm_bradius_left');
            $arr = self::removeEle($arr, 'data_angle');
            $arr = self::removeEle($arr, 'm_data_angle');
            $arr = self::removeEle($arr, 'data_xaix');
            $arr = self::removeEle($arr, 'm_data_xaix');
            $arr = self::removeEle($arr, 'data_yaix');
            $arr = self::removeEle($arr, 'm_data_yaix');
            $arr = self::removeEle($arr, 'halign');
            $arr = self::removeEle($arr, 'm_halign');
            $arr = self::removeEle($arr, 'valign');
            $arr = self::removeEle($arr, 'm_valign');
            $arr = self::removeEle($arr, 'max_width');
            $arr = self::removeEle($arr, 'm_max_width');
            $arr = self::removeEle($arr, 'max_height');
            $arr = self::removeEle($arr, 'm_max_height');
            $arr = self::removeEle($arr, 'align_behave');
            $arr = self::removeEle($arr, 'm_align_behave');
            $arr = self::removeEle($arr, 'full_width');
            $arr = self::removeEle($arr, 'm_full_width');
            $arr = self::removeEle($arr, 'full_height');
            $arr = self::removeEle($arr, 'm_full_height');
            $arr = self::removeEle($arr, 'white_space');
            $arr = self::removeEle($arr, 'm_white_space');
            $arr = self::removeEle($arr, 'inner_html');
            $arr = self::removeEle($arr, 'button_text');
            $arr = self::removeEle($arr, 'data_shortcode');
            $arr = self::removeEle($arr, 'icon_source');
            $arr = self::removeEle($arr, 'hideDefinedEleAfter');
            $arr = self::removeEle($arr, 'custom_css');
            $arr = self::removeEle($arr, 'attr_id');
            $arr = self::removeEle($arr, 'attr_class');
            $arr = self::removeEle($arr, 'attr_title');
            $arr = self::removeEle($arr, 'attr_rel');
            $arr = self::removeEle($arr, 'link');
            $arr = self::removeEle($arr, 'link_new_tab');
            $arr = self::removeEle($arr, 'image_alt');
            $arr = self::removeEle($arr, 'image_title');
            $arr = self::removeEle($arr, 'video_link');
            $arr = self::removeEle($arr, 'video_html5_mp4_video_link');
            $arr = self::removeEle($arr, 'video_html5_webm_video_link');
            $arr = self::removeEle($arr, 'video_html5_ogv_video_link');
            $arr = self::removeEle($arr, 'video_html5_poster_url');
            $arr = self::removeEle($arr, 'video_width');
            $arr = self::removeEle($arr, 'video_height');
            $arr = self::removeEle($arr, 'video_full_width');
            $arr = self::removeEle($arr, 'video_force_cover');
            $arr = self::removeEle($arr, 'video_loop');
            $arr = self::removeEle($arr, 'video_autoplay_firsttime');
            $arr = self::removeEle($arr, 'video_allow_fullscreen');
            $arr = self::removeEle($arr, 'next_slide_on_video_end');
            $arr = self::removeEle($arr, 'video_show_poser_pause');
            $arr = self::removeEle($arr, 'video_preview_img_alt');
            $arr = self::removeEle($arr, 'video_preview_img_title');
            $arr = self::removeEle($arr, 'video_preview_img_src');
            $arr = self::removeEle($arr, 'button_text');
            $arr = self::removeEle($arr, 'data_delay');
            $arr = self::removeEle($arr, 'data_time');
            $arr = self::removeEle($arr, 'data_in');
            $arr = self::removeEle($arr, 'data_out');
            $arr = self::removeEle($arr, 'data_easeIn');
            $arr = self::removeEle($arr, 'data_easeOut');
            $arr = self::removeEle($arr, 'data_ignoreEaseOut');
            $arr = self::removeEle($arr, 'video_is_preview_set');
            $arr = self::removeEle($arr, 'button_style');
            $arr = self::removeEle($arr, 'link_id');
            $arr = self::removeEle($arr, 'link_class');
            $arr = self::removeEle($arr, 'link_title');
            $arr = self::removeEle($arr, 'link_rel');
            $arr = self::removeEle($arr, 'font_family_group');
            $arr = self::removeEle($arr, 'font_decoration');
            $arr = self::removeEle($arr, 'font_color_hover');
            $arr = self::removeEle($arr, 'background_color');
            $arr = self::removeEle($arr, 'background_color_hover');
            $arr = self::removeEle($arr, 'individual_border');
            $arr = self::removeEle($arr, 'individual_border_hover');
            $arr = self::removeEle($arr, 'border_top_width');
            $arr = self::removeEle($arr, 'border_top_style');
            $arr = self::removeEle($arr, 'border_top_color');
            $arr = self::removeEle($arr, 'border_left_width');
            $arr = self::removeEle($arr, 'border_left_style');
            $arr = self::removeEle($arr, 'border_left_color');
            $arr = self::removeEle($arr, 'border_right_width');
            $arr = self::removeEle($arr, 'border_right_style');
            $arr = self::removeEle($arr, 'border_right_color');
            $arr = self::removeEle($arr, 'border_bottom_width');
            $arr = self::removeEle($arr, 'border_bottom_style');
            $arr = self::removeEle($arr, 'border_bottom_color');
            $arr = self::removeEle($arr, 'border_top_width_hover');
            $arr = self::removeEle($arr, 'border_top_style_hover');
            $arr = self::removeEle($arr, 'border_top_color_hover');
            $arr = self::removeEle($arr, 'border_left_width_hover');
            $arr = self::removeEle($arr, 'border_left_style_hover');
            $arr = self::removeEle($arr, 'border_left_color_hover');
            $arr = self::removeEle($arr, 'border_right_width_hover');
            $arr = self::removeEle($arr, 'border_right_style_hover');
            $arr = self::removeEle($arr, 'border_right_color_hover');
            $arr = self::removeEle($arr, 'border_bottom_width_hover');
            $arr = self::removeEle($arr, 'border_bottom_style_hover');
            $arr = self::removeEle($arr, 'border_bottom_color_hover');
            $arr = self::removeEle($arr, 'border_top_left_radius');
            $arr = self::removeEle($arr, 'border_top_right_radius');
            $arr = self::removeEle($arr, 'border_bottom_right_radius');
            $arr = self::removeEle($arr, 'border_bottom_left_radius');
            $arr = self::removeEle($arr, 'box_shadow_hoffset');
            $arr = self::removeEle($arr, 'box_shadow_voffset');
            $arr = self::removeEle($arr, 'box_shadow_blur');
            $arr = self::removeEle($arr, 'box_shadow_spread');
            $arr = self::removeEle($arr, 'box_shadow_color');
            $arr = self::removeEle($arr, 'box_shadow_type');
            $arr = self::removeEle($arr, 'box_shadow_hoffset_hover');
            $arr = self::removeEle($arr, 'box_shadow_voffset_hover');
            $arr = self::removeEle($arr, 'box_shadow_blur_hover');
            $arr = self::removeEle($arr, 'box_shadow_spread_hover');
            $arr = self::removeEle($arr, 'box_shadow_color_hover');
            $arr = self::removeEle($arr, 'box_shadow_type_hover');
            $arr = self::removeEle($arr, 'rotate_angle');
            $arr = self::removeEle($arr, 'layer_behavior');
            $arr = self::removeEle($arr, 'layer_alignment');
            $arr = self::removeEle($arr, 'layer_verticle_alignment');
            $arr = self::removeEle($arr, 'animation_ease_in');
            $arr = self::removeEle($arr, 'animation_ease_out');
            $arr = self::removeEle($arr, 'hide_under_width');
            $arr = self::removeEle($arr, 'show_on_desktop_view');
            $arr = self::removeEle($arr, 'show_on_mobile_view');
            $arr = self::removeEle($arr, 'parallax_level');
            $arr = self::removeEle($arr, 'layer_3d_attach');
            $arr = self::removeEle($arr, 'button_type');
            $arr = self::removeEle($arr, 'video_fullscreen');
            $arr = self::removeEle($arr, 'video_forcecover');
            $arr = self::removeEle($arr, 'video_loopvideo');
            $arr = self::removeEle($arr, 'video_firsttime');
            $arr = self::removeEle($arr, 'video_allow_full_screen');
            $arr = self::removeEle($arr, 'video_next_slide');
            $arr = self::removeEle($arr, 'video_hide_control');
            $arr = self::removeEle($arr, 'video_poster_on_pause');
            $arr = self::removeEle($arr, 'button_type');
            $arr = self::removeEle($arr, 'guides');
            $arr = self::removeEle($arr, 'innerOffsetX');
            $arr = self::removeEle($arr, 'innerOffsetY');
            $arr = self::removeEle($arr, 'width');
            $arr = self::removeEle($arr, 'height');
            $arr = self::removeEle($arr, 'x_position');
            $arr = self::removeEle($arr, 'y_position');
            $arr = self::removeEle($arr, 'x_aix');
            $arr = self::removeEle($arr, 'y_aix');
        } else if ($type == 'slide') {

            $arr = self::removeEle($arr, 'background_type_image');
            $arr = self::removeEle($arr, 'background_type_color');
            $arr = self::removeEle($arr, 'background_property_position');
            $arr = self::removeEle($arr, 'background_property_position_x');
            $arr = self::removeEle($arr, 'background_property_position_y');
            $arr = self::removeEle($arr, 'background_repeat');
            $arr = self::removeEle($arr, 'background_property_size');
            $arr = self::removeEle($arr, 'background_property_size_x');
            $arr = self::removeEle($arr, 'background_property_size_y');
            $arr = self::removeEle($arr, 'background_color_overlay');
            $arr = self::removeEle($arr, 'background_pattern_overlay');
            $arr = self::removeEle($arr, 'data_in');
            $arr = self::removeEle($arr, 'data_out');
            $arr = self::removeEle($arr, 'data_easeOut');
            $arr = self::removeEle($arr, 'slide_name');
            $arr = self::removeEle($arr, 'overlay');
            $arr = self::removeEle($arr, 'attributes');
            $arr = self::removeEle($arr, 'kenburns');
            $arr = self::removeEle($arr, 'parallax_level');
            $arr = self::removeEle($arr, 'slot_amount');
            $arr = self::removeEle($arr, 'slot_rotation');
            $arr = self::removeEle($arr, 'animation_in');
            $arr = self::removeEle($arr, 'animation_out');
            $arr = self::removeEle($arr, 'description');
            
            //background
            if(isset($arr['background']) && isset($arr['background']['bggradient'])) unset($arr['background']['bggradient']);
            if(isset($arr['background']) && isset($arr['background']['feature_image'])) unset($arr['background']['feature_image']);
            if(isset($arr['background']) && isset($arr['background']['youtube'])) unset($arr['background']['youtube']);
            if(isset($arr['background']) && isset($arr['background']['vimeo'])) unset($arr['background']['vimeo']);
            if(isset($arr['background']) && isset($arr['background']['html5'])) unset($arr['background']['html5']);
            if(isset($arr['background']) && isset($arr['background']['image']) && isset($arr['background']['image']['alt'])) unset($arr['background']['image']['alt']);
            if(isset($arr['background']) && isset($arr['background']['image']) && isset($arr['background']['image']['title'])) unset($arr['background']['image']['title']);
            
        } else if ($type == 'slider') {

            $arr = self::removeEle($arr, 'startWidth');
            $arr = self::removeEle($arr, 'startHeight');
            $arr = self::removeEle($arr, 'automaticSlide');
            $arr = self::removeEle($arr, 'showLoader');
            $arr = self::removeEle($arr, 'loader_type');
            $arr = self::removeEle($arr, 'loaderClass');
            $arr = self::removeEle($arr, 'loader_image');
            $arr = self::removeEle($arr, 'loader_image_width');
            $arr = self::removeEle($arr, 'showControls');
            $arr = self::removeEle($arr, 'controlsClass');
            $arr = self::removeEle($arr, 'showNavigation');
            $arr = self::removeEle($arr, 'navigationClass');
            $arr = self::removeEle($arr, 'navigationPosition');
            $arr = self::removeEle($arr, 'enableSwipe');
            $arr = self::removeEle($arr, 'showTimerBar');
            $arr = self::removeEle($arr, 'showShadowBar');
            $arr = self::removeEle($arr, 'shadowClass');
            $arr = self::removeEle($arr, 'pauseOnHover');
            $arr = self::removeEle($arr, 'randomSlide');
            $arr = self::removeEle($arr, 'background_opacity');
            $arr = self::removeEle($arr, 'loader_image_height');
            $arr = self::removeEle($arr, 'timerBarPosition');
            $arr = self::removeEle($arr, 'beforeStart');
            $arr = self::removeEle($arr, 'beforeSetResponsive');
            $arr = self::removeEle($arr, 'beforeSlideStart');
            $arr = self::removeEle($arr, 'beforePause');
            $arr = self::removeEle($arr, 'beforeResume');
            $arr = self::removeEle($arr, 'forcefullwidth');
            $arr = self::removeEle($arr, 'mobileCustomSize');
            $arr = self::removeEle($arr, 'mobileGridWidth');
            $arr = self::removeEle($arr, 'mobileGridHeight');
            $arr = self::removeEle($arr, 'post');
            $arr = self::removeEle($arr, 'hideSliderAfter');
            $arr = self::removeEle($arr, 'hideDefinedEleAfter');
            $arr = self::removeEle($arr, 'hideAllEleAfter');
            $arr = self::removeEle($arr, 'hideArrows');
            $arr = self::removeEle($arr, 'hideBullets');
            $arr = self::removeEle($arr, 'beforeSliderResize');
            $arr = self::removeEle($arr, 'hideNavigation');
            $arr = self::removeEle($arr, 'type');
            $arr = self::removeEle($arr, 'force_fullwidth');
            $arr = self::removeEle($arr, 'mobile_custom_size');
            $arr = self::removeEle($arr, 'mobile_grid_width');
            $arr = self::removeEle($arr, 'mobile_grid_height');
            $arr = self::removeEle($arr, 'random_slide');
            $arr = self::removeEle($arr, 'parallax');
            $arr = self::removeEle($arr, 'show_timer_bar');
            $arr = self::removeEle($arr, 'timer_bar_position');
            $arr = self::removeEle($arr, 'hide_slider_after');
            $arr = self::removeEle($arr, 'hide_defined_ele_after');
            $arr = self::removeEle($arr, 'hide_all_ele_after');
            $arr = self::removeEle($arr, 'before_start');
            $arr = self::removeEle($arr, 'before_slider_resize');
            $arr = self::removeEle($arr, 'slider_type');
            
            //Loader
            if(isset($arr['loader']) && isset($arr['loader']['enable'])) unset($arr['loader']['enable']);
            if(isset($arr['loader']) && isset($arr['loader']['width'])) unset($arr['loader']['width']);
            if(isset($arr['loader']) && isset($arr['loader']['height'])) unset($arr['loader']['height']);
            
            //Arrows
            if(isset($arr['navigation']) && isset($arr['navigation']['arrows']) && isset($arr['navigation']['arrows']['hideUnder'])) unset($arr['navigation']['arrows']['hideUnder']);
            if(isset($arr['navigation']) && isset($arr['navigation']['arrows']) && isset($arr['navigation']['arrows']['left'])) unset($arr['navigation']['arrows']['left']);
            if(isset($arr['navigation']) && isset($arr['navigation']['arrows']) && isset($arr['navigation']['arrows']['right'])) unset($arr['navigation']['arrows']['right']);
            
            //Bullets
            if(isset($arr['navigation']) && isset($arr['navigation']['bullets']) && isset($arr['navigation']['bullets']['hideUnder'])) unset($arr['navigation']['bullets']['hideUnder']);
            if(isset($arr['navigation']) && isset($arr['navigation']['bullets']) && isset($arr['navigation']['bullets']['hide_under'])) unset($arr['navigation']['bullets']['hide_under']);
            if(isset($arr['navigation']) && isset($arr['navigation']['bullets']) && isset($arr['navigation']['bullets']['direction'])) unset($arr['navigation']['bullets']['direction']);
            if(isset($arr['navigation']) && isset($arr['navigation']['bullets']) && isset($arr['navigation']['bullets']['gap'])) unset($arr['navigation']['bullets']['gap']);
            if(isset($arr['navigation']) && isset($arr['navigation']['bullets']) && isset($arr['navigation']['bullets']['vPos'])) unset($arr['navigation']['bullets']['vPos']);
            if(isset($arr['navigation']) && isset($arr['navigation']['bullets']) && isset($arr['navigation']['bullets']['hOffset'])) unset($arr['navigation']['bullets']['hOffset']);
            if(isset($arr['navigation']) && isset($arr['navigation']['bullets']) && isset($arr['navigation']['bullets']['vOffset'])) unset($arr['navigation']['bullets']['vOffset']);
        }
        return $arr;
    }

    /**
     * Convert pt,em into px
     *
     * @since 1.3
     * @param type $str
     * @return int|string
     */
    public static function avsConvertToPX($str = '') {
        if (trim($str) == 'undefined' || trim($str) == '' || trim($str) == 0)
            return 0;

        $type = substr(strtolower($str), -2);
        $ori = floatval(substr(strtolower($str), 0, -2));

        switch ($type) {
            case 'px':
                return $ori;
                break;

            case 'pt':
                return ceil(floatval(($ori * 8) / 6));
                break;

            case 'em':
                return ceil(floatval(($ori * 8) / 0.5));
                break;

            default: if (strrpos($type, '%') !== false) {
                    $ori = floatval(substr(strtolower($str), 0, -1));
                    return ceil(floatval(($ori * 8) / 50));
                } else {
                    return '';
                }
                break;
        }
    }

    /**
     * Filter value from old to new
     *
     * @since 1.3
     * @param string $str
     * @param string $type
     * @return array $newVal
     */
    public static function filterVal($str, $type) {

        if ($type == 'animation') {

            $old_arr = array(
                'fadeleft' => 'fadeleft',
                'faderight' => 'faderight',
                'fadeup' => 'fadeup',
                'fadedown' => 'fadedown',
                'fadesmallleft' => 'fadesmallleft',
                'fadesmallright' => 'fadesmallright',
                'fadesmallup' => 'fadesmallup',
                'fadesmalldown' => 'fadesmalldown',
                'slideleft' => 'slideleft',
                'slideright' => 'slideright',
                'slideup' => 'slideup',
                'slidedown' => 'slidedown',
            );
        } else if ($type == 'link') {

            $old_arr = array(
                '1' => 'new_tab',
                '0' => 'same_tab',
            );
        } else if ($type == 'num') {

            $old_arr = array(
                'Y' => '1',
                'N' => '0',
            );
        } else if ($type == 'bulletpos') {

            $old_arr = array(
                'bl' => 'left',
                'bc' => 'center',
                'br' => 'right',
            );
        } else if ($type == 'arrows') {

            $old_arr = array(
                'control1' => 'arrows1',
                'control2' => 'arrows2',
                'control3' => 'arrows3',
                'control4' => 'arrows4',
                'control5' => 'arrows5',
                'control6' => 'arrows6',
                'control7' => 'arrows7',
                'control8' => 'arrows8',
                'control9' => 'arrows9',
            );
        } else if($type == 'bgimage') {
            $old_arr = array(
                'featured_image' => 'transparent',
                'gradient_color' => 'transparent',
                'youtube_video' => 'transparent',
                'vimeo_video' => 'transparent',
                'html5_video' => 'transparent',
            );
        }
        $newVal = isset($old_arr[$str]) ? $old_arr[$str] : $str;
        
        if ($type == 'animation')
            $newVal = isset($old_arr[$str]) ? $old_arr[$str] : 'fade';
        
        if ($type == 'arrows' && strpos($newVal, 'arrows') === false) $newVal = 'arrows1';
        else if($type == 'arrows' && strpos($newVal, 'arrows') !== false) {
            $suff = explode('arrows',$newVal);
            if(isset($suff[1]) && $suff[1] > 9) $newVal = 'arrows1';
        }
        if ($type == 'bullets' && strpos($newVal, 'navigation') === false) $newVal = 'navigation1';
        else if($type == 'bullets' && strpos($newVal, 'navigation') !== false) {
            $suff = explode('navigation',$newVal);
            if(isset($suff[1]) && $suff[1] > 10) $newVal = 'navigation1';
        }
        if ($type == 'loader' && (strpos($newVal, 'loader') === false || $newVal == '')) { 
            $newVal = 'loader1';
        } else if($type == 'loader' && strpos($newVal, 'loader') !== false) {
            $suff = explode('loader',$newVal);
            if(isset($suff[1]) && $suff[1] > 6) $newVal = 'loader1';
        }

        return $newVal;
    }

    /**
    * Filter setting and update advanced style
    *
    * @since 1.3
    * @param array $settings
    * @return array $settings
    */
    public static function filterIndividualToAdvaceStyle($settings,$layer_type) {
        $advanced_style = array();
        $advanced_style[0] = (isset($settings['font_size']['desktop']) && $settings['font_size']['desktop'] != '') ? 'font-size:'.$settings['font_size']['desktop'].'px' : '';
        $advanced_style[1] = ((isset($settings['line_height']['desktop']) && $settings['line_height']['desktop'] != '') ? 'line-height:'.($settings['line_height']['desktop'] < 2 ? $settings['line_height']['desktop'] : $settings['line_height']['desktop'].'px') : '');
        $advanced_style[2] = (isset($settings['font_weight']['desktop']) && $settings['font_weight']['desktop'] != '') ? 'font-weight:'.$settings['font_weight']['desktop'].'' : '';
        $advanced_style[3] = (isset($settings['font_italic']['desktop']) && $settings['font_italic']['desktop'] != '') ? 'font-style:'.$settings['font_italic']['desktop'].'' : '';
        $advanced_style[4] = (isset($settings['text_transform']['desktop']) && $settings['text_transform']['desktop'] != '') ? 'text-transform:'.$settings['text_transform']['desktop'].'' : '';
        $advanced_style[5] = (isset($settings['letter_spacing']['desktop']) && $settings['letter_spacing']['desktop'] != '') ? 'letter-spacing:'.$settings['letter_spacing']['desktop'].'px' : '';
        $advanced_style[6] = (isset($settings['white_space']['desktop']) && $settings['white_space']['desktop'] != '') ? 'white-space:'.$settings['white_space']['desktop'].'' : '';
        $advanced_style[7] = (isset($settings['font_decoration']['desktop']) && $settings['font_decoration']['desktop'] != '') ? 'text-decoration:'.$settings['font_decoration']['desktop'].'' : '';
        $advanced_style[8] = (isset($settings['text_align']['desktop']) && $settings['text_align']['desktop'] != '') ? 'text-align:'.$settings['text_align']['desktop'].'' : '';
        $advanced_style[9] = (isset($settings['width']['desktop']) && $settings['width']['desktop'] != '' && $settings['width']['desktop'] != 'auto') ? 'width:'.$settings['width']['desktop'].'px' : '';
        $advanced_style[10] = (isset($settings['height']['desktop']) && $settings['height']['desktop'] != '' && $settings['height']['desktop'] != 'auto') ? 'height:'.$settings['height']['desktop'].'px' : '';
        $advanced_style[11] = (isset($settings['padding_top']['desktop']) && $settings['padding_top']['desktop'] != '') ? 'padding-top:'.$settings['padding_top']['desktop'].'px' : '';
        $advanced_style[12] = (isset($settings['padding_right']['desktop']) && $settings['padding_right']['desktop'] != '') ? 'padding-right:'.$settings['padding_right']['desktop'].'px' : '';
        $advanced_style[13] = (isset($settings['padding_bottom']['desktop']) && $settings['padding_bottom']['desktop'] != '') ? 'padding-bottom:'.$settings['padding_bottom']['desktop'].'px' : '';
        $advanced_style[14] = (isset($settings['padding_left']['desktop']) && $settings['padding_left']['desktop'] != '') ? 'padding-left:'.$settings['padding_left']['desktop'].'px' : '';
        
        if($layer_type == 'text' || $layer_type == 'icon' || $layer_type == 'shape'){
            
            $advanced_style[15] = (isset($settings['border_top_left_radius']['desktop']) && $settings['border_top_left_radius']['desktop'] != '') ? 'border-top-left-radius:'.$settings['border_top_left_radius']['desktop'].'px' : '';
            $advanced_style[16] = (isset($settings['border_top_right_radius']['desktop']) && $settings['border_top_right_radius']['desktop'] != '') ? 'border-top-right-radius:'.$settings['border_top_right_radius']['desktop'].'px' : '';
            $advanced_style[17] = (isset($settings['border_bottom_right_radius']['desktop']) && $settings['border_bottom_right_radius']['desktop'] != '') ? 'border-bottom-right-radius:'.$settings['border_bottom_right_radius']['desktop'].'px' : '';
            $advanced_style[18] = (isset($settings['border_bottom_left_radius']['desktop']) && $settings['border_bottom_left_radius']['desktop'] != '') ? 'border-bottom-left-radius:'.$settings['border_bottom_left_radius']['desktop'].'px' : '';
            $advanced_style[19] = (isset($settings['border_top_width']['desktop']) && $settings['border_top_width']['desktop'] != '') ? 'border-top-width:'.$settings['border_top_width']['desktop'].'px' : '';
            $advanced_style[20] = (isset($settings['border_top_style']['desktop']) && $settings['border_top_style']['desktop'] != '') ? 'border-top-style:'.$settings['border_top_style']['desktop'].'' : '';
            $advanced_style[21] = (isset($settings['border_top_color']['desktop']) && $settings['border_top_color']['desktop'] != '') ? 'border-top-color:'.$settings['border_top_color']['desktop'].'' : '';
            $advanced_style[22] = (isset($settings['border_left_width']['desktop']) && $settings['border_left_width']['desktop'] != '') ? 'border-left-width:'.$settings['border_left_width']['desktop'].'px' : '';
            $advanced_style[23] = (isset($settings['border_left_style']['desktop']) && $settings['border_left_style']['desktop'] != '') ? 'border-left-style:'.$settings['border_left_style']['desktop'].'' : '';
            $advanced_style[24] = (isset($settings['border_left_color']['desktop']) && $settings['border_left_color']['desktop'] != '') ? 'border-left-color:'.$settings['border_left_color']['desktop'].'' : '';
            $advanced_style[25] = (isset($settings['border_right_width']['desktop']) && $settings['border_right_width']['desktop'] != '') ? 'border-right-width:'.$settings['border_right_width']['desktop'].'px' : '';
            $advanced_style[26] = (isset($settings['border_right_style']['desktop']) && $settings['border_right_style']['desktop'] != '') ? 'border-right-style:'.$settings['border_right_style']['desktop'].'' : '';
            $advanced_style[27] = (isset($settings['border_right_color']['desktop']) && $settings['border_right_color']['desktop'] != '') ? 'border-right-color:'.$settings['border_right_color']['desktop'].'' : '';
            $advanced_style[28] = (isset($settings['border_bottom_width']['desktop']) && $settings['border_bottom_width']['desktop'] != '') ? 'border-bottom-width:'.$settings['border_bottom_width']['desktop'].'px' : '';
            $advanced_style[29] = (isset($settings['border_bottom_style']['desktop']) && $settings['border_bottom_style']['desktop'] != '') ? 'border-bottom-style:'.$settings['border_bottom_style']['desktop'].'' : '';
            $advanced_style[30] = (isset($settings['border_bottom_color']['desktop']) && $settings['border_bottom_color']['desktop'] != '') ? 'border-bottom-color:'.$settings['border_bottom_color']['desktop'].'' : '';
            $advanced_style[31] = (isset($settings['font_color']['desktop']) && $settings['font_color']['desktop'] != '') ? 'color:'.$settings['font_color']['desktop'].'' : '';
            $advanced_style[32] = (isset($settings['background']['desktop']) && $settings['background']['desktop'] != '') ? 'background:'.$settings['background']['desktop'].'' : '';
            $advanced_style[33] = (isset($settings['background_color']['desktop']) && $settings['background_color']['desktop'] != '') ? 'background-color:'.$settings['background_color']['desktop'].'' : '';

            if(isset($settings['box_shadow_hoffset']['desktop']) && ($settings['box_shadow_hoffset']['desktop'] != '') && isset($settings['box_shadow_voffset']['desktop']) && ($settings['box_shadow_voffset']['desktop'] != '') && isset($settings['box_shadow_blur']['desktop']) && ($settings['box_shadow_blur']['desktop'] != '') && isset($settings['box_shadow_spread']['desktop']) && ($settings['box_shadow_spread']['desktop'] != '') && isset($settings['box_shadow_color']['desktop']) && ($settings['box_shadow_color']['desktop'] != '') && ($settings['box_shadow_type']['desktop'] != '')){
                $advanced_style[34] = 'box-shadow:'.$settings['box_shadow_hoffset']['desktop'].' '.$settings['box_shadow_voffset']['desktop'].' '.$settings['box_shadow_blur']['desktop'].' '.$settings['box_shadow_spread']['desktop'].' '.$settings['box_shadow_color']['desktop'].' '.$settings['box_shadow_type']['desktop'].'';
            }
        }
        if($layer_type == 'button'){
            if(isset($settings['button_bgcolor']) && $settings['button_bgcolor'] != ''){
                $advanced_style[35] = 'background:'.$settings['button_bgcolor'].'';
            }
            if(isset($settings['button_bgcolor']['desktop']) && $settings['button_bgcolor']['desktop'] != ''){
                $advanced_style[35] = 'background:'.$settings['button_bgcolor']['desktop'].'';
            }
            if(isset($settings['background_color']['desktop']) && $settings['background_color']['desktop'] != ''){
                $advanced_style[35] = 'background:'.$settings['background_color']['desktop'].'';
            }

            if(isset($settings['button_labelcolor']) && $settings['button_labelcolor'] != ''){
                $advanced_style[36] = 'color:'.$settings['button_labelcolor'].'';
            }
            if(isset($settings['button_labelcolor']['desktop']) && $settings['button_labelcolor']['desktop'] != ''){
                $advanced_style[36] = 'color:'.$settings['button_labelcolor']['desktop'].'';
            }
            if(isset($settings['font_color']['desktop']) && $settings['font_color']['desktop'] != ''){
                $advanced_style[36] = 'color:'.$settings['font_color']['desktop'].'';
            }

            if(isset($settings['button_bordercolor']) && $settings['button_bordercolor'] != ''){
                $advanced_style[37] = 'border-color:'.$settings['button_bordercolor'].'';
            }
            if(isset($settings['button_bordercolor']['desktop']) && $settings['button_bordercolor']['desktop'] != ''){
                $advanced_style[37] = 'border-color:'.$settings['button_bordercolor']['desktop'].'';
            }

            if(isset($settings['border_bottom_color']['desktop']) && $settings['border_bottom_color']['desktop'] != ''){
                $advanced_style[38] = 'border-bottom-color:'.$settings['border_bottom_color']['desktop'].'';
            }
            if(isset($settings['border_top_color']['desktop']) && $settings['border_top_color']['desktop'] != ''){
                $advanced_style[39] = 'border-top-color:'.$settings['border_top_color']['desktop'].'';
            }
            if(isset($settings['border_left_color']['desktop']) && $settings['border_left_color']['desktop'] != ''){
                $advanced_style[40] = 'border-left-color:'.$settings['border_left_color']['desktop'].'';
            }
            if(isset($settings['border_right_color']['desktop']) && $settings['border_right_color']['desktop'] != ''){
                $advanced_style[41] = 'border-right-color:'.$settings['border_right_color']['desktop'].'';
            }

            if(isset($settings['button_borderwidth']) && $settings['button_borderwidth'] != ''){
                $advanced_style[42] = 'border-width:'.$settings['button_borderwidth'].'';
            }
            if(isset($settings['button_borderwidth']['desktop']) && $settings['button_borderwidth']['desktop'] != ''){
                $advanced_style[42] = 'border-width:'.$settings['button_borderwidth']['desktop'].'';
            }

            if(isset($settings['border_bottom_width']['desktop']) && $settings['border_bottom_width']['desktop'] != ''){
                $advanced_style[43] = 'border-bottom-width:'.$settings['border_bottom_width']['desktop'].'';
            }
            if(isset($settings['border_top_width']['desktop']) && $settings['border_top_width']['desktop'] != ''){
                $advanced_style[44] = 'border-top-width:'.$settings['border_top_width']['desktop'].'';
            }
            if(isset($settings['border_left_width']['desktop']) && $settings['border_left_width']['desktop'] != ''){
                $advanced_style[45] = 'border-left-width:'.$settings['border_left_width']['desktop'].'';
            }
            if(isset($settings['border_right_width']['desktop']) && $settings['border_right_width']['desktop'] != ''){
                $advanced_style[46] = 'border-right-width:'.$settings['border_right_width']['desktop'].'';
            }

            if(isset($settings['button_borderstyle']) && $settings['button_borderstyle'] != ''){
                $advanced_style[47] = 'border-style:'.$settings['button_borderstyle'].'';
            }
            if(isset($settings['button_borderstyle']['desktop']) && $settings['button_borderstyle']['desktop'] != ''){
                $advanced_style[48] = 'border-style:'.$settings['button_borderstyle']['desktop'].'';
            }

            if(isset($settings['border_bottom_style']['desktop']) && $settings['border_bottom_style']['desktop'] != ''){
                $advanced_style[49] = 'border-bottom-style:'.$settings['border_bottom_style']['desktop'].'';
            }
            if(isset($settings['border_top_style']['desktop']) && $settings['border_top_style']['desktop'] != ''){
                $advanced_style[50] = 'border-top-style:'.$settings['border_top_style']['desktop'].'';
            }
            if(isset($settings['border_left_style']['desktop']) && $settings['border_left_style']['desktop'] != ''){
                $advanced_style[51] = 'border-left-style:'.$settings['border_left_style']['desktop'].'';
            }
            if(isset($settings['border_right_style']['desktop']) && $settings['border_right_style']['desktop'] != ''){
                $advanced_style[52] = 'border-right-style:'.$settings['border_right_style']['desktop'].'';
            }

            if(isset($settings['button_style']) && $settings['button_style'] != ''){
                if($settings['button_style'] == 'ovel'){
                    $advanced_style[53] = 'border-radius:50px';
                }
                if($settings['button_style'] == 'round'){
                    $advanced_style[53] = 'border-radius:5px';
                }
                if($settings['button_style'] == '3d'){
                    $advanced_style[53] = 'border-radius:5px';
                }
            }
        }
        
        $advanced_style[] = (isset($settings['font_size']) && !is_array($settings['font_size']) && $settings['font_size'] != '') ? 'font-size:'.$settings['font_size'].'px' : '';
        $advanced_style[] = ((isset($settings['line_height']) && !is_array($settings['line_height']) && $settings['line_height'] != '') ? 'line-height:'.($settings['line_height'] < 2 ? $settings['line_height'] : $settings['line_height'].'px') : '');
        $advanced_style[] = (isset($settings['font_color']) && !is_array($settings['font_color']) && $settings['font_color'] != '') ? 'color:'.$settings['font_color'].'' : '';
        $advanced_style[] = (isset($settings['background_color']) && !is_array($settings['background_color']) && $settings['background_color'] != '') ? 'background-color:'.$settings['background_color'].'' : '';
        
        $advanced_style1 = trim(implode(';', $advanced_style),';');
        $settings['fixed_style'] = $advanced_style1;
        return $settings;
    }

}

//end of the class
//init the static vars
AvartanSliderLiteWPFunctions::initStaticVars();

?>