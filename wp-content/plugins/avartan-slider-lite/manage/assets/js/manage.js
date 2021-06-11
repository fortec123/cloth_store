/*
 * ======================================
 * GLOBAL VARIABLES
 * ======================================
 */
var objLayer = {};
var ele_count = 0;
var current_index = 0;
var loadWin = 1;
var default_array = JSON.stringify(avs_default_layer_value.layer_value);
var default_colors = JSON.parse(JSON.stringify(avs_default_colors.colors));
//var default_array = '';
var ele_left = 100;
var ele_top = 100;
var select2_load = 1;
var element_index = 1;
var save_needed = false;
var changeD = false;

jQuery(window).load(function () {
    //Hide loader
    avsShowLoader({hideTime:300});

    // add class to parent div of dialog
    jQuery(".ui-dialog.ui-widget").addClass("as-wrapper");

    if(jQuery( window ).width() > 850) {
        var slider_ver_tab_height = 0;
        jQuery(".as-wrapper .as-edit-slider .as-tabs-verticle > ul.ui-tabs-nav li.ui-state-default, .as-wrapper .as-add-slider .as-tabs-verticle > ul.ui-tabs-nav li.ui-state-default").each(function() {
           slider_ver_tab_height += jQuery(this).outerHeight(true);
        });
        jQuery(".as-wrapper .as-edit-slider .ui-tabs.as-tabs-verticle, .as-wrapper .as-add-slider .ui-tabs.as-tabs-verticle").css("min-height", slider_ver_tab_height - 2);

        var slide_ver_tab_height = 0;
        jQuery(".as-wrapper .as-edit-slide .as-tabs-verticle > ul.ui-tabs-nav li.ui-state-default, .as-wrapper .as-add-slide .as-tabs-verticle > ul.ui-tabs-nav li.ui-state-default").each(function() {
           slide_ver_tab_height += jQuery(this).outerHeight(true);
        });
        jQuery(".as-wrapper .as-edit-slide .ui-tabs.as-tabs-verticle , .as-wrapper .as-add-slide .ui-tabs.as-tabs-verticle").css("min-height", slide_ver_tab_height - 1);
    }
    else {
        jQuery(".as-wrapper .as-edit-slider .ui-tabs.as-tabs-verticle, .as-wrapper .as-add-slider .ui-tabs.as-tabs-verticle").css("min-height", 0);
        jQuery(".as-wrapper .as-edit-slide .ui-tabs.as-tabs-verticle, .as-wrapper .as-add-slide .ui-tabs.as-tabs-verticle").css("min-height", 0);
    }

    //subscribe code
    jQuery('#subscribe_thickbox').trigger('click');
    jQuery("#TB_closeWindowButton").click(function() {
         jQuery.post(ajaxurl,
         {
             'action': 'close_tab'
         });
    });
    // deactivation popup code
    var avl_plugin_admin = jQuery('.documentation_avl_plugin').closest('div').find('.deactivate').find('a');
    jQuery('.avl-deactivation').on('click', function() {
        window.location.href = avl_plugin_admin.attr('href');
    });

    avl_plugin_admin.click(function(event){
        event.preventDefault();
        jQuery('#deactivation_thickbox_avl').trigger('click');
        jQuery('#TB_window').removeClass('thickbox-loading');
        change_thickbox_size_avl();
    });
    checkOtherDeactivateAvl();
    jQuery('.sol_deactivation_reasons').click(function(){
        checkOtherDeactivateAvl();
    });
    jQuery('#sbtDeactivationFormCloseavl').click(function(event){
        event.preventDefault();
        jQuery("#TB_closeWindowButton").trigger('click');
    })
    function checkOtherDeactivateAvl() {
        var selected_option_de = jQuery('input[name=sol_deactivation_reasons_avl]:checked', '#frmDeactivationavl').val();
        jQuery('.sol_deactivation_reason_other_avl').val('');
        if(selected_option_de == '10') {
            jQuery('.sol_deactivation_reason_other_avl').show();
        }
        else {
            jQuery('.sol_deactivation_reason_other_avl').hide();
        }
    }
    function change_thickbox_size_avl() {
        jQuery(document).find('#TB_window').width( '700' ).height( '500' ).css( 'margin-left', - 700 / 2 );
        jQuery(document).find('#TB_ajaxContent').width( '640' ).height( '500' );
        var doc_height = jQuery(window).height();
        var doc_space = doc_height - 500;
        if(doc_space > 0) {
            jQuery(document).find('#TB_window').css('margin-top',doc_space/2);
        }
    }
});

jQuery( window ).resize(function() {
    if(jQuery( window ).width() > 850) {
        var slider_ver_tab_height = 0;
        jQuery(".as-wrapper .as-edit-slider .as-tabs-verticle > ul.ui-tabs-nav li.ui-state-default").each(function() {
           slider_ver_tab_height += jQuery(this).outerHeight(true);
        });
        jQuery(".as-wrapper .as-edit-slider .ui-tabs.as-tabs-verticle").css("min-height", slider_ver_tab_height - 2);

        var slide_ver_tab_height = 0;
        jQuery(".as-wrapper .as-edit-slide .as-tabs-verticle > ul.ui-tabs-nav li.ui-state-default").each(function() {
           slide_ver_tab_height += jQuery(this).outerHeight(true);
        });
        jQuery(".as-wrapper .as-edit-slide .ui-tabs.as-tabs-verticle").css("min-height", slide_ver_tab_height - 1);
    }
    else {
        jQuery(".as-wrapper .as-edit-slider .ui-tabs.as-tabs-verticle").css("min-height", 0);
        jQuery(".as-wrapper .as-edit-slide .ui-tabs.as-tabs-verticle").css("min-height", 0);
    }
});

jQuery(document).ready(function () {

    jQuery("input[name='txtPermissionDeacavl']").change(function () {
        if (jQuery(this).is(':checked')) {
            jQuery("#sbtDeactivationFormavl").removeAttr('disabled');
        } else {
            jQuery("#sbtDeactivationFormavl").attr('disabled', 'disabled');
        }
    });

    jQuery('.as-pro-version').on('click', function(e) {
        if(!jQuery(this).hasClass('as-slide-layer-width') && !jQuery(this).hasClass('as-slide-layer-height')){
            avsProPopup();
        }
    });

    jQuery('#as_tab_new_slider .as-slider-build-block.as-pro-version').on('click', function(e) {
        create_new_slider_dialog.dialog("close");
        return false;
    });

    jQuery('.as-slider-preview-mobile.as-pro-version').on('click', function(e) {
        preview_slide_dialog.dialog("close");
        return false;
    });

    jQuery('#as_tab_default_template .as-pro-version').on('click', function(e) {
        create_new_slider_dialog.dialog("close");
        return false;
    });

    // Script for system status
    var clipboard = new Clipboard('#copy-for-support');
    clipboard.on('success', function (event) {
        event.clearSelection();
        event.trigger.textContent = avs_translations.copied;
        window.setTimeout(function () {
            event.trigger.textContent = avs_translations.copy_for_support;
        }, 1000);
    });


    //hover tab
    jQuery('.as-editor-tabs').children('ul').children('li').click(function(){
            avsLayerDefVal();
    });

    jQuery('.as-editor-videoImg').on('keyup change',function() {
        var img_old = jQuery('.as-active-element').find('img');
        var img_old_width = img_old.width();
        var img_old_height = img_old.height();
        var img_old_title = img_old.attr('title');
        var img_old_alt = img_old.attr('alt');
        var img_url = jQuery('.as-editor-videoImg').val();
        if(img_url == '') {
            jQuery('.as-remove-preview-image-element-upload-button').trigger('click');
        }
        else {
            var img_new = jQuery("<img />").error(function() {
            })
            .attr('src', img_url).on('load', function() {
                if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {

                } else {
                    img_new.attr('height',img_old_height);
                    img_new.attr('width',img_old_width);
                    img_new.attr('title',img_old_title);
                    img_new.attr('alt',img_old_alt);
                    img_old.replaceWith(img_new);
                }
            });
        }
    });

    //COMMON EVENTS

    /*
     * Intialize tabs
     */
    jQuery(".as-tabs-verticle").tabs();
    jQuery(".as-tabs-horizontal").tabs();
    jQuery(".as-editor-tabs").tabs();
    jQuery(".as-dialog-tabs").tabs();
    jQuery(".as-tab-video-element").tabs();

    /*
     * Call color picker function
     */
    avsInitializeColorPicker();

    /*
     * Set Action button At top right corner when scroll down page
     */
    if(jQuery(".as-action-button").length) {
        var top_height = jQuery(".as-action-button").offset().top;
        var height = jQuery(".as-action-button").height();
        jQuery(document).on("scroll", function () {
            var scroll = jQuery(window).scrollTop();
            if (scroll > (top_height + height - 32)) {
                if (!jQuery(".as-action-button").hasClass("as-sticky")) {
                    jQuery(".as-action-button").addClass("as-sticky");
                }
            } else if (scroll <= (top_height + height - 32)) {
                if (jQuery(".as-action-button").hasClass("as-sticky")) {
                    jQuery(".as-action-button").removeClass("as-sticky");
                }
            }
        });
    }

    jQuery('.as-admin .as-home .as-panel .wp-picker-container').on('click', function () {
        loadWin = 0;
    });

    jQuery("body").on("keydown keyup", function (e) {

        var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element'),
            x = parseInt(jQuery('.as-slide-x-position').val()),
            y = parseInt(jQuery('.as-slide-y-position').val()),
            code = (e.keyCode ? e.keyCode : e.which),
            step = 1;

        if (e.shiftKey)
            step = step * 10;

        step = parseInt(step);
        switch (jQuery(document.activeElement).get(0).tagName.toLowerCase()) {
            case "INPUT":
            case "input":
                if (jQuery(document.activeElement).hasClass('as-text-number') && !jQuery(document.activeElement).hasClass('as-pro-version')) {
                    var input_number = parseFloat(jQuery(document.activeElement).val());
                    input_number = Number(input_number);
                    if (jQuery.isNumeric(input_number)) {
                        switch (code) {
                            case 38:
                                if (e.type === "keyup")
                                    avsFocusBlur(step, input_number, jQuery(document.activeElement));
                                return false;
                                break;
                            case 40:
                                if(jQuery(document.activeElement).data('min-value') == input_number)
                                    return false;
                                if (e.type === "keyup")
                                    avsFocusBlur(-step, input_number, jQuery(document.activeElement));
                                return false;
                                break;
                        }
                    }
                }
                break;
            case "textarea":
                    return true;
            break;
            default:
                    switch(code) {
                        case 46:
                                e.preventDefault();
                                if (e.type === "keydown" && editorLayer.length > 0) {
                                        jQuery('.as-editor-footer .as-editor-action-icon .as-delete-layer').click();
                                }
                        break;
                    }
            break;
        }
    });

    avsEditorMeasurement();

    /*
    * ======================================
    * HOME PAGE SETTINGS
    * ======================================
    */

    /*
    * jquery for Hide/show slider list layout grid view and list view
    */
    if (jQuery('.as-grid-view').hasClass("as-active")) {
        jQuery('.as-slider-list').addClass("as-gridview")
        jQuery('.as-slider-list').removeClass("as-listview")
    } else if (jQuery('.as-list-view').hasClass("as-active")) {
        jQuery('.as-slider-list').removeClass("as-gridview")
        jQuery('.as-slider-list').addClass("as-listview")
    }

    jQuery('.as-grid-view').on('click', function () {
        jQuery('.as-panel-header .as-action-button .as-btn').removeClass("as-active");
        jQuery(this).addClass("as-active");
        jQuery('.as-slider-list').addClass("as-gridview")
        jQuery('.as-slider-list').removeClass("as-listview")
    });
    jQuery('.as-list-view').on('click', function () {
        jQuery('.as-panel-header .as-action-button .as-btn').removeClass("as-active");
        jQuery(this).addClass("as-active");
        jQuery('.as-slider-list').removeClass("as-gridview")
        jQuery('.as-slider-list').addClass("as-listview")
    });

    /*
     * jquery for define and open dialog box for delete slider
     */
    var delete_slider_dialog = jQuery("#dialog_delete_slider_confirm").dialog({
        resizable: false,
        draggable: false,
        height: "auto",
        width: 400,
        modal: true,
        autoOpen: false,
        dialogClass: 'as-wrapper',
        buttons: [
            {
                text: avs_translations.delete_slider,
                "class": 'as-btn as-btn-primary',
                click: function () {
                    // Get options
                    var slider_id = jQuery(this).data('slider_id');
                    var final_options = new Array();
                    final_options.push({"slider_id": parseInt(slider_id)});
                    // Do the ajax call
                    avsAjaxRequestCall('delete_slider', final_options, 'json', function (response) {
                    });
                    jQuery(this).dialog("close");
                }
            },
            {
                text: avs_translations.cancel,
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                }
            }
        ]
    });
    jQuery(".as-delete-slider").on("click", function () {
        var slider_id = jQuery(this).attr('id').replace("delete_as_slider_", "");
        if(slider_id == '' || slider_id == undefined) {
            avsShowMsg(avs_translations.slider_error_delete, 'danger');
        } else {
            delete_slider_dialog.data('slider_id', slider_id).dialog("open");
        }
    });


   /*
     * jquery for define and open dialog box for create new slider
     */
    var create_new_slider_dialog = jQuery("#dialog_create_new_slider").dialog({
        resizable: false,
        draggable: false,
        width: "850px",
        modal: true,
        autoOpen: false,
        dialogClass: 'as-wrapper',
        buttons: [
            {
                text: avs_translations.create_slider,
                "class": 'as-btn as-btn-create_slider as-btn-primary',
                click: function () {
                    var $href = jQuery('#as_tab_new_slider .as-slider-build-block.active').attr('href');
                    window.location.href = avs_translations.admin_url +"admin.php"+ $href;
                }
            },
            {
                text: avs_translations.close,
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                }
            }
        ]
    });
    jQuery(".as-create-new-slider").on("click", function () {
        create_new_slider_dialog.dialog("open");
    });
    jQuery('#as_tab_new_slider').on('click', '.as-slider-build-block', function(e) {
        e.preventDefault();
    });

    /*
     * jquery for define and open dialog box for Advance Embadded Slider
     */
    var advance_embadded_slider_dialog = jQuery("#dialog_advance_embadded_slider").dialog({
        resizable: false,
        draggable: false,
        height: "auto",
        width: 350,
        modal: true,
        autoOpen: false,
        dialogClass: 'as-wrapper',
        buttons: [
            {
                text: avs_translations.cancel,
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                }
            }
        ]
    });
    jQuery(".as-advance-embadded").on("click", function () {
        var as_slider_alias = jQuery(this).closest('li').data('alias');
        var as_slider_shortcode = jQuery(this).closest('li').find('input.as-shortcode-selection').val();
        var as_slider_php = "if(function_exists('avartanslider')) avartanslider('" + as_slider_alias + "');";
        jQuery('#dialog_advance_embadded_slider').find('#embadded_shortcode').val(as_slider_shortcode);
        jQuery('#dialog_advance_embadded_slider').find('#embadded_php').val(as_slider_php);
        advance_embadded_slider_dialog.dialog("open");
    });

    /*
    * ======================================
    * SLIDER SETTINGS
    * ======================================
    */

    jQuery('.as-slider').find('.as-slider-name').on('blur', function () {
        var alias = avsGetAlias();
        var shortcode = "[avartanslider alias='" + alias + "']";
        var phpfunction = "if(function_exists('avartanslider')) avartanslider('" + alias + "');";
        if (alias != '' && jQuery.trim(jQuery('.as-slider').find('.as-slider-alias').val()) == '') {
            jQuery('.as-slider').find('.as-slider-alias').val(alias);
            jQuery('.as-slider').find('.as-slider-shortcode').val(shortcode);
            jQuery('.as-slider').find('.as-slider-php-function').val(phpfunction);
        }
    });

    jQuery('.as-admin .as-save-settings').click(function () {

        if (jQuery.trim(jQuery(this).closest('.as-slider').find('.as-slider-name').val()) != '' && jQuery.trim(jQuery(this).closest('.as-slider').find('.as-slider-alias').val()) != '')
        {
            avsSaveSlider();
        }
        else
        {
            if (jQuery.trim(jQuery(this).closest('.as-slider').find('.as-slider-name').val()) == '')
            {
                jQuery(this).closest('.as-slider').find('.as-slider-name').focus();
                avsShowMsg(avs_translations.slider_name, 'danger');
            }
            else if (jQuery.trim(jQuery(this).closest('.as-slider').find('.as-slider-alias').val()) == '')
            {
                jQuery(this).closest('.as-slider').find('.as-slider-alias').focus();
                avsShowMsg(avs_translations.slider_alias, 'danger');
            }
        }
    });

    /* LAYOUT SETTINGS */

    /*
     * jquery for display layout base on option selected like fixed, full width, full screen
     */
    if (jQuery('.as-layout-button.as-active').val() == 'full-width') {
        jQuery('.as-force-full-width').show();
    } else {
        jQuery('.as-force-full-width').hide();
    }
    jQuery(".as-layout-button").on("click", function () {
        jQuery(".as-layout-button").removeClass("as-active");
        jQuery(this).addClass("as-active");
        avsReadLayoutValues();
        if (jQuery(this).val() == 'full-width') {
            jQuery('.as-force-full-width').show();
        } else {
            jQuery('.as-force-full-width').hide();
        }
    });

    jQuery('.as-toggle-indicator.as-custom-design-toggle input[type="radio"]:checked').change();

    /* GENERAL SETTINGS */

    //LOADER
    /*
     * jquery for display loader style or image
     */
    jQuery('.as-toggle-indicator.as-loader-toggle input[type="radio"]').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-loader-type').show();
            if (jQuery('.as-loader-type select.as-loaderType option:selected').val() == 0) {
                jQuery('.as-loader-style').show();
                jQuery('.as-loader-img').hide();
            } else {
                jQuery('.as-loader-style').hide();
                jQuery('.as-loader-img').show();
            }
        } else {
            jQuery('.as-loader-type, .as-loader-style, .as-loader-img').hide();
        }
    });
    jQuery('.as-toggle-indicator.as-loader-toggle input[type="radio"]:checked').change();

    /*
     * jquery for display loader type style based on selection of loader type
     */
    jQuery('.as-loader-type select.as-loaderType').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-loader-style').hide();
            jQuery('.as-loader-img').show();
        } else {
            jQuery('.as-loader-style').show();
            jQuery('.as-loader-img').hide();
        }
    });
    jQuery('.as-loader-type select.as-loaderType').change();

    /*
     * jquery for define and open dialog box for loader style
     */
    var loader_dialog = jQuery("#dialog_loader_style").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        height: 410,
        width: 900,
        modal: true,
        dialogClass: 'as-wrapper',
    });
    jQuery(".as-loaderStyle").on("click", function () {
        loader_dialog.dialog("open");
    });

    /*
     * jquery for set as selected loader to main content part
     */
    jQuery('.as-dialog-loader-style').on('click', function () {
        var lStyle = jQuery.trim(jQuery(this).find('.as-loader-style-hidden').val());
        var lHtml = jQuery.trim(jQuery(this).find('.as-loader-style-html').html());

        jQuery('.as-loader-style .as-selected-loader-style').find('.as-loader-style-hidden').val(lStyle);
        if (lHtml != '') {
            jQuery('.as-loader-style .as-selected-loader-style').css('display', 'table');
        }
        jQuery('.as-loader-style .as-selected-loader-style').find('.as-loader-style-html').html(lHtml);
        loader_dialog.dialog("close");
    });

    /* VISUAL SETTINGS */

    //SLIDER BACKGROUND
    /*
     * jquery for display color picker based on background color selection
     */
    jQuery('.as-slider-bgcolor').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-slider-bg-colorpicker').show();
        } else {
            jQuery('.as-slider-bg-colorpicker').hide();
        }
    });
    jQuery('.as-slider-bgcolor').change();

    //SHADOW

    /*
     * jquery for hide/show shadow based on selection in Appearance
     */
    jQuery('.as-slider-shadow').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-slider-shadow-img').show();
        } else {
            jQuery('.as-slider-shadow-img').hide();
        }
    });
    jQuery('.as-slider-shadow').change();

    //Select deault shadow from given list
    jQuery('.as-admin .as-slider').on('click', '.as-slider-shadow-img .as-shadow-img', function () {
        jQuery('.as-shadow-img').removeClass('as-active');
        jQuery(this).addClass('as-active');
        var image_class = jQuery(this).find('img').attr('data-shadow-class');
        jQuery(this).closest('.as-slider-shadow-img').find('.as-slider-default-shadow').attr('data-shadow-class', image_class);
    });

    /*
     * jquery for display shadow selection
     */
    jQuery(".as-shadow-img").on("click", function () {
        jQuery(".as-shadow-img").removeClass("as-active");
        jQuery(this).addClass("as-active");
    });

    //TIMER BAR
    /*
     * jquery for hide/show Timer Bar Position based on on/off Show Timer Bar in visual timer bar
     */
    jQuery('.as-toggle-indicator.as-timerbar-toggle input[type="radio"]').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-timerbar-position').show();
        } else {
            jQuery('.as-timerbar-position').hide();
        }
    });
    jQuery('.as-toggle-indicator.as-timerbar-toggle input[type="radio"]:checked').change();

    /* NAVIGATION SETTINGS */

    //ARROW
    /*
     * jquery for define and open dialog box for arrow style
     */
    var arrow_dialog = jQuery("#dialog_arrows_style").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        height: 320,
        width: 550,
        modal: true,
        dialogClass: 'as-wrapper',
        open: function(){
            var arrow_sel = jQuery('.as-form-control .as-arrow-style-hidden').val();
            jQuery('.as-arrow-style-box .as-dialog-arrow-style').removeClass('avs_selected');
            jQuery('.as-arrow-style-box .as-dialog-arrow-style').each(function() {
                if(jQuery(this).find('.as-arrows-style-hidden').val() == arrow_sel) {
                    jQuery(this).closest('.as-dialog-arrow-style').addClass('avs_selected');
                }
            })

        }
    });
    jQuery(".as-arrowStyle").on("click", function () {
        arrow_dialog.dialog("open");
    });

    /*
     * jquery for set as selected arrow to main content part
     */
    jQuery('.as-dialog-arrow-style').on('click', function () {
        var aStyle = jQuery.trim(jQuery(this).find('.as-arrows-style-hidden').val());
        var aHtml = jQuery(this).find('.as-nav-arrows').html();
        jQuery('.as-selected-arrow-style').find('.as-arrow-style-hidden').val(aStyle);
        jQuery('.as-selected-arrow-style').find('.as-nav-arrows').html(aHtml);

        arrow_dialog.dialog("close");
    });

    /*
     * jquery for enabled/disabled arrow options
     */
    jQuery('.as-toggle-indicator.as-nav-arrows-toggle input[type="radio"]').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-tab-arrows-enabled').show();
        } else {
            jQuery('.as-tab-arrows-enabled').hide();
        }
    });
    jQuery('.as-toggle-indicator.as-nav-arrows-toggle input[type="radio"]:checked').change();

    //BULLET
    /*
     * jquery for enabled/disabled bullets options
     */
    jQuery('.as-toggle-indicator.as-nav-bullets-toggle input[type="radio"]').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-tab-bullets-enabled').show();
        } else {
            jQuery('.as-tab-bullets-enabled').hide();
        }
    });
    jQuery('.as-toggle-indicator.as-nav-bullets-toggle input[type="radio"]:checked').change();

    /*
     * jquery for define and open dialog box for bullet style
     */
    var bullet_dialog = jQuery("#dialog_bullets_style").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        height: 250,
        width: 640,
        modal: true,
        dialogClass: 'as-wrapper',
        open: function(){
            var arrow_sel = jQuery('.as-form-control .as-bullet-style-hidden').val();
            jQuery('.as-bullet-style-box .as-dialog-bullet-style').removeClass('avs_selected');
            jQuery('.as-bullet-style-box .as-dialog-bullet-style').each(function() {
                if(jQuery(this).find('.as-bullet-style-hidden').val() == arrow_sel) {
                    jQuery(this).closest('.as-dialog-bullet-style').addClass('avs_selected');
                }
            })

        }
    });
    jQuery(".as-bulletStyle").on("click", function () {
        bullet_dialog.dialog("open");
    });

    /*
     * jquery for set as selected arrow to main content part
     */
    jQuery('.as-dialog-bullet-style').on('click', function () {
        var bStyle = jQuery.trim(jQuery(this).find('.as-bullet-style-hidden').val());
        var bHtml = jQuery(this).find('.as-bullets-wrap').html();
        jQuery('.as-selected-bullet-style').find('.as-bullet-style-hidden').val(bStyle);
        jQuery('.as-selected-bullet-style').find('.as-bullets-wrap').html(bHtml);
        bullet_dialog.dialog("close");
    });

    /*
    * ======================================
    * SLIDE SETTINGS
    * ======================================
    */

    jQuery('#dialog_preview_slide').on('click','.as-slider-preview-desktop',function(){
        jQuery("#dialog_preview_slide").dialog( "option", "width", jQuery(window).width() );
        jQuery(this).addClass('as-active');
        jQuery('.as-slide-live-preview-area').css({'width':'100%','height': jQuery('.as-slider-height').val()+'px','margin':'0 auto'});
        jQuery(window).trigger('resize');
    });

    /*
     * jquery for hide/show parallax option
     */
    jQuery('.as-toggle-indicator#as-slider-parallax-effect input[type="radio"]').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-slide-parallax-setting').show();
        } else {
            jQuery('.as-slide-parallax-setting').hide();
        }
    });
    jQuery('.as-toggle-indicator#as-slider-parallax-effect input[type="radio"]:checked').change();

    jQuery('.as-toggle-indicator#as-slider-parallax-3d-effect input[type="radio"]').on('change', function () {
        if (jQuery(this).val() == 1) {
            jQuery('.as-3d-effect-show').show();
            jQuery('.as-3d-effect-hide').hide();
        } else {
            jQuery('.as-3d-effect-show').hide();
            jQuery('.as-3d-effect-hide').show();
        }
    });
    jQuery('.as-toggle-indicator#as-slider-parallax-3d-effect input[type="radio"]:checked').change();

    /*
     * jquery for define and open dialog box for delete slide
     */
    var delete_slide_dialog = jQuery("#dialog_delete_slide_confirm").dialog({
        resizable: false,
        draggable: false,
        height: "auto",
        width: 400,
        modal: true,
        autoOpen: false,
        dialogClass: 'as-wrapper',
        buttons: [
            {
                text: avs_translations.delete_slide,
                "class": 'as-btn as-btn-primary',
                click: function () {
                    // Get options
                    var slider_id = jQuery(this).data('slider_id');
                    var slide_id = jQuery(this).data('slide_id');
                    var current_slide = jQuery(this).data('current_slide');
                    var current_li = jQuery(this).data('current_li');
                    var final_options = new Array();
                    final_options.push({"slider_id": parseInt(slider_id), "slide_id": parseInt(slide_id), "current_slide": current_slide});
                    // Do the ajax call
                    avsAjaxRequestCall('delete_slide', final_options, 'json', function (response) {
                    });
                    var li_length = current_li.closest('.as-slide-tabs').find('.as-slide-tab-block').length;
                    li_length--;
                    if (li_length != 1) {
                        current_li.closest('li.as-slide-tab-block').remove();
                        avsUpdateSlidePos();
                    }
                    jQuery(this).dialog("close");
                }
            },
            {
                text: avs_translations.cancel,
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                }
            }
        ]
    });

    jQuery('.as-admin').on('click', ".as-delete-slide", function (e) {
        e.preventDefault();
        var slide_id = jQuery(this).attr('id').replace("delete_as_slide_", "");
        var slider_id = jQuery('.as-edit-slide .as-slider-id').val();
        var current = jQuery(this).closest('li.as-slide-tab-block').hasClass('as-active') ? 'yes' : 'no';
        delete_slide_dialog.data({'slide_id': slide_id, 'slider_id': slider_id, 'current_li':jQuery(this) ,'current_slide': current}).dialog("open");
    });

    /*
     * jquery for define and open dialog box for preview slide
     */
    var preview_slide_dialog = jQuery("#dialog_preview_slide").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        height: jQuery(window).height(),
        width: jQuery(window).width(),
        modal: true,
        dialogClass: 'as-wrapper',
        buttons: [
            {
                text: avs_translations.cancel,
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                }
            }
        ],
        close: function(event, ui) {
            jQuery('#dialog_preview_slide').find('.as-slide-live-preview-area').html('');
            jQuery('#dialog_preview_slide').find('.as-slider-h, .as-slider-mh').val('');
            jQuery("#dialog_preview_slide").dialog( "option", "width", jQuery(window).width() );
        },
    });
    jQuery('.as-admin').on('click', ".as-duplicate-slide,.as-copy-move-slide,.as-export-slide", function (e) {
        e.preventDefault();
    });

    jQuery('body').on('click', ".as-preview-slide", function () {
        avsShowLoader({showTime:300});
        avsDeselectElements();
        var final_options = new Array();
        //Get Json Array of settings
        final_options = avsSetSlideLayerSettings();
        var prev = jQuery('#dialog_preview_slide').find('.as-slide-live-preview-area');
        prev.html('');
        jQuery('#dialog_preview_slide').find('.as-slider-h').val(jQuery('.as-slider-height').val());
        jQuery('#dialog_preview_slide .as-slider-preview-mobile').removeClass('as-active');
        jQuery('#dialog_preview_slide .as-slider-preview-desktop').addClass('as-active');

        jQuery('.as-slide-live-preview-area').css({'width':'100%','height': jQuery('.as-slider-height').val()+'px','margin':'0 auto'});

        avsAjaxRequestCall('preview_slide', final_options, 'json', function (response) {});
        jQuery(window).trigger('resize');
        setTimeout(function(){
            preview_slide_dialog.dialog("open");
            avsShowLoader({hideTime:300});
        }, 300);
    });

    /*
     * jquery for add new slide
     */
    jQuery(".as-create-new-slide").on("click", function () {
        var slider_id = jQuery('.as-edit-slide .as-slider-id').val();
        var final_options = new Array();
        final_options.push({"slider_id": parseInt(slider_id)});
        // Do the ajax call
        avsAjaxRequestCall('add_slide_from_slideview', final_options, 'json', function (response) {
        });
    });

    /**
     * Sorting slide list
     */
    var slide_before; // Contains the index before the sorting
    var slide_after; // Contains the index after the sorting

    //Set sortable
    jQuery('.as-slide-tabs.as-sortable').sortable({
        items: 'li:not(.as-create-new-slide)',
        connectWith: ".as-slide-list",
        // Store the actual index
        start: function (event, ui) {
            slide_before = jQuery(ui.item).index();
            slide_before--;
        },
        // Change the .as-slide order based on the new index and rename the tabs
        update: function (event, ui) {
            // Store the new index
            slide_after = jQuery(ui.item).index();
            slide_after--;

            // Rename all the tabs
            jQuery('.as-edit-slide .as-slide-tabs li.as-sorting-li').each(function () {
                var temp = jQuery(this);
                var position = temp.index();
                position--;
                temp.find('.as-slide-tab-name').find('.as-serial-no').html(('#' + position));
            });
            avsUpdateSlidePos();
            avsShowMsg('Slide position updated.', 'success');
        }
    });

    /* SLIDE BACKGROUND */
    /*
     * jquery for hide/show option based on background type
     */
    jQuery('.as-slide-bg-type').on('change', function () {

        //hide/show parallex tab
        if (jQuery(this).val() == 'transparent' || jQuery(this).val() == 'solid_color' || jQuery(this).val() == 'gradient_color') {
            jQuery('.as-slide-parallax-show-hide').hide();
            jQuery('#as_tab_parallax').hide();
        }else{
            jQuery('.as-slide-parallax-show-hide').show();
        }

        if (jQuery(this).val() == 'transparent') {
            jQuery('.as-bgtype-solidColor').hide();
            jQuery('.as-bgtype-gradientColor').hide();
            jQuery('.as-bgtype-image').hide();
            jQuery('.as-bgtype-youTubeVideo').hide();
            jQuery('.as-bgtype-vimeoVideo').hide();
            jQuery('.as-bgtype-htmlVideo').hide();
        }
        if (jQuery(this).val() == 'solid_color') {
            jQuery('.as-bgtype-solidColor').show();
            jQuery('.as-bgtype-gradientColor').hide();
            jQuery('.as-bgtype-image').hide();
            jQuery('.as-bgtype-youTubeVideo').hide();
            jQuery('.as-bgtype-vimeoVideo').hide();
            jQuery('.as-bgtype-htmlVideo').hide();
        }
        if (jQuery(this).val() == 'featured_image') {
            jQuery('.as-bgtype-solidColor').hide();
            jQuery('.as-bgtype-gradientColor').hide();
            jQuery('.as-bgtype-image').hide();
            jQuery('.as-bgtype-youTubeVideo').hide();
            jQuery('.as-bgtype-vimeoVideo').hide();
            jQuery('.as-bgtype-htmlVideo').hide();
        }
        if (jQuery(this).val() == 'gradient_color') {
            jQuery('.as-bgtype-solidColor').hide();
            jQuery('.as-bgtype-gradientColor').show();
            jQuery('.as-bgtype-image').hide();
            jQuery('.as-bgtype-youTubeVideo').hide();
            jQuery('.as-bgtype-vimeoVideo').hide();
            jQuery('.as-bgtype-htmlVideo').hide();
        }
        if (jQuery(this).val() == 'image') {
            jQuery('.as-bgtype-solidColor').hide();
            jQuery('.as-bgtype-gradientColor').hide();
            jQuery('.as-bgtype-image').show();
            jQuery('.as-bgtype-youTubeVideo').hide();
            jQuery('.as-bgtype-vimeoVideo').hide();
            jQuery('.as-bgtype-htmlVideo').hide();
            jQuery('.as-slide-kenburns-show-hide').show();
        }else{
            jQuery('.as-slide-kenburns-show-hide').hide();
            jQuery('#as_tab_kenburns').hide();
        }
        if (jQuery(this).val() == 'youtube_video') {
            jQuery('.as-bgtype-solidColor').hide();
            jQuery('.as-bgtype-gradientColor').hide();
            jQuery('.as-bgtype-image').hide();
            jQuery('.as-bgtype-youTubeVideo').show();
            jQuery('.as-bgtype-vimeoVideo').hide();
            jQuery('.as-bgtype-htmlVideo').hide();
        }
        if (jQuery(this).val() == 'vimeo_video') {
            jQuery('.as-bgtype-solidColor').hide();
            jQuery('.as-bgtype-gradientColor').hide();
            jQuery('.as-bgtype-image').hide();
            jQuery('.as-bgtype-youTubeVideo').hide();
            jQuery('.as-bgtype-vimeoVideo').show();
            jQuery('.as-bgtype-htmlVideo').hide();
        }
        if (jQuery(this).val() == 'html5_video') {
            jQuery('.as-bgtype-solidColor').hide();
            jQuery('.as-bgtype-gradientColor').hide();
            jQuery('.as-bgtype-image').hide();
            jQuery('.as-bgtype-youTubeVideo').hide();
            jQuery('.as-bgtype-vimeoVideo').hide();
            jQuery('.as-bgtype-htmlVideo').show();
        }
    });
    jQuery('.as-slide-bg-type').change();

    //IMAGE BACKGROUND

    //Set Background image (the upload function)
    jQuery('.as-edit-slide').on('click', '.as-slide-bg-image', function () {
        var slide_parent = jQuery(this).closest('.as-admin');
        if (jQuery(slide_parent).find('.as-slide-bg-type').val() == 'image') {
            avsAddSlideImageBackground(slide_parent);
        }
    });

    //IMAGE ADVANCED SETTINGS

    //Select background type
    jQuery('.as-admin').on('change', '.as-slide-bg-type', function () {
        var area = jQuery(this).closest('.as-home');
        var bg_type = jQuery(this).val();

        //reset settings
        jQuery(area).find('.as-main-bg').hide();


        //BG image and color
        area.find('.as-slide-bgcolor').val('');
        area.find('.as-slide-bgcolor').closest('.as-form-control').find('.wp-color-result span').css('background', 'transparent');
        var slidebg = jQuery(area).find('.as-editor-content-area');
        slidebg.css({
            'background-color': 'transparent',
            'background-image': '',
            'background-position': '',
            'background-size': '',
        });

        //Current li change background
        var current_li = jQuery('.as-slide-list ul.as-slide-tabs > li.as-active').find('.as-slide-tab-img');
        current_li.css({
            'background-color': 'transparent',
            'background-image': '',
            'background-position': '',
            'background-size': '',
        });

        //Gradient color
        area.find('.as-slide-gradientColor').val('');
        area.find('.as-slide-gradientColor').closest('.as-form-control-group').find('.wp-color-result span').css('background', 'transparent');

        //Set new settings
        switch (bg_type) {
            case 'solid_color'      :
                var color_picker_value = jQuery(area).find('.as-slide-bgcolor').val();
                slidebg.css('background-color', color_picker_value);
                break;

            case 'image'            :
                avsSetGridBg();
                break;
        }
        jQuery('.as-admin #as_tab_background .wp-picker-container').on('click', function () {
            loadWin = 0;
        });
    });

    /*
     * jquery for hide/show Background Position X and Y based on X%,Y%
     */
    jQuery('.as-slide-bgpos').on('change', function () {
        if (jQuery(this).val() == 'percentage') {
            jQuery('.as-slide-bgpos-p').show();
        } else {
            jQuery('.as-slide-bgpos-p').hide();
        }
        avsSetGridBg();
    });
    jQuery('.as-slide-bgpos').change();

    /*
     * jquery for hide/show Background size X and Y
     */
    jQuery('.as-slide-bgsize').on('change', function () {
        if (jQuery(this).val() == 'percentage') {
            jQuery('.as-slide-bgsize-p').show();
        } else {
            jQuery('.as-slide-bgsize-p').hide();
        }

        avsSetGridBg();
    });
    jQuery('.as-slide-bgsize').change();

    /*
     * jQuery set background repeat
     */
    jQuery('.as-slide-bgrepeat').on('change', function () {
        avsSetGridBg();
    });

    //Background property: positions x and y
    jQuery('.as-slide-bgpos-x, .as-slide-bgpos-y').on('keyup change click', function () {
        avsSetGridBg();
    });

    //Background property: size x and y
    jQuery('.as-slide-bgsize-x, .as-slide-bgsize-y').on('keyup change click', function () {
        avsSetGridBg();
    });

    //OVERLAY
    /*
     * jquery for hide/show option based on overlay type
     */
    jQuery('.as-slide-overlay-type').on('change', function () {
        if (jQuery(this).val() == 'solid_color') {
            jQuery('.as-overlay-solidcolor').show();
            jQuery('.as-overlay-gradientColor').hide();
        }
        if (jQuery(this).val() == 'gradient_color') {
            jQuery('.as-overlay-solidcolor').hide();
            jQuery('.as-overlay-gradientColor').show();
        }
    });

    /*
     * jquery for Hide/show pattern block on click pattern picker
     */
    jQuery('.as-pattern-collection').hide();
    jQuery('.as-pattern-picker').on('click', function (event) {
        event.stopPropagation();
        jQuery('.as-pattern-collection').show();
    });

    /*
     * jquery for Hide pattern block on click of body
     */
    jQuery('body').on('click', function () {
        jQuery('.as-pattern-collection').hide();
    });


    /* ANIMATION SLIDE */
    /*
    * jquery for set active class on selected animation effect
    */
    jQuery('.as-animation-effect-list li:not(.as-pro-version)').on('click', function () {
        jQuery('.as-animation-effect-list li').removeClass('as-active');
        jQuery(this).addClass('as-active');
    });

    /* ACTION SLIDE */

    /*
     * jquery for hide/show link options
     */
    if (jQuery('.as-slide-link:checked').val() == 0) {
        jQuery('.as-slide-link-option').hide();
    } else {
        jQuery('.as-slide-link-option').show();
        if (jQuery('.as-link-to-slide').val() == 'simple_link') {
            jQuery('.as-link-type-simple').show();
        } else {
            jQuery('.as-link-type-simple').hide();
        }
    }
    jQuery('.as-slide-link').on('change', function () {
        if (jQuery(this).val() == 0) {
            jQuery('.as-slide-link-option').hide();
        } else {
            jQuery('.as-slide-link-option').show();
            if (jQuery('.as-link-to-slide').val() == 'simple_link') {
                jQuery('.as-link-type-simple').show();
            } else {
                jQuery('.as-link-type-simple').hide();
            }
        }
    });

    /* ADVANCE SLIDE */
    jQuery('body').on('change blur keyup', ".as-slide-custom-css", function () {
        avsSetGridBg();
    });

    /*
     * jQuery to hide/show ken burns options
     */
    if (jQuery('.as-slide-kenburns:checked').val() == 'off') {
        jQuery('.as-hide-ken-burns').hide();
    } else {
        jQuery('.as-hide-ken-burns').show();
    }
    jQuery('.as-slide-kenburns').on('change', function () {
        if (jQuery(this).val() == 'off') {
            jQuery('.as-hide-ken-burns').hide();
        } else {
            jQuery('.as-hide-ken-burns').show();
        }
    });

    //PRESET FOR POST SLIDER
    /**
     * Slide Preset Layout
     */
    var add_preset_slide_dialog = jQuery("#dialog_add_preset_slide_confirm").dialog({
        resizable: false,
        draggable: false,
        height: "auto",
        width: 400,
        modal: true,
        class: 'dialog_add_preset_slide',
        autoOpen: false,
        dialogClass: 'as-wrapper',
        buttons: [
            {
                text: avs_translations.continue,
                "class": 'as-btn as-btn-continue_preset as-btn-primary',
                click: function () {
                    var preset_id = jQuery('.preset_wrap li.preset_inner.avs_selected a').attr('data-preset-id');
                    var slide_id = jQuery('.as-slide-id').val();
                    var final_options = new Array();
                    final_options.push({"slide_id": parseInt(slide_id), "preset_id": preset_id});
                    // Do the ajax call
                    jQuery(this).dialog("close");
                    slide_preset_dialog.dialog("close");
                    save_needed = false;
                    avsAjaxRequestCall('slide_preset_layout', final_options, 'json', function (response) {
                    });
                }
            },
            {
                text: avs_translations.cancel,
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                }
            }
        ]
    });
    var slide_preset_dialog = jQuery("#dialog_slide_preset").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        height: jQuery(window).height() - 150,
        width: jQuery(window).width() - 300,
        modal: true,
        dialogClass: 'as-wrapper',
        buttons: [
            {
                text: avs_translations.continue,
                "class": 'as-btn as-btn-continue_preset as-btn-primary',
                click: function () {
                    add_preset_slide_dialog.dialog('open');
                }
            },
            {
                text: avs_translations.cancel,
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                    add_preset_slide_dialog.dialog("close");
                }
            }
        ],
        close: function() {
            add_preset_slide_dialog.dialog("close");
        },
        open: function(){
            jQuery('.preset_wrap li.preset_inner').removeClass('avs_selected');
            jQuery('.preset_wrap li.preset_inner:first-child').addClass('avs_selected');

        }
    });
    jQuery('.as-admin').on('click', '.as-slide-preset', function () {
        slide_preset_dialog.dialog('open');
    });

    jQuery('.preset_wrap li.preset_inner.free > a').click(function (e) {
        e.preventDefault();
        jQuery('.preset_wrap li.preset_inner').removeClass('avs_selected');
        jQuery(this).closest('.preset_inner').addClass('avs_selected');
    });

    jQuery('.as-admin').on('click', '.as-save-slide', function () {
        avsSaveSlide();
    });

    /*
    * ======================================
    * EDITOR AND ELEMENT SETTINGS
    * ======================================
    */

    /*
     * jquery for display positon of pointer in content area
     */
    jQuery('.as-editor-area').on('mousemove', function (event) {
        var wrap_width = jQuery('.as-editor-content-area_wrap').width(),
        h_width = jQuery('.as-slide-editing-area').width();

        if (jQuery(this).attr('data-slider-layout') == 'full-width') {
            var editor_wrap = jQuery('.as-slide-editing-area');

            if(editor_wrap.length >= 1){
                negative_diff = parseInt(editor_wrap.offset().left,0) - parseInt(jQuery('.as-editor-content-area_wrap').offset().left,0);
                negative_diff = negative_diff - 34;
            }
            negative_diff = parseInt(editor_wrap.offset().left, 0) - parseInt(jQuery('.as-editor-content-area_wrap').offset().left, 0);
            negative_diff = negative_diff - 34;

        }
        if (h_width < wrap_width && jQuery(this).attr('data-slider-layout') == 'fixed') {
            main_h_offset = event.pageX - jQuery(".as-slide-editing-area").offset().left;
            main_v_offset = event.pageY - jQuery(".as-slide-editing-area").offset().top;
        }
        else {
            main_h_offset = event.pageX - jQuery(this).offset().left;
            main_v_offset = event.pageY - jQuery(this).offset().top;
        }
        sub_h_offset = event.pageX - jQuery('.as-editor-content-area').offset().left;
        sub_v_offset = event.pageY - jQuery('.as-editor-content-area').offset().top;

        sub_width = jQuery('.as-editor-content-area').width();
        sub_height = jQuery('.as-editor-content-area').height();

        mx = sub_h_offset;
        my = sub_v_offset;

        if (h_width < wrap_width && jQuery(this).attr('data-slider-layout') == 'fixed') {
            if (main_h_offset > (sub_width)) {
                mx = sub_width;
            } else if (main_h_offset < 35) {
                mx = 0 ;
            }
        }
        else {

            if (main_h_offset > (sub_width + 35)) {
                mx = sub_width;
            } else if (main_h_offset < 35) {
                mx = 0 ;
            }
        }

        if (main_v_offset > (sub_height + 35)) {
            my = sub_height;
        } else if (main_v_offset < 35) {
            my = 0;
        }

        var s1 = event.pageX - jQuery(this).offset().left;
        var s2 = event.pageX - jQuery(".as-slide-editing-area").offset().left;
        var s3 = parseInt(s1)- parseInt(s2);


        jQuery('.as-verline').css({top: (my + 34) + "px"});


          if (h_width < wrap_width && jQuery(this).attr('data-slider-layout') == 'fixed') {
              jQuery('.as-bottom-horline').css({left: (mx + s3) + "px"});
               jQuery('.as-horline').css({left: (mx + s3) + "px"});
          }
          else{
               jQuery('.as-bottom-horline').css({left: (mx + 34) + "px"});
                jQuery('.as-horline').css({left: (mx + 34) + "px"});
          }
        jQuery('.as-verMeasure').html(Math.round(my));

        if (h_width < wrap_width && jQuery(this).attr('data-slider-layout') == 'fixed') {
            if (Math.round(mx) > (sub_width)) {

                jQuery('.as-horMeasure').css('right', '4px');
                jQuery('.as-horMeasure').css('left', 'auto');
                jQuery('.as-bottom-horMeasure').css('right', '4px');
                jQuery('.as-bottom-horMeasure').css('left', 'auto');
            } else {

                jQuery('.as-horMeasure').css('left', "4px");
                jQuery('.as-horMeasure').css('right', 'auto');

                jQuery('.as-bottom-horMeasure').css('left', '4px');
                jQuery('.as-bottom-horMeasure').css('right', 'auto');
            }

        } else {
            if (Math.round(mx) > (sub_width - 50)) {
                jQuery('.as-horMeasure').css('right', '4px');
                jQuery('.as-horMeasure').css('left', 'auto');

                jQuery('.as-bottom-horMeasure').css('right', '4px');
                jQuery('.as-bottom-horMeasure').css('left', 'auto');
            } else {
                jQuery('.as-horMeasure').css('left', '4px');
                jQuery('.as-horMeasure').css('right', 'auto');

                jQuery('.as-bottom-horMeasure').css('left', '4px');
                jQuery('.as-bottom-horMeasure').css('right', 'auto');
            }
        }




        if (Math.round(my) > (sub_height - 50)) {
            jQuery('.as-verMeasure').css('bottom', '4px');
            jQuery('.as-verMeasure').css('top', 'auto');

            jQuery('.as-right-verMeasure').css('bottom', '4px');
            jQuery('.as-right-verMeasure').css('top', 'auto');
        } else {
            jQuery('.as-verMeasure').css('top', '4px');
            jQuery('.as-verMeasure').css('bottom', 'auto');

            jQuery('.as-right-verMeasure').css('top', '4px');
            jQuery('.as-right-verMeasure').css('bottom', 'auto');
        }

        //side ruler js
        jQuery('.as-right-verline').css({top: (my + 34) + "px"});

        if (jQuery('.as-editor-area').attr('data-slider-layout') == 'full-width') {
              if (h_width < wrap_width) {
                   jQuery('.as-bottom-horMeasure').html(Math.round(mx - negative_diff));
                   jQuery('.as-horMeasure').html(Math.round(mx - negative_diff));
              } else {
                   jQuery('.as-bottom-horMeasure').html(Math.round(mx));
                   jQuery('.as-horMeasure').html(Math.round(mx));
              }

        } else {
            jQuery('.as-horMeasure').html(Math.round(mx));
            jQuery('.as-bottom-horMeasure').html(Math.round(mx));
        }


        jQuery('.as-right-verMeasure').html(Math.round(my));

    });

    /*
     * Remove element selection
     */
    jQuery('.as-editor-area').on('click', function () {
        jQuery(".as-editor-layer-detail > div").removeClass("as-active");
        jQuery(".as-edit-layer").addClass("as-btn-disabled");
        jQuery(".as-edit-layer").attr("disabled", "disabled");
    });

    /*
     * jquery for set active class besed on layer menu selection
     */
    jQuery(".as-editor-addNewLayer ul li a").on('click', function () {
        jQuery(".as-editor-layer-detail > div").removeClass("as-active");
        jQuery(".as-edit-layer").removeAttr("onclick");

        if (jQuery(this).hasClass("as-add-text-element")) {
            jQuery(".as-editor-layer-detail .as-layer-text-element").addClass("as-active");
            jQuery(".as-edit-layer").removeClass("as-btn-disabled");
            jQuery(".as-edit-layer").removeAttr("disabled");
            avsAddTextElement();
        } else if (jQuery(this).hasClass("as-add-video-element")) {
            jQuery(".as-editor-layer-detail .as-layer-video-element").addClass("as-active");
            jQuery(".as-edit-layer").removeClass("as-btn-disabled");
            jQuery(".as-edit-layer").removeAttr("disabled");
            avsAddVideoElement();
        } else if (jQuery(this).hasClass("as-add-image-element")) {
            jQuery(".as-edit-layer").removeClass("as-btn-disabled");
            jQuery(".as-edit-layer").removeAttr("disabled");
            avsAddImageElement();
        }
    });

    /*
     * Select element in editor
     */
    jQuery('.as-admin').on('click', '.as-slide-editing-area .as-slide-elements .as-element', function (e) {
        e.stopPropagation();
        e.preventDefault();
        avsSelectElement(jQuery(this));
    });

    /*
     * Call Deselect elements
     */
    jQuery('.as-admin').on('click', '.as-editor-content-area_wrap .as-slide-bg-default-image', function (e) {
        e.preventDefault();
        avsDeselectElements();
    });

    /*
     * Show edit area based on element
     */
    jQuery('.as-edit-layer').on('click',function(){
        var current_layer = jQuery('.as-element.as-active-element');
        var layer = avsGetEleObj(current_index);
        if (current_layer.hasClass("as-text-element")) {
            jQuery(".as-editor-layer-detail .as-layer-text-element").addClass("as-active");
        } else if (current_layer.hasClass("as-video-element")) {
            var video_type = avsGetObjVal(layer,'video_type'),
                youtube_url = avsGetObjVal(layer,'youtube_url'),
                video_id = avsGetObjVal(layer,'video_id'),
                vimeo_url = avsGetObjVal(layer,'vimeo_url'),
                html5_mp4_url = avsGetObjVal(layer,'html5_mp4_url'),
                html5_webm_url = avsGetObjVal(layer,'html5_webm_url'),
                html5_ogv_url = avsGetObjVal(layer,'html5_ogv_url'),
                video_fullscreen = avsGetObjVal(layer,'video_fullscreen'),
                editor_video_image = avsGetObjVal(layer,'editor_video_image');

            jQuery(".as-editor-layer-detail .as-layer-video-element").addClass("as-active");
            jQuery('.as-video-type').removeClass('as-active');
            jQuery('.as-video-type').each(function(){
                if(jQuery(this).attr('value') == video_type){
                    jQuery(this).addClass('as-active');
                }
            });
            jQuery('.as-editor-youtubeUrl').val(youtube_url);
            jQuery('.as-editor-videoId').val(video_id);
            jQuery('.as-editor-vimeoUrl').val(vimeo_url);
            jQuery('.as-editor-htmlMp4').val(html5_mp4_url);
            jQuery('.as-editor-htmlWebm').val(html5_webm_url);
            jQuery('.as-editor-htmlOgv').val(html5_ogv_url);
            jQuery('input[name="video_fullscreen"][value="' + video_fullscreen + '"]').prop('checked',true);
            jQuery('.as-editor-videoImg').val(editor_video_image);
        } else if (current_layer.hasClass("as-image-element")) {
            var last_element = current_layer;
            avsUpMediaUpload(last_element);
        }
    });

    /**
     * Set layout in desktop and in mobile
     */
    avsReadLayoutValues();
    jQuery('.as-slider-startWidth,.as-slider-startHeight').on("change keyup blur", function () {
        avsReadLayoutValues();
    });

    jQuery('body').on('click', ".as-duplicate-layer", function () {
        var element = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element');
        avsDuplicateElement(element);
    });

    //By click on delete element call delete element function
    jQuery('body').on('click', ".as-delete-layer", function () {
        // Click only if an element is selected
        if(jQuery(this).hasClass('as-btn-disabled')) {
            return;
        }
        var confirm = window.confirm(avs_translations.ele_del_confirm);
        if(!confirm) {
            return;
        }
        var element = jQuery('.as-slide-elements .as-element.as-active-element');
        avsDeleteElement(element);
    });


    /* DESIGN SETTINGS */
    /*
     * Set style to element
     */
    jQuery('body').on('change blur keyup', "#as_editor_design input, #as_editor_design textarea", function () {
        avsUpLayerFromFields();
    });

    jQuery('body').on('change blur keyup','.as-slide-font-size', function () {
        var new_font_size = jQuery(this).val();
        jQuery('.as-slide-line-height').val(new_font_size * 1.5);
    });

    //Update animation parameter
    jQuery('body').on('change', "#as_editor_animation select,#as_editor_attributesLink select", function () {
        avsUpLayerOtherFields();
    });
    jQuery('body').on('change blur keyup', "#as_editor_animation input,#as_editor_attributesLink input", function () {
        avsUpLayerOtherFields();
    });

    //Update advanced parameter
    jQuery('body').on('change blur keyup', "#as_editor_advanced input,#as_editor_advanced textarea", function () {
        avsUpLayerFromFields();
    });

    //COMMON DESIGN
    /*
     * jquery for editor selection box display using select2 jquery plugin
     */
    // jquery for font-family select2
    jQuery("select.as-slide-font-family").select2({
        placeholder: avs_translations.font_family,
    }).on("select2:open", function (e) {
        var class_name = jQuery(this).attr("data-class");
        jQuery(".select2-dropdown").addClass(class_name);
    }).on("change", function (e) {
        jQuery(this).siblings(".select2").find(".select2-selection__rendered").removeAttr('title');
    });

    // jquery for border-style and layer behavior select2
    jQuery("select.as-editor-selectText").select2({
        minimumResultsForSearch: Infinity,
    }).on("select2:open", function (e) {
        var class_name = jQuery(this).attr("data-class");
        jQuery(".select2-dropdown").addClass(class_name);
    }).on("change", function (e) {
        jQuery(this).siblings(".select2").find(".select2-selection__rendered").removeAttr('title');
        if (jQuery(this).hasClass("as-editor-selectText")) {
            var class_name = jQuery(this).attr("data-class");
            jQuery(this).siblings(".select2").addClass(class_name);
            jQuery(this).siblings(".select2").find(".select2-selection__rendered").addClass(class_name);
        }
    }).trigger('change');


    // jquery for other editor selection box select2
    jQuery("select.as-editor-select").select2({
        minimumResultsForSearch: Infinity,
    }).on("select2:open", function (e) {
        var class_name = jQuery(this).attr("data-class");
        jQuery(".select2-dropdown").addClass(class_name);
    }).on("change", function (e) {
        jQuery(this).siblings(".select2").find(".select2-selection__rendered").removeAttr('title');
        jQuery(this).siblings(".select2").find(".select2-selection__rendered").html("");
        var class_name = jQuery(this).attr("data-class");
        if (jQuery(this).hasClass("as-editor-select")) {
            jQuery(this).siblings(".select2").addClass("as-editor-select");
            jQuery(this).siblings(".select2").find(".select2-selection__rendered").addClass(class_name);
        }
    }).trigger('change');

    // for remove title from selected option
    jQuery(".select2 .select2-selection__rendered").removeAttr('title');
    select2_load = 0;
    /*
     * jquery for set button for font color and background color
     */
    jQuery('.as-font-color.as-color-picker').closest(".wp-picker-container").find(".wp-color-result").addClass("as-btn-color-picker as-font-color-btn");
    jQuery('.as-background-color.as-color-picker').closest(".wp-picker-container").find(".wp-color-result").addClass("as-btn-color-picker as-bgcolor-btn");


    /*
     * jquery for set as active on check/uncheck checkbox
     */
    jQuery('.as-checkbox-toggle input[type="checkbox"]').on('click', function () {
        if (jQuery(this).is(':checked')) {
            jQuery(this).parent(".as-checkbox-toggle").addClass("as-active");
        } else {
            jQuery(this).parent(".as-checkbox-toggle").removeClass("as-active");
        }
    });



    //Modify width
    jQuery('.as-admin').on('keyup change click', '.as-slide-layer-width', function() {
        avsUpAixes();

        var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element'),
            posX = jQuery(".as-slide-x-position").val(),
            posY = jQuery(".as-slide-y-position").val();
        avsUpHtmlLayerPos(editorLayer,posX,posY);
    });

    //Modify height
    jQuery('.as-admin').on('keyup change click', '.as-slide-layer-height', function() {
        avsUpAixes();

        var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element'),
            posX = jQuery(".as-slide-x-position").val(),
            posY = jQuery(".as-slide-y-position").val();
        avsUpHtmlLayerPos(editorLayer,posX,posY);
    });

    //Modify left position
    jQuery('.as-admin').on('keyup change click', '.as-slide-x-position', function() {
            avsUpAixes();

            var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element'),
                posX = jQuery(".as-slide-x-position").val(),
                posY = jQuery(".as-slide-y-position").val();
                if(posX == 'NaN') {
                    posX = 0;
                    jQuery(".as-slide-x-position").val(0);
                }
                if(posY == 'NaN') {
                    posY = 0;
                    jQuery(".as-slide-y-position").val(0);
                }
            avsUpHtmlLayerPos(editorLayer,posX,posY);
    });

    //Modify top position
    jQuery('.as-admin').on('keyup change click', '.as-slide-y-position', function() {
            avsUpAixes();

            var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element'),
                posX = jQuery(".as-slide-x-position").val(),
                posY = jQuery(".as-slide-y-position").val();
                if(posX == 'NaN') {
                    posX = 0;
                    jQuery(".as-slide-x-position").val(0);
                }
                if(posY == 'NaN') {
                    posY = 0;
                    jQuery(".as-slide-y-position").val(0);
                }
            avsUpHtmlLayerPos(editorLayer,posX,posY);
    });

    /*
     * jquery for hide/show link type options
     */
    jQuery(".as-editor-linktype").on('change', function () {
        jQuery(".as-editor-link-type").hide();
        if (jQuery(this).val() == 'simpleLink') {
            jQuery(".as-editor-simplelink-type").css("display", "inline-block");
        }
    });
    jQuery(".as-editor-linktype").change();

    jQuery(".as-editor-content-area_wrap").perfectScrollbar({suppressScrollY: true});
    jQuery(".as-animation-effect-list").perfectScrollbar({suppressScrollX: true});
    jQuery(".as-editor-tabs-content").perfectScrollbar({suppressScrollY: true});

    /* ELEMENT SETTINGS  */

    //TEXT ELEMENT
    // on change of text element
    jQuery('body').on('change keyup blur', ".as-text-element-text", function () {
        if(typeof objLayer != 'object') {
            return false;
        }
        var objCurrent = avsGetEleObj(current_index);
        objCurrent = avsSetObjVal(objCurrent,'text',jQuery('.as-text-element-text').val());
        var active_inner_class = jQuery('.as-slide-editing-area .as-element.as-active-element .as-inner-element');
        active_inner_class.html(avsGetObjVal(objCurrent,'text'));
    });

    //VIDEO ELEMENT

    /*
     * jquery for set active class for video type button
     */
    jQuery(".as-video-type").on("click", function () {
        jQuery(".as-video-type").removeClass("as-active");
        jQuery(this).addClass("as-active");

        jQuery('.as-video-type-youtube').hide();
        jQuery('.as-video-type-vimeo').hide();
        jQuery('.as-video-type-html5').hide();

        if (jQuery(this).val() == 'youtube') {
            jQuery('.as-video-type-youtube').show();
            jQuery(".as-editor-youtubeUrl-search").trigger('click');
        } else if (jQuery(this).val() == 'vimeo') {
            jQuery('.as-video-type-vimeo').show();
            jQuery(".as-editor-vimeoUrl-search").trigger('click');
        } else if (jQuery(this).val() == 'html5') {
            jQuery('.as-video-type-html5').show();
            jQuery(".as-editor-html5Url-search").trigger('click');
        }
    });

    // on change of video element
    jQuery('body').on('change keyup blur',".as-layer-video-element input,.as-layer-video-element select",function(){
        if(jQuery(this).hasClass('as-editor-htmlMp4')) {
            var mp4_url = jQuery.trim(jQuery(this).val());
            var html5_mp4_ext = mp4_url.split('.').pop();

            if(mp4_url!='' && html5_mp4_ext.toLowerCase()!='mp4'){
                jQuery(this).val('');
                avsShowMsg(avs_translations.must_be_mp4, "danger");
                return(false);
            }
        }
        else if(jQuery(this).hasClass('as-editor-htmlWebm')) {
            var webm_url = jQuery.trim(jQuery(this).val());
            var html5_webm_ext = webm_url.split('.').pop();

            if(webm_url!='' && html5_webm_ext.toLowerCase()!='webm'){
                jQuery(this).val('');
                avsShowMsg(avs_translations.must_be_webm, "danger");
                return(false);
            }
        }
        else if(jQuery(this).hasClass('as-editor-htmlOgv')) {
            var ogv_url = jQuery.trim(jQuery(this).val());
            var html5_ogv_ext = ogv_url.split('.').pop();

            if(ogv_url!='' && html5_ogv_ext.toLowerCase()!='ogv'){
                jQuery(this).val('');
                avsShowMsg(avs_translations.must_be_ogv, "danger");
                return(false);
            }
        }
        avsSetVideoSettings();
    });

    //Search youtube video on click of button
    jQuery('.as-admin').on('click', '.as-layer-video-element .as-editor-youtubeUrl-search', function() {
        var url_val = jQuery.trim(jQuery('.as-editor-youtubeUrl').val());
        var index = jQuery(this).closest('.as-element-settings').index();
        if(url_val != ''){
            avsGetYoutubeInfo(url_val);
        }
    });

    //Search vimeo video on click of button
    jQuery('.as-admin').on('click', '.as-layer-video-element .as-editor-vimeoUrl-search', function() {
        var url_val = jQuery.trim(jQuery('.as-editor-vimeoUrl').val());
        var index = jQuery(this).closest('.as-element-settings').index();
        if(url_val != ''){
            avsGetVimeoInfo(url_val);
        }
    });

    //Search Html5 video on click of button
    jQuery('.as-admin').on('click', '.as-editor-html5Url-search', function() {

        var mp4_url = jQuery.trim(jQuery('.as-layer-video-element').find('.as-editor-htmlMp4').val());
        var webm_url = jQuery.trim(jQuery('.as-layer-video-element').find('.as-editor-htmlWebm').val());
        var ogv_url = jQuery.trim(jQuery('.as-layer-video-element').find('.as-editor-htmlOgv').val());
        var poster_url = jQuery.trim(jQuery('.as-layer-video-element').find('.as-editor-videoImg').val());
        if(mp4_url!='' || webm_url!='' || ogv_url!=''){
            if(mp4_url!='') {
                var html5_mp4_ext = mp4_url.split('.').pop();
                if(mp4_url!='' && html5_mp4_ext.toLowerCase()!='mp4'){
                    jQuery('.as-layer-video-element').find('.as-editor-htmlMp4').val('');
                    avsShowMsg('Extension of video must be mp4.', "danger");
                    return(false);
                }
            }
            else if(webm_url!='') {
                var html5_webm_ext = webm_url.split('.').pop();

                if(webm_url!='' && html5_webm_ext.toLowerCase()!='webm'){
                    jQuery('.as-layer-video-element').find('.as-editor-htmlWebm').val('');
                    avsShowMsg('Extension of video must be webm.', "danger");
                    return(false);
                }
            }
            else if(ogv_url!='') {
                var html5_ogv_ext = ogv_url.split('.').pop();

                if(ogv_url!='' && html5_ogv_ext.toLowerCase()!='ogv'){
                    jQuery('.as-layer-video-element').find('.as-editor-htmlOgv').val('');
                    avsShowMsg('Extension of video must be ogv.', "danger");
                    return(false);
                }
            }
            var video_block = jQuery('.as-element.as-video-element.as-active-element');
            var video_width = jQuery.trim(jQuery('.as-slide-layer-width').val());
            var video_height = jQuery.trim(jQuery('.as-slide-layer-height').val());
            video_width = video_width == 0 || video_width == '' ? '320' : video_width;
            video_height = video_height == 0 || video_height == '' ? '240' : video_height;
            var html5Image = '';
            if(poster_url!=''){
                html5Image = poster_url;
            }else{
                html5Image = avs_translations.AvartanPluginUrl+'/manage/assets/images/html5-video.png';
            }
            var html5Html = '';
            html5Html += '<label class="video_block_title">'+avs_translations.html5_video_title+'</label>';
            html5Html += '<img src="'+html5Image+'" width="'+video_width+'" height="'+video_height+'" />';
            html5Html += '<div class="video_block_icon html5_icon"></div>';
            jQuery(video_block).find('.as-inner-element').html(html5Html);
            avsSetVideoSettings();
        }
    });

    //Preview image in video element
    jQuery('.as-admin').on('click', '.as-layer-video-element .as-preview-image-element-upload-button', function() {
        var slide_parent = jQuery(this).closest('.as-edit-slide');
        avsUploadPreviewImageElement(slide_parent);
    });

    //Remove preview
    jQuery('.as-admin').on('click', '.as-layer-video-element .as-remove-preview-image-element-upload-button', function() {
        var index = '';
        var video_type = jQuery(this).closest('.as-layer-video-element.as-active').find('.as-video-type.as-active');
        if (video_type.hasClass('as-youtube')){
            var url_val = jQuery.trim(jQuery('.as-editor-youtubeUrl').val());
            jQuery('.as-layer-video-element').find('.as-editor-videoImg').val('');
            if (url_val != ''){
                avsGetYoutubeInfo(url_val);
            }
        }else if (video_type.hasClass('as-vimeo')){
            var url_val = jQuery.trim(jQuery('.as-editor-vimeoUrl').val());
            jQuery('.as-layer-video-element').find('.as-editor-videoImg').val('');
            if (url_val != ''){
                avsGetVimeoInfo(url_val);
            }
        }else if(video_type.hasClass('as-html5')){
            var video_block = jQuery('.as-element.as-video-element.as-active-element');
            jQuery('.as-layer-video-element').find('.as-editor-videoImg').val('');
            var video_image = avs_translations.AvartanPluginUrl+'/manage/assets/images/html5-video.png';
            var video_title = avs_translations.html5_video;
            jQuery('.as-editor-attribute-title').val(video_title)
            jQuery('.as-editor-attribute-alt').val(video_title)
            video_block.find('img').attr('src',video_image);
        }
    });

    avsSlidesColorPicker();

});

// Script for system status
jQuery(function () {
    jQuery('a.debug-status-report').click(
        function () {
            var report = '';

            jQuery('.get-system-status').css('display', 'none');

            jQuery('.avs_status_table thead, .avs_status_table tbody').each(
                function () {
                    if (jQuery(this).is('thead')) {
                        var label = jQuery(this).find('th:eq(0)').data('export-label') || jQuery(this).text();
                        report = report + "\n### " + jQuery.trim(label) + " ###\n\n";
                    } else {
                        jQuery('tr', jQuery(this)).each(
                            function () {
                                var label = jQuery(this).find('td:eq(0)').data('export-label') || jQuery(this).find('td:eq(0)').text();
                                var the_name = jQuery.trim(label).replace(/(<([^>]+)>)/ig, ''); // Remove HTML
                                var the_value = jQuery.trim(jQuery(this).find('td:eq(2)').text());
                                var value_array = the_value.split(', ');

                                if (value_array.length > 1) {
                                    // If value have a list of plugins ','
                                    // Split to add new line
                                    var output = '';
                                    var temp_line = '';
                                    jQuery.each(
                                        value_array, function (key, line) {
                                            temp_line = temp_line + line + '\n';
                                        }
                                    );

                                    the_value = temp_line;
                                }

                                report = report + '' + the_name + ': ' + the_value + "\n";
                            }
                        );
                    }
                }
            );

            try {
                jQuery("#debug-report").slideDown();
                jQuery("#debug-report textarea").val(report).focus().select();
                jQuery(this).fadeOut();

                return false;
            } catch (e) {
                console.log(e);
            }

            return false;
        }
    );

    jQuery(document.body).on('init_tooltips', function () {
        var tiptip_args = {
            'attribute': 'data-tip',
            'fadeIn': 50,
            'fadeOut': 50,
            'delay': 200
        };
        jQuery('.tips, .help_tip, .avs-help-tip').tipTip(tiptip_args);
        // Add tiptip to parent element for widefat tables
        jQuery('.parent-tips').each(function () {
            jQuery(this).closest('a, th').attr('data-tip', jQuery(this).data('tip')).tipTip(tiptip_args).css('cursor', 'help');
        });
    });
    // Tooltips
    jQuery(document.body).trigger('init_tooltips');
});

/*
 * ======================================
 * COMMON
 * ======================================
 */

function avsShowLoader(data) {

    var loader_div = jQuery('.as-admin-preloader');

    //Show loader
    if (data.showTime != undefined) {
        loader_div.show();
    }

    //hide loader
    if (data.hideTime != undefined) {
        loader_div.hide();
    }

}

function avsProPopup() {
    //check this feature available for pro version only
    var as_upgrade_dialog = jQuery("#as_upgrade_to_pro_dialog").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        modal: true,
        height: "auto",
        width: 'auto',
        maxWidth: '100%',
        dialogClass: 'as-pro-ui-dialog',
        hide: {
            effect: "fadeOut",
            duration: 500
        },
        buttons: [
            {
                text: 'x',
                "class": 'as-btn as-btn-gray',
                click: function () {
                    jQuery(this).dialog("close");
                }
            }
        ],
        close: function(event, ui) {
        },
        open: function(event, ui) {
            jQuery(document).on('click','.ui-widget-overlay', function() {
                as_upgrade_dialog.dialog( "close" );
            });
            jQuery( this ).bind('clickoutside',function(){
                as_upgrade_dialog.dialog('close');
            });

        },
    });
    as_upgrade_dialog.dialog("open");
}
function avsSetSaveNeeded(setto){
        save_needed = setto;
}

// warn the user if changes are made and not saved yet
function avsAddPreventLeave(){
    window.onbeforeunload = function (e) {
            if(save_needed){
                    var message = avs_translations.leave_not_saved,
                    e = e || window.event;
                    // For IE and Firefox
                    if (e) {
                            e.returnValue = message;
                    }

                    // For Safari
                    return message;
            }
    };
}

function avsGetColor(color,alt) {
    if(typeof alt != 'undefined') alt = '';

    if(typeof color == 'undefined' && alt != '') {
        return alt;
    }
    else if (typeof color != 'undefined' && typeof default_colors[color.toLowerCase()] != 'undefined')
    {
        return default_colors[color.toLowerCase()];
    }

    return color;
}
function avsIsNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if (charCode == 37 || charCode == 39 || charCode == 46) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function avsIsFloatingKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
        return false;
    } else {
        return true;
    }
}

function avsIsNotSpecialChar(e) {

    var regex = new RegExp(/^[!~`"'?,|;:><@#\$%\^\&*\)\(\[\]\{\}\\\/+=.]+$/g);
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;

}

function avsFocusBlur(step, input_number, el) {

    input_number = Number(input_number) + step;
    input_number = Math.round(input_number * 100) / 100;
    el.val(input_number);
    jQuery(':focus').blur();
    el.focus();

}

function avsStripslashes(str) {
    return (str + '').replace(/\\(.?)/g, function (s, n1) {
        switch (n1) {
            case '\\':
                return '\\';
            case '0':
                return '\u0000';
            case '':
                return '';
            default:
                return n1;
        }
    });
}

function avsShowMsg(msg, type) {

    if (type == 'error' || type == 'danger') {
        jQuery.growl.error({message: msg,title:''});
    }
    else if (type == 'notice') {
        jQuery.growl.notice({message: msg});
    }
    else if (type == 'warning') {
        jQuery.growl.warning({message: msg});
    }
    else {
        jQuery.growl({title: '', message: msg});
    }
}

function avsInitializeColorPicker() {
    jQuery('.as-color-picker').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            // Change only if the color picker is the user choice
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });
    loadWin = 0;
    avsElementsColorPicker();
}

function avsGetMaxEditor(alignto) {
    var editor = jQuery('.as-slider-width').val(),
        editor_wrapper = jQuery(".as-slide-bg-default-image").width();


    if(alignto === 'slide') {
        if(editor >  editor_wrapper){
            return editor;
        }
        return editor_wrapper;
    }
    return editor;
}

function avsAjaxRequestCall(action, data, datatype) {

    var objData = {
        action: "avartanslider_ajax_action",
        user_action: action,
        nonce: avs_translations.default_nonce,
        data: data
    }
    avsShowLoader({showTime:300});
    jQuery.ajax({
        type: "post",
        url: ajaxurl,
        dataType: datatype,
        data: objData,
        success: function (response) {
            if(response == null || !response.is_redirect)
                avsShowLoader({hideTime:300});

            if (response == null)
                return(false);

            if (response.success == false) {
                avsShowMsg(response.message, "danger");
                return(false);
            } else {
                if (response.message) {
                    avsShowMsg(response.message, "success");

                    if (action == 'delete_slider' || action == 'duplicate_slider') {
                        setTimeout(function () {
                        }, 2000);
                    }

                }

                if(response.action === 'preview_output') {
                    jQuery('.as-slide-live-preview-area').html(response.data);
                    jQuery('.as-slide-live-preview-area').css({'width':'100%','height': jQuery('.as-slider-h').val()+'px','margin':'0 auto'});
                }
            }

            if (response.is_redirect) {
                var avsredirect_url = response.redirect_url;
                var avsfredirect_url = avsredirect_url.replace(/&amp;/g, '&');
                location.href = avsfredirect_url;
                return;
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            avsShowLoader({hideTime:300});
            avsShowMsg('Error in slider!<br>Status:' + textStatus + ' <br>Error:' + errorThrown, 'danger');
        }
    });
}

/*
 * ======================================
 * SLIDER
 * ======================================
 */
function avsGetAlias() {
    var slider_name = jQuery('.as-slider').find('.as-slider-name').val();
    var slider_alias = slider_name.toLowerCase();
    slider_alias = slider_alias.replace(/ /g, '_');
    return slider_alias;
}


function avsAddSliderLoaderImage(slide_parent) {
    // Upload
    var file_frame;

    // If the media frame already exists, reopen it.
    if (file_frame) {
        file_frame.open();
        return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        library: {
            type: 'image'
        },
        multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on('select', function () {
        // We set multiple to false so only get one image from the uploader
        attachment = file_frame.state().get('selection').first().toJSON();

        // Do something with attachment.id and/or attachment.url here
        var image_src = attachment.url;
        var image_width = attachment.width;
        var image_height = attachment.height;

        var img_html = '<img src="' + image_src + '" />';
        slide_parent.find('.as-loader-img').find('img').remove();
        slide_parent.find('.as-loader-img').find('.as-loader-img-hidden').after(img_html);
        slide_parent.find('.as-loader-img').find('.as-loader-img-hidden').val(image_src);
        slide_parent.find('.as-loader-img').find('.as-loaderImg').attr('data-width', image_width);
        slide_parent.find('.as-loader-img').find('.as-loaderImg').attr('data-height', image_height);
    });

    // Finally, open the modal
    file_frame.open();
}

function avsSaveSlider() {
    save_needed = false;
    var content = jQuery('.as-admin .as-slider');
    var final_options = new Array();
    var loader_type = '';
    var loader_style = '';

    if (content.find('.as-loaderType').val() == 0) {
        loader_type = 'default';
        loader_style = content.find('.as-loader-style').find('.as-loader-style-hidden').val();
    }

    var options = {
        layout: content.find('.as-layout-button.as-active').val(),
        start_width: parseInt(content.find('.as-slider-startWidth').val()),
        start_height: parseInt(content.find('.as-slider-startHeight').val()),
        automatic_slide: parseInt(content.find('.automatic-slide:checked').val()),
        pause_on_hover: parseInt(content.find('.pause-on-hover-slide:checked').val()),
        enable_swipe: parseInt(content.find('.enable-swipe:checked').val()),
        background_type_color: parseInt(content.find('#as-slider-background-type-color').val()) == 0 ? 'transparent' : content.find('#as-slider-background-type-color-picker-input').val() + "",
        loader: {
            type: loader_type,
            style: loader_style,
        },
        navigation: {
            arrows: {
                enable: parseInt(content.find('.enable-navigation:checked').val()),
                style: content.find('.as-arrow-style-hidden').val(),
            },
            bullets: {
                enable: parseInt(content.find('.enable-nav-bullets:checked').val()),
                style: content.find('.as-bullet-style-hidden').val(),
                hPos: content.find('.bullet-hpos:checked').val(),
            }
        },
        show_shadow_bar: content.find('.as-slider-shadow-type').val(),
        shadow_class: parseInt(content.find('.as-slider-shadow-type').val()) == 1 ? content.find('.as-slider-default-shadow').attr('data-shadow-class') : '',
        current_version: avs_translations.current_version
    };
    final_options.push({"id": parseInt(jQuery('.as-admin .as-slider .as-save-settings').attr('data-id')), "name": jQuery.trim(content.find('.as-slider-name').val()), "alias": jQuery.trim(content.find('.as-slider-alias').val()), "slider_option": JSON.stringify(options)});


    avsAjaxRequestCall(jQuery('.as-admin .as-slider').hasClass('as-add-slider') ? 'avartanslider_addSlider' : 'avartanslider_editSlider', final_options, 'json', function (response) {

    });

}

function avsReadLayoutValues() {

    var o = new Object();
    var s = new Object();

    s.width_desktop = jQuery('.as-slider-startWidth').val();
    s.height_desktop = jQuery('.as-slider-startHeight').val();
    o.dotted_top = 15;
    o.dotted_left = 15;
    o.dotted_bottom = 15;
    o.dotted_right = 15;
    avsSetLayoutDesign(jQuery('.as-desktop-layout-img'), s.width_desktop, s.height_desktop, 1280, 650, 1, o.dotted_top, o.dotted_left, o.dotted_bottom, o.dotted_right, 0);
}

function avsSetLayoutDesign(element, width_desktop, height_desktop, default_width, default_height, bm, top, left, bottom, right, tt) {
    var o = new Object();
    o.mtp = 1;

    if (width_desktop > default_width) {
        height_desktop = height_desktop * default_width / width_desktop;
        o.mtp = default_width / width_desktop;
        width_desktop = default_width;
    }
    if (height_desktop > default_height) {
        width_desktop = width_desktop * default_height / height_desktop;
        o.mtp = default_height / height_desktop;
        height_desktop = default_height;
    }

    o.tt = tt;

    o.left = o.right = (15 + ((1 - (width_desktop / default_width)) * (default_width / 10)) / 2) * bm,
            o.top = top;
    o.bottom = (height_desktop / 10) * bm;
    if (o.bottom == 15) {
        o.bottom = o.bottom + 24;
    } else {
        o.bottom = o.bottom + 24;
    }
    element.find('.as-dotted-line-left').css('left', o.left);
    element.find('.as-dotted-line-right').css('right', o.right);

    element.find('.as-dotted-line-top').css('top', o.top);
    element.find('.as-dotted-line-bottom').css({top: o.bottom, bottom: 'auto'});
    if (jQuery('.as-layout-grid-wrap').length >= 1) {
        var width;
        width = 172 - (o.left + o.right);
        left = o.left + 2;
        top = o.top + 2;
        height = (o.bottom - o.top) - 2;
        if (jQuery('.as-layout-button.as-active').attr('value') == 'full-width') {
            width = 160;
            left = 8;
        }
        element.find('.as-slider-bg-image').css({'height': height, 'width': width, 'left': left, 'top': top});
    }
}

/*
 * ======================================
 * SLIDE
 * ======================================
 */
function avsSlidesColorPicker() {

    //Background Color Picker
    jQuery('.as-admin .as-home .as-panel .as-slide-bgcolor').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            if (loadWin == 0) {
                // Change only if the color picker is the user choice
                avsSetGridBg();
            }
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
            avsSetGridBg();
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });

    //Background Gradient Color Picker
    jQuery('.as-admin .as-home .as-panel .as-slide-gradientColor').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            jQuery('.as-slide-gradientColor').val('');
            jQuery('.as-slide-gradientColor').closest('.as-form-control-group').find('.wp-color-result span').css('background', 'transparent');
            avsProPopup();
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });

    //Background Gradient overlay Color Picker
    jQuery('.as-admin .as-home .as-panel .as-slide-gradientOverlay').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            jQuery('.as-slide-gradientOverlay').val('');
            jQuery('.as-slide-gradientOverlay').closest('.as-form-control-group').find('.wp-color-result span').css('background', 'transparent');
            avsProPopup();
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });

    //Color overlay on background image
    jQuery('.as-admin .as-home .as-panel .as-slide-overlaySolidColor').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            jQuery('.as-slide-overlaySolidColor').val('');
            jQuery('.as-slide-overlaySolidColor').closest('.as-form-control-group').find('.wp-color-result span').css('background', 'transparent');
            avsProPopup();
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });
}

function avsAddSlideImageBackground(slide_parent) {

    // Upload
    var file_frame;

    // If the media frame already exists, reopen it.
    if (file_frame) {
        file_frame.open();
        return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        library: {
            type: 'image'
        },
        multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on('select', function () {
        // We set multiple to false so only get one image from the uploader
        attachment = file_frame.state().get('selection').first().toJSON();

        // Do something with attachment.id and/or attachment.url here
        var image_src = attachment.url;
        var image_alt = attachment.alt;
        var image_title = attachment.title;

        // I add a data with the src because, is not like images (when there is only the src link), the background contains the url('') string that is very annoying when we will get the content
        slide_parent.find('.as-slide-bg-image').attr('data-source', image_src);
        slide_parent.find('.as-slide-bg-image').attr('data-alt', image_alt);
        slide_parent.find('.as-slide-alter-text').val(image_alt);
        slide_parent.find('.as-slide-image-title').val(image_title);

        avsSetGridBg();
    });
    file_frame.on('close', function () {
        setTimeout(function () {
            if (slide_parent.find('.as-slide-bg-image').attr('data-source') == '') {
                avsSetGridBg();
            }
        }, 50);
    });

    // Finally, open the modal
    file_frame.open();
}

function avsSetGridBg() {
    var slide_parent = jQuery('.as-admin');
    var type = slide_parent.find('.as-slide-bg-type').val();
    var area = jQuery('.as-editor-content-area');
    var area_thumb = jQuery('.as-slide-list ul.as-slide-tabs > li.as-active').find('.as-slide-tab-img');

    area.attr('style','');
    area_thumb.attr('style','');

    switch (type) {
        case 'solid_color':
            area.css('background-color', jQuery('.as-slide-bgcolor').val());
            area_thumb.css('background-color', jQuery('.as-slide-bgcolor').val());
            break;
        case 'image':
            if(jQuery('.as-slide-bg-image').attr('data-source') != '') {
                //Bg image
                area.css('background-image', 'url("' + jQuery('.as-slide-bg-image').attr('data-source') + '")');
                area_thumb.css('background-image', 'url("' + jQuery('.as-slide-bg-image').attr('data-source') + '")');

                //Bg size
                var slide_background = slide_parent.find('.as-slide-bgsize').val();

                if (slide_background == 'percentage') {
                    slide_background = jQuery.trim(slide_parent.find('.as-slide-bgsize-x').val()) + '% ' + jQuery.trim(slide_parent.find('.as-slide-bgsize-y').val()) + '%';
                }
                area.css('background-size', slide_background);
                area_thumb.css('background-size', slide_background);

                //Bg Repeat
                var slide_bg_repeat = slide_parent.find('.as-slide-bgrepeat').val();

                area.css('background-repeat', slide_bg_repeat);
                area_thumb.css('background-repeat', slide_bg_repeat);

                //Bg Position
                var slide_bg_pos = slide_parent.find('.as-slide-bgpos').val();
                if (slide_bg_pos == 'percentage') {
                    slide_bg_pos = jQuery.trim(slide_parent.find(".as-slide-bgpos-x").val()) + '% ' + jQuery.trim(slide_parent.find(".as-slide-bgpos-y").val()) + '%';
                }

                area.css('background-position', slide_bg_pos);
                area_thumb.css('background-position', slide_bg_pos);
            } else {
                area.css({
                    'background-color': 'transparent',
                    'background-image': 'none',
                    'background-position': 'none',
                    'background-size': 'none',
                });
                area_thumb.css({
                    'background-color': 'transparent',
                    'background-image': 'none',
                    'background-position': 'none',
                    'background-size': 'none',
                });
            }
            break;
    }

    //Custom CSS
    var advance_style = jQuery('.as-slide-custom-css').val();
    area.attr('style',area.attr('style')+advance_style);
    area_thumb.attr('style',area_thumb.attr('style')+advance_style);

}

function avsSaveSlide() {
   save_needed = false;
   var final_options = new Array();
   //Get Json Array of settings
   final_options = avsSetSlideLayerSettings();
   avsAjaxRequestCall('as_saveSlide', final_options, 'json', function (response) {

   });
}
/*
 * ======================================
 * EDITOR
 * ======================================
 */

function avsEditorMeasurement() {

    var wrap_width = parseInt(jQuery('.as-editor-content-area_wrap').width()),
    h_width = parseInt(jQuery('.as-slider-width').val()),
    v_width = parseInt(jQuery('.as-slider-height').val());

    //bottom and right side ruler js
    var bottom_horl = jQuery('.as-bottom-horGrid .as-gridMeasure'),
    bottom_verl = jQuery('.as-right-verGrid .as-gridMeasure'),
    org_h_width = h_width;

    if (h_width < wrap_width) {
        h_width = wrap_width;
    }

    // top and left side ruler js
    var horl = jQuery('.as-horGrid .as-gridMeasure'),
    verl = jQuery('.as-verGrid .as-gridMeasure');
    horl.empty();
    bottom_horl.empty();

    if (jQuery('.as-editor-area').attr('data-slider-layout') == 'fixed') {

        editor_wrap = jQuery('.as-slide-editing-area');
        negative_diff = parseInt(editor_wrap.offset().left,0) - parseInt(jQuery('.as-editor-content-area_wrap').offset().left,0);
        jQuery('.as-horGrid').css({backgroundPosition:(negative_diff - 35)+"px 50%"});
        jQuery('.as-horGrid .as-gridMeasure').css({left:(negative_diff - 33)+"px"});
        jQuery('.as-bottom-horGrid').css({backgroundPosition:(negative_diff - 35)+"px 50%"});
        jQuery('.as-bottom-horGrid .as-gridMeasure').css({left:(negative_diff - 33)+"px"});

        for (var i = 0; i < org_h_width; i = i + 50) {
            horl.append('<li><span>' + i + '</span></li>');
            bottom_horl.append('<li><span>' + i + '</span></li>');
        }

    } else {
            if(h_width < wrap_width) {
                h_width = wrap_width;
            }
            var editor_wrap = jQuery('.as-slide-editing-area');
            if(editor_wrap.length >= 1){
                var negative_diff = parseInt(editor_wrap.offset().left,0) - parseInt(jQuery('.as-editor-content-area_wrap').offset().left,0);
                jQuery('.as-horGrid').css({backgroundPosition:(negative_diff-634)+"px 50%"});
                jQuery('.as-horGrid .as-gridMeasure').css({left:(negative_diff-632)+"px"});
                jQuery('.as-bottom-horGrid').css({backgroundPosition:(negative_diff-634)+"px 50%"});
                jQuery('.as-bottom-horGrid .as-gridMeasure').css({left:(negative_diff-632)+"px"});
            }
            for (var i = -600; i < h_width; i = i + 50) {
                if(h_width - i < 50){
                    horl.append('<li style="width:'+(h_width-i)+'px"><span>'+i+'</span></li>');
                    bottom_horl.append('<li style="width:'+(h_width-i)+'px"><span>'+i+'</span></li>');
                } else {
                    horl.append('<li><span>' + i + '</span></li>');
                    bottom_horl.append('<li><span>' + i + '</span></li>');
                }

            }
    }

    for (var i = 0; i <= v_width; i = i + 50) {
        verl.append('<li><span>' + i + '</span></li>');
    }

    jQuery('.as-horline').css({left: '34px'});
    jQuery('.as-verline').css({top: '34px'});

    jQuery('.as-horMeasure').html(Math.round(0));
    jQuery('.as-verMeasure').html(Math.round(0));


    for (var i = 0; i <= v_width; i = i + 50) {
        bottom_verl.append('<li><span>' + i + '</span></li>');
    }

    jQuery('.as-bottom-horline').css({left: '34px'});
    jQuery('.as-right-verline').css({top: '34px'});

    jQuery('.as-bottom-horMeasure').html(Math.round(0));
    jQuery('.as-right-verMeasure').html(Math.round(0));

}

function avsDeselectElements() {

    var slide = jQuery('.as-edit-slide');
    jQuery('.as-admin .as-slide-editing-area .as-slide-elements .as-element').removeClass('as-active-element');
    // Make the delete and the duplicate buttons disable
    slide.find('.as-editor-action-icon .as-delete-layer').addClass('as-btn-disabled');
    slide.find('.as-editor-action-icon .as-duplicate-layer').addClass('as-btn-disabled');
    slide.find('.as-editor-action-icon .as-edit-layer').addClass('as-btn-disabled');
    jQuery(".as-editor-layer-detail > div").removeClass("as-active");
    slide.attr('class', '').addClass('as-home as-edit-slide as-disable-wrapper');
}

function avsSelectElement(element) {
    var slide = element.closest('.as-edit-slide');
    current_index = element.index() - 1;
    element_index = element.index();
    var layerObj = avsGetEleObj(current_index);
    var layer = element;
    // Add .active class to the element in the editing area
    element.parent().children('.as-element').removeClass('as-active-element');
    element.addClass('as-active-element');
    if(element.hasClass('as-active-element')) {
        avsLayerDefVal();
    }
    // Make the delete and the duplicate buttons working
    slide.find('.as-editor-action-icon .as-delete-layer').removeClass('as-btn-disabled');
    slide.find('.as-editor-action-icon .as-duplicate-layer').removeClass('as-btn-disabled');
    slide.find('.as-editor-action-icon .as-edit-layer').removeClass('as-btn-disabled');
    jQuery(".as-edit-layer").removeAttr("disabled");

    var type = (element.hasClass('as-image-element') ? 'image' : (element.hasClass('as-video-element') ? 'video' : 'text'));
    slide.attr('class', '').addClass('as-home as-edit-slide ' + type + '-element-wrapper');

    if(type == "video"){
        jQuery(".as-video-layer-show.as-slide-layer-width").removeAttr("readonly");
        jQuery(".as-video-layer-show.as-slide-layer-width").removeClass("as-pro-version");

        jQuery(".as-video-layer-show.as-slide-layer-height").removeAttr("readonly");
        jQuery(".as-video-layer-show.as-slide-layer-height").removeClass("as-pro-version");

    }else{
        jQuery(".as-video-layer-show.as-slide-layer-width").attr('readonly', true);
        jQuery(".as-video-layer-show.as-slide-layer-width").addClass("as-pro-version");

        jQuery(".as-video-layer-show.as-slide-layer-height").attr('readonly', true);
        jQuery(".as-video-layer-show.as-slide-layer-height").addClass("as-pro-version");

        jQuery(document).on('click','.as-slide-layer-width,.as-slide-layer-height', function() {
            if(element.hasClass('as-active-element')) {
                avsProPopup();
            }
        });
    }

    switch (type) {
        case 'video':
            jQuery(".as-editor-layer-detail .as-text-element-text").val('');
            jQuery(".as-editor-layer-detail .as-button-element-text").val('');
            jQuery(".as-editor-layer-detail .as-shortcode-element-text").val('');
            avsGetVideoSettings();
            avsDraggableElements();
            break;
        case 'image':
            jQuery(".as-editor-layer-detail .as-text-element-text").val('');
            jQuery(".as-editor-layer-detail .as-button-element-text").val('');
            jQuery(".as-editor-layer-detail .as-shortcode-element-text").val('');
            jQuery(".as-edit-layer").attr("onclick", "avsUpMediaUpload()");
            avsDraggableElements();
            break;
        default :

            //Update value type wise
            jQuery(".as-editor-layer-detail .as-text-element-text").val('');
            jQuery(".as-edit-layer").removeAttr("onclick");
            jQuery(".as-editor-layer-detail .as-layer-"+type+"-element .as-"+type+"-element-text").val(avsGetObjVal(layerObj,'text'));

            var mw = 0,
                mh = 0;
                mw = parseInt(slide.find('.as-slide-layer-width').val());
                mh = parseInt(slide.find('.as-slide-layer-height').val());
            if (isNaN(mw) && isNaN(mh))
                layer.css({'width': 'auto', 'height': 'auto'});

            avsDraggableElements();
            break;
    }
}

function avsCalGuidesForElement(elem, pos, w, h) {
    if (elem != null) {
        var $t = jQuery(elem);
        pos = $t.offset();
        var editor = jQuery(".as-slide-editing-area"),
        editorOff = editor.offset();
        pos.left = pos.left - editorOff.left;
        pos.top = pos.top - editorOff.top;
        w = $t.outerWidth() - 1;
        h = $t.outerHeight() - 1;
    }
    return [
        {type: "h", left: pos.left, top: pos.top},
        {type: "h", left: pos.left, top: pos.top + h},
        {type: "v", left: pos.left, top: pos.top},
        {type: "v", left: pos.left + w, top: pos.top},
        // you can add _any_ other guides here as well (e.g. a guide 10 pixels to the left of an element)
        {type: "h", left: pos.left, top: pos.top + h / 2},
        {type: "v", left: pos.left + w / 2, top: pos.top}
    ];
}

function avsDeleteElement(element){
    ele_count--;
    if(typeof objLayer[current_index] == 'object' ) {
        delete objLayer[current_index];
    }
    element.remove();
    avsDeselectElements();
    avsReinitializeObject();
}

function avsReinitializeObject() {
    current_index = -1;
    var tempObjLayer = objLayer;
    objLayer = {};
    jQuery.each(tempObjLayer,function(index,value){
        current_index++;
        var objUpdate = {};
        objUpdate = jQuery.extend({},value);
        avsAddInObject(objUpdate);
    });
}

function avsDuplicateElement(element) {
        ele_count++;
        element.clone().appendTo(element.parent());
        var index = element.parent().find('.as-element').last().index() - 1;
        avsObjectClone(index);
        avsDeselectElements();
        avsSelectElement(element.parent().find('.as-element').last());

        // Make draggable
        avsDraggableElements();
        avsElementsColorPicker();
}

function avsDraggableElements() {

    jQuery('.as-admin .as-slide-elements .as-element').draggable({
        containment: jQuery('.as-slide-bg-default-image'),
        start: function (event, ui) {
            // Select when dragging
            avsSelectElement(jQuery(this));
        },
        drag: function (event, ui) {
            var layerObj = avsGetEleObj(current_index);
            avsIsElementDrag(jQuery(this), false);
        },
        stop: function (event, ui) {
            avsIsElementDrag(jQuery(this), true)
        },
    });
}

function avsIsElementDrag(editorLayer, done) {
    var position = editorLayer.position(),
        posTop = Math.round(position.top),
        posLeft = Math.round(position.left);

    if(done) {
        jQuery('.as-slide-y-position').val(posTop);
        jQuery('.as-slide-x-position').val(posLeft);
        avsUpHtmlLayerPos(editorLayer,posLeft,posTop);
    }
}

function avsUpAixes() {
    var foffset = 0,
        xaix = 0,
        yaix = 0,
        fleft = jQuery('.as-slide-x-position').val(),
        ftop = jQuery('.as-slide-y-position').val();

    xaix = (-foffset + parseFloat(fleft));

    foffset = 0;
    yaix = (-foffset + parseFloat(ftop));

    jQuery('.as-slide-x-position').val(xaix);
    jQuery('.as-slide-y-position').val(yaix);
}

function avsUpPos(editorLayer) {
    var layer = avsGetEleObj(editorLayer.index()-1),
        alignto = avsGetObjVal(layer,'alignto'),
        posTop = parseInt(avsGetObjVal(layer,'y_position')),
        posLeft = parseInt(avsGetObjVal(layer,'x_position')),
        selectedLayerWidth = parseInt(editorLayer.outerWidth()),
        totalWidth = parseInt(avsGetMaxEditor(alignto)),
        selectedlayerHeight = parseInt(editorLayer.outerHeight()),
        totalHeight = parseInt(jQuery('.as-slide-editing-area').height()),
        align_vert = avsGetObjVal(layer,'align_vert'),
        align_hor = avsGetObjVal(layer,'align_hor');
    if(alignto === 'slide') {
        var wrapper = jQuery(".as-slide-bg-default-image").offset();
        var loffset = editorLayer.offset();
        posLeft = Math.round(loffset.left - wrapper.left);
    }
    switch(align_hor){
            case "right":
                    var ew = (totalWidth - selectedLayerWidth);
                    if(posLeft > 0)
                        posLeft = ew + posLeft;
                    else
                        posLeft = ew - Math.abs(posLeft);
            break;
            case "center":
                    var ew = Math.round((totalWidth - selectedLayerWidth)/2);
                    if(posLeft > 0)
                        posLeft = ew + posLeft;
                    else
                        posLeft = ew - Math.abs(posLeft);
            break;
            case "left":
            default:
                    posLeft = posLeft;
            break;
    }

    switch(align_vert){
            case "bottom":
                    var eh = (totalHeight - selectedlayerHeight);
                    if(posTop > 0)
                        posTop = eh + posTop;
                    else
                        posTop = eh - Math.abs(posTop);
            break;
            case "middle":
                    var eh = Math.round((totalHeight - selectedlayerHeight)/2);
                    if(posTop > 0)
                        posTop = eh + posTop;
                    else
                        posTop = eh - Math.abs(posTop);
            break;
            case "top":
            default:
                    posTop = posTop;
            break;
    }
    var pos = {left:parseInt(posLeft),top:parseInt(posTop)};
    return pos;
}
function avsUpHtmlLayerPos(editorLayer, left, top) {
    var layer = avsGetEleObj(editorLayer.index()-1);

    //update positions by align
    var type = editorLayer.hasClass('as-text-element') ? 'text' : editorLayer.hasClass('as-image-element') ? 'image' : editorLayer.hasClass('as-video-element') ? 'video' : '',
        mw = avsGetObjVal(layer,'width'),
        mh = avsGetObjVal(layer,'height');

    var objCss = {};

    //handle horizontal
    objCss["right"] = "auto";
    objCss["left"] = left + "px";

    //handle vertical
    objCss["bottom"] = "auto";
    objCss["top"] = top + "px";

    avsApplyStyle(editorLayer,{
        'top' : objCss.top,
        'bottom' : objCss.bottom,
        'right' : objCss.right,
        'left' : objCss.left,
    });


    //SET IN EDITOR
    if(type === 'text') {
        if(isNaN(mw) && isNaN(mh)) {
            jQuery(editorLayer).css({width : 'auto',height : 'auto',whiteSpace : 'nowrap'});
            jQuery(editorLayer).find('.as-inner-element').css({whiteSpace : 'nowrap'});
        } else {
            jQuery(editorLayer).css({width : mw,height : mh,whiteSpace : 'normal'});
            jQuery(editorLayer).find('.as-inner-element').css({maxWidth : mw,maxHeight : mh,minHeight : mh,whiteSpace : 'normal'});
        }
    }
    else if(type === 'image') {
        if(!isNaN(mw) || !isNaN(mh)) {
            jQuery(editorLayer).css({width : mw,height : mh,whiteSpace : 'normal'});
            editorLayer.find('.as-inner-element').css({maxWidth : mw,maxHeight : mh,width : mw,height : mh});
            editorLayer.find('img').css({width : mw,height : mh});
        }
    }
    else if(type === 'video') {
        jQuery(editorLayer).css({width : mw,height : mh,whiteSpace : 'normal'});
        editorLayer.find('.as-inner-element').css({width:"100%",height:"100%"});
    }
    avsUpLayerFromFields();
    avsUpCrossIconPos(editorLayer);
}

function avsUpCrossIconPos(editorLayer) {
    var htmlCross = editorLayer.find(".as-layer-point"),
        crossWidth = htmlCross.width(),
        crossHeight = htmlCross.height(),
        crossHalfW = Math.round(crossWidth / 2),
        crossHalfH = Math.round(crossHeight / 2),
        posx = 0,
        posy = 0;

        //left
        posx = -crossHalfW;

        //top
        posy = -crossHalfH;

    htmlCross.css({"left": posx + "px", "top": posy + "px"});
}

function avsGetAllLayers(slide_layers) {
    slide_layers = jQuery.parseJSON(slide_layers);
    jQuery.each(slide_layers, function(i,slide_layer) {
        var objtmplayer = {};
        objtmplayer = jQuery.extend({},slide_layer);
        var layer_type = '';
        if(objtmplayer.type == 'image' || objtmplayer.type == 'shortcode' || objtmplayer.type == 'button' || objtmplayer.type == 'icon' || objtmplayer.type == 'shape' || objtmplayer.type == 'video' || objtmplayer.type == 'text') {
            layer_type = objtmplayer.type;
        }
        if(layer_type != '') {
            switch (layer_type) {
                case 'image':
                    objtmplayer = avsAddDefaultInObject(objtmplayer);
                    avsAddImageElement(objtmplayer);
                    break;
                case 'video':
                    objtmplayer = avsAddDefaultInObject(objtmplayer);
                    avsAddVideoElement(objtmplayer);
                    break;
                case 'text':
                    objtmplayer = avsAddDefaultInObject(objtmplayer);
                    avsAddTextElement(objtmplayer);
                    break;
            }
            var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element:eq('+i+')');
        }
    });
}

function avsAddInObject(objUpdate) {
    objLayer[current_index] = jQuery.extend({},objUpdate);
}

function avsAddDefaultInObject(objData) {
    if(typeof objData.x_position == 'undefined') {
        jQuery.extend(objData,{
            x_position:JSON.parse(default_array).x_position,
        });
    }
    if(typeof objData.y_position == 'undefined') {
        jQuery.extend(objData,{
            y_position:JSON.parse(default_array).y_position,
        });
    }
    return objData;
}

function avsObjectClone(index) {
    if(typeof objLayer == 'undefined' || current_index == -1)
            return(false);

    var obj = objLayer[current_index];

    var obj2 = jQuery.extend(true, {}, obj);	//duplicate object

    current_index = index;
    obj2 = avsSetObjVal(obj2,'z_index',current_index+5);
    avsAddInObject(obj2);
}

function avsGetEleObj(serial){
    var layer = objLayer[serial];
    if(!layer){
            return false;
    }else{
            return layer;
    }
    return false;
}

function avsGetObjVal(obj, handle){
    if(typeof(obj) === 'undefined') return;

    if(typeof(obj[handle]) !== 'undefined' && typeof(obj[handle]) !== 'object'){
            return obj[handle];
    }
}

function avsSetObjVal(obj, handle, val){
    if(typeof(obj[handle]) !== 'undefined'){
        obj[handle] = val;
    }else{
        if(typeof(obj[handle]) === 'undefined') obj[handle] = {};
        obj[handle] = val;
    }
    return obj;
}

function avsUpEleObj(serial,objData,del_certain){
        var layer = avsGetEleObj(serial);
        if(!layer){
                return(false);
        }

        if(del_certain !== undefined){
                for(var key in del_certain){
                        delete layer[del_certain[key]];
                }
        }

        for(var key in objData){
                if(typeof(objData[key]) === 'object'){
                        for(var okey in objData[key]){
                                if(typeof(layer[key]) === 'object'){
                                        if(typeof(layer[key][okey]) === 'object'){
                                                for(var mk in objData[key][okey]){
                                                        layer[key][okey][mk] = objData[key][okey][mk];
                                                }
                                        } else {
                                                layer[key][okey] = objData[key][okey];
                                        }
                                }else{
                                        layer[key] = {};
                                        layer[key][okey] = objData[key][okey];
                                }
                        }
                }else{
                        layer[key] = objData[key];
                }
        }

        if(!objLayer[serial]){
                return(false);
        }

        objLayer[serial] = jQuery.extend({},layer);
}

function avsAllLayerUp(type) {
    var search = type!=undefined && type!='' ? '.as-'+type+'-element' : '.as-element';
    jQuery(search).each(function() {
            avsRebuildPos(jQuery(this));
    });
}

function avsRebuildPos(element){
    var layer = avsGetEleObj(element.index()-1),
        xaix = avsGetObjVal(layer,'x_position'),
        yaix = avsGetObjVal(layer,'y_position');
    avsUpHtmlLayerPos(element,xaix,yaix);
}

function avsGetVideoSettings() {
    var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element');
    if(editorLayer.length == 0) {
        return false;
    }

    var layer = avsGetEleObj(current_index);
    var video_type = avsGetObjVal(layer,'video_type'),
        video_fullscreen = avsGetObjVal(layer,'video_fullscreen','single'),
        youtube_url = avsGetObjVal(layer,'youtube_url'),
        video_id = avsGetObjVal(layer,'video_id'),
        vimeo_url = avsGetObjVal(layer,'vimeo_url'),
        html5_mp4_url = avsGetObjVal(layer,'html5_mp4_url'),
        html5_ogv_url = avsGetObjVal(layer,'html5_ogv_url'),
        html5_webm_url = avsGetObjVal(layer,'html5_webm_url'),
        video_poster_img = avsGetObjVal(layer,'editor_video_image');

    if(video_type == '' || typeof video_type == 'undefined') return false;

    jQuery('.as-video-type').removeClass('as-active');
    jQuery('.as-video-type.as-'+video_type).addClass('as-active');
        jQuery('.as-video-type-youtube').hide();
        jQuery('.as-video-type-vimeo').hide();
        jQuery('.as-video-type-html5').hide();
        switch(video_type) {
            case 'youtube' :
                jQuery('.as-editor-youtubeUrl').val(youtube_url);
                jQuery('.as-video-type-youtube').show();
                break;
            case 'vimeo' :
                jQuery('.as-editor-vimeoUrl').val(vimeo_url);
                jQuery('.as-video-type-vimeo').show();
                break;
            case 'html5' :
                jQuery('.as-editor-htmlMp4').val(html5_mp4_url);
                jQuery('.as-editor-htmlWebm').val(html5_webm_url);
                jQuery('.as-editor-htmlOgv').val(html5_ogv_url);
                jQuery('.as-video-type-html5').show();
                break;
        }
        jQuery('.as-editor-videoId').val(video_id);
        jQuery('.as-video-aspectRatio').val('16:9');
        jQuery('.as-editor-videoImg').val(video_poster_img);
        jQuery('input[name="video_fullscreen"][value="'+video_fullscreen+'"]').prop( "checked", true );
        jQuery('.as-video-force-cover').hide();
        jQuery('input[name="video_forcecover"][value="0"]').prop( "checked", true );
        jQuery('.as-video-aspect-ratio').hide();
        jQuery('input[name="video_autoplay"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_firstTime"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_loopVideo"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_allowFullscreen"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_nextSlide"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_hideControl"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_mute"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_posterOnPause"][value="0"]').prop( "checked", true );
        jQuery('input[name="video_forceRewind"][value="0"]').prop( "checked", true );
}
function avsLayerDefVal() {
    changeD = false;
    var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element');
    if(editorLayer.length == 0) {
        return false;
    }
    var layer = avsGetEleObj(current_index);
    var font_size = avsGetObjVal(layer,'font_size'),
        line_height = avsGetObjVal(layer,'line_height'),
        font_color = avsGetColor(avsGetObjVal(layer,'font_color'),'#000000'),
        background_color = avsGetColor(avsGetObjVal(layer,'background_color','rgba(255,255,255,0)')),
        x_position = avsGetObjVal(layer,'x_position'),
        y_position = avsGetObjVal(layer,'y_position'),
        width = avsGetObjVal(layer,'width'),
        height = avsGetObjVal(layer,'height'),
        advance_style = avsGetObjVal(layer,'advance_style'),
        animation_delay = avsGetObjVal(layer,'animation_delay'),
        animation_time = avsGetObjVal(layer,'animation_time'),
        animation_in = avsGetObjVal(layer,'animation_in'),
        animation_out = avsGetObjVal(layer,'animation_out'),
        animation_startspeed = avsGetObjVal(layer,'animation_startspeed'),
        animation_endspeed = avsGetObjVal(layer,'animation_endspeed'),
        attribute_id = avsGetObjVal(layer,'attribute_id'),
        attribute_class = avsGetObjVal(layer,'attribute_class'),
        attribute_title = avsGetObjVal(layer,'attribute_title'),
        attribute_rel = avsGetObjVal(layer,'attribute_rel'),
        attribute_alt = avsGetObjVal(layer,'attribute_alt'),
        attribute_link_type = avsGetObjVal(layer,'attribute_link_type'),
        attribute_link_url = avsGetObjVal(layer,'attribute_link_url'),
        attribute_link_target = avsGetObjVal(layer,'attribute_link_target');
    jQuery('.as-slide-font-size').val(font_size);
    jQuery('select.as-slide-font-family').select2().val('Arial, Helvetica, sans-serif').trigger('change.select2');
    jQuery('.as-slide-line-height').val(line_height);
    jQuery('.as-font-weight').val('normal');

    jQuery('.as-slide-font-italic').prop( "checked", false );
    jQuery('.as-slide-font-italic').parent(".as-checkbox-toggle").removeClass("as-active");

    jQuery('.as-font-decoration').val('none');
    jQuery('.as-slide-letter-spacing').val(1);
    jQuery('.as-white-space').val('nowrap');
    jQuery('.as-text-transform').val('none');

    jQuery('.as-slide-text-align').parent(".as-radio-toggle").removeClass("as-active");
    jQuery('.as-slide-text-align[value=left]').prop('checked',true);
    jQuery('.as-slide-text-align[value=left]').parent(".as-radio-toggle").addClass("as-active");

    jQuery('.as-border-radius-top-left,.as-border-radius-top-right,.as-border-radius-bottom-right,.as-border-radius-bottom-left').val(0);

    jQuery('.as-slide-top-padding,.as-slide-right-padding,.as-slide-bottom-padding,.as-slide-left-padding').val(0);

    jQuery('.as-slide-individual-border').prop( "checked", false );
    jQuery('.as-slide-individual-border').parent().removeClass('as-active');
    jQuery('.as-slide-border-width,.as-slide-border-left-width,.as-slide-border-right-width.as-slide-border-bottom-width,.as-box-shadow-hoffset,.as-box-shadow-voffset,.as-box-shadow-blur,.as-box-shadow-spread').val(0);
    jQuery('.as-box-shadow-type').val('outset');
    jQuery('.as-slide-border-style,.as-slide-border-left-style,.as-slide-border-right-style,.as-slide-border-bottom-style').val('none');

    jQuery('.as-slide-x-position').val(x_position);
    jQuery('.as-slide-y-position').val(y_position);
    jQuery('.as-layer-rotate-angle').val(0);
    jQuery('.as-slide-layer-width').val(width);
    jQuery('.as-slide-layer-height').val(height);

    jQuery('.as-slide-elememt-full-width').prop( "checked", false );
    jQuery('.as-slide-elememt-full-width').parent().removeClass('as-active');

    jQuery('.as-slide-elememt-full-height').prop( "checked", false );
    jQuery('.as-slide-elememt-full-height').parent().removeClass('as-active');

    jQuery('.as-slide-layer-behavior').val('grid');
    jQuery('.as-element-layer-alignment').parent(".as-radio-toggle").removeClass("as-active");
    jQuery('.as-element-layer-alignment[value="left"]').prop('checked',true);
    jQuery('.as-element-layer-alignment[value="left"]').parent().addClass('as-active');
    jQuery('.as-element-verticle-alignment').parent(".as-radio-toggle").removeClass("as-active");
    jQuery('.as-element-verticle-alignment[value="top"]').prop('checked',true);
    jQuery('.as-element-verticle-alignment[value="top"]').parent().addClass('as-active');

    jQuery(".as-advance-css").val(advance_style);

    //set animation parameters
    jQuery('.as-editor-animation-delay').val(animation_delay);
    jQuery('.as-editor-animation-time').val(animation_time);
    if(select2_load == 0){
        jQuery('select.as-editor-animation-in').select2().val(animation_in).trigger('change.select2');
        jQuery('select.as-editor-animation-out').select2().val(animation_out).trigger("change.select2");
        jQuery('select.as-editor-animation-ease-in').select2().val('default').trigger("change.select2");
        jQuery('select.as-editor-animation-ease-out').select2().val('default').trigger("change.select2");

        if(jQuery('.as-layer-parallax-level').length > 0){
            // Set parallax value
            jQuery('select.as-layer-parallax-level').select2().val(0).trigger('change.select2');
            if(jQuery('.as-layer-3d-level-attach').length > 0){
                jQuery('select.as-layer-3d-level-attach').select2().val(0).trigger('change.select2');
            }
        }

    }
    jQuery('.as-editor-animation-startspeed').val(animation_startspeed);
    jQuery('.as-editor-animation-endspeed').val(animation_endspeed);

    //Update object attribute value
    jQuery('.as-editor-attribute-id').val(attribute_id);
    jQuery('.as-editor-attribute-classes').val(attribute_class);
    jQuery('.as-editor-attribute-title').val(attribute_title);
    jQuery('.as-editor-attribute-rel').val(attribute_rel);
    jQuery('.as-editor-attribute-alt').val(attribute_alt);
    if(select2_load === 0){
        jQuery('select.as-editor-linktype').select2().val(attribute_link_type).trigger("change.select2");
        if(attribute_link_type === 'simpleLink'){
            jQuery('.as-editor-link-type').show();
        }else{
            jQuery('.as-editor-link-type').hide();
        }
    }
    jQuery('.as-editor-linkUrl').val(attribute_link_url);
    jQuery('input[name="link_target"][value="' + attribute_link_target + '"]').prop('checked',true);

    //Hide Alt value from elements
    if(layer.type === 'image' || layer.type === 'video') {
        jQuery('.as-editor-altText').show();
    } else {
        jQuery('.as-editor-altText').hide();
    }
    jQuery('.show-on-desktop-view').prop( "checked", true );
    jQuery('.show-on-desktop-view').parent().addClass('as-device-active');
    jQuery('.show-on-mobile-view').prop( "checked", true );
    jQuery('.show-on-mobile-view').parent().addClass('as-device-active');
    jQuery('input[name="hide_under_width"][value="0"]').prop('checked',true);

    // jquery for border-style and layer behavior select2
    jQuery("select.as-editor-selectText").select2({
        minimumResultsForSearch: Infinity,
    }).on("select2:open", function (e) {
        var class_name = jQuery(this).attr("data-class");
        jQuery(".select2-dropdown").addClass(class_name);
    }).on("change", function (e) {
        jQuery(this).siblings(".select2").find(".select2-selection__rendered").removeAttr('title');
        if (jQuery(this).hasClass("as-editor-selectText")) {
            var class_name = jQuery(this).attr("data-class");
            jQuery(this).siblings(".select2").addClass(class_name);
            jQuery(this).siblings(".select2").find(".select2-selection__rendered").addClass(class_name);
        }
    }).trigger('change');
    //Color picker updates
    if(loadWin == 0){
        jQuery('.as-font-color').iris('color', font_color);
        if(jQuery.trim(background_color) == '') {
            jQuery('.as-background-color').val("");
            jQuery(jQuery('.as-background-color').closest('.wp-picker-container').find('.wp-color-result').find('span')).css("background",'none');
        } else {
            jQuery('.as-background-color').iris('color', background_color);
        }
        jQuery('.as-slide-borderColor').iris('color','#000000');
        jQuery('.as-slide-left-borderColor').iris('color','#000000');
        jQuery('.as-slide-right-borderColor').iris('color','#000000');
        jQuery('.as-slide-bottom-borderColor').iris('color','#000000');
        jQuery('.as-box-shadow-color').iris('color','#000000');
        changeD = true;
    }
    jQuery('.as-layer-detail-btn').removeClass('active');
    var pos = avsUpPos(editorLayer);
    jQuery('.as-slide-x-position').val(pos.left);
    jQuery('.as-slide-y-position').val(pos.top);
    avsUpLayerFromFields();
}

function avsUpLayerFromFields() {
    var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element');
    if(typeof objLayer != 'object' || !objLayer[current_index] || editorLayer.length == 0) {
        return false;
    }

    var layer = avsGetEleObj(current_index);
    layer = avsSetObjVal(layer,'font_size',jQuery('.as-slide-font-size').val());
    layer = avsSetObjVal(layer,'line_height',jQuery('.as-slide-line-height').val());
    layer = avsSetObjVal(layer,'font_color',jQuery('.as-font-color').val());
    layer = avsSetObjVal(layer,'background_color',jQuery('.as-background-color').val());

    //position
    layer = avsSetObjVal(layer,'x_position',jQuery('.as-slide-x-position').val());
    layer = avsSetObjVal(layer,'y_position',jQuery('.as-slide-y-position').val());

    layer = avsSetObjVal(layer,'alignto','grid');
    layer = avsSetObjVal(layer,'align_vert','top');
    layer = avsSetObjVal(layer,'align_hor','left');

    //width, height
    layer = avsSetObjVal(layer,'width',jQuery('.as-slide-layer-width').val());
    if (jQuery('.as-slide-layer-width').val() == 0 || jQuery('.as-slide-layer-width').val() == '') {
        layer = avsSetObjVal(layer,'width','auto');
    }
    layer = avsSetObjVal(layer,'height',jQuery('.as-slide-layer-height').val());
    if (jQuery('.as-slide-layer-height').val() == 0 || jQuery('.as-slide-layer-height').val() == '') {
        layer = avsSetObjVal(layer,'height','auto');
    }

    layer = avsSetObjVal(layer,'advance_style',jQuery('.as-advance-css').val());
    avsSetStyle(layer);
    avsUpEleObj(current_index,layer);
}

function avsUpLayerOtherFields() {
    var editorLayer = jQuery('.as-slide-editing-area .as-slide-elements .as-element.as-active-element');
    if(typeof objLayer != 'object' || !objLayer[current_index] || editorLayer.length == 0) {
        return false;
    }

    var layer = avsGetEleObj(current_index);
    //Update object animation value
    layer = avsSetObjVal(layer,'animation_delay',jQuery('.as-editor-animation-delay').val());
    layer = avsSetObjVal(layer,'animation_time',jQuery('.as-editor-animation-time').val());
    layer = avsSetObjVal(layer,'animation_in',jQuery('.as-editor-animation-in').val());
    layer = avsSetObjVal(layer,'animation_out',jQuery('.as-editor-animation-out').val());
    layer = avsSetObjVal(layer,'animation_startspeed',jQuery('.as-editor-animation-startspeed').val());
    layer = avsSetObjVal(layer,'animation_endspeed',jQuery('.as-editor-animation-endspeed').val());

    //Update object attribute value
    layer = avsSetObjVal(layer,'attribute_id',jQuery('.as-editor-attribute-id').val());
    layer = avsSetObjVal(layer,'attribute_class',jQuery('.as-editor-attribute-classes').val());
    layer = avsSetObjVal(layer,'attribute_title',jQuery('.as-editor-attribute-title').val());
    layer = avsSetObjVal(layer,'attribute_rel',jQuery('.as-editor-attribute-rel').val());
    layer = avsSetObjVal(layer,'attribute_alt',jQuery('.as-editor-attribute-alt').val());
    layer = avsSetObjVal(layer,'attribute_link_type',jQuery('.as-editor-linktype').val());
    layer = avsSetObjVal(layer,'attribute_link_url',jQuery('.as-editor-linkUrl').val());
    layer = avsSetObjVal(layer,'attribute_link_target',jQuery('input[name="link_target"]:checked').val());

    avsSetStyle(layer);
    avsUpEleObj(current_index,layer);
}

function avsSetStyle(layer) {
    avsSetSaveNeeded(true);

    var active_element = jQuery('.as-slide-editing-area .as-slide-elements .as-element:eq('+current_index+')');
    var active_inner_class = active_element.find('.as-inner-element');

    var advance_style = avsGetObjVal(layer,'advance_style');
    var type = avsGetObjVal(layer,'type');
    active_inner_class.attr('style','');
    avsApplyStyle(active_inner_class, {
        'max-width': avsGetObjVal(layer,'width') == 'auto' ? 'auto' : avsGetObjVal(layer,'width') + 'px',
        'min-height': avsGetObjVal(layer,'height') === 0 || avsGetObjVal(layer,'height') == '' ? 'auto' : avsGetObjVal(layer,'height') + 'px',
    });
    active_element.css({
        'width' : avsGetObjVal(layer,'width') == 'auto' ? 'auto' : avsGetObjVal(layer,'width') + 'px',
        'height' : avsGetObjVal(layer,'height') == 0 || avsGetObjVal(layer,'height') == '' ? 'auto' : avsGetObjVal(layer,'height') + 'px',
    });

    if(type == 'text') {
        avsApplyStyle(active_inner_class, {
            'font-size': avsGetObjVal(layer,'font_size') + 'px',
            'line-height': avsGetObjVal(layer,'line_height') + 'px',
            'color': avsGetObjVal(layer,'font_color'),
            'background-color': avsGetObjVal(layer,'background_color'),
        });
    }

    if(type == 'video') {
        active_element.find('img').attr('width',avsGetObjVal(layer,'width') == 'auto' ? 'auto' : avsGetObjVal(layer,'width'));
        active_element.find('img').attr('height',avsGetObjVal(layer,'height') == 0 || avsGetObjVal(layer,'height') == '' ? 'auto' : avsGetObjVal(layer,'height'));
    }
    var style = active_inner_class.attr('style')+advance_style;
    var pstyle = active_element.attr('style');
    if (style.indexOf("z-index") >= 0) {
        var zin = style.split(';');
        jQuery.each(zin, function (index, value) {
            if (value.indexOf("z-index") >= 0) {
                pstyle += value;
                active_element.attr('style',pstyle);
            }
        });
    } else {
        pstyle += 'z-index:'+(current_index+5)+';';
        active_element.attr('style',pstyle);
    }

    active_inner_class.attr('style',style);
}

function avsApplyStyle(element, style) {
    //var data_style = '';
    jQuery.each(style, function (index, value) {
        element.css(index,value);
    });
}


function avsUpdateSlidePos() {
    var slide_postion = new Array();
    //to reset position of all slides
    var slides = jQuery('.as-edit-slide .as-slide-tabs li.as-sorting-li');
    var i = 1;
    slides.each(function () {
        var slide_pos = jQuery(this);
        var slide_id_pos = slide_pos.find('.as-delete-slide').attr('id').replace("delete_as_slide_", "");
        if (slide_id_pos != '' && slide_id_pos != 0 && slide_id_pos != '0') {
            slide_postion.push({"slide_position": i, "slide_id": slide_id_pos});
            i++;
        }
    });
    avsAjaxRequestCall('update_slide_position', slide_postion, 'json', function (response) {
    });
}
/*
 * ======================================
 * ELEMENTS
 * ======================================
 */
function avsElementsColorPicker() {
    //Background color change
    jQuery('.as-admin .as-edit-slide .as-background-color').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            if (loadWin == 0) {
                jQuery('.as-element.as-active-element').children('.as-inner-element').css('background-color',ui.color.toString());
                avsUpLayerFromFields();
            }
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
            avsUpLayerFromFields();
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });

    //Text color change
    jQuery('.as-admin .as-edit-slide .as-font-color').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            if (loadWin == 0) {
                jQuery('.as-element.as-active-element').children('.as-inner-element').css('color',ui.color.toString());
                avsUpLayerFromFields();
            }
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
            jQuery(".as-font-color").iris('color','#000000');
            avsUpLayerFromFields();
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });

    //Border color
    jQuery('.as-admin .as-edit-slide .as-slide-borderColor,.as-admin .as-edit-slide .as-slide-left-borderColor,.as-admin .as-edit-slide .as-slide-right-borderColor,.as-admin .as-edit-slide .as-slide-bottom-borderColor').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            if(changeD) {
                jQuery('.as-slide-borderColor,.as-slide-left-borderColor,.as-slide-right-borderColor,.as-slide-bottom-borderColor').val('#000000');
                jQuery('.as-slide-borderColor,.as-slide-left-borderColor,.as-slide-right-borderColor,.as-slide-bottom-borderColor').closest('.as-form-control-group').find('.wp-color-result span').css('background', '#000000');
                avsProPopup();
            }
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });

    //Box-shadow color
    jQuery('.as-admin .as-edit-slide .as-box-shadow-color').wpColorPicker({
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            if(changeD) {
                jQuery('.as-box-shadow-color').val('#000000');
                jQuery('.as-box-shadow-color').closest('.as-form-control-group').find('.wp-color-result span').css('background', '#000000');
                avsProPopup();
            }
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    });

}

function avsAddTextElement(slide_layer) {
    current_index = ele_count;
    ele_count++;
    var objUpdate = {}, height = 'auto', width = 'auto';
    var area = jQuery('.as-slide-elements');
    if(typeof slide_layer === 'object') {
        objUpdate = jQuery.extend({},slide_layer);
        var dflt_text = avsGetObjVal(objUpdate,'text');
        dflt_text = dflt_text.replace(/\\"/ig,'"');
        dflt_text = dflt_text.replace(/\\'/ig,"'");
        objUpdate = avsSetObjVal(objUpdate,'text',dflt_text);
        ele_left = avsGetObjVal(objUpdate,'x_position');
        ele_top = avsGetObjVal(objUpdate,'y_position');
    }
    else {
        var dflt_text = 'Text Element' + (ele_count);
        var dflt_type = "text";
        objUpdate = jQuery.extend({},JSON.parse(default_array));
        objUpdate = avsSetObjVal(objUpdate,'text',dflt_text);
        objUpdate = avsSetObjVal(objUpdate,'type',dflt_type);
        jQuery('.as-text-element-text').val(dflt_text);
        jQuery('.as-slide-layer-width').val(width);
        jQuery('.as-slide-layer-height').val(height);
    }
    var z_index = current_index+5;
    objUpdate = avsSetObjVal(objUpdate,'z_index',current_index+5);
    avsAddInObject(objUpdate);

    // Insert in editing area
    area.append('<div class="as-element as-text-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;width:'+width+'px;height:'+height+'px;"><div class="as-inner-element">' + dflt_text + '</div><div class="as-layer-point"></div></div>');

    if(typeof slide_layer != 'object') {
        avsSelectElement(area.find('.as-element').last());
    } else {
        //Set Settings
        avsSetStyle(objUpdate);

        //Make draggable
        avsDraggableElements();

        //Update position
        var pos = avsUpPos(area.find('.as-element').last());
        ele_left = pos.left;
        ele_top = pos.top;
        avsUpHtmlLayerPos(area.find('.as-element').last(), ele_left, ele_top);
    }
}

function avsAddImageElement(slide_layer) {
    current_index = ele_count;
    ele_count++;
    var area = jQuery('.as-slide-elements');
    var objUpdate = {};
    var file_frame, image_count = 1;
    if(typeof slide_layer == 'object') {
        objUpdate = jQuery.extend({},slide_layer);
        ele_left = avsGetObjVal(objUpdate,'x_position');
        ele_top = avsGetObjVal(objUpdate,'y_position');
        var image_src = avsGetObjVal(objUpdate,'image_src');
        var image_alt = avsGetObjVal(objUpdate,'attribute_alt');
        var image_title = avsGetObjVal(objUpdate,'attribute_title');
        var image_width = avsGetObjVal(objUpdate,'width');
        var image_height = avsGetObjVal(objUpdate,'height');
        if (image_src != '' && image_count == 1) {
            var z_index = current_index+5;
            objUpdate = avsSetObjVal(objUpdate,'z_index',z_index);
            // Insert in editing area
            area.append('<div class="as-element as-image-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;"><div class="as-inner-element"><img src="' + image_src + '" alt="' + image_alt + '" title="' + image_title + '" width="' + image_width + '" height="' + image_height + '" ></div><div class="as-layer-point"></div></div>');
            jQuery(".as-edit-layer").attr("onclick", "avsUpMediaUpload()");
            image_count++;
            objUpdate = avsSetObjVal(objUpdate,'image_src',image_src);
            objUpdate = avsSetObjVal(objUpdate,'attribute_alt',image_alt);
            objUpdate = avsSetObjVal(objUpdate,'attribute_title',image_title);
            jQuery('.as-slide-layer-width').val(image_width);
            jQuery('.as-slide-layer-height').val(image_height);
            avsAddInObject(objUpdate);

            //Set Settings
            avsSetStyle(objUpdate);

            //Make draggable
            avsDraggableElements();

            //Update position
            var pos = avsUpPos(area.find('.as-element').last());
            ele_left = pos.left;
            ele_top = pos.top;
            avsUpHtmlLayerPos(area.find('.as-element').last(), ele_left, ele_top);
        }
    }else {
        var dflt_type = "image";
        objUpdate = jQuery.extend({},JSON.parse(default_array));
        objUpdate = avsSetObjVal(objUpdate,'type',dflt_type);
        ele_left = avsGetObjVal(objUpdate,'x_position');
        ele_top = avsGetObjVal(objUpdate,'y_position');
        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media({
            title: avs_translations.upload_image,
            multiple: false,
            library: {
                type: 'image'
            },
        });
        var gk_media_set_image = function () {
            current_index = ele_count;
            ele_count++;
            // This will return the selected image from the Media Uploader, the result is an object
            var attachment = file_frame.state().get('selection');
            if (attachment.length == 0) {
                //last_element.remove();
                return;
            }
            // Do something with attachment.id and/or attachment.url here
            attachment = attachment.first().toJSON();
            var image_src = attachment.url;
            var image_alt = attachment.alt;
            var image_title = attachment.title;
            var image_width = attachment.width;
            var image_height = attachment.height;
            if (image_src != '' && image_count == 1) {
                var z_index = current_index+5;
                objUpdate = avsSetObjVal(objUpdate,'z_index',z_index);
                // Insert in editing area
                area.append('<div class="as-element as-image-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;"><div class="as-inner-element"><img src="' + image_src + '" alt="' + image_alt + '" title="' + image_title + '" width="' + image_width + '" height="' + image_height + '" ></div><div class="as-layer-point"></div></div>');
                jQuery(".as-edit-layer").attr("onclick", "avsUpMediaUpload()");

                image_count++;
                objUpdate = avsSetObjVal(objUpdate,'image_src',image_src);
                objUpdate = avsSetObjVal(objUpdate,'attribute_title',image_title);
                objUpdate = avsSetObjVal(objUpdate,'attribute_alt',image_alt);
                objUpdate = avsSetObjVal(objUpdate,'width',image_width);
                objUpdate = avsSetObjVal(objUpdate,'height',image_height);
                jQuery('.as-slide-layer-width').val(image_width);
                jQuery('.as-slide-layer-height').val(image_height);
                avsAddInObject(objUpdate);
                avsSelectElement(area.find('.as-element').last());
            }
        };
        var gk_media_set_image_close = function () {
            ele_count--;
            current_index = ele_count;
            // This will return the selected image from the Media Uploader, the result is an object
            var attachment = file_frame.state().get('selection');
            if (attachment.length == 0) {
                //last_element.remove();
                return;
            }
        };
        file_frame.on('select', gk_media_set_image);
        file_frame.on('close', gk_media_set_image_close);
        file_frame.open();
    }
}

function avsUpMediaUpload(last_element){
    var objUpdate = objLayer[current_index];
    if( typeof last_element == 'undefined' ){
        return;
    }
    var file_frame;

   // If the media frame already exists, reopen it.
   if (file_frame) {
       file_frame.open();
       return;
   }

   // Create the media frame.
   file_frame = wp.media({
       title: avs_translations.upload_image,
       multiple: false,
       library: {
            type: 'image'
        },
   });

   file_frame.on('select',function(){
       var attachment = file_frame.state().get('selection');
       attachment = attachment.first().toJSON();
       var image_src = attachment.url;
       var image_alt = attachment.alt;
       var image_title = attachment.title;
       var image_width = attachment.width;
       var image_height = attachment.height;
       if (image_src != '') {
           last_element.find('.as-inner-element').find('img').attr('src',image_src);
           last_element.find('.as-inner-element').find('img').attr('alt',image_alt);
           last_element.find('.as-inner-element').find('img').attr('title',image_title);
           last_element.find('.as-inner-element').find('img').attr('width',image_width);
           last_element.find('.as-inner-element').find('img').attr('height',image_height);
           objUpdate = avsSetObjVal(objUpdate,'image_src',image_src);
           objUpdate = avsSetObjVal(objUpdate,'attribute_alt',image_alt);
           objUpdate = avsSetObjVal(objUpdate,'attribute_title',image_title);
           objUpdate = avsSetObjVal(objUpdate,'width',image_width);
           objUpdate = avsSetObjVal(objUpdate,'height',image_height);
           objUpdate = avsSetObjVal(objUpdate,'z_index',current_index+5);
           avsUpEleObj(current_index,objUpdate);
           jQuery('.as-slide-layer-width').val(image_width);
           jQuery('.as-slide-layer-height').val(image_height);
       }
   });
   file_frame.open();
}

function avsGetMediaUpload(last_element) {
    var objUpdate = objLayer['current_index'];
    if( typeof last_element == 'undefined' ){
        return;
    }
    var file_frame, image_count;

    // If the media frame already exists, reopen it.
    if (file_frame) {
        file_frame.open();
        return;
    }

    // Create the media frame.
    file_frame = wp.media({
        title: avs_translations.upload_image,
        multiple: false,
        library: {
            type: 'image'
        },
    });
    image_count = 1;
    var gk_media_set_image = function () {
        // This will return the selected image from the Media Uploader, the result is an object
        var attachment = file_frame.state().get('selection');
        if (attachment.length == 0) {
            last_element.remove();
            return;
        }
        // Do something with attachment.id and/or attachment.url here
        attachment = attachment.first().toJSON();
        var image_src = attachment.url;
        var image_alt = attachment.alt;
        var image_title = attachment.title;
        var image_width = attachment.width;
        var image_height = attachment.height;
        if (image_src != '' && image_count == 1) {
            last_element.find('.as-inner-element').append('<img src="' + image_src + '" alt="' + image_alt + '" title="' + image_title + '" width="' + image_width + '" height="' + image_height + '" >');
            jQuery(".as-edit-layer").attr("onclick", "avsUpMediaUpload()");
            image_count++;
            objUpdate = avsSetObjVal(objUpdate,'image_src',image_src);
            objUpdate = avsSetObjVal(objUpdate,'attribute_alt',image_alt);
            objUpdate = avsSetObjVal(objUpdate,'attribute_title',image_title);
        }
    };
    file_frame.on('close', gk_media_set_image);
    file_frame.on('select', gk_media_set_image);
    file_frame.open();
}

function avsAddVideoElement(slide_layer) {
    current_index = ele_count;
    ele_count++;
    ele_left = 100,
    ele_top = 100;
    var objUpdate = {},
    video_url = '',
    video_img = '',
    video_poster_img = '',
    video_type = '',
    video_height = '',
    video_width = '',
    video_poster_img = '',
    html5_mp4_url = '',
    html5_ogv_url = '',
    html5_webm_url = '',
    youtube_url = '',
    video_id = '',
    vimeo_url = '',
    html5Html = '',
    video_alt = '',
    video_title = '';
    var area = jQuery('.as-slide-elements'),
            width = 320,
            height = 240;
    if(typeof slide_layer == 'object') {
        objUpdate = jQuery.extend({},slide_layer);
        ele_left = avsGetObjVal(objUpdate,'x_position');
        ele_top = avsGetObjVal(objUpdate,'y_position');
        video_type = avsGetObjVal(objUpdate,'video_type');

        youtube_url = avsGetObjVal(objUpdate,'youtube_url'),
        video_id = avsGetObjVal(objUpdate,'video_id'),
        vimeo_url = avsGetObjVal(objUpdate,'vimeo_url'),
        html5_mp4_url = avsGetObjVal(objUpdate,'html5_mp4_url'),
        html5_ogv_url = avsGetObjVal(objUpdate,'html5_ogv_url'),
        html5_webm_url = avsGetObjVal(objUpdate,'html5_webm_url'),

        video_height = avsGetObjVal(objUpdate,'height');
        video_width = avsGetObjVal(objUpdate,'width');

        video_poster_img = avsGetObjVal(objUpdate,'editor_video_image');
        video_alt = avsGetObjVal(objUpdate,'attribute_alt');
        video_title = avsGetObjVal(objUpdate,'attribute_title');

        switch(video_type) {
            case 'youtube' :
                            video_url = youtube_url;
                            if(video_url != ''){
                                var youtubeHtml = '',
                                youtubeID = '',
                                youtubeID = jQuery.trim(video_url);
                                youtubeID = avsGetYoutubeIDFromUrl(youtubeID);

                                video_img = "https://img.youtube.com/vi/"+youtubeID+"/sddefault.jpg"
                                if(video_poster_img !== '') video_img = video_poster_img;

                                if(jQuery.trim(video_title) =='') video_title = avs_translations.youtube_video_title;
                                if(jQuery.trim(video_alt) =='') video_alt = avs_translations.youtube_video_title;

                                video_width = video_width == 0 || video_width == '' ? '320' : video_width;
                                video_height = video_height == 0 || video_height == '' ? '240' : video_height;

                                youtubeHtml += '<label class="video_block_title">'+jQuery.trim(video_title)+'</label>';
                                youtubeHtml += '<img src="'+video_img+'" width="'+video_width+'" height="'+video_height+'" />';
                                youtubeHtml += '<div class="video_block_icon youtube_icon"></div>';
                                var z_index = current_index+5;
                                var area = jQuery('.as-slide-elements');
                                // Add the image into the editing area.
                                area.append('<div class="as-element as-video-element as-iframe-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;">\n\
                                            <div class="as-inner-element">'+youtubeHtml+'</div><div class="as-layer-point"></div>\n\
                                            </div>');
                                jQuery('.as-editor-youtubeUrl').val(video_url);
                                jQuery('#as_tab_video_sources div.as-form-control .as-btn').removeClass('as-active');
                                jQuery('#as_tab_video_sources div.as-form-control .as-btn.as-youtube').addClass('as-active');
                                jQuery('.as-editor-videoId').val(video_id);
                                jQuery('.as-editor-attribute-title').val(video_title);
                                jQuery('.as-editor-attribute-alt').val(video_alt);
                                jQuery('.as-editor-videoImg').val(video_poster_img);
                                jQuery('.as-slide-layer-width').val(video_width);
                                jQuery('.as-slide-layer-height').val(video_height);
                                objUpdate = avsSetObjVal(objUpdate,'z_index',z_index );
                                avsAddInObject(objUpdate);
                                avsSetfLoad(area,objUpdate);
                            }
                break;
            case 'vimeo' :
                            video_url = vimeo_url;
                            if(video_url != ''){
                                var vimeoID = '';
                                vimeoID = jQuery.trim(video_url);
                                vimeoID = avsGetVimeoIDFromUrl(vimeoID);
                                video_width = video_width == 0 || video_width == '' ? '320' : video_width;
                                video_height = video_height == 0 || video_height == '' ? '240' : video_height;
                                if(vimeoID != '') {
                                    jQuery.ajax({
                                        url: 'http://vimeo.com/api/v2/video/' + vimeoID + '.json',
                                        dataType: 'jsonp',
                                        success: function (data) {
                                            video_img = data[0].thumbnail_large;
                                            if(video_poster_img !== '') video_img = video_poster_img;

                                            if(jQuery.trim(video_title) == '') video_title = data[0].title;
                                            if(jQuery.trim(video_alt) == '') video_alt = data[0].title;

                                            var vimeoHtml = '';
                                            vimeoHtml += '<label class="video_block_title">'+jQuery.trim(video_title)+'</label>';
                                            vimeoHtml += '<img src="'+video_img+'" width="'+video_width+'" height="'+video_height+'" />';
                                            vimeoHtml += '<div class="video_block_icon vimeo_icon"></div>';

                                            var area = jQuery('.as-slide-elements');
                                            var z_index = current_index+5;
                                            // Add the image into the editing area.
                                            area.append('<div class="as-element as-video-element as-iframe-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;">\n\
                                                        <div class="as-inner-element">'+vimeoHtml+'</div><div class="as-layer-point"></div>\n\
                                                        </div>');
                                            jQuery('.as-editor-videoId').val(video_id);
                                            jQuery('.as-editor-attribute-title').val(video_title);
                                            jQuery('.as-editor-attribute-alt').val(video_alt);
                                            jQuery('.as-editor-videoImg').val(video_poster_img);
                                            jQuery('.as-slide-layer-width').val(video_width);
                                            jQuery('.as-slide-layer-height').val(video_height);
                                            objUpdate = avsSetObjVal(objUpdate,'z_index',z_index );
                                            avsAddInObject(objUpdate);
                                            avsSetfLoad(area,objUpdate);
                                        },
                                        error: function () {
                                            var vimeoHtml = '';
                                            vimeoHtml += '<label class="video_block_title">'+jQuery.trim(video_title)+'</label>';
                                            vimeoHtml += '<img src="'+video_img+'" width="'+video_width+'" height="'+video_height+'" />';
                                            vimeoHtml += '<div class="video_block_icon vimeo_icon"></div>';

                                            var area = jQuery('.as-slide-elements');
                                            var z_index = current_index+5;
                                            // Add the image into the editing area.
                                            area.append('<div class="as-element as-video-element as-iframe-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;">\n\
                                                        <div class="as-inner-element">'+vimeoHtml+'</div><div class="as-layer-point"></div>\n\
                                                        </div>');
                                            jQuery('.as-editor-videoId').val(video_id);
                                            jQuery('.as-editor-attribute-title').val(video_title);
                                            jQuery('.as-editor-attribute-alt').val(video_alt);
                                            jQuery('.as-editor-videoImg').val(video_poster_img);
                                            jQuery('.as-slide-layer-width').val(video_width);
                                            jQuery('.as-slide-layer-height').val(video_height);
                                            objUpdate = avsSetObjVal(objUpdate,'z_index',z_index );
                                            avsAddInObject(objUpdate);
                                            avsSetfLoad(area,objUpdate);
                                        }
                                    });
                                }
                                else {
                                    var vimeoHtml = '';
                                    vimeoHtml += '<label class="video_block_title">'+jQuery.trim(video_title)+'</label>';
                                    vimeoHtml += '<img src="'+video_img+'" width="'+video_width+'" height="'+video_height+'" />';
                                    vimeoHtml += '<div class="video_block_icon vimeo_icon"></div>';

                                    var area = jQuery('.as-slide-elements');
                                    var z_index = current_index+5;
                                    // Add the image into the editing area.
                                    area.append('<div class="as-element as-video-element as-iframe-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;">\n\
                                                <div class="as-inner-element">'+vimeoHtml+'</div><div class="as-layer-point"></div>\n\
                                                </div>');
                                    jQuery('.as-editor-videoId').val(video_id);
                                    jQuery('.as-editor-attribute-title').val(video_title);
                                    jQuery('.as-editor-attribute-alt').val(video_alt);
                                    jQuery('.as-editor-videoImg').val(video_poster_img);
                                    jQuery('.as-slide-layer-width').val(video_width);
                                    jQuery('.as-slide-layer-height').val(video_height);
                                    objUpdate = avsSetObjVal(objUpdate,'z_index',z_index );
                                    avsAddInObject(objUpdate);
                                    avsSetfLoad(area,objUpdate);
                                }
                                jQuery('.as-editor-vimeoUrl').val(video_url);
                                jQuery('#as_tab_video_sources div.as-form-control .as-btn').removeClass('as-active');
                                jQuery('#as_tab_video_sources div.as-form-control .as-btn.as-vimeo').addClass('as-active');
                            }
                break;
            case 'html5' :
                            if(html5_mp4_url != '' || html5_ogv_url != '' || html5_webm_url != ''){
                                video_width = video_width == 0 || video_width == '' ? '320' : video_width;
                                video_height = video_height == 0 || video_height == '' ? '240' : video_height;

                                video_img = avs_translations.AvartanPluginUrl+'/manage/assets/images/html5-video.png';
                                if(video_poster_img !== 'undefined' && video_poster_img !== '') video_img = video_poster_img;

                                if(jQuery.trim(video_title) == '') video_title = avs_translations.html5_video_title;
                                if(jQuery.trim(video_alt) == '') video_alt = avs_translations.html5_video_title;

                                var html5Html = '';
                                html5Html += '<label class="video_block_title">'+video_title+'</label>';
                                html5Html += '<img src="'+video_img+'" width="'+video_width+'" height="'+video_height+'" />';
                                html5Html += '<div class="video_block_icon html5_icon"></div>';
                                var z_index = current_index+5;
                                var area = jQuery('.as-slide-elements');
                                // Add the image into the editing area.
                                area.append('<div class="as-element as-video-element as-iframe-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;">\n\
                                            <div class="as-inner-element">'+html5Html+'</div><div class="as-layer-point"></div>\n\
                                            </div>');

                                jQuery('.as-editor-htmlMp4').val(html5_mp4_url);
                                jQuery('.as-editor-htmlWebm').val(html5_webm_url);
                                jQuery('.as-editor-htmlOgv').val(html5_ogv_url);
                                jQuery('#as_tab_video_sources div.as-form-control .as-btn').removeClass('as-active');
                                jQuery('#as_tab_video_sources div.as-form-control .as-btn.as-html5').addClass('as-active');
                                if(html5_mp4_url != '') {
                                    video_url = html5_mp4_url;
                                }
                                else if(html5_webm_url != '') {
                                    video_url = html5_webm_url;
                                }
                                else if(html5_ogv_url != '') {
                                    video_url = html5_ogv_url;
                                }
                                jQuery('.as-editor-videoId').val(video_id);
                                jQuery('.as-editor-attribute-title').val(video_title);
                                jQuery('.as-editor-attribute-alt').val(video_alt);
                                jQuery('.as-editor-videoImg').val(video_poster_img);
                                jQuery('.as-slide-layer-width').val(video_width);
                                jQuery('.as-slide-layer-height').val(video_height);
                                objUpdate = avsSetObjVal(objUpdate,'z_index',z_index );
                                avsAddInObject(objUpdate);
                                avsSetfLoad(area,objUpdate);
                            }
                break;
        }
    } else {
        objUpdate = jQuery.extend({},JSON.parse(default_array));
        var dflt_type = "video";
        objUpdate = avsSetObjVal(objUpdate,'type',dflt_type);
        objUpdate = avsSetObjVal(objUpdate,'width',width);
        objUpdate = avsSetObjVal(objUpdate,'height',height);
        jQuery('.as-slide-layer-width').val(width);
        jQuery('.as-slide-layer-height').val(height);
        jQuery('.as-editor-youtubeUrl').val('youtube');
        jQuery('.as-editor-vimeoUrl').val('');
        jQuery('.as-editor-htmlMp4').val('');
        jQuery('.as-editor-htmlWebm').val('');
        jQuery('.as-editor-htmlOgv').val('');
        jQuery('.as-editor-videoId').val('');
        jQuery('.as-video-type').removeClass('as-active');
        jQuery('.as-video-type.as-youtube').addClass('as-active');
        jQuery('input[name="video_fullscreen"][value="0"]').prop('checked',true);
        jQuery('input[name="video_forcecover"][value="0"]').prop('checked',true);
        jQuery('.as-video-aspectRatio').val('16:9');
        jQuery('input[name="video_loopVideo"][value="0"]').prop('checked',true);
        jQuery('input[name="video_autoplay"][value="0"]').prop('checked',true);
        jQuery('input[name="video_firstTime"][value="0"]').prop('checked',true);
        jQuery('input[name="video_allowFullscreen"][value="0"]').prop('checked',true);
        jQuery('input[name="video_nextSlide"][value="0"]').prop('checked',true);
        jQuery('input[name="video_hideControl"][value="0"]').prop('checked',true);
        jQuery('input[name="video_mute"][value="0"]').prop('checked',true);
        jQuery('input[name="video_posterOnPause"][value="0"]').prop('checked',true);
        jQuery('.as-editor-videoImg').val('');
        var z_index = current_index+5;
        objUpdate = avsSetObjVal(objUpdate,'z_index',z_index );
        avsAddInObject(objUpdate);
        // Add the image into the editing area.
        area.append('<div class="as-element as-video-element as-iframe-element" style="z-index: '+z_index+';left:'+ele_left+'px;top:'+ele_top+'px;"><div class="as-inner-element"><img src="'+avs_translations.AvartanPluginUrl+'/manage/assets/images/video_sample.jpg" width="320" height="240" style="z-index: 1;" /></div><div class="as-layer-point"></div></div>');
        avsSelectElement(area.find('.as-element').last());
    }
}

function avsSetfLoad(area,objUpdate) {
    //Set Settings
    avsSetStyle(objUpdate);

    //Make draggable
    avsDraggableElements();

    //Update position
    var pos = avsUpPos(area.find('.as-element').last());
    avsUpHtmlLayerPos(area.find('.as-element').last(), pos.left, pos.top);
}
function avsGetYoutubeInfo(url_val){
    var youtubeHtml = '',
        youtubeImg = '',
        youtubeID = '',
        youtubeTitle = '',
        video_width = jQuery('.as-slide-layer-width').val(),
        video_height = jQuery('.as-slide-layer-height').val(),
        youtube_block = jQuery('.as-element.as-video-element.as-active-element'),
        poster_img = jQuery('.as-editor-videoImg').val();

    youtubeID = jQuery.trim(url_val);
    youtubeID = avsGetYoutubeIDFromUrl(youtubeID);

    //If api call fail then display youtube image
    if(youtubeImg == ''){
        var newUrl = "https://img.youtube.com/vi/"+youtubeID+"/sddefault.jpg"
        youtubeImg = newUrl;
        if(poster_img != '') youtubeImg = poster_img;
        youtubeTitle = avs_translations.youtube_video_title;
    }

    if(jQuery.trim(youtubeTitle)!=''){
        youtubeHtml += '<label class="video_block_title">'+jQuery.trim(youtubeTitle)+'</label>';
    }
    video_width = video_width == 0 || video_width == '' ? '320' : video_width;
    video_height = video_height == 0 || video_height == '' ? '240' : video_height;

    youtubeHtml += '<img src="'+youtubeImg+'" width="'+video_width+'" height="'+video_height+'" />';
    youtubeHtml += '<div class="video_block_icon youtube_icon"></div>';
    jQuery(youtube_block).find('.as-inner-element').html(youtubeHtml);

    jQuery('.as-editor-attribute-title').val(youtubeTitle);
    jQuery('.as-editor-attribute-alt').val(youtubeTitle);
    jQuery('.as-editor-videoImg').val(poster_img);

    avsSetVideoSettings();
}

function avsGetYoutubeIDFromUrl(url) {
    url = jQuery.trim(url);

    var video_id = url.split('v=')[1];
    if (video_id) {
        var ampersandPosition = video_id.indexOf('&');
        if (ampersandPosition != -1) {
            video_id = video_id.substring(0, ampersandPosition);
        }
    } else {
        video_id = url;
    }

    return(video_id);
}

function avsGetVimeoInfo(url_val){
    var vimeo_block = jQuery('.as-element.as-video-element.as-active-element');
    var video_width = jQuery('.as-slide-layer-width').val();
    var video_height = jQuery('.as-slide-layer-height').val();
    var vimeoID = '';
    var vimeoImg = '';
    var vimeoTitle = '',
    poster_img = jQuery('.as-editor-videoImg').val();

    vimeoID = jQuery.trim(url_val);
    vimeoID = avsGetVimeoIDFromUrl(vimeoID);

    video_width = video_width == 0 || video_width == '' ? '320' : video_width;
    video_height = video_height == 0 || video_height == '' ? '240' : video_height;

    jQuery.ajax({
        url: 'http://vimeo.com/api/v2/video/' + vimeoID + '.json',
        dataType: 'jsonp',
        success: function (data) {
            vimeoImg = data[0].thumbnail_large;
            if(poster_img != '') vimeoImg = poster_img;
            vimeoTitle = data[0].title;

            var vimeoHtml = '';
            if(jQuery.trim(vimeoTitle)!=''){
                vimeoHtml += '<label class="video_block_title">'+jQuery.trim(vimeoTitle)+'</label>';
            }
            vimeoHtml += '<img src="'+vimeoImg+'" width="'+video_width+'" height="'+video_height+'" />';
            vimeoHtml += '<div class="video_block_icon vimeo_icon"></div>';
            jQuery(vimeo_block).find('.as-inner-element').html(vimeoHtml);

            jQuery('.as-editor-attribute-title').val(vimeoTitle)
            jQuery('.as-editor-attribute-alt').val(vimeoTitle)
            jQuery('.as-editor-videoImg').val(poster_img);

            avsSetVideoSettings();
        }
    });
}

function avsGetVimeoIDFromUrl(url) {
    url = jQuery.trim(url);

    var video_id = url.replace(/[^0-9]+/g, '');
    video_id = jQuery.trim(video_id);

    return(video_id);
}

function avsUploadPreviewImageElement(slide_parent) {
    var area = slide_parent.find('.as-slide-editing-area').find('.as-slide-elements');
    var settings_div = slide_parent.find('.as-layer-video-element');
    var file_frame;

    // If the media frame already exists, reopen it.
    if (file_frame) {
        file_frame.open();
        return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        multiple: false,  // Set to true to allow multiple files to be selected
        library: {
            type: 'image'
        },
    });

    // When an image is selected, run a callback.
    file_frame.on('select', function () {
        // We set multiple to false so only get one image from the uploader
        attachment = file_frame.state().get('selection').first().toJSON();

        // Do something with attachment.id and/or attachment.url here
        var image_src = attachment.url;
        var image_alt = (jQuery.trim(attachment.alt) != '') ? attachment.alt : jQuery('.as-editor-attribute-alt').val();
        var image_title = (jQuery.trim(attachment.title) != '') ? attachment.title : jQuery('.as-editor-attribute-title').val();

        // Set attributes. If is a link, do the right thing
        var image = area.find('.as-video-element.as-active-element').last();

        image.find('img').attr('src', image_src);
        image.find('img').attr('alt', image_alt);
        image.find('img').attr('title', image_title);

        // Set data (will be used in the ajax call)
        settings_div.find('.as-editor-videoImg').val(image_src);
        jQuery('.as-editor-attribute-title').val(image_title)
        jQuery('.as-editor-attribute-alt').val(image_alt)

        avsSetVideoSettings();

    });
    // Finally, open the modal
    file_frame.open();
}

function avsSetVideoSettings() {
    if(typeof objLayer != 'object' || typeof objLayer[current_index] == 'undefined') {
        return false;
    }
    var objCurrent = avsGetEleObj(current_index);
    objCurrent = avsSetObjVal(objCurrent,'video_fullscreen',jQuery('input[name="video_fullscreen"]:checked').val(),'single');
    objCurrent = avsSetObjVal(objCurrent,'video_type',jQuery('.as-video-type.as-active').attr('value'));
    objCurrent = avsSetObjVal(objCurrent,'youtube_url',jQuery('.as-editor-youtubeUrl').val());
    objCurrent = avsSetObjVal(objCurrent,'vimeo_url',jQuery('.as-editor-vimeoUrl').val());
    objCurrent = avsSetObjVal(objCurrent,'html5_mp4_url',jQuery('.as-editor-htmlMp4').val());
    objCurrent = avsSetObjVal(objCurrent,'html5_webm_url',jQuery('.as-editor-htmlWebm').val());
    objCurrent = avsSetObjVal(objCurrent,'html5_ogv_url',jQuery('.as-editor-htmlOgv').val());
    objCurrent = avsSetObjVal(objCurrent,'editor_video_image',jQuery('.as-editor-videoImg').val());
    objCurrent = avsSetObjVal(objCurrent,'attribute_title',jQuery('.as-editor-attribute-title').val());
    objCurrent = avsSetObjVal(objCurrent,'attribute_alt',jQuery('.as-editor-attribute-alt').val());
    var video_type = avsGetObjVal(objCurrent,'video_type');
    var youtube_url = avsGetObjVal(objCurrent,'youtube_url');
    var vimeo_url = avsGetObjVal(objCurrent,'vimeo_url');
    var video_id_u = '';
    if(video_type == 'youtube') {
        video_id_u = avsGetYoutubeIDFromUrl(youtube_url);
    }
    if(video_type == 'vimeo') {
        video_id_u = avsGetVimeoIDFromUrl(vimeo_url);
    }
    objCurrent = avsSetObjVal(objCurrent,'video_id',video_id_u);
}

/*
 * ======================================
 * Animation
 * ======================================
 */
function avsOneSlideStructure(slotholder, slide_options, visible, layout, width, height) {

    var sh = slotholder,
            src = sh.find('.default_image').css("backgroundImage"),
            bgcolor = sh.find('.default_image').css('backgroundColor'),
            off = 0,
            bgfit = sh.find('.default_image').css("backgroundSize"),
            bgrepeat = sh.find('.default_image').css("backgroundRepeat"),
            bgposition = sh.find('.default_image').css("backgroundPosition");

    src = src.replace('"', '');
    src = src.replace('"', '');

    if (bgfit == undefined)
        bgfit = "cover";
    if (bgrepeat == undefined)
        bgrepeat = "no-repeat";
    if (bgposition == undefined)
        bgposition = "center center";

    slide_options.slotw = Math.ceil(width / slide_options.slots),
            slide_options.sloth = Math.ceil(height / slide_options.slots);

    //set default value for box
    var basicsize = 0;

    if (slide_options.sloth > slide_options.slotw)
        basicsize = slide_options.sloth
    else
        basicsize = slide_options.slotw;

    slide_options.slotw = basicsize;
    slide_options.sloth = basicsize;

    var x = 0,
        y = 0,
        fulloff = 0,
        fullyoff = 0;



    switch (layout) {
        // Box layout animation
        case "box":

            for (var j = 0; j < slide_options.slots; j++) {
                y = 0;
                for (var i = 0; i < slide_options.slots; i++) {
                    sh.append('<div class="slot" ' +
                            'style="position:absolute;' +
                            'top:' + (fullyoff + y) + 'px;' +
                            'left:' + (fulloff + x) + 'px;' +
                            'width:' + basicsize + 'px;' +
                            'height:' + basicsize + 'px;' +
                            'overflow:hidden;">' +
                            '<div class="slot_slide" data-x="' + x + '" data-y="' + y + '" ' +
                            'style="position:absolute;' +
                            'top:' + (0) + 'px;' +
                            'left:' + (0) + 'px;' +
                            'width:' + basicsize + 'px;' +
                            'height:' + basicsize + 'px;' +
                            'overflow:hidden;">' +
                            '<div class="slot_slide_bg" style="position:absolute;' +
                            'top:' + (0 - y) + 'px;' +
                            'left:' + (0 - x) + 'px;' +
                            'width:' + width + 'px;' +
                            'height:' + height + 'px;' +
                            'background-color:' + bgcolor + ';' +
                            'background-image:' + src + ';' +
                            'background-repeat:' + bgrepeat + ';' +
                            'background-size:' + bgfit + ';background-position:' + bgposition + ';">' +
                            '</div></div></div>');
                    y = y + basicsize;
                }
                x = x + basicsize;
            }
            break;

        // verticle and horizontal slot animation
        case "vertical":
        case "horizontal":


            if (layout == "horizontal") {
                if (!visible)
                    var off = 0 - slide_options.slotw;

                for (var i = 0; i < slide_options.slots; i++) {
                    sh.append('<div class="slot" style="position:absolute;' +
                            'top:' + (0 + fullyoff) + 'px;' +
                            'left:' + (fulloff + (i * slide_options.slotw)) + 'px;' +
                            'overflow:hidden;width:' + (slide_options.slotw + 0.6) + 'px;' +
                            'height:' + height + 'px">' +
                            '<div class="slot_slide" style="position:absolute;' +
                            'top:0px;left:' + off + 'px;' +
                            'width:' + (slide_options.slotw + 0.6) + 'px;' +
                            'height:' + height + 'px;overflow:hidden;">' +
                            '<div class="slot_slide_bg" style="background-color:' + bgcolor + ';' +
                            'position:absolute;top:0px;' +
                            'left:' + (0 - (i * slide_options.slotw)) + 'px;' +
                            'width:' + width + 'px;height:' + height + 'px;' +
                            'background-image:' + src + ';' +
                            'background-repeat:' + bgrepeat + ';' +
                            'background-size:' + bgfit + ';background-position:' + bgposition + ';">' +
                            '</div></div></div>');
                }

            } else {
                if (!visible)
                    var off = 0 - slide_options.sloth;

                for (var i = 0; i < slide_options.slots + 2; i++) {
                    sh.append('<div class="slot" style="position:absolute;' +
                            'top:' + (fullyoff + (i * slide_options.sloth)) + 'px;' +
                            'left:' + (fulloff) + 'px;' +
                            'overflow:hidden;' +
                            'width:' + width + 'px;' +
                            'height:' + (slide_options.sloth) + 'px">' +
                            '<div class="slot_slide" style="position:absolute;' +
                            'top:' + (off) + 'px;' +
                            'left:0px;width:' + width + 'px;' +
                            'height:' + slide_options.sloth + 'px;' +
                            'overflow:hidden;">' +
                            '<div class="slot_slide_bg" style="background-color:' + bgcolor + ';' +
                            'position:absolute;' +
                            'top:' + (0 - (i * slide_options.sloth)) + 'px;' +
                            'left:0px;' +
                            'width:' + width + 'px;height:' + height + 'px;' +
                            'background-image:' + src + ';' +
                            'background-repeat:' + bgrepeat + ';' +
                            'background-size:' + bgfit + ';background-position:' + bgposition + ';">' +
                            '</div></div></div>');
                }
            }
            break;
    }
}

function avsSetSlideLayerSettings(){
   var slide = jQuery('.as-edit-slide');
   var slide_index = jQuery('.as-admin .as-slide-tabs').find('li.as-active').index();
   slide_index--;
   var final_options = new Array();
   var bg_type = slide.find('.as-slide-bg-type').val();

   var options = {
       background: {
           type: bg_type,
           bgcolor: bg_type == 'solid_color' ? jQuery.trim(slide.find('.as-slide-bgcolor').val()) : '',
           image: {
               source: bg_type == 'image' ? jQuery.trim(slide.find('.as-slide-bg-image').attr('data-source')) : '',
               position: bg_type == 'image' ? slide.find('.as-slide-bgpos').val() : '',
               position_x: (bg_type == 'image' && jQuery.trim(slide.find('.as-slide-bgpos').val()) == 'percentage') ? jQuery.trim(slide.find('.as-slide-bgpos-x').val()) : '0',
               position_y: (bg_type == 'image' && jQuery.trim(slide.find('.as-slide-bgpos').val()) == 'percentage') ? jQuery.trim(slide.find('.as-slide-bgpos-y').val()) : '0',
               repeat: bg_type == 'image' ? jQuery.trim(slide.find('.as-slide-bgrepeat').val()) : '',
               size: bg_type == 'image' ? slide.find('.as-slide-bgsize').val() : '',
               size_x: (bg_type == 'image' && jQuery.trim(slide.find('.as-slide-bgsize').val()) == 'percentage') ? jQuery.trim(slide.find('.as-slide-bgsize-x').val()) : '0',
               size_y: (bg_type == 'image' && jQuery.trim(slide.find('.as-slide-bgsize').val()) == 'percentage') ? jQuery.trim(slide.find('.as-slide-bgsize-y').val()) : '0',
           }
       },
       data_animation: slide.find('.as-animation-effect-list li.as-active').data('animation'),
       data_time: (jQuery.trim(slide.find('.as-slide-animation-time').val()) != '') ? parseInt(slide.find('.as-slide-animation-time').val()) : '0',
       data_easeIn: (jQuery.trim(slide.find('.as-slide-animation-easyin').val()) != '') ? parseInt(slide.find('.as-slide-animation-easyin').val()) : '0',
       custom_css: avsStripslashes(slide.find('#as_tab_advance .as-slide-custom-css').val()),
       current_version: avs_translations.current_version
   };
   var slide_layera = '';
   if(typeof objLayer == 'undefined') {
       objLayer = '';
   }
   else {
       jQuery.each(objLayer, function(i,slide_layer) {
           if(typeof slide_layera == 'object') {
               slide_layera.push(slide_layer);
           }
           else {
               slide_layera = [slide_layer];
           }
       });
   }
   final_options.push({"slider_id": jQuery('.as-edit-slide .as-slider-id').val(), "slide_id": jQuery('.as-edit-slide .as-slide-id').val(), "position": slide_index, "slide_option": JSON.stringify(options), "layers": JSON.stringify(slide_layera)});
   return final_options;
}

function avl_show_hide_permission() {
    jQuery('.avl_permission_cover').slideToggle();
}

function avl_submit_optin(options) {
    result = {};
    result.action = 'avl_submit_optin';
    result.email = jQuery('#avl_admin_email').val();
    result.type = options;

    if (options == 'submit') {
        if (jQuery('input#avl_agree_gdpr').is(':checked')) {
            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: result,
                error: function () { },
                success: function () {
                    window.location.href = "admin.php?page=avartanslider";
                },
                complete: function () {
                    window.location.href = "admin.php?page=avartanslider";
                }
            });
        }
        else {
            jQuery('.avl_agree_gdpr_lbl').css('color', '#ff0000');
        }
    }
    else if (options == 'deactivate') {
        if (jQuery('input#avl_agree_gdpr_deactivate').is(':checked')) {
            var avl_plugin_admin = jQuery('.documentation_avl_plugin').closest('div').find('.deactivate').find('a');
            result.selected_option_de = jQuery('input[name=sol_deactivation_reasons_avl]:checked', '#frmDeactivationavl').val();
            result.selected_option_de_id = jQuery('input[name=sol_deactivation_reasons_avl]:checked', '#frmDeactivationavl').attr("id");
            result.selected_option_de_text = jQuery("label[for='" + result.selected_option_de_id + "']").text();
            result.selected_option_de_other = jQuery('.sol_deactivation_reason_other_avl').val();
            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: result,
                error: function () { },
                success: function () {
                    window.location.href = avl_plugin_admin.attr('href');
                },
                complete: function () {
                    window.location.href = avl_plugin_admin.attr('href');
                }
            });
        }
        else {
            jQuery('.avl_agree_gdpr_lbl').css('color', '#ff0000');
        }
    }
    else {
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: result,
            error: function () { },
            success: function () {
                window.location.href = "admin.php?page=avartanslider";
            },
            complete: function () {
                window.location.href = "admin.php?page=avartanslider";
            }
        });
    }
}