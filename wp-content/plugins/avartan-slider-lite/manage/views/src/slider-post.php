<?php
if (!defined('ABSPATH'))
    exit();

//Post Settings information
$post_options = '';

$pSource = 'default';
$pdeft_style = $pSource == 'default' ? 'style="display:table-row;"' : 'style="display:none;"';
$pspec_style = $pSource == 'specific' ? 'style="display:table-row;"' : 'style="display:none;"';

$pDeftOpt = '';
$pTypes = explode(',',array('post'));
$pTerms = explode(',',array());

$pSpecs = '';

$post_order_by = 'ID';
$post_sort_order = 'DESC';
$max_posts = 10;
$excerpt_limit = 10;

//Get All Post types
$post_type = '';

$posttype_with_term = '';

?>
<div class="as-form as-form-horizontal">
    <div class="as-form-control-group">
        <label><?php _e('Source', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-pro-version">
            <select class="as-slider-post-source">
                <?php
                foreach ($slider_select_options['post_source'] as $key => $value) {
                    echo '<option value="' . $key . '"';
                    if ($pSource == $key) {
                        echo ' selected';
                    }
                    echo '>' . $value[0] . '</option>';
                }
                ?>
            </select>
        </div>
        <span class="option-desc"><?php _e('Select source type for post based slider.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group as-slide-post-deft as-slide-post">
        <label><?php _e('Post Type', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-pro-version">
            <select class="as-slider-post-type" multiple="multiple" size="4" name="as-slider-post-type">
                <option></option>
            </select>
        </div>
        <span class="option-desc"><?php _e('Select post types to dispaly posts on slider.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group as-slide-post-deft as-slide-post">
        <label><?php _e('Post Terms', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-pro-version">
            <select class="as-slider-post-terms" multiple="multiple" size="10" name="as-slider-post-terms">
                <option></option>
            </select>
        </div>
        <span class="option-desc"><?php _e('Select terms to dispaly posts on slider.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group as-slide-post-spec as-slide-post">
        <label><?php _e('Specific Post', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input class="as-slider-spec-post as-pro-version" readonly="" type="text" value="<?php echo $pSpecs; ?>" placeholder="<?php esc_attr_e('ex', 'avartan-slider-lite'); ?>: 1,2,3" />
        </div>
        <span class="option-desc"><?php _e('Enter specific post ids that is display on slider.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Sort Post By', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-pro-version">
            <select id="as-slider-post-sort-by">
                <?php
                foreach ($slider_select_options['post_sort_by'] as $key => $value) {
                    echo '<option value="' . $key . '"';
                    if ($post_order_by == $key) {
                        echo ' selected';
                    }
                    echo '>' . $value[0] . '</option>';
                }
                ?>
            </select>
        </div>
        <span class="option-desc"><?php _e('Select sorting order of display posts.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Sort Direction', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control as-pro-version">
            <select id="as-slider-post-sort-dir">
                <?php
                foreach ($slider_select_options['post_sort_dir'] as $key => $value) {
                    echo '<option value="' . $key . '"';
                    if ($post_sort_order == $key) {
                        echo ' selected';
                    }
                    echo '>' . $value[0] . '</option>';
                }
                ?>
            </select>
        </div>
        <span class="option-desc"><?php _e('Select slider post direction.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group as-slide-post-deft as-slide-post">
        <label><?php _e('Post Per Slider', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input class="as-slider-max-post as-text-number as-pro-version" readonly="" type="text" data-min-value="0" onkeypress="return avsIsNumberKey(event);" value="<?php echo $max_posts; ?>" min="0" />
            <span class="lbl_px"><?php _e('count', 'avartan-slider-lite'); ?></span>
        </div>
        <span class="option-desc"><?php _e('Set posts per slider limit.', 'avartan-slider-lite'); ?></span>
    </div>
    <div class="as-form-control-group">
        <label><?php _e('Excerpt Limit', 'avartan-slider-lite'); ?></label>
        <div class="as-form-control">
            <input class="as-slider-limit-excerpt as-text-number as-pro-version" readonly="" data-min-value="0" type="text" onkeypress="return avsIsNumberKey(event);" value="<?php echo $excerpt_limit; ?>" min="0" />
            <span class="lbl_px"><?php _e('char', 'avartan-slider-lite'); ?></span>
        </div>
        <span class="option-desc"><?php _e('Set excerpt limit for posts.', 'avartan-slider-lite'); ?></span>
    </div>
</div>