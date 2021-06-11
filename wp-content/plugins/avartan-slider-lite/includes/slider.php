<?php
if (!defined('ABSPATH'))
    exit();

class avsLiteSlider {

    private $id;
    private $title;
    private $alias;
    private $totalslide;
    private $settings;
    private $slider_setting_ary;
    private $slider_nav_array;
    public static $core_obj;

    function __construct() {
        self::$core_obj = new AvartanSliderLiteCore();
    }

    /**
     * Get slider id
     *
     * @since 1.3
     */
    function getId() {
        return $this->id;
    }

    /**
     * Get slider title
     *
     * @since 1.3
     */
    function getTitle() {
        return $this->title;
    }

    /**
     * Get slider alias
     *
     * @since 1.3
     */
    function getAlias() {
        return $this->alias;
    }

    /**
     * Get slider settings
     *
     * @since 1.3
     */
    function getSettings() {
        return $this->settings;
    }

    /**
     * Get total slides
     *
     * @since 1.3
     */
    function getTotalSlides() {
        return $this->totalslide;
    }

    /**
     * Array for slider setting tab
     *
     * @since 1.3
     */
    function getSliderNavAry() {
        $slider_nav_array = array(
            'layout' => array(
                'name' => __('Layout', 'avartan-slider-lite'),
                'icon' => 'fas fa-th-large'
            ),
            'general' => array(
                'name' => __('General', 'avartan-slider-lite'),
                'icon' => 'fas fa-cog'
            ),
            'visual' => array(
                'name' => __('Visual', 'avartan-slider-lite'),
                'icon' => 'fas fa-eye'
            ),
            'navigation' => array(
                'name' => __('Navigation', 'avartan-slider-lite'),
                'icon' => 'fas fa-bars'
            ),
            'parallax' => array(
                'name' => __('Parallax & 3D', 'avartan-slider-lite'),
                'icon' => 'fas fa-paragraph'
            ),
            'callbacks' => array(
                'name' => __('Callbacks', 'avartan-slider-lite'),
                'icon' => 'fas fa-exchange-alt'
            )
        );
        $this->slider_nav_array = apply_filters('slider-navigation-array', $slider_nav_array);
        return $this->slider_nav_array;
    }

    /**
     * Array for arrows, bullets , slider type ...
     *
     * @since 1.3
     */
    function getSliderSettingAry() {
        $slider_setting_ary = array(
            'type' => array(
                'standard' => array(__('Standard Slider', 'avartan-slider-lite'), false),
                'post' => array(__('Post Slider', 'avartan-slider-lite'), true),
            ),
            'post_source' => array(
                'default' => array(__('Default Post', 'avartan-slider-lite'), false),
                'specific' => array(__('Specific Post', 'avartan-slider-lite'), true),
            ),
            'post_sort_by' => array(
                'ID' => array(__('Post ID', 'avartan-slider-lite'), true),
                'date' => array(__('Date', 'avartan-slider-lite'), false),
                'title' => array(__('Title', 'avartan-slider-lite'), false),
                'name' => array(__('Slug', 'avartan-slider-lite'), false),
                'author' => array(__('Author', 'avartan-slider-lite'), false),
                'modified' => array(__('Last Modified', 'avartan-slider-lite'), false),
                'comment_count' => array(__('Number Of Comments', 'avartan-slider-lite'), false),
                'rand' => array(__('Random', 'avartan-slider-lite'), false),
                'menu_order' => array(__('Custom Order', 'avartan-slider-lite'), false),
                'none' => array(__('None', 'avartan-slider-lite'), false),
            ),
            'post_sort_dir' => array(
                'DESC' => array(__('Descending', 'avartan-slider-lite'), true),
                'ASC' => array(__('Ascending', 'avartan-slider-lite'), false),
            ),
            'layout' => array(
                'fixed' => array(__('Fixed', 'avartan-slider-lite'), true),
                'full-width' => array(__('Full Width', 'avartan-slider-lite'), false),
            ),
            'boolean' => array(
                1 => array(__('On', 'avartan-slider-lite'), true),
                0 => array(__('Off', 'avartan-slider-lite'), false),
            ),
            'shadow' => array(
                'shadow1', 'shadow2', 'shadow3',
            ),
            'arrows' => array(
                'arrows1' => '<img data-arrows-style="arrows1" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow1.png">',
                'arrows2' => '<img data-arrows-style="arrows2" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow2.png">',
                'arrows3' => '<img data-arrows-style="arrows3" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow3.png">',
                'arrows4' => '<img data-arrows-style="arrows4" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow4.png">',
                'arrows5' => '<img data-arrows-style="arrows5" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow5.png">',
                'arrows6' => '<img data-arrows-style="arrows6" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow6.png">',
                'arrows7' => '<img data-arrows-style="arrows7" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow7.png">',
                'arrows8' => '<img data-arrows-style="arrows8" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow8.png">',
                'arrows9' => '<img data-arrows-style="arrows9" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/arrows/arrow9.png">',
            ),
            'bullets' => array(
                'navigation1' => '<img data-bullets-style="navigation1" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation1.png">',
                'navigation2' => '<img data-bullets-style="navigation2" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation2.png">',
                'navigation3' => '<img data-bullets-style="navigation3" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation3.png">',
                'navigation4' => '<img data-bullets-style="navigation4" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation4.png">',
                'navigation5' => '<img data-bullets-style="navigation5" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation5.png">',
                'navigation6' => '<img data-bullets-style="navigation6" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation6.png">',
                'navigation7' => '<img data-bullets-style="navigation7" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation7.png">',
                'navigation8' => '<img data-bullets-style="navigation8" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation8.png">',
                'navigation9' => '<img data-bullets-style="navigation9" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation9.png">',
                'navigation10' => '<img data-bullets-style="navigation10" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/bullets/navigation10.png">'
            ),
            'navDirection' => array(
                'horizontal' => array(__('Horizontal', 'avartan-slider-lite'), true),
                'vertical' => array(__('Vertical', 'avartan-slider-lite'), false),
            ),
            'navHPosition' => array(
                'left' => array(__('Left', 'avartan-slider-lite'), false),
                'center' => array(__('Center', 'avartan-slider-lite'), true),
                'right' => array(__('Right', 'avartan-slider-lite'), false),
            ),
            'navVPosition' => array(
                'top' => array(__('Top', 'avartan-slider-lite'), false),
                'center' => array(__('Center', 'avartan-slider-lite'), false),
                'bottom' => array(__('Bottom', 'avartan-slider-lite'), true),
            ),
            'timerBarPosition' => array(
                'top_pos' => array(__('Top', 'avartan-slider-lite'), false),
                'bottom_pos' => array(__('Bottom', 'avartan-slider-lite'), true),
            ),
            'loaders' => array(
                'loader1' => '<img data-loader-style="loader1" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/loaders/loader1.gif">',
                'loader2' => '<img data-loader-style="loader2" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/loaders/loader2.gif">',
                'loader3' => '<img data-loader-style="loader3" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/loaders/loader3.gif">',
                'loader4' => '<img data-loader-style="loader4" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/loaders/loader4.gif">',
                'loader5' => '<img data-loader-style="loader5" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/loaders/loader5.gif">',
                'loader6' => '<img data-loader-style="loader6" src="'.AVARTAN_LITE_PLUGIN_URL.'/views/assets/images/loaders/loader6.gif">'
            ),
        );
        $this->slider_setting_ary = apply_filters('slider-setting-ary', $slider_setting_ary);
        return $this->slider_setting_ary;
    }

    /**
     * Default slider templates
     *
     * @since 1.3
     */
    function defaultTemplateArray() {
        $default_template = array(
            'casino' => array(
                'name' => __('Casino','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/casino-slider/',
                'zip' => 'casino_slider.zip'
            ),
            'smart-watch' => array(
                'name' => __('Smart Watch','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/smart-watch-slider/',
                'zip' => 'smart_watch_slider.zip'
            ),
            'shoes' => array(
                'name' => __('Shoes','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/shoes-slider/',
                'zip' => 'shoes.zip'
            ),
            'trend' => array(
                'name' => __('Trend','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/trend-slider/',
                'zip' => 'trend_slider.zip'
            ),
            'furniture' => array(
                'name' => __('Furniture','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/furniture-slider/',
                'zip' => 'furniture_slider.zip'
            ),
            'fashion' => array(
                'name' => __('Fashion','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/fashion-slider/',
                'zip' => 'fashion_slider.zip'
            ),
            'product' => array(
                'name' => __('Product','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/product-slider/',
                'zip' => 'product_slider.zip'
            ),
            'restaurant' => array(
                'name' => __('Restaurant','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/restaurant-slider/',
                'zip' => 'restaurant_slider.zip'
            ),
            'travel' => array(
                'name' => __('Travel','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/travel-slider/',
                'zip' => 'travel_slider.zip'
            ),
            'wedding' => array(
                'name' => __('Wedding','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/wedding-slider/',
                'zip' => 'wedding_slider.zip'
            ),
            'freebies' => array(
                'name' => __('Freebies','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/freebies-slider/',
                'zip' => 'freebies.zip'
            ),
            'branding-agency' => array(
                'name' => __('Branding Agency','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/branding-agency-slider/',
                'zip' => 'branding_agency.zip'
            ),
            'vehicles' => array(
                'name' => __('Vehicles','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/vehicles-slider/',
                'zip' => 'vehicles.zip'
            ),

            'interior' => array(
                'name' => __('Interior','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/interior-slider/',
                'zip' => 'interior_design.zip'
            ),
            'headphone' => array(
                'name' => __('Headphone','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/headphone-slider/',
                'zip' => 'headphone.zip'
            ),
            'car' => array(
                'name' => __('Car','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/car-slider/',
                'zip' => 'car_slider.zip'
            ),
            'web-product' => array(
                'name' => __('Web Product','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/web-product-slider/',
                'zip' => 'web_product_slider.zip'
            ),
            'yoga' => array(
                'name' => __('Yoga','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/yoga-slider/',
                'zip' => 'yoga_slider.zip'
            ),
            'transportation' => array(
                'name' => __('Transportation','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/transportation-slider/',
                'zip' => 'transportation_slider.zip'
            ),
            'music' => array(
                'name' => __('Music','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/music-slider/',
                'zip' => 'music_slider.zip'
            ),
            'sport' => array(
                'name' => __('Sport','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/sport-slider/',
                'zip' => 'sports.zip'
            ),
            'gujarat-tourisam' => array(
                'name' => __('Gujarat Tourisam','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/gujarat-tourisam/',
                'zip' => 'gujarat_tourism.zip'
            ),
            'singer' => array(
                'name' => __('Singer','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/singer-slider/',
                'zip' => 'singer.zip'
            ),
            'baby-care' => array(
                'name' => __('Baby Care','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/baby-care-slider/',
                'zip' => 'baby_care.zip'
            ),
            'wild-life' => array(
                'name' => __('Wild Life','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/wild-life-slider/',
                'zip' => 'wild_life.zip'
            ),
            'architecture' => array(
                'name' => __('Architecture','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/architecture-slider/',
                'zip' => 'architecture.zip'
            ),
            'architecture-design' => array(
                'name' => __('Architecture Design','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/architecture-designslider/',
                'zip' => 'architecture_design_slider.zip'
            ),
            'holiday' => array(
                'name' => __('Holiday','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/holiday-slider/',
                'zip' => 'holiday.zip'
            ),
            'festival' => array(
                'name' => __('Festival','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/festival-slider/',
                'zip' => 'festival_slider.zip'
            ),
            'fruit' => array(
                'name' => __('Fruit','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/fruit-slider/',
                'zip' => 'fruit_slider.zip'
            ),
            'landing-page-2' => array(
                'name' => __('Landing Page','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/landing-page-slider-2/',
                'zip' => 'landing_page.zip'
            ),
            'juice' => array(
                'name' => __('Juice','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/juice-slider/',
                'zip' => 'juice.zip'
            ),
            'media' => array(
                'name' => __('Media','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/media-slider/',
                'zip' => 'media_product.zip'
            ),
            'hosting' => array(
                'name' => __('Hosting','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/hosting-slider/',
                'zip' => 'hosting.zip'
            ),
            'university' => array(
                'name' => __('University','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/university-slider/',
                'zip' => 'university_slider.zip'
            ),
            'environment' => array(
                'name' => __('Environment','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/environment-slider/',
                'zip' => 'environment_slider.zip'
            ),
            'workspace' => array(
                'name' => __('Workspace','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/workspace-slider/',
                'zip' => 'workspace_slider.zip'
            ),
            'charity' => array(
                'name' => __('Charity','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/charity-slider/',
                'zip' => 'charity_slider.zip'
            ),
            'education' => array(
                'name' => __('Education','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/education-slider/',
                'zip' => 'education_slider.zip'
            ),
            'creative' => array(
                'name' => __('Creative','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/creative-slider/',
                'zip' => 'creative_slider.zip'
            ),
            'construction' => array(
                'name' => __('Construction','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/construction-slider/',
                'zip' => 'construction_slider.zip'
            ),
            'wonder' => array(
                'name' => __('Wonder','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/wonder-slider/',
                'zip' => 'wonder_slider.zip'
            ),
            'full-width' => array(
                'name' => __('Full Width','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/full-width-slider/',
                'zip' => 'full_width_demo_slider.zip'
            ),
            'content' => array(
                'name' => __('Content','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/content-slider/',
                'zip' => 'content_slider.zip'
            ),
            'photography' => array(
                'name' => __('Photography','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/photography-slider/',
                'zip' => 'photography_slider.zip'
            ),
            'pleasant' => array(
                'name' => __('Pleasant','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/pleasant-slider/',
                'zip' => 'pleasant_slider.zip'
            ),
            'sports' => array(
                'name' => __('Sports Slider','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/sports-slider/',
                'zip' => 'sports_slider.zip'
            ),
            'video' => array(
                'name' => __('Video','avartan-slider-lite'),
                'link' => 'https://avartanslider.com/wordpress/video-slider/',
                'zip' => 'video_slider.zip'
            ),

        );
        return $default_template;
    }

    /**
     * Initialize slider
     *
     * @since 1.3
     * @param array $arrData
     */
    public function initSingleSlider($arrData) {
        $this->id = $arrData->id;
        $this->title = $arrData->name;
        $this->alias = $arrData->alias;
        $this->totalslide = $arrData->totalSlide;
        $settings = $arrData->slider_option;
        $settings = (array) maybe_unserialize($settings);
        $this->settings = AvartanSliderLiteWPFunctions::filterSettings($settings, 'slider');
        return $this->settings;
    }

    /**
     * Initialize slider by id
     *
     * @since 1.3
     * @param integer $id
     */
    public function initSingleSliderById($id = '') {
        $select = 'aslider.id, aslider.name, aslider.alias, count(aslide.id) AS totalSlide, aslider.slider_option';
        $from = avsLiteGlobals::$avs_slider_tbl . ' AS aslider LEFT JOIN ' . avsLiteGlobals::$avs_slides_tbl . ' AS aslide ON aslider.id = aslide.slider_parent';
        $where = 'aslider.id =' . $id;
        try {
            $response = self::$core_obj->fetch($select, $from, $where);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            exit;
        }
        return $this->initSingleSlider($response[0]);
    }

    /**
     * Get id of first slide
     *
     * @since 1.3
     * @param integer $id
     */
    public function getFirstSlideId($id = '') {
        $select = 'aslide.id';
        $from = avsLiteGlobals::$avs_slider_tbl . ' AS aslider JOIN ' . avsLiteGlobals::$avs_slides_tbl . ' AS aslide ON aslider.id = aslide.slider_parent';
        $where = 'aslider.id =' . $id;
        $extra = 'limit 1';
        $order_by = 'position';
        try {
            $response = self::$core_obj->fetch($select, $from, $where, $order_by, '', $extra);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            exit;
        }
        return $response[0]->id;
    }

    /**
     * Get all sliders
     *
     * @since 1.3
     */
    public function getAllSlider() {
        $select = 'aslider.id, aslider.name, aslider.alias, count(aslide.id) AS totalSlide, aslider.slider_option';
        $from = avsLiteGlobals::$avs_slider_tbl . ' AS aslider INNER JOIN ' . avsLiteGlobals::$avs_slides_tbl . ' AS aslide ON aslider.id = aslide.slider_parent';
        $where = '';
        $order_by = '';
        $group_by = 'aslider.id';
        $response = self::$core_obj->fetch($select, $from, $where, $order_by, $group_by);
        $all_sliders = array();
        foreach ($response as $sArr) {
            $slider = new avsLiteSlider();
            $slider->initSingleSlider($sArr);
            $all_sliders[] = $slider;
        }
        return $all_sliders;
    }

    /**
     * Get all slides for single slider
     *
     * @since 1.3
     * @param bool $published
     */
    public function getAllSlides($published = false) {
        $arr_slides = $this->getSlidesFromAll($published);
        return($arr_slides);
    }

    /**
     * Get first slider from all sliders
     *
     * @since 1.3
     * @param bool $published
     */
    public function getSlidesFromAll($published = false) {
        $from = avsLiteGlobals::$avs_slides_tbl;
        $where = "slider_parent=$this->id";
        $select = '*';
        $order_by = 'position';
        $all_slides_ary = array();
        $all_slides = self::$core_obj->fetch($select, $from, $where, $order_by);
        $arrChildren = array();
        foreach ($all_slides as $single_slide) {
            $slide = new avsLiteSlide();
            $slide->initSingleSlide($single_slide);
            $slide_id = $slide->getID();
            $arrIdsAssoc[$slide_id] = true;
            if ($published == true) {
                $state = $slide->getSlideStatus();
                if ($state == "0") {
                    continue;
                }
            }
            $slider_id = $slide->getSliderID();

            $all_slides_ary[] = $slide;
        }
        return($all_slides_ary);
    }


    /**
     * Delete slider
     *
     * @since 1.3
     * @param integer $slider_id
     */
    public function deleteSlider($slider_id) {
        global $wpdb;
        // Delete slider
        $table_name = $wpdb->prefix . 'avartan_sliders';
        $select = 'id';
        $from = $table_name;
        $where = 'id =' . $slider_id;
        $slider_detail = self::$core_obj->fetch($select, $from, $where, '', '', '', ARRAY_A);
        if ($slider_detail) {
            $where_delete = 'id =' . $slider_id;
            $output = self::$core_obj->delete($table_name, $where_delete);
            if ($output === false) {
                $output = false;
            } else {
                //Get slide information of the particular slider
                $table_name = $wpdb->prefix . 'avartan_slides';
                $where_slide = 'slider_parent =' . $slider_id;
                $slides_detail = self::$core_obj->fetch('id', $table_name, $where_slide, '', '', '', ARRAY_A);
                if ($slides_detail) {
                    // Delete slides
                    $where_delete = 'slider_parent =' . $slider_id;
                    $output = self::$core_obj->delete($table_name, $where_delete);
                    if ($output === false) {
                        $output = false;
                    }
                }
            }
        }

        // Returning
        $output = wp_json_encode($output);
        return $output;
    }
}