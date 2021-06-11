<?php
if (!defined('ABSPATH'))
    exit();

//Attribute save
$attributes_id = '';
$attribute_class = '';
$attribute_title = '';
$attribute_rel = '';
?>
<div class="as-form as-form-horizontal">
    <div class="as-form-control-group">
        <label><?php _e('ID', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input type="text" value="<?php echo $attributes_id; ?>" class="as-slide-attribute-id as-pro-version" readonly="" placeholder="<?php esc_attr_e('ID', 'avartan-slider-lite'); ?>"/>
        </div>
        <span class="option-desc"><?php _e('Add ID attribute to slide.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Classes', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input type="text" value="<?php echo $attribute_class; ?>" class="as-slide-attribute-classes as-pro-version" readonly="" placeholder="<?php esc_attr_e('Classes', 'avartan-slider-lite'); ?>"/>
        </div>
        <span class="option-desc"><?php _e('Add Class attribute to slide.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Title', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input type="text" value="<?php echo $attribute_title; ?>" class="as-slide-attribute-title as-pro-version" readonly="" placeholder="<?php esc_attr_e('Title', 'avartan-slider-lite'); ?>"/>
        </div>
        <span class="option-desc"><?php _e('Add Title attribute to slide.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Rel', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input type="text" value="<?php echo $attribute_rel; ?>" class="as-slide-attribute-rel as-pro-version" readonly="" placeholder="<?php esc_attr_e('Rel', 'avartan-slider-lite'); ?>"/>
        </div>
        <span class="option-desc"><?php _e('Add Rel attribute to slide.', 'avartan-slider-lite'); ?></span>
    </div>
</div>