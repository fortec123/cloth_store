<?php
if (!defined('ABSPATH'))
    exit();
?>
<div class="as-tabs">
    <?php
    $active = 'slider';
    if(isset($_GET['view']) && $_GET['view'] == 'slide') {
        $active = 'slide';
    }
    ?>
    <ul>
        <li class="<?php if($active == 'slider') echo 'as-active'; ?>">
            <!-- <a href="?page=avartanslider&view=slider&id=<?php echo $slider->getId(); ?>">
                <span class="fas fa-cog"></span>
                <?php _e('Settings', 'avartan-slider-lite'); ?>
            </a> -->
            <a href="<?php echo wp_nonce_url(admin_url("admin.php?page=avartanslider&view=slider&id=".$slider->getId()),"asview-nouce","asview-nouce")?> ">
                <span class="fas fa-cog"></span>
                <?php _e('Settings', 'avartan-slider-lite'); ?>
            </a>
        </li>
        <li class="<?php if($active == 'slide') echo 'as-active'; ?>">
            <a href="<?php echo wp_nonce_url(admin_url("admin.php?page=avartanslider&view=slide&id=".$slider->getFirstSlideId($slider->getId())),"asview-action","asview-nouce"); ?>"><span class="fas fa-pencil-alt"></span>
            <?php _e('Edit Slides ', 'avartan-slider-lite'); ?>
            [&nbsp;<span class="as-slider-title"><?php echo $slider->getTitle(); ?></span>]
            </a>
        </li>
        <li class="as-pull-right">
            <a href="?page=avartanslider">
                <span class="fas fa-bars"></span>
                <?php _e('All Sliders', 'avartan-slider-lite'); ?>
            </a>
        </li>
        <li class="as-pull-right">
            <a title="<?php esc_attr_e('Import Single Slide', 'avartan-slider-lite') ?>" href="javascript:void(0)" class="as-import-slide-settings as-pro-version">
                <span class="fas fa-download"></span>
                <?php _e('Import Slide', 'avartan-slider-lite'); ?>
            </a>
        </li>
    </ul>
</div>