<?php

if (!defined('ABSPATH'))
    exit();

class avsLiteFrontClass {

    public function __construct() {
        add_action('wp_enqueue_scripts', array(&$this, 'avsLiteFrontEnqueue'));
    }

    /**
     * Include js and css for front
     *
     * @since 1.3
     */
    public function avsLiteFrontEnqueue() {
        wp_enqueue_style('avs-min-css', AVARTAN_LITE_PLUGIN_URL . '/views/assets/css/avartanslider.min.css');
        wp_enqueue_style('avs-basic-tools-css', AVARTAN_LITE_PLUGIN_URL . '/views/assets/css/basic-tools-min.css');

        wp_enqueue_script('jquery');
        wp_enqueue_script('avs-min-js', AVARTAN_LITE_PLUGIN_URL . '/views/assets/js/avartanslider.min.js', array('jquery'));
        require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
        $loader = new avsLiteSlider();
        $getSliderSettingAry = $loader->getSliderSettingAry();
        $loader_array = $getSliderSettingAry['loaders'];
        wp_localize_script('avs-min-js', 'avs_loader_array', $loader_array);
    }

}

new avsLiteFrontClass();
