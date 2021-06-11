<?php
if( !defined( 'ABSPATH') ) exit();

class avsLiteGlobals {
    const AVS_VERSION = '1.4';
    const AVS_PRESET_VERSION = '1.4.0';
    const AVS_PRESET = 'avartan_preset';
    const AVS_SLIDER = 'avartan_sliders';
    const AVS_SLIDES = 'avartan_slides';
    public static $avs_preset_tbl;
    public static $avs_slider_tbl;
    public static $avs_slides_tbl;
    

    public function __construct() {
        global $wpdb;
        static::$avs_preset_tbl = $wpdb->prefix.self::AVS_PRESET;
        static::$avs_slider_tbl = $wpdb->prefix.self::AVS_SLIDER;
        static::$avs_slides_tbl = $wpdb->prefix.self::AVS_SLIDES;
    }
}
new avsLiteGlobals();