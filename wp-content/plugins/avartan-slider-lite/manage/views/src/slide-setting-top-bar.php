<?php
if (!defined('ABSPATH'))
    exit();
?>
<h4><?php _e( 'Slide General Options', 'avartan-slider-lite' ); ?></h4>
<div class="as-action-button">
    <button title="<?php esc_attr_e('Save Slide','avartan-slider-lite'); ?>" class="as-btn as-btn-green as-save-slide" data-slide-id="<?php echo $slide->getID() ?>"><i class="fas fa-save"></i> <span><?php _e( 'Save Slide', 'avartan-slider-lite' ); ?></span></button>
    <button title="<?php esc_attr_e('Preview','avartan-slider-lite'); ?>" class="as-btn as-btn-orange as-preview-slide"><i class="fas fa-search"></i> <span><?php _e( 'Preview', 'avartan-slider-lite' ); ?></span></button>
    <button title="<?php esc_attr_e('Slider Settings','avartan-slider-lite'); ?>" onclick="location.href='?page=avartanslider&view=slider&id=<?php echo $slider->getId() ?>&asview-nouce=<?php if(isset($_GET['asview-nouce']) && !empty($_GET['asview-nouce'])) { echo $_GET['asview-nouce']; } ?>'" class="as-btn as-btn-blue as-slider-setting"><i class="fas fa-cog"></i> <span><?php _e( 'Slider Settings', 'avartan-slider-lite' ); ?></span></button>
    <button title="<?php esc_attr_e('Preset','avartan-slider-lite'); ?>" class="as-btn as-btn-red as-slide-preset" data-toggle="modal" data-target="dialog_slide_preset"><i class="fas fa-tachometer-alt"></i> <span><?php _e( 'Preset', 'avartan-slider-lite' ); ?></span></button>
</div>