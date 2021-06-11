<?php
if (!defined('ABSPATH'))
    exit();

$slide_custom_css = AvartanSliderLiteFunctions::getVal($params_slide,'custom_css','');
$slide_description = '';
?>
<div class="as-form as-form-horizontal">
    <div class="as-form-control-group">
        <label><?php _e('Slide Description', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-pro-version">
            <textarea readonly="" class="as-slide-description as-pro-version" placeholder="<?php _e('Slide Description', 'avartan-slider-lite'); ?>"><?php echo $slide_description; ?></textarea>
        </div>
        <span class="option-desc"><?php _e('Add slide description.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Custom CSS', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <?php
            $custom_css = '';
            $remove_n = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), "<br/>", $slide_custom_css);
            $breaks = array("<br />", "<br>", "<br/>");
            $custom_css = str_ireplace($breaks, "\r\n", $remove_n);
            ?>
            <textarea class="as-slide-custom-css" placeholder="<?php _e('Custom CSS', 'avartan-slider-lite'); ?>"><?php echo stripslashes($custom_css); ?></textarea>
        </div>
        <span class="option-desc">
        <?php
        _e('Apply custom CSS to the slide.', 'avartan-slider-lite');
        echo '<br/>';
        echo 'Ex: display: block;verticle-align: middle;';
        echo '<br/>';
        _e('Note: Do not use', 'avartan-slider-lite');
        echo ' .class_name{} or #id{}.';
        ?>
        </span>
    </div>
</div>