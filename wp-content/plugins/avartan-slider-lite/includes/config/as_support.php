<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


/* * ********************************************* */
/*                                                 */
/*              Visual Composer plugin             */
/*                                                 */
/* * ********************************************* */

if(!function_exists( 'avs_add_vc_support' )) {

function avs_add_vc_support() {
    global $wpdb;
    $as_sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders');
    $as_sliders_array = array(__("Select Slider", 'avartan-slider-lite'));
    if (!empty($as_sliders) && is_array($as_sliders)) {
        foreach ($as_sliders as $as_slider) {
            $as_sliders_array[$as_slider->name] = $as_slider->alias;
        }
    }
    vc_map(array(
        "name" => esc_html__("Avartan Slider", 'avartan-slider-lite'),
        "base" => "avartanslider",
        "class" => "vc_avartanslider_section",
        "category" => 'Content',
        "icon" => 'avartan_slider_icon',
        'admin_enqueue_css' => array(AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/as_support.css'),
        'front_enqueue_css' => array(AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/as_support.css'),
        "description" => __("Add Your Beautiful Avartan Slider", 'avartan-slider-lite'),
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Select Avartan Slider", 'avartan-slider-lite'),
                "param_name" => "alias",
                'value' => $as_sliders_array,
                'admin_label' => true,
            )
        )
    ));

  }

}

add_action('vc_before_init', 'avs_add_vc_support');


/* * ********************************************* */
/*                                                 */
/*              Beaver Builder Lite                */
/*                                                 */
/* * ********************************************* */

if (is_plugin_active('beaver-builder-lite-version/fl-builder.php')) {

    if (!function_exists('avs_add_as_widget')) {

        function avs_add_as_widget() {
            ?>
            <div id="fl-builder-blocks-as-widget" class="fl-builder-blocks-section">
                <span class="fl-builder-blocks-section-title">
                    <?php _e('Avartan Slider', 'avartan-slider-lite'); ?>
                    <i class="fas fa-chevron-down"></i>
                </span>
                <div class="fl-builder-blocks-section-content fl-builder-modules">
                    <span class="fl-builder-block fl-builder-block-module" data-widget="Avartansliderlite_Widget" data-type="widget">
                        <span class="fl-builder-block-title"><?php _e('Avartan Slider', 'avartan-slider-lite'); ?></span>
                    </span>
                </div>
            </div>
            <?php
        }

    }
    add_action('fl_builder_ui_panel_after_modules', 'avs_add_as_widget');
}


/* * ********************************************* */
/*                                                 */
/*          Page Builder by SiteOrigin             */
/*                                                 */
/* * ********************************************* */
if (is_plugin_active('siteorigin-panels/siteorigin-panels.php')) {

    function avs_siteorigin_panels_add_widgets_dialog_tabs($tabs) {
        $tabs['avartan_slider'] = array(
            'title' => __('Avartan Slider', 'avartan-slider-lite'),
            'filter' => array(
                'groups' => array('avartan_slider')
            )
        );
        return $tabs;
    }

    add_filter('siteorigin_panels_widget_dialog_tabs', 'avs_siteorigin_panels_add_widgets_dialog_tabs', 20);

    function avs_siteorigin_panels_add_recommended_widgets($widgets) {
        foreach ($widgets as $widget_id => &$widget) {
            if (strpos($widget_id, 'Avartanslider_') === 0 || strpos($widget_id, 'widget_avartanslider') !== FALSE) {
                $widget['groups'][] = 'avartan_slider';
                $widget['icon'] = 'as_icon';
            }
        }
        return $widgets;
    }

    add_filter('siteorigin_panels_widgets', 'avs_siteorigin_panels_add_recommended_widgets');
}

if (is_plugin_active('siteorigin-panels/siteorigin-panels.php') || is_plugin_active('wr-pagebuilder/wr-pagebuilder.php')) {

    add_action('admin_enqueue_scripts', 'avs_support_script');

    function avs_support_script() {
        wp_enqueue_style('avs_support_css', plugins_url('avartan-slider-lite/manage/assets/css/as_support.css'));
    }

}


/* * ********************************************* */
/*                                                 */
/*          BE Page Builder                        */
/*                                                 */
/* * ********************************************* */

if (is_plugin_active('be-page-builder/be-page-builder.php')) {

    function avs_be_builder_support() {

        global $be_shortcode, $wpdb;

        $as_sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders');
        $as_sliders_array = array();
        if (!empty($as_sliders) && is_array($as_sliders)) {
            foreach ($as_sliders as $as_slider) {
                $as_sliders_array[$as_slider->name] = $as_slider->alias;
            }
        }

        $be_shortcode['avartanslider'] = array (
                        'name' => __('Avartan Slider', 'avartan-slider-lite'),
                        'type' => 'single',
                        'icon' => AVARTAN_LITE_PLUGIN_URL . 'manage/assets/images/avartan_icon.png',
                        'options' => array(
                                'alias' => array (
                                        'title' => __('Select Slider','avartan-slider-lite'),
                                        'type' => 'select',
                                        'options'=> $as_sliders_array,
                                        'default' => __("Select Slider", 'avartan-slider-lite'),
                                ),
                        )
                );
        }

    add_action('init', 'avs_be_builder_support');

}