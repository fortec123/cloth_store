<?php
if (!defined('ABSPATH'))
    exit();

if(!isset($id) || $id == '') {
    $id = '_id';
} ?>
<div class="as-form as-form-horizontal">
    <div class="as-form-control-group">
        <label><?php _e('onLoaded', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-callback-textarea as-pro-version">
            <textarea readonly cols="50" rows="10" class="as-slider-callback-beforeStart">
<?php echo 'avartanslider'.$id ?>.on('avartanslider.onLoaded',function(e){
            console.log('<?php _e('Slider loaded.', 'avartan-slider-lite'); ?>');
});</textarea>
        </div>
        <span class="option-desc"><?php _e('Callback for slider load.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('beforeSlideStart', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-callback-textarea as-pro-version">
            <textarea readonly cols="50" rows="10" class="as-slider-callback-beforeSliderResize">
<?php echo 'avartanslider'.$id ?>.on('avartanslider.beforeSlideStart',function(e,data){
            console.log(data.currentslide); // Current slide jQuery object
            console.log(data.nextslide); //Coming slide jQuery object
});</textarea>
        </div>
        <span class="option-desc"><?php _e('Callback for slide start.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('afterSlideFinish', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-callback-textarea as-pro-version">
            <textarea readonly cols="50" rows="10">
<?php echo 'avartanslider'.$id ?>.on('avartanslider.afterSlideFinish',function(e,data){
            console.log(data.currentslide); // Current slide jQuery object
            console.log(data.previousslide); //Previous slide jQuery object
});</textarea>
        </div>
        <span class="option-desc"><?php _e('Callback for slide finish.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('onChange', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-callback-textarea as-pro-version">
            <textarea readonly cols="50" rows="10">
<?php echo 'avartanslider'.$id ?>.on('avartanslider.onChange',function(e){
            console.log('<?php _e('Slide changed.', 'avartan-slider-lite'); ?>');
});</textarea>
        </div>
        <span class="option-desc"><?php _e('Callback for slide change.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('onPause', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-callback-textarea as-pro-version">
            <textarea readonly cols="50" rows="10" >
<?php echo 'avartanslider'.$id ?>.on('avartanslider.onPause',function(e,data){
            console.log('<?php _e('Slider paused.', 'avartan-slider-lite'); ?>');
});</textarea>
        </div>
        <span class="option-desc"><?php _e('Callback for slider pause.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('onResume', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-callback-textarea as-pro-version">
            <textarea readonly cols="50" rows="10" >
<?php echo 'avartanslider'.$id ?>.on('avartanslider.onResume',function(e,data){
            console.log('<?php _e('Slider resumed.', 'avartan-slider-lite'); ?>');
});</textarea>
        </div>
        <span class="option-desc"><?php _e('Callback for slider resume after pause.', 'avartan-slider-lite'); ?></span>
    </div>    
</div>