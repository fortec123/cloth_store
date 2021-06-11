<?php
if (!defined('ABSPATH'))
    exit();
$slide_setting_type = 'background';
$params_slide = array();
$slide_id = 0;
$id = avsLiteAdmin::$id;
$void = !$id ? true : false;
$edit = avsLiteAdmin::$edit;
$slide = new avsLiteSlide();
$slide->initSingleSlideById($id);
$slide_nav_array = $slide->getSlideNavAry();
$slide_animation_array = $slide->getElementAnimationEffects();
$params_slide = $slide->getParams();
$slider_id = $slide->getSliderID();
$slide_layers = $slide->getLayers();
$slider = new avsLiteSlider();
$slider->initSingleSliderById($slider_id);
$slider_option = maybe_unserialize($slider->getSettings());
$slider_type = 'standard-slider';
$slides = $slider->getAllSlides();
$animations = avsLiteSlide::getSlideAminationAry();
$animation_effect = avsLiteSlide::getAnimationEffects();
$slide_select_options = avsLiteSlide::getSlideSettingAry();

//Preset Data
$preset = new avsLitePreset();
$getAllPreset = $preset->getAllPreset();

?>
<div class="as-home as-disable-wrapper <?php echo $edit ? 'as-edit-slide' : 'as-add-slide' ?>">
    <?php
    include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slider-top-bar.php';
    ?>
    <div class="as-slide-list">
        <?php
        include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slide-list.php';
        ?>
    </div>
    <div class="as-panel">
        <div class="as-panel-header">
            <?php
            include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slide-setting-top-bar.php';
            ?>
        </div>
        <div class="as-panel-body">
            <div class="as-tabs-verticle">
                <ul class="ui-tabs-nav">
                    <?php
                    if (is_array($slide_nav_array) && !empty($slide_nav_array)) {

                        foreach ($slide_nav_array as $key => $value) {
                            $active_tab_class = '';
                            if ($key == $slide_setting_type) {
                                $active_tab_class = ' as-is-active';
                            }
                            ?>
                            <li class="ui-state-default">
                                <a href="#as_tab_<?php echo $key; ?>">
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
                    if (is_array($slide_nav_array) && !empty($slide_nav_array)) {
                        foreach ($slide_nav_array as $key => $value) {
                            ?>
                            <div id="as_tab_<?php echo $key; ?>" class="as-tab-info">
                            <?php
                                include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slide-' . $key . '.php';
                            ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="as-slider-settings-wrapper">

        </div>
        <div class="as-slide">

        </div>
    </div>
    <?php include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slide-design-grid.php'; ?>
</div>
<?php
include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slider-dialog.php';
?>