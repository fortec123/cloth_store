<?php

/**
 * Plugin Name: Avartan Slider Lite
 * Plugin URI: https://wordpress.org/plugins/avartan-slider-lite/
 * Description: To make your home page more beautiful with Avaratan Slider. Avaratan Slider Lite is a first free slider plugin with lots of nice features like beautiful, modern and configurable backend elements. It is multipurpose slider which comes with text, image and video elements.
 * Version: 1.5.3
 * Author: Solwin Infotech
 * Author URI: https://www.solwininfotech.com/
 * Requires at least: 4.0
 * Tested up to: 5.6
 * Text Domain: avartan-slider-lite
 * Domain Path: /languages/
 */

if (!defined('ABSPATH'))
    exit();

define('AVARTAN_LITE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AVARTAN_LITE_PLUGIN_URL', plugin_dir_url(__FILE__));

class avsLiteFront {

    public static $core_obj = '';

    public function __construct() {
        require_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/global.php';
        require_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/core.php';
        require_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/wp-functions.php';
        require_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/functions.php';
        require_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/widget.php';
        require_once AVARTAN_LITE_PLUGIN_DIR . 'includes/shortcode.php';
        require_once AVARTAN_LITE_PLUGIN_DIR . 'views/front.class.php';
        require_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/as_support.php';
        add_action('admin_init', array('avsLiteFront', 'avsStatus'));
        add_action('plugins_loaded', array('avsLiteFront', 'avsTextDomain'));
        add_action('admin_head', array('avsLiteFront', 'avsUpgradeLinkCss'));
        add_filter('plugin_action_links_' . dirname(plugin_basename(__FILE__)), array('avsLiteFront', 'avsPluginActionLink'));
        register_activation_hook(__FILE__, array('avsLiteFront', 'avsActive'));
        register_uninstall_hook(__FILE__, array('avsLiteFront', 'avsDropTables'));
        add_action('activated_plugin', array('avsLiteFront', 'avsRedirection'));        
        if (is_admin()) {
            require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/manage.php';
        }
        self::$core_obj = new AvartanSliderLiteCore();
    }

    /**
     * Returns current plugin version
     *
     * @since 1.3
     */
    public static function avsPluginGetVersion() {
        if (!function_exists('get_plugins'))
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
        $plugin_file = basename(( __FILE__));
        return $plugin_folder[$plugin_file]['Version'];
    }

    /**
     * plugin text domain
     *
     * @since 1.3
     */
    public static function avsTextDomain() {
        $locale = apply_filters('plugin_locale', get_locale(), 'avartan-slider-lite');
        load_plugin_textdomain('avartan-slider-lite', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Deactivate lite version if it is activated and Create table if anyone delete from database directly and pro plugin is activated
     *
     * @since 1.3
     */
    public static function avsStatus() {
        global $wpdb;

        //if plugin activated and database table not found then create it
        if (is_plugin_active('avartan-slider-lite/avartanslider.php')) {
            $avartanSlider = avsLiteGlobals::$avs_slider_tbl;
            if ($wpdb->get_var("SHOW TABLES LIKE '$avartanSlider'") != $avartanSlider) {
                self::$core_obj->createSliderTbl();
            }
            $avartanSlides = avsLiteGlobals::$avs_slides_tbl;
            if ($wpdb->get_var("SHOW TABLES LIKE '$avartanSlides'") != $avartanSlides) {
                self::$core_obj->createSlidesTbl();
            }
            $avartanPresetSlides = avsLiteGlobals::$avs_preset_tbl;
            if ($wpdb->get_var("SHOW TABLES LIKE '$avartanPresetSlides'") != $avartanPresetSlides) {
                self::$core_obj->createPresetTbl();
                AvartanSliderLiteFunctions::avsPreset();
            } else {
                AvartanSliderLiteFunctions::avsPreset();
            }
        }
    }

    /**
     * Create (or remove) 2 tables: the sliders settings, the slides/Elements settings.
     *
     * @since 1.3
     */
    public static function avsActive() {
        //plugin is activated
        if (is_plugin_active('avartanslider/avartanslider.php')) {
            deactivate_plugins('/avartanslider/avartanslider.php');
        }
        self::$core_obj->createSliderTbl();
        self::$core_obj->createSlidesTbl();
    }

    /**
     * Drop tables
     *
     * @since 1.3
     */
    public static function avsDropTables() {
        self::$core_obj->dropTbl(avsLiteGlobals::$avs_slider_tbl);
        self::$core_obj->dropTbl(avsLiteGlobals::$avs_slides_tbl);
    }

    /**
     * Add upgrade link style in plugin listing page
     *
     * @since 1.5
     */
    public static function avsUpgradeLinkCss(){
        echo '<style>.row-actions a.upgrade_avl_plugin { color: #4caf50; }</style>';
    }

    /**
     * Add documentation and upgrade link in plugin listing page
     *
     * @since 1.3
     * @param array $links
     * @return string
     */
    public static function avsPluginActionLink($links){
        $links['documents'] = '<a class="documentation_avl_plugin" target="_blank" href="' . esc_url('https://www.solwininfotech.com/documents/wordpress/avartan-lite/') . '">' . __('Documentation', 'avartan-slider-lite') . '</a>';
        $links['upgrade'] = '<a class="upgrade_avl_plugin" target="_blank" href="' . esc_url('https://codecanyon.net/item/avartan-slider-responsive-wordpress-slider-plugin/19973800?ref=solwin') . '">' . __('Upgrade', 'avartan-slider-lite') . '</a>';
        return $links;
    }
    
    /**
     * redirection on plugin activation
     *
     * @since 1.3
     * @param array $links
     * @return string
     */
    public static function avsRedirection($plugin) {
        if( $plugin == dirname(plugin_basename( __FILE__ ) )) {
            if (!isset($_GET['activate-multi']) && !is_array($_POST['plugin'])) { 
                $avl_is_optin = get_option('avl_is_optin');
                if($avl_is_optin == 'yes' || $avl_is_optin == 'no') {
                    
                }
                else {
                    exit( wp_redirect( admin_url( 'admin.php?page=avartanslider_welcome' ) ) );
                }
            }
        }
    }

}

new avsLiteFront();
