<?php
if (!defined('ABSPATH'))
    exit();

$slot_amount = 0;
$slot_rotation = 0;
$animation_in = 'default';
$animation_out = 'default';
$data_time = AvartanSliderLiteFunctions::getVal($params_slide,'data_time',9000);
$data_easeIn = AvartanSliderLiteFunctions::getVal($params_slide,'data_easeIn',300);
$animation_select = AvartanSliderLiteFunctions::getVal($params_slide,'data_animation','fade');
?>
<div class="as-form as-form-horizontal as-animation-text-div">
    <div class="as-form-control-group">
        <label><?php _e('Slot Amount', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input class="as-slide-slot-amount as-text-number as-pro-version" type="text" readonly="readonly" value="<?php echo esc_attr($slot_amount); ?>" onkeypress="return avsIsNumberKey(event);" min="0">
        </div>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Slot Rotation', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input class="as-slide-slot-rotation as-text-number as-pro-version" type="text" readonly="readonly" value="<?php echo esc_attr($slot_rotation); ?>" onkeypress="return avsIsNumberKey(event);" min="0">
            <span class="lbl_px">deg</span>
        </div>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Ease In', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <select class="as-slide-animation-in as-pro-show">
                <?php
                foreach ($animations as $key => $value) {
                    echo '<option disabled="" class="as-pro-version" value="' . $key . '"';
                    if ($animation_in == $key) {
                        echo ' selected';
                    }
                    echo '>' . $value[0] . '</option>';
                }
                ?>
            </select>
        </div>
        <span class="option-desc"><?php _e('The in animation of the slide.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Ease Out', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <select class="as-slide-animation-out as-pro-show">
                <?php
                foreach ($animations as $key => $value) {
                    echo '<option disabled="" class="as-pro-version" value="' . $key . '"';
                    if ($animation_out == $key) {
                        echo ' selected';
                    }
                    echo '>' . $value[0] . '</option>';
                }
                ?>
            </select>
        </div>
        <span class="option-desc"><?php _e('The out animation of the slide.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Time', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input class="as-slide-animation-time as-text-number" type="text" value="<?php echo esc_attr($data_time); ?>" onkeypress="return avsIsNumberKey(event);" min="0">
            <span class="lbl_px">ms</span>
        </div>
        <span class="option-desc"><?php _e('The time that the slide will remain on the screen. Default : 9000ms', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Start Speed', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input class="as-slide-animation-easyin as-text-number" type="text" value="<?php echo esc_attr($data_easeIn); ?>" onkeypress="return avsIsNumberKey(event);" min="0">
            <span class="lbl_px">ms</span>
        </div>
        <span class="option-desc"><?php _e('The time that the slide will take to get in. Default : 300ms', 'avartan-slider-lite'); ?></span>
    </div>
</div>
<div class="as-animation-effect">
    <div class="slide-trans-example">
        <div class="slide-trans-example-inner">
            <div class="next_slide" style="overflow:hidden;width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:1">
                <div class="as-bgimg default_image"></div>
            </div>
            <div class="first_slide" style="overflow:hidden;width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:1">
                <div class="as-bgimg default_image"></div>
            </div>
        </div>
        <span><?php _e('Animation Effect will be shown in pro version', 'avartan-slider-lite')?></span>
    </div>
    <ul class="as-animation-effect-list" style="float: right;">
        <?php
        if($animation_effect){
            foreach ($animation_effect as $animation_name => $value) {
                $animation_selected = $procls = '';
                if($animation_select == $animation_name){
                    $animation_selected = " as-active";
                }
                if(!$value['status']) $procls = 'as-pro-version';
                 ?>
                <li class="<?php echo $procls.$animation_selected; ?>"  data-animation="<?php echo $animation_name; ?>"><?php echo $value['name'] ?></li>
            <?php
            }
            if($animation_select != '') {
            ?>
            <script type="text/javascript">
                jQuery('.as-animation-effect-list').animate({
                    scrollTop: jQuery('.as-animation-effect-list li[data-animation="<?php echo $animation_select ?>"]').position().top
                }, 'slow');
            </script> <?php
            }
        }
        ?>
    </ul>
</div>