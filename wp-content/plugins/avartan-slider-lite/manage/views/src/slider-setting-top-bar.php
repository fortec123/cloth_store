<?php
if (!defined('ABSPATH'))
    exit();
?>
<!--Slider information section-->
<div class="as-slider-info">
    <div class="as-form as-form-inline" id="as-slider-info">
        <div class="as-form-control-group">
            <label class="as-required"><?php _e('Slider Name', 'avartan-slider-lite'); ?></label>
            <input type="text" class="as-slider-name" placeholder="<?php esc_attr_e('Slider Name', 'avartan-slider-lite'); ?>" value="<?php echo ($edit) ? $slider->getTitle() : ''; ?>" onkeypress="return avsIsNotSpecialChar(event);" />
        </div>
        <div class="as-form-control-group">
            <label class="as-required"><?php _e('Alias', 'avartan-slider-lite'); ?></label>
            <input type="text" class="as-slider-alias as-pro-version" readonly="readonly" placeholder="<?php esc_attr_e('Alias', 'avartan-slider-lite'); ?>" value="<?php echo ($edit) ? $slider->getAlias() : ''; ?>" onkeypress="return avsIsNotSpecialChar(event);" />
        </div>
        <div class="as-form-control-group">
            <label><?php _e('Shortcode', 'avartan-slider-lite'); ?></label>
            <input type="text" class="as-slider-shortcode" readonly="readonly" onClick="this.select();" class="shortcode_selection" value="<?php echo (($edit) ? ('[avartanslider alias=\'' . $slider->getAlias() . '\']') : ''); ?>" />
        </div>
        <div class="as-form-control-group">
            <label><?php _e('PHP Function', 'avartan-slider-lite'); ?></label>
            <input type="text" class="as-slider-php-function" readonly="readonly" onClick="this.select();" class="shortcode_selection" value="<?php echo ($edit) ? 'if(function_exists(\'avartanslider\')) avartanslider(\'' . $slider->getAlias() . '\');' : ''; ?>" />
        </div>
    </div>
</div>