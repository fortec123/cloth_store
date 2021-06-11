<?php
if (!defined('ABSPATH'))
    exit();
$slider_setting_type = 'general';
$slider = new avsLiteSlider();
$slider_nav_array = $slider->getSliderNavAry();
$slider_select_options = $slider->getSliderSettingAry();
$id = avsLiteAdmin::$id;
$edit = avsLiteAdmin::$edit;

//Preset Data
$preset = new avsLitePreset();
$getAllPreset = $preset->getAllPreset();

$slider_option  = array();

if ($id != '') {
    $slider_option = $slider->initSingleSliderById($id);
}
$slider_type = 'standard-slider';
?>
<div class="as-home as-slider <?php echo $edit ? 'as-edit-slider' : 'as-add-slider' ?>" data-slider-type="<?php echo $slider_type; ?>">
    <?php
    if ($edit):
        include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slider-top-bar.php';
    endif;
    include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slider-setting-top-bar.php';
    ?>
    <div class="as-panel">
        <div class="as-panel-header">
            <h4><?php _e('Slider Settings', 'avartan-slider-lite'); ?></h4>
            <div class="as-action-button">
                <button type="button" class="as-btn as-btn-green as-save-settings" data-id="<?php echo $id; ?>"><i class="fas fa-save"></i> <span><?php _e('Save Settings', 'avartan-slider-lite'); ?></span></button>
                <button type="button" class="as-btn as-btn-orange as-preview-slider as-pro-version"><i class="fas fa-search"></i> <span><?php _e('Preview', 'avartan-slider-lite'); ?></span></button>
                <button id="delete_as_slider_<?php echo $id; ?>" type="button" class="as-btn as-btn-red as-delete-slider"><i class="fas fa-trash-alt"></i> <span><?php _e('Delete Slider', 'avartan-slider-lite'); ?></span></button>
                <button type="button" onclick="location.href='?page=avartanslider';" class="as-btn as-btn-blue" title="<?php esc_attr_e('All Sliders', 'avartan-slider-lite'); ?>"><i class="fas fa-list"></i> <span><?php _e('All Sliders', 'avartan-slider-lite'); ?></span></button>
            </div>
        </div>
        <div class="as-panel-body">
            <div class="as-tabs-verticle">
                <ul class="ui-tabs-nav">
                    <?php
                    if (is_array($slider_nav_array) && !empty($slider_nav_array)) {

                        foreach ($slider_nav_array as $key => $value) {
                            $active_tab_class = '';
                            if ($key == $slider_setting_type) {
                                $active_tab_class = ' as-is-active';
                            }
                            ?>
                            <li class="ui-state-default">
                                <a href="#as-slider-<?php echo $key; ?>" class="<?php if($key == 'parallax' || $key == 'callbacks'){ echo 'as-pro-version'; } ?>">
                                    <span class="<?php echo $value['icon']; ?>"></span>
                                    <?php echo $value['name']; ?>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <div class="as-tabs-content">
                    <?php
                    if (is_array($slider_nav_array) && !empty($slider_nav_array)) {

                        foreach ($slider_nav_array as $key => $value) {
                            ?>
                            <div class="as-tab-info" id="as-slider-<?php echo $key; ?>">
                                <?php
                                include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slider-' . $key . '.php';
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if ($id != '') {
    include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slider-dialog.php';
}
?>