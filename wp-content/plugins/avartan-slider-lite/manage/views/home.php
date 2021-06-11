<?php
if (!defined('ABSPATH'))
    exit();
?>
<div class="as-panel">
    <div class="as-panel-header as-home">
        <?php
        include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/home-top-bar.php';
        ?>
    </div>
    <div class="as-panel-body">
        <ul class="as-slider-list as-gridview">
            <?php
            if (!$sliders) {
                echo '<label>';
                _e('No Sliders Found. Please add a', 'avartan-slider-lite');
                ?>
                <a href="javascript:void(0);" class="as-create-new-slider" title="<?php esc_attr_e( 'Create New Slider', 'avartan-slider-lite' ); ?>">
                    <?php
                    _e('new one.','avartan-slider-lite');
                    ?>
                </a>
                <?php
                echo '</label>';
            } else {
                $slider_cnt = 0;
                foreach ($sliders as $slider) {
                    $slider_cnt++;
                    include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/slider-list.php';
                }
            }
            ?>
        </ul>
        <?php
        include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/home-dialog.php';
        ?>
    </div>
</div>
<div class="as-info-block" id="as_updatehistory_section">
    <div class="as-tabs-horizontal">
        <div class="as-info-heading">
            <ul>
                <li><a href="#as_update_history"><i class="fas fa-sync"></i><?php _e('Update History', 'avartan-slider-lite'); ?></a></li>
                <li><a href="#as_system_info"><i class="fas fa-info-circle"></i><?php _e('System Info', 'avartan-slider-lite'); ?></a></li>
            </ul>
        </div>
        <div class="as-tabs-content as-info-content inside">
            <?php
            include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/plugin-updates.php';
            include AVARTAN_LITE_PLUGIN_DIR . 'manage/views/src/plugin-system-info.php';
            ?>
        </div>
    </div>
</div>