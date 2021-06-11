<?php
if (!defined('ABSPATH'))
    exit();

$slider_id = $slider->getId();
$first_slider_id = $slider->getFirstSlideId($slider_id);
$slide = new avsLiteSlide();
$slide->initSingleSlideById($first_slider_id);
$all_slide_data = $slide->getParams();

$bgoptionget = AvartanSliderLiteFunctions::getVal($all_slide_data,'background',array());
$bgtype = AvartanSliderLiteFunctions::getVal($bgoptionget,'type','transparent');

$style = $slide->avsGetSlideBG($all_slide_data);

// For get slider type
$slider->initSingleSliderById($slider_id);
$slider_option = maybe_unserialize($slider->getSettings());
$slider_type = 'standard-slider';
$wp_default_class = '';
?>
<li data-id="<?php echo $slider->getId(); ?>" data-name='<?php echo $slider->getTitle(); ?>' data-alias='<?php echo $slider->getAlias(); ?>' style="<?php echo $slider_type; ?>">
    <div class="as-slide-tab-img <?php echo $wp_default_class; ?> <?php if( $style != '' ) echo "bgtype_".$bgtype; ?>" <?php echo $style; ?>>
        <div class="as-slider-build-total-slide">
            <?php
            _e('Slides', 'avartan-slider-lite');
            echo " (" . $slider->getTotalSlides() . ")";
            ?>
        </div>
        <div class="as-slide-action">            
            <span class="as-animation-rightToLeft">
                <a class="as-btn as-slide-tab-btn as-delete-slider" id="delete_as_slider_<?php echo $slider->getId(); ?>" href="javascript:void(0)" data-delete="<?php echo $slider->getId(); ?>" title="<?php esc_attr_e('Delete Slider', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-trash-alt"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-export-slider as-pro-version" id="export_as_slider_<?php echo $slider->getId(); ?>" href="javascript:void(0);" title="<?php esc_attr_e('Export Slider', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-upload"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-duplicate-slider as-pro-version" href="javascript:void(0)" title="<?php esc_attr_e('Duplicate Slider', 'avartan-slider-lite'); ?>">
                    <span class="far fa-clipboard"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-preview-slider as-pro-version" href="javascript:void(0)" title="<?php esc_attr_e('Preview Slider', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-search"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-import-slide as-pro-version" href="javascript:void(0)" title="<?php esc_attr_e('Import Single Slide', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-download"></span>
                </a>
            </span>
        </div>
    </div>
    <div class="as-slide-tab-name">
        <div class="as-slider-detail">
            <span class="as-serial-no"><?php echo "#" . $slider_cnt; ?></span>
            <div class="as-slider-name">
                <!-- <a class="as-slider-title" title="<?php echo $slider->getTitle(); ?>" href="?page=avartanslider&view=slider&id=<?php echo $slider->getId(); ?>"><?php echo $slider->getTitle(); ?></a> -->
                <a class="as-slider-title" title="<?php echo $slider->getTitle(); ?>" href="<?php echo wp_nonce_url(admin_url("admin.php?avartanslider&view=slider&id=".$slider->getId()),"asview-action","asview-action"); ?>"><?php echo $slider->getTitle(); ?></a>
            </div>
            <div class="as-slider-shortcode">
                <input class="as-shortcode-selection" type="text" value="[avartanslider alias='<?php echo esc_attr($slider->getAlias()); ?>']" onclick="this.select();" readonly="readonly">
            </div>
            <span class="as-slider-build-total-slide">
                <?php
                _e('Slides', 'avartan-slider-lite');
                echo " (" . $slider->getTotalSlides() . ")";
                ?>
            </span>
        </div>
        <div class="as-slide-action">
            <!-- <a class="as-btn as-slide-tab-btn" href="?page=avartanslider&view=slider&id=<?php echo $slider->getId(); ?>" title="<?php esc_attr_e('Settings', 'avartan-slider-lite'); ?>">
                <span class="fas fa-cog"></span>
            </a> -->
            <a class="as-btn as-slide-tab-btn" href="<?php echo wp_nonce_url(admin_url("admin.php?page=avartanslider&view=slider&id=".$slider->getId()),"asview-nouce","asview-nouce" )?>" title="<?php esc_attr_e('Settings', 'avartan-slider-lite'); ?>">
                <span class="fas fa-cog"></span>
            </a>
            <a class="as-btn as-slide-tab-btn" href="<?php echo wp_nonce_url(admin_url("admin.php?page=avartanslider&view=slide&id=".$slider->getFirstSlideId($slider->getId())),"asview-action","asview-nouce"); ?>" title="<?php esc_attr_e('Edit Slides', 'avartan-slider-lite'); ?>">
                <span class="fas fa-pencil-alt"></span>
            </a> 
            <div class="as-listview-action">
                <a class="as-btn as-slide-tab-btn as-delete-slider" id="delete_as_slider_<?php echo $slider->getId(); ?>" href="javascript:void(0)" data-delete="<?php echo $slider->getId(); ?>" title="<?php esc_attr_e('Delete Slider', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-trash-alt"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-export-slider as-pro-version" id="export_as_slider_<?php echo $slider->getId(); ?>" href="javascript:void(0);" title="<?php esc_attr_e('Export Slider', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-upload"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-duplicate-slider as-pro-version" href="javascript:void(0)" title="<?php esc_attr_e('Duplicate Slider', 'avartan-slider-lite'); ?>">
                    <span class="far fa-clipboard"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-preview-slider as-pro-version" href="javascript:void(0)" title="<?php esc_attr_e('Preview Slider', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-search"></span>
                </a>
                <a class="as-btn as-slide-tab-btn as-import-slide as-pro-version" href="javascript:void(0)" title="<?php esc_attr_e('Import Single Slide', 'avartan-slider-lite'); ?>">
                    <span class="fas fa-download"></span>
                </a>
            </div>
            <button class="as-btn as-slide-tab-btn as-advance-embadded" title="<?php esc_attr_e('Advanced Embedded Code', 'avartan-slider-lite'); ?>">
                <span class="fas fa-arrows-alt"></span>
            </button>
        </div>
    </div>
</li>