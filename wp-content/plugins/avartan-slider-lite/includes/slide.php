<?php

if (!defined('ABSPATH'))
    exit();

class avsLiteSlide {

    private $id;
    private $slider_id;
    private $slide_position;
    private $slide_params;
    private $slide_layers;
    public static $core_obj;

    function __construct() {
        self::$core_obj = new AvartanSliderLiteCore();
    }

    /**
     * Get slide id
     *
     * @since 1.3
     */
    public function getID() {
        return $this->id;
    }

    /**
     * Get slider id
     *
     * @since 1.3
     */
    public function getSliderID() {
        return $this->slider_id;
    }

    /**
     * Get slide position
     *
     * @since 1.3
     */
    public function getSlidePosition() {
        return $this->slide_position;
    }

    /**
     *  Get slide layers
     *
     * @since 1.3
     */
    public function getLayers() {
        return $this->slide_layers;
    }

    /**
     * Get slider parameters
     *
     * @since 1.3
     */
    public function getParams() {
        return apply_filters('avs-slider-params', $this->slide_params, $this);
    }

    /**
     * Get single slide parameters
     *
     * @since 1.3
     * @param string $name
     * @param string $default
     */
    public function getParam($name, $default = null) {
        if ($default === null) {
            $default = '';
        }
        $val = AvartanSliderLiteFunctions::getVal($this->slide_params, $name, $default);
        return apply_filters('avs-slider-param', $val, $this, $name, $default);
    }

    /**
     * Set slide single parameter
     *
     * @since 1.3
     * @param string|integer $name
     * @param string|integer $value
     */
    public function setParam($name, $value) {
        $this->slide_params[$name] = $value;
    }

    /**
     * Return modified text
     *
     * @since 1.3
     * @param array $match
     * @return string
     */
    public function avsChangeLayerString($match){
        return 's:'. strlen($match[2]) .':"'. $match[2] .'";';
    }

    /**
     * Initialize Single slide
     *
     * @since 1.3
     * @param array $arrData
     */
    public function initSingleSlide($arrData) {
        $this->id = $arrData->id;
        $this->slider_id = $arrData->slider_parent;
        $this->slide_position = $arrData->position;
        $params = $arrData->params;
        $params = maybe_unserialize($params);
        $this->slide_params = AvartanSliderLiteWPFunctions::filterSettings($params,'slide');
        $layers = $arrData->layers;
        $layers = preg_replace_callback('!s:(\d+):"(.*?)";!', array(&$this, 'avsChangeLayerString'), $layers);
        $layers_array = array();
        $layers_array = maybe_unserialize($layers);
        $layers_arr = array();
        if(!empty($layers_array) && count($layers_array) > 0) {
            foreach($layers_array as $layer) {
                $layer_up = array();
                $layer_up = AvartanSliderLiteWPFunctions::filterSettings($layer,'layer');
                if(!empty($layer_up)) $layers_arr[] = $layer_up;
            }
        }
        $this->slide_layers = $layers_arr;
    }

    /**
     * Initialize single slide by id
     *
     * @since 1.3
     * @param integer $id
     */
    public function initSingleSlideById($id) {
        $select = '*';
        $from = avsLiteGlobals::$avs_slides_tbl;
        $where = 'id =' . $id;
        try {
            $response = self::$core_obj->fetch($select, $from, $where);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            exit;
        }
        $this->initSingleSlide($response[0]);
    }

    /**
     * Array for slide animation
     *
     * @since 1.3
     */
    public static function getSlideAminationAry() {
        $animation_array = array(
            'default' => array(__('default', 'avartan-slider-lite'), true),
            'Linear.easeNone' => array(__('Linear.easeNone', 'avartan-slider-lite'), false),
            'Power0.easeIn' => array(__('Power0.easeIn  (linear)', 'avartan-slider-lite'), false),
            'Power0.easeInOut' => array(__('Power0.easeInOut  (linear)', 'avartan-slider-lite'), false),
            'Power0.easeOut' => array(__('Power0.easeOut  (linear)', 'avartan-slider-lite'), false),
            'Power1.easeIn' => array(__('Power1.easeIn', 'avartan-slider-lite'), false),
            'Power1.easeInOut' => array(__('Power1.easeInOut', 'avartan-slider-lite'), false),
            'Power2.easeIn' => array(__('Power2.easeIn', 'avartan-slider-lite'), false),
            'Power2.easeInOut' => array(__('Power2.easeInOut', 'avartan-slider-lite'), false),
            'Power2.easeOut' => array(__('Power2.easeOut', 'avartan-slider-lite'), false),
            'Power3.easeIn' => array(__('Power3.easeIn', 'avartan-slider-lite'), false),
            'Power3.easeInOut' => array(__('Power3.easeInOut', 'avartan-slider-lite'), false),
            'Power3.easeOut' => array(__('Power3.easeOut', 'avartan-slider-lite'), false),
            'Power4.easeIn' => array(__('Power4.easeIn', 'avartan-slider-lite'), false),
            'Power4.easeInOut' => array(__('Power4.easeInOut', 'avartan-slider-lite'), false),
            'Power4.easeOut' => array(__('Power4.easeOut', 'avartan-slider-lite'), false),
            'Back.easeIn' => array(__('Back.easeIn', 'avartan-slider-lite'), false),
            'Back.easeInOut' => array(__('Back.easeInOut', 'avartan-slider-lite'), false),
            'Back.easeOut' => array(__('Back.easeOut', 'avartan-slider-lite'), false),
            'Bounce.easeIn' => array(__('Bounce.easeIn', 'avartan-slider-lite'), false),
            'Bounce.easeInOut' => array(__('Bounce.easeInOut', 'avartan-slider-lite'), false),
            'Bounce.easeOut' => array(__('Bounce.easeOut', 'avartan-slider-lite'), false),
            'Circ.easeIn' => array(__('Circ.easeIn', 'avartan-slider-lite'), false),
            'Circ.easeInOut' => array(__('Circ.easeInOut', 'avartan-slider-lite'), false),
            'Circ.easeOut' => array(__('Circ.easeOut', 'avartan-slider-lite'), false),
            'Elastic.easeIn' => array(__('Elastic.easeIn', 'avartan-slider-lite'), false),
            'Elastic.easeInOut' => array(__('Elastic.easeInOut', 'avartan-slider-lite'), false),
            'Elastic.easeOut' => array(__('Elastic.easeOut', 'avartan-slider-lite'), false),
            'Expo.easeIn' => array(__('Expo.easeIn', 'avartan-slider-lite'), false),
            'Expo.easeInOut' => array(__('Expo.easeInOut', 'avartan-slider-lite'), false),
            'Expo.easeOut' => array(__('Expo.easeOut', 'avartan-slider-lite'), false),
            'Sine.easeIn' => array(__('Sine.easeIn', 'avartan-slider-lite'), false),
            'Sine.easeInOut' => array(__('Sine.easeInOut', 'avartan-slider-lite'), false),
            'Sine.easeOut' => array(__('Sine.easeOut', 'avartan-slider-lite'), false),
            'SlowMo.ease' => array(__('SlowMo.ease', 'avartan-slider-lite'), false),
        );
        $animation_array = apply_filters('avs-animation-array', $animation_array);
        return $animation_array;
    }

    /**
     * Array for slide tab
     *
     * @since 1.3
     */
    public static function getSlideNavAry() {
        $slide_nav_array = array(
            'background' => array(
                'name' => __('Background', 'avartan-slider-lite'),
                'icon' => 'fas fa-th-large'
            ),
            'animation' => array(
                'name' => __('Animation', 'avartan-slider-lite'),
                'icon' => 'fas fa-bars'
            ),
            'action' => array(
                'name' => __('Action', 'avartan-slider-lite'),
                'icon' => 'fas fa-link'
            ),
            'attr-link' => array(
                'name' => __('Attributes', 'avartan-slider-lite'),
                'icon' => 'fas fa-cog'
            ),
            'advance' => array(
                'name' => __('Advance', 'avartan-slider-lite'),
                'icon' => 'fas fa-eye'
            ),

        );
        return apply_filters('slide-navigation-array', $slide_nav_array);
    }

    /**
     * Get slide setting array
     *
     * @since 1.3
     */
    public static function getSlideSettingAry() {
        $slide_select_options = array(
            'background' =>
            array(
                'background_type' => array(
                    'transparent' => array(__('Transparent', 'avartan-slider-lite'), true),
                    'solid_color' => array(__('Solid Color', 'avartan-slider-lite'), false),
                    'gradient_color' => array(__('Gradient Color', 'avartan-slider-lite'), false),
                    'featured_image' => array(__('Featured Image', 'avartan-slider-lite'), false),
                    'image' => array(__('Image', 'avartan-slider-lite'), false),
                    'youtube_video' => array(__('YouTube Video', 'avartan-slider-lite'), false),
                    'vimeo_video' => array(__('Vimeo Video', 'avartan-slider-lite'), false),
                    'html5_video' => array(__('HTML5 Video', 'avartan-slider-lite'), false),
                ),
                'bgoverlay_type' => array(
                    'solid_color' => array(__('Solid Color', 'avartan-slider-lite'), true),
                    'gradient_color' => array(__('Gradient Color', 'avartan-slider-lite'), false),
                ),
                'position' => array(
                    'center top' => array(__('Center Top', 'avartan-slider-lite'), false),
                    'center right' => array(__('Center Right', 'avartan-slider-lite'), false),
                    'center bottom' => array(__('Center Bottom', 'avartan-slider-lite'), false),
                    'center center' => array(__('Center Center', 'avartan-slider-lite'), true),
                    'left top' => array(__('Left Top', 'avartan-slider-lite'), false),
                    'left center' => array(__('Left Center', 'avartan-slider-lite'), false),
                    'left bottom' => array(__('Left Bottom', 'avartan-slider-lite'), false),
                    'right top' => array(__('Right Top', 'avartan-slider-lite'), false),
                    'right center' => array(__('Right Center', 'avartan-slider-lite'), false),
                    'right bottom' => array(__('Right Bottom', 'avartan-slider-lite'), false),
                    'percentage' => array('X%, Y%', false),
                ),
                'size' => array(
                    'cover' => array(__('Cover', 'avartan-slider-lite'), true),
                    'contain' => array(__('Contain', 'avartan-slider-lite'), false),
                    'percentage' => array(__('Percentage', 'avartan-slider-lite'), false),
                    'normal' => array(__('Normal', 'avartan-slider-lite'), false),
                ),
                'repeat' => array(
                    'no-repeat' => array(__('No Repeat', 'avartan-slider-lite'), true),
                    'repeat' => array(__('Repeat', 'avartan-slider-lite'), false),
                    'repeat-x' => array(__('Repeat-x', 'avartan-slider-lite'), false),
                    'repeat-y' => array(__('Repeat-y', 'avartan-slider-lite'), false),
                ),
                'pattern' => array(
                    'pattern0', 'pattern1', 'pattern2',
                    'pattern3', 'pattern4', 'pattern5',
                    'pattern6', 'pattern7', 'pattern8',
                    'pattern9', 'pattern10', 'pattern11',
                    'pattern12', 'pattern13', 'pattern14',
                    'pattern15', 'pattern16', 'pattern17',
                    'pattern18', 'pattern19', 'pattern20',
                    'pattern21', 'pattern22', 'pattern23',
                    'pattern24', 'pattern25', 'pattern26',
                    'pattern27', 'pattern28', 'pattern29',
                    'pattern30', 'pattern31', 'pattern32',
                    'pattern33', 'pattern34', 'pattern35',
                    'pattern36', 'pattern37', 'pattern38',
                    'pattern39', 'pattern40'
                ),
                'boolean' => array(
                    1 => array(__('On', 'avartan-slider-lite'), true),
                    0 => array(__('Off', 'avartan-slider-lite'), false),
                ),
            ),
        );
        $slide_select_options = apply_filters('slide-select-options', $slide_select_options);
        return $slide_select_options;
    }

    /**
     * Get all animation effects
     *
     * @since 1.3
    */
    public function getElementAnimationEffects(){
        $ele_animation_effect_list = array(
            "fade" => __('Fade','avartan-slider-lite'),
            "slideup" => __('Slide To Top','avartan-slider-lite'),
            "slidedown" => __('Slide To Bottom','avartan-slider-lite'),
            "slideright" => __('Slide To Right','avartan-slider-lite'),
            "slideleft" => __('Slide To Left','avartan-slider-lite'),
            "fadeup" => __('Fade To Top','avartan-slider-lite'),
            "fadedown" => __('Fade To Bottom','avartan-slider-lite'),
            "fadeleft" => __('Fade To Left','avartan-slider-lite'),
            "faderight" => __('Fade To Right','avartan-slider-lite'),
            "fadesmallup" => __('Fade Small Up','avartan-slider-lite'),
            "fadesmalldown" => __('Fade Small Down','avartan-slider-lite'),
            "fadesmallleft" => __('Fade Small Left','avartan-slider-lite'),
            "fadesmallright" => __('Fade Small Right','avartan-slider-lite'),
        );

        return $ele_animation_effect_list;
    }

   /**
    * Get all animation effects
    *
    * @since 1.3
    */
    public static function getAnimationEffects(){

        $animation_effect_list = array(
            "fade" => array('status' => true, 'name' => __('Fade','avartan-slider-lite')),
            "crossfade" => array('status' => false, 'name' => __('Fade Cross','avartan-slider-lite')),
            "fadethroughdark" => array('status' => false, 'name' => __('Fade Through Black','avartan-slider-lite')),
            "fadethroughlight" => array('status' => false, 'name' => __('Fade Through Light','avartan-slider-lite')),
            "fadethroughtransparent" => array('status' => false, 'name' => __('Fade Through Transparent','avartan-slider-lite')),
            "fadeup" => array('status' => false, 'name' => __('Fade From Top','avartan-slider-lite')),
            "fadedown" => array('status' => false, 'name' => __('Fade From Bottom','avartan-slider-lite')),
            "faderight" => array('status' => true, 'name' => __('Fade From Right','avartan-slider-lite')),
            "fadeleft" => array('status' => true, 'name' => __('Fade From Left','avartan-slider-lite')),
            "slideup" => array('status' => true, 'name' => __('Slide To Top','avartan-slider-lite')),
            "slidedown" => array('status' => true, 'name' => __('Slide To Bottom','avartan-slider-lite')),
            "slideright" => array('status' => true, 'name' => __('Slide To Right','avartan-slider-lite')),
            "slideleft" => array('status' => true, 'name' => __('Slide To Left','avartan-slider-lite')),
            "slidehorizontal" => array('status' => false, 'name' => __('Slide Horizontal (Next/Previous)','avartan-slider-lite')),
            "slidevertical" => array('status' => false, 'name' => __('Slide Vertical (Next/Previous)','avartan-slider-lite')),
            "slideoverup" => array('status' => false, 'name' => __('Slide Over To Top','avartan-slider-lite')),
            "slideoverdown" => array('status' => false, 'name' => __('Slide Over To Bottom','avartan-slider-lite')),
            "slideoverright" => array('status' => false, 'name' => __('Slide Over To Right','avartan-slider-lite')),
            "slideoverleft" => array('status' => false, 'name' => __('Slide Over To Left','avartan-slider-lite')),
            "slideoverhorizontal" => array('status' => false, 'name' => __('Slide Over Horizontal (Next/Previous)','avartan-slider-lite')),
            "slideoververtical" => array('status' => false, 'name' => __('Slide Over Vertical (Next/Previous)','avartan-slider-lite')),
            "slideremoveup" => array('status' => false, 'name' => __('Slide Remove To Top','avartan-slider-lite')),
            "slideremovedown" => array('status' => false, 'name' => __('Slide Remove To Bottom','avartan-slider-lite')),
            "slideremoveright" => array('status' => false, 'name' => __('Slide Remove To Right','avartan-slider-lite')),
            "slideremoveleft" => array('status' => false, 'name' => __('Slide Remove To Left','avartan-slider-lite')),
            "slideremovehorizontal" => array('status' => false, 'name' => __('Slide Remove Horizontal (Next/Previous)','avartan-slider-lite')),
            "slideremovevertical" => array('status' => false, 'name' => __('Slide Remove Vertical (Next/Previous)','avartan-slider-lite')),
            "boxslide" => array('status' => false, 'name' => __('Slide Boxes','avartan-slider-lite')),
            "slotslide-horizontal" => array('status' => false, 'name' => __('Fade Slots Horizontal','avartan-slider-lite')),
            "slotslide-vertical" => array('status' => false, 'name' => __('Slide Slots Vertical','avartan-slider-lite')),
            "boxfade" => array('status' => false, 'name' => __('Fade Boxes','avartan-slider-lite')),
            "slotfade-horizontal" => array('status' => false, 'name' => __('Fade Slots Horizontal','avartan-slider-lite')),
            "slotfade-vertical" => array('status' => false, 'name' => __('Fade Slots Vertical','avartan-slider-lite')),
            "parallaxtoright" => array('status' => false, 'name' => __('Parallax to Right','avartan-slider-lite')),
            "parallaxtoleft" => array('status' => false, 'name' => __('Parallax to Left','avartan-slider-lite')),
            "parallaxtotop" => array('status' => false, 'name' => __('Parallax to Top','avartan-slider-lite')),
            "parallaxtobottom" => array('status' => false, 'name' => __('Parallax to Bottom','avartan-slider-lite')),
            "parallaxhorizontal" => array('status' => false, 'name' => __('Parallax Horizontal','avartan-slider-lite')),
            "parallaxvertical" => array('status' => false, 'name' => __('Parallax Vertical','avartan-slider-lite')),
            "scaledownfromright" => array('status' => false, 'name' => __('Zoom Out and Fade From Right','avartan-slider-lite')),
            "scaledownfromleft" => array('status' => false, 'name' => __('Zoom Out and Fade From Left','avartan-slider-lite')),
            "scaledownfromtop" => array('status' => false, 'name' => __('Zoom Out and Fade From Top','avartan-slider-lite')),
            "scaledownfrombottom" => array('status' => false, 'name' => __('Zoom Out and Fade From Bottom','avartan-slider-lite')),
            "zoomout" => array('status' => false, 'name' => __('ZoomOut','avartan-slider-lite')),
            "zoomin" => array('status' => false, 'name' => __('ZoomIn','avartan-slider-lite')),
            "slotzoom-horizontal" => array('status' => false, 'name' => __('Zoom Slots Horizontal','avartan-slider-lite')),
            "slotzoom-vertical" => array('status' => false, 'name' => __('Zoom Slots Vertical','avartan-slider-lite')),
            "curtain-1" => array('status' => false, 'name' => __('Curtain from Left','avartan-slider-lite')),
            "curtain-2" => array('status' => false, 'name' => __('Curtain from Right','avartan-slider-lite')),
            "curtain-3" => array('status' => false, 'name' => __('Curtain from Middle','avartan-slider-lite')),
        );

        return $animation_effect_list;
    }

    /**
     * Validation Message for slide import
     *
     * @since 1.3
     */
    public function avsSlideValidationMessage(){
        global $avsSlideMessage;
        ?>
        <div class="notice notice-error">
            <p><?php echo $avsSlideMessage; ?></p>
        </div>
    <?php
    }

    /**
     * Get slide background style
     *
     * @since 1.3
     */
    public function avsGetSlideBG($all_slide_data){
        $bgstyle = "style=''";
        $bg_options = AvartanSliderLiteFunctions::getVal($all_slide_data,'background',array());
        $bgtype = AvartanSliderLiteFunctions::getVal($bg_options,'type','transparent');

        switch($bgtype) {
            case 'image':
                        $bg_img = AvartanSliderLiteFunctions::getVal($bg_options,'image',array());
                        $bg = AvartanSliderLiteFunctions::getVal($bg_img,'source','');
                        if($bg != ''){
                            $bgstyle = "style='background-image:url($bg);background-size: cover;'";
                        }
            break;
            case 'solid_color':
                        $bg = AvartanSliderLiteFunctions::getVal($bg_options,'bgcolor','transparent');
                        if($bg != ''){
                            $bgstyle = "style='background:$bg'";
                        }
            break;
        }
        return $bgstyle;
    }
}
