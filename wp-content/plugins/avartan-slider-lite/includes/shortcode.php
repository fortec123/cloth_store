<?php
if( !defined( 'ABSPATH') ) exit();

class AvartansliderLiteShortcode {

    private $slider_data;
    private $slide_id;

    public function __construct() {
        $this->avsAddShortcode();
    }

    /**
     * check shortcode
     *
     * @since 1.3
     * @param string $atts
     */
    public function avsExtractShortcode($atts) {
        $a = shortcode_atts(array(
            'alias' => false,
                ), $atts);

        if (!$a['alias']) {
            return __( 'You have to insert a valid alias in the shortcode', 'avartan-slider-lite' );
        } else {
            return $this->avsSliderOutput($a['alias'], false);
        }
    }

    /**
     * Generate shortcode
     *
     * @since 1.3
     */
    private function avsAddShortcode() {
        add_shortcode('avartanslider', array(&$this, 'avsExtractShortcode'));
    }

    /**
    * return boolean
     *
     * @since 1.3
     * @param integer $str
     * @return bool
    */
    public function avsReturnBoolean($str){
           if(is_numeric($str)) {
               if($str == 0 || trim($str) == '')
                   return "false";
               else if($str == 1)
                   return "true";
           }
           return "false";

    }

    /**
     * Generate slider element with data
     *
     * @since 1.3
     * @param array $elements
     * @param bool $preview_slide
     */
    public function avsSliderElementDetails($elements,$preview_slide = false) {
        $ele_output = '';
        $loadFontArr = array();

        $elements = AvartanSliderLiteFunctions::convertStdClassToArray($elements);
        foreach ($elements as $element) {
            //Based on type slide element will display
            $element = AvartanSliderLiteWPFunctions::filterSettings($element,'layer');

            $element_type = AvartanSliderLiteFunctions::getVal($element,'type','');
            if ($element_type != '') {
                if($element_type === 'shortcode' || $element_type === 'shape' || $element_type === 'button' || $element_type === 'icon')
                    continue;

                $element_style = array();
                $ele_dstyle = $ele_idle = $ele_custom_css = $font_family = $ele_css = '';

                $element_style['z-index'] = AvartanSliderLiteFunctions::getVal($element,'z_index',5);

                $ele_dstyle .=  ' data-zindex="'.AvartanSliderLiteFunctions::getVal($element, 'z_index',5).'"';
                $ele_dstyle .=  ' data-width="'.AvartanSliderLiteFunctions::getVal($element, 'width','auto').'"'.
                                ' data-height="'.AvartanSliderLiteFunctions::getVal($element, 'height','auto').'"';

                //behaviour, alignment
                $ele_dstyle .=  ' data-top="' . AvartanSliderLiteFunctions::getVal($element, 'y_position',0) . '"' .
                                ' data-left="' . AvartanSliderLiteFunctions::getVal($element, 'x_position',0) . '"' .
                                ' data-behavior="'.AvartanSliderLiteFunctions::getVal($element, 'alignto','grid').'"'.
                                ' data-halign="'.AvartanSliderLiteFunctions::getVal($element, 'align_hor','left').'"'.
                                ' data-valign="'.AvartanSliderLiteFunctions::getVal($element, 'align_vert','top').'"';

                //Animation
                $ele_dstyle .= ' data-in="' . trim(AvartanSliderLiteFunctions::getVal($element,'animation_in','fade')) . '"' .
                               ' data-out="' . trim(AvartanSliderLiteFunctions::getVal($element,'animation_out','fade')) . '"'.
                               ' data-delay="' . trim(AvartanSliderLiteFunctions::getVal($element,'animation_delay',300)) . '"'.
                               ' data-time="' . trim(AvartanSliderLiteFunctions::getVal($element,'animation_time',0)) . '"'.
                               ' data-ease-out="' . trim(AvartanSliderLiteFunctions::getVal($element,'animation_endspeed',300)) . '"'.
                               ' data-ease-in="' . AvartanSliderLiteFunctions::getVal($element, 'animation_startspeed', 300) . '"';

                //If Text, Button, Icon
                if($element_type === 'text') {
                    $ele_dstyle .=  ' data-fontsize="'.trim(AvartanSliderLiteFunctions::getVal($element,'font_size',18)).'"'.
                                    ' data-lineheight="'.trim(AvartanSliderLiteFunctions::getVal($element,'line_height',27)).'"' .
                                    ' data-color="'.trim(AvartanSliderLiteFunctions::getVal($element,'font_color','#000000')).'"'.
                                    ' data-background="'.trim(AvartanSliderLiteFunctions::getVal($element,'background_color','')).'"';

                    $element_style['font-size'] = trim(AvartanSliderLiteFunctions::getVal($element,'font_size',18)).'px';
                    $element_style['line-height'] = trim(AvartanSliderLiteFunctions::getVal($element,'line_height',27)).'px';
                    $element_style['color'] = trim(AvartanSliderLiteFunctions::getVal($element,'font_color','#000000'));
                    $element_style['background'] = trim(AvartanSliderLiteFunctions::getVal($element,'background_color',''));

                }

                //Get css for all common attribute
                $ele_width = AvartanSliderLiteFunctions::getVal($element,'width','auto');
                $ele_height = AvartanSliderLiteFunctions::getVal($element,'height','auto');

                //Get element id
                $element_id = trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_id', ''));
                if($element_id != ''){
                    $ele_id = 'id="' . $element_id . '" ';
                }else{
                    $ele_id = '';
                }
                //Get element class
                $element_class = trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_class', ''));
                $ele_class = 'as-layer'.( $element_class != '' ? ' '. $element_class : '');

                //Get element title
                $element_title = trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_title', ''));
                $ele_title = ($element_title != '' ? 'title="' . $element_title . '" ' : '');

                //Get element rel
                $element_rel = trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_rel', ''));
                $ele_rel = $element_rel !='' ? 'rel="' . $element_rel . '" ' : '';

                //Get element alt tag
                $element_alt = trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_alt', ''));
                $ele_alt = ( $element_alt !='' ? 'alt="' . $element_alt . '" ' : '');

                //Get element target
                $element_link_type = trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_link_type', 'nolink'));
                $element_target = trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_link_target', 'same_tab'));
                $element_link_url = stripslashes(trim(AvartanSliderLiteFunctions::getVal($element, 'attribute_link_url', '')));
                $ele_target = ( $element_link_type == 'simpleLink' && $element_target != 'same_tab') ? ' target="_blank"' : '';
                $ele_href = ($element_link_type == 'simpleLink') ? ' href="'. $element_link_url .'"' : '';

                if($element_link_type == 'simpleLink')
                    $ele_output .= '<a '.$ele_href.$ele_target;
                else
                    $ele_output .= '<div ';


                if($ele_id!='') { $ele_output .= ' ' . $ele_id; }

                if($ele_title!='') { $ele_output .= ' ' . $ele_title; }

                if($ele_rel!='') { $ele_output .= ' ' . $ele_rel; }

                if($ele_alt!='') { $ele_output .= ' ' . $ele_alt; }

                if($ele_dstyle!='') { $ele_output .= ' ' . $ele_dstyle; }

                foreach($element_style as $key => $value){
                    if($value != ''){
                        $ele_css .= $key.':'.$value.';';
                    }
                }
                $ele_css .= AvartanSliderLiteFunctions::getVal($element, 'advance_style', '');
                if($element_type == 'video'){
                    $ele_css .= "width :".$ele_width."px; height:".$ele_height."px;";
                }

                if($element_type == 'image'){
                    $ele_css .= "width :".$ele_width."px; height:".$ele_height."px;";
                }
                $ele_output .= ' style="';

                $ele_output .= $ele_css;

                $ele_output .= '"';
                $html = '';
                switch ($element_type) {
                    case 'text':
                        $ele_class .= ' as-text-layer';

                        $ele_output .= ' class="'. trim($ele_class) .'" ';

                        $ele_output .= '>';

                        $ele_output .= AvartanSliderLiteFunctions::getVal($element, 'text');

                        break;

                    case 'image':
                        $ele_class .= ' as-image-layer';

                        $ele_output .= ' class="'. $ele_class .'" ';

                        $ele_output .= '>' . "\n";

                        $ele_output .= '<img';

                        $ele_output .= ' src="' . AvartanSliderLiteFunctions::getVal($element, 'image_src') . '"' .
                                ' alt="' . $element_alt . '"'.
                                ' title="' . $element_title . '"';

                        $ele_output .= '/>' . "\n";

                        break;

                    case 'video':
                        $video_preview_img = '';

                        $fullscreen = $this->avsReturnBoolean(AvartanSliderLiteFunctions::getVal($element, 'video_fullscreen',0));
                        $fullscreen = (($fullscreen == 'true') ? 'fullscreenvideo' : 'none' );

                        $ele_video_type = AvartanSliderLiteFunctions::getVal($element, 'video_type', 'youtube');

                        $ele_video_settings = ' data-video-type =' . $ele_video_type;

                        $video_preview_img = AvartanSliderLiteFunctions::getVal($element, 'editor_video_image');
                        if(trim($video_preview_img) == '' && $ele_video_type == 'html5') {
                            $video_preview_img = AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/html5-video.png';
                        }
                        if($ele_video_type == 'youtube' || $ele_video_type == 'vimeo'){
                            $ele_video_settings .= ' data-video-id="'. AvartanSliderLiteFunctions::getVal($element, 'video_id','') .'"'.
                                                    ' data-preview-img="' . $video_preview_img . '"'.
                                                    ' data-fullscreenvideo=' . $fullscreen.
                                                    ' data-preview-title="' . AvartanSliderLiteFunctions::getVal($element, 'attribute_title') . '"';
                        }

                        if($ele_video_type == 'html5'){
                            $ele_video_settings .= ' data-preview-img="' . $video_preview_img . '"'.
                                                    ' data-preview-title="' . AvartanSliderLiteFunctions::getVal($element, 'attribute_title') . '"';
                            $html5_mp4_url = AvartanSliderLiteFunctions::getVal($element,'html5_mp4_url','');
                            $html5_ogv_url = AvartanSliderLiteFunctions::getVal($element,'html5_ogv_url','');
                            $html5_webm_url = AvartanSliderLiteFunctions::getVal($element,'html5_webm_url','');

                            if($html5_mp4_url != ''){
                                $ele_video_settings .= ' data-video-mp4="' . trim($html5_mp4_url) . '"';
                            }
                            if($html5_ogv_url != ''){
                                $ele_video_settings .= ' data-video-ogv="' . trim($html5_ogv_url) . '"';
                            }
                            if($html5_webm_url != ''){
                                $ele_video_settings .= ' data-video-webm="' . trim($html5_webm_url) . '"';
                            }

                        }

                        if($ele_video_type == 'youtube'){
                            $ele_video_settings .= ' data-video-attr="version=3&amp;enablejsapi=1&amp;html5=1&amp;hd=1&amp;wmode=opaque&amp;showinfo=0&amp;ref=0;"'.
                                                   ' data-video-speed="1"';
                        }

                        if($ele_video_type == 'vimeo'){
                            $ele_video_settings .= ' data-video-attr="title=0&amp;byline=0&amp;portrait=0&amp;api=1"';
                        }

                        $ele_class .= ' as-video-layer as-'.$ele_video_type.'-video';

                        $ele_output .= ' class="'. $ele_class .'" ';

                        if($ele_video_settings!='') { $ele_output .= ' ' . $ele_video_settings; }

                        $ele_output .= '>';
                        break;
                }
                $ele_output .= $html;

                if($element_link_type == 'simpleLink')
                    $ele_output .= '</a>' . "\n";
                else
                    $ele_output .= '</div>' . "\n";

            }
        }
        return $ele_output;
    }

    /**
     * Generate slider slides with data
     *
     * @since 1.3
     * @param array $params
     * @param array $elements
     * @param bool $preview
     */
    public function avsSlideDetail($params, $elements,$preview =false) {
        $output = '';
        if( $preview ){
            $preview_slide = true;
            $slide_index = AvartanSliderLiteFunctions::getVal($params, 'slide_id', '');
            $slider_id = AvartanSliderLiteFunctions::getVal($params, 'slider_id', '');
            $select = '*';
            $from = avsLiteGlobals::$avs_slider_tbl;
            $where = 'id = \'' . $slider_id . '\'';
            $as_DBObj = new AvartanSliderLiteCore();
            $slider = $as_DBObj->getRow($select,$from,$where);
            $this->slider_data = AvartanSliderLiteWPFunctions::filterSettings(maybe_unserialize($slider->slider_option),'slider');
            $slider_type = 'standard-slider';

        }else{
            $preview_slide = false;
            $slider_type = 'standard-slider';
            $slide_index = $this->slide_id;
        }

        //Get background type
        $bg_options = AvartanSliderLiteFunctions::getVal($params, 'background', array());
        $bg_type = AvartanSliderLiteFunctions::getVal($bg_options, 'type', 'image');
        $bgstyle = $bgvideo_settings = $bgposition_image ='';

        switch ($bg_type) {
            case 'solid_color' :
                //Get Background Solid Color
                $bgcolor = AvartanSliderLiteFunctions::getVal($bg_options, 'bgcolor', 'rgba(0,0,0,0)');
                $bgstyle .= 'background-color:'.$bgcolor.';';
                break;

            case 'image' :
                //Get Background Image
                $bgstyle .= 'background-color:transparent;';
                $bgImgOptions = AvartanSliderLiteFunctions::getVal($bg_options, 'image', array());
                $bgimage_src = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'source', '');
                $bdimage_alt = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'alt', '');
                $bdimage_title = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'title', '');
                if($bgimage_src != '') {
                    $bgstyle .= 'background-image:url('.$bgimage_src.');';
                    $bgimage_pos = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'position', 'center center');
                    if($bgimage_pos == 'percentage') {
                        $bgimage_posx = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'position_x', '0');
                        $bgimage_posy = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'position_y', '0');
                        $bgimage_pos = $bgimage_posx.'% '.$bgimage_posy.'%';
                    }
                    $bgstyle .= 'background-position:'.$bgimage_pos.';';

                    $bgimage_repeat =  AvartanSliderLiteFunctions::getVal($bgImgOptions, 'repeat', 'no-repeat');
                    $bgstyle .= 'background-repeat:'.$bgimage_repeat.';';

                    $bgimage_size = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'size', 'cover');
                    if($bgimage_size == 'percentage') {
                        $bgimage_sizex = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'size_x', '100');
                        $bgimage_sizey = AvartanSliderLiteFunctions::getVal($bgImgOptions, 'size_y', '100');
                        $bgimage_size = $bgimage_sizex.'% '.$bgimage_sizey.'%';
                    }
                    $bgstyle .= 'background-size:'.$bgimage_size.';';
                }
                break;
        }

        //Custom CSS
        $slide_custom_css = AvartanSliderLiteFunctions::getVal($params,'custom_css','');
        $remove_n = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), "<br/>", $slide_custom_css);
        $breaks = array("<br />", "<br>", "<br/>");
        $custom_css = str_ireplace($breaks, "\r\n", $remove_n);
        $bgstyle .= $custom_css;

        $output .= '<li' .
                ' data-ease-in="' . AvartanSliderLiteFunctions::getVal($params,'data_easeIn','') . '"' .
                ' data-ease-out="300"' .
                ' data-time="' . AvartanSliderLiteFunctions::getVal($params,'data_time','') . '"' .
                ' data-in="' . AvartanSliderLiteFunctions::getVal($params,'data_animation','') . '"' .
                ' data-out="fade"' .
                ' style="'. $bgstyle . '"' .
                '>' . "\n";

        //Get Elements of particular slide
        if(count($elements) > 0){
            $output .= $this->avsSliderElementDetails($elements,$preview_slide);
        }

        $output .= '</li>' . "\n";

        return $output;
    }


    /**
     * Generate slider
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $alias
     * @param type $echo
     * @param bool $preview
     */
    public function avsSliderOutput($alias, $echo, $preview=false) {
        global $wpdb;
        //Get the slider information
        $arrSlides = $loadFontArr = array();
        $select = '*';
        $from = avsLiteGlobals::$avs_slider_tbl;
        $where = 'alias = \'' . $alias . '\'';
        $as_DBObj = new AvartanSliderLiteCore();
        $wpObj = new AvartanSliderLiteWPFunctions();
        $slider = $as_DBObj->getRow($select,$from,$where);


        //Display error message if slider is not found
        if (!$slider) {
            if ($echo) {
                _e( 'The slider has not been found', 'avartan-slider-lite' );
                return;
            } else {
                return __( 'The slider has not been found', 'avartan-slider-lite' );
            }
        }
        $slider_id = AvartanSliderLiteFunctions::getVal($slider,'id','');
        $slider_option = AvartanSliderLiteWPFunctions::filterSettings(maybe_unserialize(AvartanSliderLiteFunctions::getVal($slider,'slider_option','')),'slider');
        $this->slider_data = $slider_option;

        $slider_type = 'standard-slider';
        $slider_width = AvartanSliderLiteFunctions::getVal($slider_option,'start_width','1280');
        $slider_height = AvartanSliderLiteFunctions::getVal($slider_option,'start_height','650');

        $output = '';
        $containerStyle = '';
        $containerStyle .= "height:".$slider_height."px;";

        //Set some settings for slider
        $output .= '<div style="display: none;" class="avartanslider-slider avartanslider-slider-' . AvartanSliderLiteFunctions::getVal($slider_option,'layout','') . ' avartanslider-slider-' . $alias . '" id="avartanslider-' . $slider_id . '">' . "\n";
        $output .= '<ul>' . "\n";

        //Get slide information
        $select = '*';
        $from = avsLiteGlobals::$avs_slides_tbl;
        $where = 'slider_parent = ' . $slider_id . ' ORDER BY position';
        $slides = $as_DBObj->fetch($select,$from,$where);

        $slides = $slides;

        foreach ($slides as $slide) {

            //Get slide setting and set the property
            $this->slide_id = AvartanSliderLiteFunctions::getVal($slide,'id','');
            $params = AvartanSliderLiteWPFunctions::filterSettings(maybe_unserialize(AvartanSliderLiteFunctions::getVal($slide,'params','')),'slide');
            $elements = array();
            //Get Elements of particular slide
            $layers = AvartanSliderLiteFunctions::getVal($slide,'layers','');
            if ($layers != '') {
                $elements = maybe_unserialize($layers);
            }
            $output .= $this->avsSlideDetail($params,$elements);
        }

        $output .= '</ul>' . "\n";

        $output .= '</div>' . "\n";


        //Get Responsiveness
        $startWidth = AvartanSliderLiteFunctions::getVal($slider_option,'start_width','1280');
        $startHeight = AvartanSliderLiteFunctions::getVal($slider_option,'start_height','650');

        //Get Loader
        $loader_options = AvartanSliderLiteFunctions::getVal($slider_option,'loader',array());
        $lType = AvartanSliderLiteFunctions::getVal($loader_options,'type','default');
        if($lType == 'default') {
            $lStyle = AvartanSliderLiteFunctions::getVal($loader_options,'style','loader1');
        } else {
            $lStyle = AvartanSliderLiteFunctions::getVal($loader_options,'style','');
        }

        $navigation_options = AvartanSliderLiteFunctions::getVal($slider_option,'navigation',array());

        //Get Arrows
        $arrows_options = AvartanSliderLiteFunctions::getVal($navigation_options,'arrows',array());
        $aEnable = AvartanSliderLiteFunctions::getVal($arrows_options,'enable',1);
        $arrowsStyle = AvartanSliderLiteFunctions::getVal($arrows_options,'style','arrows1');

        //Get Bullets
        $navBulletOptions = AvartanSliderLiteFunctions::getVal($navigation_options,'bullets',array());
        $bulletStyle = AvartanSliderLiteFunctions::getVal($navBulletOptions,'style','navigation1');
        $hPos = AvartanSliderLiteFunctions::getVal($navBulletOptions,'hPos','center');

        $output .= '<script type="text/javascript">' . "\n";
        $output .= '(function($) {' . "\n";
        $output .= '$(document).ready(function() {' . "\n";
        $output .= '$("#avartanslider-' . $slider_id . '").avartanSlider({' . "\n";
        $output .= 'layout: \'' . AvartanSliderLiteFunctions::getVal($slider_option,'layout','fixed') . '\',' . "\n";
        $output .= 'startWidth: ' . $startWidth . ',' . "\n";
        $output .= 'startHeight: ' . $startHeight . ',' . "\n";
        $output .= 'sliderBgColor: \'' . AvartanSliderLiteFunctions::getVal($slider_option,'background_type_color','transparent') . '\',' . "\n";
        $output .= 'automaticSlide: ' .  $this->avsReturnBoolean(AvartanSliderLiteFunctions::getVal($slider_option,'automatic_slide','0'))  . ',' . "\n";
        $output .= 'enableSwipe: ' . $this->avsReturnBoolean(AvartanSliderLiteFunctions::getVal($slider_option,'enable_swipe','0')) . ',' . "\n";
        $output .= 'showShadowBar: ' . $this->avsReturnBoolean(AvartanSliderLiteFunctions::getVal($slider_option,'show_shadow_bar','0')) . ',' . "\n";
        $output .= 'shadowClass: \'' . AvartanSliderLiteFunctions::getVal($slider_option,'shadow_class','') . '\',' . "\n";
        $output .= 'pauseOnHover: ' . $this->avsReturnBoolean(AvartanSliderLiteFunctions::getVal($slider_option,'pause_on_hover','0')) . ',' . "\n";
        $output .= 'loader : {'. "\n";
        $output .= 'type:'.'\''. $lType .'\''. ',' . "\n";
        $output .= 'style:'.'\''. $lStyle .'\''. ',' . "\n";
        $output .= '}' . ',' . "\n";
        $output .= 'navigation : {'. "\n";
        $output .= 'arrows: {'. "\n";
        $output .= 'enable:'. $this->avsReturnBoolean($aEnable) . ',' . "\n";
        $output .= 'style:'.'\''.$arrowsStyle.'\''. ',' . "\n";
        $output .= ' },' . "\n";
        $output .= 'bullets: {'. "\n";
        $output .= 'enable:'. $this->avsReturnBoolean(AvartanSliderLiteFunctions::getVal($navBulletOptions,'enable','1')) . ',' . "\n";
        $output .= 'style:'.'\''. $bulletStyle .'\''. ',' . "\n";
        $output .= 'hPos:\''.$hPos. '\',' . "\n";
        $output .= ' }' . "\n";
        $output .= '}' . ',' . "\n";
        $output .= '});' . "\n";
        $output .= '});' . "\n";
        $output .= '})(jQuery);' . "\n";
        $output .= '</script>' . "\n";
        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

}
new AvartansliderLiteShortcode();
?>
