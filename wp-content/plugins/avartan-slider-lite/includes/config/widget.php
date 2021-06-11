<?php
if (!defined('ABSPATH'))
    exit();

if (!function_exists('Avartansliderwidget_register')) {

    /**
     * Register widget
     *
     * @since 1.3
     */
    function Avartansliderwidget_register() {
        register_widget('Avartansliderlite_Widget');
    }

}
add_action('widgets_init', 'Avartansliderwidget_register');

class Avartansliderlite_Widget extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_avartanslider', 'description' => __('Add slider to your sidebar.', 'avartan-slider-lite'));
        parent::__construct('avartan-slider-widget', __('Avartan Slider Widget', 'avartan-slider-lite'), $widget_ops);
        $this->alt_option_name = 'widget_avartanslider';

        add_action('save_post', array($this, 'flush_widget_cache1'));
        add_action('deleted_post', array($this, 'flush_widget_cache1'));
        add_action('switch_theme', array($this, 'flush_widget_cache1'));
    }

    /**
     * @since 1.3
     * @param array $args arguments from sidebar
     * @param array $instance instance of widget
     * @return return html for front end display
     */
    function widget($args, $instance) {
        $cache = array();
        if (!$this->is_preview()) {
            $cache = wp_cache_get('widget_avartanslider', 'widget');
        }

        if (!is_array($cache)) {
            $cache = array();
        }

        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);
        $title = (!empty($instance['title']) ) ? $instance['title'] : "";
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $slider_alias = (!empty($instance['slider_alias']) ) ? $instance['slider_alias'] : '';
        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;
        if ($slider_alias) {
            echo do_shortcode('[avartanslider alias="' . $slider_alias . '"]');
        }
        echo $after_widget;

        if (!$this->is_preview()) {
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set('widget_avartanslider', $cache, 'widget');
        } else {
            ob_end_flush();
        }
    }

    /**
     * @since 1.3
     * @param array $new_instance updated array
     * @param array $old_instance old array
     * @return array $instance instance with new value
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['slider_alias'] = strip_tags($new_instance['slider_alias']);
        $this->flush_widget_cache1();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_avartanslider']))
            delete_option('widget_avartanslider');

        return $instance;
    }

    function flush_widget_cache1() {
        wp_cache_delete('widget_avartanslider', 'widget');
    }

    /**
     * @since 1.3
     * @param array $instance instance of widget
     * @return html return html for admin side display
     */
    function form($instance) {
        global $wpdb;
        //Get the slider information
        $sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders');
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $slider_alias = isset($instance['slider_alias']) ? esc_attr($instance['slider_alias']) : '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'avartan-slider-lite'); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p>
            <?php
            if ($sliders) {
                ?>
                <label for="<?php echo $this->get_field_id('slider_alias'); ?>"><?php _e('Select Slider', 'avartan-slider-lite'); ?>:</label>
                <select class="widefat" id="<?php echo $this->get_field_id('slider_alias'); ?>" name="<?php echo $this->get_field_name('slider_alias'); ?>">
                    <option value="0" <?php if ($slider_alias == '0') echo 'selected = selected'; ?>><?php _e('Select Avartan Slider', 'avartan-slider-lite'); ?></option>
                    <?php
                    foreach ($sliders as $slider) {
                        ?>
                        <option value="<?php echo $slider->alias; ?>" <?php if ($slider->alias == $slider_alias) echo 'selected = selected'; ?>><?php echo $slider->name; ?></option>
                <?php } ?>
                </select>
                <?php
            }else {
                _e('No Sliders Found.', 'avartan-slider-lite');
            }
            ?>
        </p>
        <?php
    }

}

/**
 * Register the new dashboard widget with the 'wp_dashboard_setup' action
 *
 * @since 1.3
 */
add_action('wp_dashboard_setup', 'solwin_latest_news_with_product_details');
if (!function_exists('solwin_latest_news_with_product_details')) {

    /**
     * Add meta box to display solwin news.
     *
     * @since 1.3
     */
    function solwin_latest_news_with_product_details() {
        add_screen_option('layout_columns', array('max' => 3, 'default' => 2));
        add_meta_box('avs_dashboard_widget', __('News From Solwin Infotech', 'avartan-slider-lite'), 'avs_dashboard_widget_news', 'dashboard', 'normal', 'high');
    }

}
if (!function_exists('avs_dashboard_widget_news')) {

    /**
     * Display Solwin infotech feed from the live.
     *
     * @since 1.3
     */
    function avs_dashboard_widget_news() {
        echo '<div class="rss-widget">' . '<div class="solwin-news"><p><strong>' . __('Solwin Infotech News', 'avartan-slider-lite') . '</strong></p>';
        wp_widget_rss_output(array(
            'url' => esc_url('https://www.solwininfotech.com/feed/'),
            'title' => __('News From Solwin Infotech', 'avartan-slider-lite'),
            'items' => 5,
            'show_summary' => 0,
            'show_author' => 0,
            'show_date' => 1
        ));
        echo '</div>';
        $title = $link = $thumbnail = "";
        //get Latest product detail from xml file

        $file = 'https://www.solwininfotech.com/documents/assets/latest_product.xml';
        if(!defined('AVS_LATEST_PRODUCT_FILE')){
            define('AVS_LATEST_PRODUCT_FILE', $file);
        }
        echo '<div class="display-product">'
        . '<div class="product-detail"><p><strong>' . __('Latest Product', 'avartan-slider-lite') . '</strong></p>';
        $response = wp_remote_get(AVS_LATEST_PRODUCT_FILE);
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo "<p>" . __("Something went wrong", 'avartan-slider-lite') . ':' . " $error_message" . "</p>";
        } else {
            $body = wp_remote_retrieve_body($response);
            $xml = simplexml_load_string($body);
            $title = $xml->item->name;
            $thumbnail = $xml->item->img;
            $link = $xml->item->link;
            $allProducttext = $xml->item->viewalltext;
            $allProductlink = $xml->item->viewalllink;
            $moretext = $xml->item->moretext;
            $needsupporttext = $xml->item->needsupporttext;
            $needsupportlink = $xml->item->needsupportlink;
            $customservicetext = $xml->item->customservicetext;
            $customservicelink = $xml->item->customservicelink;
            $joinproductclubtext = $xml->item->joinproductclubtext;
            $joinproductclublink = $xml->item->joinproductclublink;

            echo '<div class="product-name"><a href="' . $link . '" target="_blank">'
            . '<img alt="' . $title . '" src="' . $thumbnail . '"> </a>'
            . '<a href="' . $link . '" target="_blank">' . $title . '</a>'
            . '<p><a href="' . $allProductlink . '" target="_blank" class="button button-default">' . $allProducttext . ' &RightArrow;</a></p>'
            . '<hr>'
            . '<p><strong>' . $moretext . '</strong></p>'
            . '<ul>'
            . '<li><a href="' . $needsupportlink . '" target="_blank">' . $needsupporttext . '</a></li>'
            . '<li><a href="' . $customservicelink . '" target="_blank">' . $customservicetext . '</a></li>'
            . '<li><a href="' . $joinproductclublink . '" target="_blank">' . $joinproductclubtext . '</a></li>'
            . '</ul>'
            . '</div>';
        }
        echo '</div></div><div class="clear"></div>'
        . '</div>';
    }

}