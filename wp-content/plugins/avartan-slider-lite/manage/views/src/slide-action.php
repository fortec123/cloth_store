<?php
if (!defined('ABSPATH'))
    exit();

$slider_type = 'standard-slider';
$as_slide_link = 0;
$link_to_slide = '';
$slide_link = '';
$slide_link_target = 'new';
?>
<div class="as-form as-form-horizontal">
    <div class="as-form-control-group">
        <label><?php _e('Enable Link', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <div class="as-toggle-indicator as-slide-link-toggle as-pro-version">
                <input <?php checked($as_slide_link, '1') ?> type="radio" id="as_slide_link_1" value="1" class="as-slide-link" name="as_slide_link">
                <label for="as_slide_link_1"><?php _e('On', 'avartan-slider-lite'); ?></label>
                <input <?php checked($as_slide_link, '0') ?> type="radio" id="as_slide_link_0" value="0" class="as-slide-link" name="as_slide_link">
                <label for="as_slide_link_0"><?php _e('Off', 'avartan-slider-lite'); ?></label>
            </div>
        </div>
        <span class="option-desc"><?php _e('Enable / Disable link to slide.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group as-slide-link-option as-link-type-slide">
        <label><?php _e('Link to Slide', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <select class="as-link-to-slide as-pro-show">
                <option class="as-pro-version" value="simple_link" <?php selected($link_to_slide, 'simple_link'); ?>><?php _e('Simple Link', 'avartan-slider-lite'); ?></option>
                <option class="as-pro-version" disabled="disabled" value="next_slide" <?php selected($link_to_slide, 'next_slide'); ?>><?php _e('Next Slide', 'avartan-slider-lite'); ?></option>
                <option class="as-pro-version" disabled="disabled" value="previous_slide" <?php selected($link_to_slide, 'previous_slide'); ?>><?php _e('Previous Slide', 'avartan-slider-lite'); ?></option>
                <option class="as-pro-version" disabled="disabled" value="scroll_below" <?php selected($link_to_slide, 'scroll_below'); ?>><?php _e('Scroll Below Slider', 'avartan-slider-lite'); ?></option>
                <?php
                $slide_pos = 2;
                foreach ($slides as $slide_single) {
                    $all_slide_data = maybe_unserialize($slide_single->getParams());
                    $slide_name = __('Slide', 'avartan-slider-lite');
                    $slide_id = $slide_single->getID();
                    if($id != $slide_id){
                    ?>
                        <option class="as-pro-version" disabled="disabled" <?php selected($link_to_slide, $slide_id); ?> value="<?php echo $slide_id; ?>"><?php echo '#'.$slide_pos. ' '.$slide_name; ?></option>
                    <?php
                    $slide_pos++;
                    }
                }
                ?>
            </select>
        </div>
        <span class="option-desc"><?php _e('Select link for slide.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group as-slide-link-option as-link-type-simple">
        <label><?php _e('Slide Link', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input type="text" readonly="readonly" value="<?php echo $slide_link; ?>" class="as-slide-solid-link as-pro-version" placeholder="<?php _e('Slide Link', 'avartan-slider-lite'); ?>"/>
        </div>
        <span class="option-desc"><?php _e('Add link for slide.', 'avartan-slider-lite'); ?>
        </span>
    </div>
    <div class="as-form-control-group as-slide-link-option as-link-type-simple">
        <label><?php _e('Link Target', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-pro-version">
            <div class="as-toggle-indicator as-link-target-toggle">
                <input <?php checked($slide_link_target, 'same'); ?> type="radio" value="same" id="slide_link_target_front" class="slide-link-target" name="slide_link_target">
                <label for="slide_link_target_front"><?php _e('Same Tab', 'avartan-slider-lite'); ?></label>
                <input <?php checked($slide_link_target, 'new'); ?> type="radio" id="slide_link_target_back" value="new" class="slide-link-target" name="slide_link_target">
                <label for="slide_link_target_back"><?php _e('New Tab', 'avartan-slider-lite'); ?></label>
            </div>
        </div>
        <span class="option-desc"><?php _e('Link open in new tab / same tab.', 'avartan-slider-lite'); ?></span>
    </div>
</div>