<?php
if (!defined('ABSPATH'))
    exit();
?>
<!--Delete Slider Dialog-->
<div id="dialog_delete_slider_confirm" title="<?php esc_attr_e('Delete Slider?', 'avartan-slider-lite'); ?>" class="as-delete-dialog">
    <span><i class="fas fa-exclamation-triangle as-danger"></i> <?php _e('This slider will be permanently deleted and cannot be recovered. Are you sure?', 'avartan-slider-lite'); ?></span>
</div>

<!--Delete Slide Dialog-->
<div id="dialog_delete_slide_confirm" title="<?php esc_attr_e('Delete Slide?', 'avartan-slider-lite'); ?>" class="as-delete-dialog">
    <span><i class="fas fa-exclamation-triangle as-danger"></i> <?php _e('This slide will be permanently deleted and cannot be recovered. Are you sure?', 'avartan-slider-lite'); ?></span>
</div>

<!--Add Slide Preset Dialog-->
<div id="dialog_add_preset_slide_confirm" title="<?php esc_attr_e('Add Slide Preset', 'avartan-slider-lite'); ?>" class="as-add-preset-slide-dialog">
    <span><i class="fas fa-exclamation-triangle as-danger"></i> <?php _e('Your slide data will be reset with selected Preset. Are you sure?', 'avartan-slider-lite'); ?></span>
</div>

<?php
if( isset($_GET['view']) && $_GET['view'] == 'slide' ){
?>
<!--Preview Slide Dialog-->
<div id="dialog_preview_slide" title="<?php esc_attr_e('Preview Slide', 'avartan-slider-lite'); ?>">
    <div class="as-preview-button as-text-center">
        <button class="as-btn as-btn-primary as-slider-preview-desktop as-active"><span class="fas fa-desktop"></span></button>
        <button class="as-btn as-btn-primary as-slider-preview-mobile as-pro-version"><span class="fas fa-mobile-alt"></span></button>
        <input class="as-slider-h" value="" type="hidden" />
    </div>
    <div class="as-slide-live-preview-area"></div>
</div>
<?php
}
?>
<div id="dialog_slide_preset" title="<?php esc_attr_e('Slide Preset', 'avartan-slider-lite'); ?>">
    <div class="as-form as-form-horizontal slide_preset_block">
        <div class="as-form-control-group">
            <div class="as-form-control">
                <ul class="preset_wrap">
                    <?php
                    if ($getAllPreset) {
                        foreach ($getAllPreset as $preset) {
                            $availability = 'free';
                            if($preset['params'] == '' && $preset['layers'] == '') {
                                $availability = 'premium';
                            }
                        ?>
                            <li class="preset_inner <?php echo $availability; ?>">
                                <a href="javascript:void(0);" data-preset-id="<?php echo $preset['id']; ?>" >
                                    <img src="<?php echo $preset['image']; ?>">
                                    <div class="as-thumb-overlay"></div>
                                    <div class="preset_title"><?php echo $preset['title']?></div>
                                    <?php echo ($availability == 'premium') ? '<span class="avs-premium">'. __('PRO', 'avartan-slider-lite').'</span>' : '';?>
                                </a>
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>