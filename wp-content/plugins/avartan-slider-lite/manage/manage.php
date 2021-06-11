<?php
if (!defined('ABSPATH'))
    exit();

class avsLiteAdmin {

    public static $avs_allowed_pages = '';
    public static $avs_enqueue_file = '';
    public static $avs_current_page = '';
    public static $avs_allowed_button_pages = '';
    public static $avs_add_button = '';
    public static $view = 'home';
    public static $id = '';
    public static $edit = false;

    public function __construct() {
        $this->avsGetCurrentPage();
        $this->avsEnqueueFile();
        $this->avsAddButton();
        $this->avsCheckView();
        $this->avsCheckId();
        add_action('admin_enqueue_scripts', array('avsLiteAdmin', 'avsLiteAdminEnqueues'), 20);
        add_filter('current_screen', array('avsLiteAdmin', 'avsRemoveFooterAdmin'));
        add_filter('media_buttons_context', array('avsLiteAdmin', 'avsInsertButton'), 10);
        add_action('admin_footer', array('avsLiteAdmin', 'avsLiteAdminFooterAvartan'), 10);
        add_action('admin_footer', 'avsLiteAdmin::avsUpgradeToProBox');
        add_action('admin_menu', array('avsLiteAdmin', 'avsAddMenu'), 10);
        add_action('wp_ajax_avartanslider_ajax_action', array('avsLiteAdmin', 'avsAjaxCallAction'));
        add_action('wp_ajax_avl_sbtDeactivationform', array('avsLiteAdmin', 'avsSbtDeactivationform'));
        add_action('admin_head', 'avsLiteAdmin::avsSubscribeMail');
        add_action('wp_ajax_avl_submit_optin','avsLiteAdmin::avsLiteSubmitOptin');
    }
    
    /**
     *  submit optin
     *
     * @since 1.3.1
     */
    public static function avsLiteSubmitOptin() {
        global $wpdb, $wp_version;
        $avl_submit_type = '';
        if(isset($_POST['email'])) {
            $avl_email = sanitize_email($_POST['email']);
        }
        else {
            $avl_email = get_option('admin_url');
        }
        if(isset($_POST['type'])) {
            $avl_submit_type = sanitize_text_field($_POST['type']);
        }
        if($avl_submit_type == 'submit') {
            $status_type = get_option('avl_is_optin');
            $theme_details = array();
            if ( $wp_version >= 3.4 ) {
                $active_theme                   = wp_get_theme();
                $theme_details['theme_name']    = strip_tags( $active_theme->name );
                $theme_details['theme_version'] = strip_tags( $active_theme->version );
                $theme_details['author_url']    = strip_tags( $active_theme->{'Author URI'} );
            }
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if (is_multisite()) {
                $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
            }
            $plugins = array();
            if (count($active_plugins) > 0) {
                $get_plugins = array();
                foreach ($active_plugins as $plugin) {
                    $plugin_data = @get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);

                    $get_plugins['plugin_name'] = strip_tags($plugin_data['Name']);
                    $get_plugins['plugin_author'] = strip_tags($plugin_data['Author']);
                    $get_plugins['plugin_version'] = strip_tags($plugin_data['Version']);
                    array_push($plugins, $get_plugins);
                }
            }

            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/avartan-slider-lite/avartanslider.php', $markup = true, $translate = true);
            $current_version = $plugin_data['Version'];

            $plugin_data = array();
            $plugin_data['plugin_name'] = 'Avartan Slider';
            $plugin_data['plugin_slug'] = 'avartan-slider-lite';
            $plugin_data['plugin_version'] = $current_version;
            $plugin_data['plugin_status'] = $status_type;
            $plugin_data['site_url'] = home_url();
            $plugin_data['site_language'] = defined( 'WPLANG' ) && WPLANG ? WPLANG : get_locale();
            $current_user = wp_get_current_user();
            $f_name = $current_user->user_firstname;
            $l_name = $current_user->user_lastname;
            $plugin_data['site_user_name'] = esc_attr( $f_name ).' '.esc_attr( $l_name );
            $plugin_data['site_email'] = false !== $avl_email ? $avl_email : get_option( 'admin_email' );
            $plugin_data['site_wordpress_version'] = $wp_version;
            $plugin_data['site_php_version'] = esc_attr( phpversion() );
            $plugin_data['site_mysql_version'] = $wpdb->db_version();
            $plugin_data['site_max_input_vars'] = ini_get( 'max_input_vars' );
            $plugin_data['site_php_memory_limit'] = ini_get( 'max_input_vars' );
            $plugin_data['site_operating_system'] = ini_get( 'memory_limit' ) ? ini_get( 'memory_limit' ) : 'N/A';
            $plugin_data['site_extensions']       = get_loaded_extensions();
            $plugin_data['site_activated_plugins'] = $plugins;
            $plugin_data['site_activated_theme'] = $theme_details;
            $url = 'http://analytics.solwininfotech.com/';
            $response = wp_safe_remote_post(
                $url, array(
                    'method'      => 'POST',
                    'timeout'     => 45,
                    'redirection' => 5,
                    'httpversion' => '1.0',
                    'blocking'    => true,
                    'headers'     => array(),
                    'body'        => array(
                        'data'    => maybe_serialize( $plugin_data ),
                        'action'  => 'plugin_analysis_data',
                    ),
                )
            );
            update_option( 'avl_is_optin', 'yes' );
        }
        elseif($avl_submit_type == 'cancel') {
            update_option( 'avl_is_optin', 'no' );
        }
        elseif($avl_submit_type == 'deactivate') {
            $status_type = get_option('avl_is_optin');
            $theme_details = array();
            if ( $wp_version >= 3.4 ) {
                $active_theme                   = wp_get_theme();
                $theme_details['theme_name']    = strip_tags( $active_theme->name );
                $theme_details['theme_version'] = strip_tags( $active_theme->version );
                $theme_details['author_url']    = strip_tags( $active_theme->{'Author URI'} );
            }
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if (is_multisite()) {
                $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
            }
            $plugins = array();
            if (count($active_plugins) > 0) {
                $get_plugins = array();
                foreach ($active_plugins as $plugin) {
                    $plugin_data = @get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
                    $get_plugins['plugin_name'] = strip_tags($plugin_data['Name']);
                    $get_plugins['plugin_author'] = strip_tags($plugin_data['Author']);
                    $get_plugins['plugin_version'] = strip_tags($plugin_data['Version']);
                    array_push($plugins, $get_plugins);
                }
            }

            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/avartan-slider-lite/avartanslider.php', $markup = true, $translate = true);
            $current_version = $plugin_data['Version'];

            $plugin_data = array();
            $plugin_data['plugin_name'] = 'Avartan Slider';
            $plugin_data['plugin_slug'] = 'avartan-slider-lite';
            $reason_id = sanitize_text_field($_POST['selected_option_de']);
            $plugin_data['deactivation_option'] = $reason_id;
            $plugin_data['deactivation_option_text'] = sanitize_text_field($_POST['selected_option_de_text']);
            if ($reason_id == 10) {
                $plugin_data['deactivation_option_text'] = sanitize_text_field($_POST['selected_option_de_other']);
            }
            $plugin_data['plugin_version'] = $current_version;
            $plugin_data['plugin_status'] = $status_type;
            $plugin_data['site_url'] = home_url();
            $plugin_data['site_language'] = defined( 'WPLANG' ) && WPLANG ? WPLANG : get_locale();
            $current_user = wp_get_current_user();
            $f_name = $current_user->user_firstname;
            $l_name = $current_user->user_lastname;
            $plugin_data['site_user_name'] = esc_attr( $f_name ).' '.esc_attr( $l_name );
            $plugin_data['site_email'] = false !== $avl_email ? $avl_email : get_option( 'admin_email' );
            $plugin_data['site_wordpress_version'] = $wp_version;
            $plugin_data['site_php_version'] = esc_attr( phpversion() );
            $plugin_data['site_mysql_version'] = $wpdb->db_version();
            $plugin_data['site_max_input_vars'] = ini_get( 'max_input_vars' );
            $plugin_data['site_php_memory_limit'] = ini_get( 'max_input_vars' );
            $plugin_data['site_operating_system'] = ini_get( 'memory_limit' ) ? ini_get( 'memory_limit' ) : 'N/A';
            $plugin_data['site_extensions']       = get_loaded_extensions();
            $plugin_data['site_activated_plugins'] = $plugins;
            $plugin_data['site_activated_theme'] = $theme_details;
            $url = 'http://analytics.solwininfotech.com/';
            $response = wp_safe_remote_post(
                $url, array(
                    'method'      => 'POST',
                    'timeout'     => 45,
                    'redirection' => 5,
                    'httpversion' => '1.0',
                    'blocking'    => true,
                    'headers'     => array(),
                    'body'        => array(
                        'data'    => maybe_serialize( $plugin_data ),
                        'action'  => 'plugin_analysis_data_deactivate',
                    ),
                )
            );
            update_option( 'avl_is_optin', '' );
        }
        exit();
    }

    /**
     *  Check current page view
     *
     * @since 1.3
     */
    public static function avsCheckView() {
        if (isset($_GET['view']) && $_GET['view'] != '' && isset($_GET['asview-nouce']) && $_GET['asview-nouce'] != '') {
            self::$view = esc_attr($_GET['view']);
        }
    }

    /**
     *  send mail on subscribe
     *
     * @since 1.3
     */
    public static function avsSubscribeMail() {
        ?>
        <div id="sol_deactivation_widget_cover_avl" style="display:none;">
            <div class="sol_deactivation_widget">
                <h3><?php _e('If you have a moment, please let us know why you are deactivating.', 'avartan-slider-lite'); ?></h3>
                <form id="frmDeactivationavl" name="frmDeactivation" method="post" action="">
                    <ul class="sol_deactivation_reasons_ul">
        <?php $i = 1; ?>
                        <li>
                            <input class="sol_deactivation_reasons" checked name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('I am going to upgrade to PRO version', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('The plugin suddenly stopped working', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('The plugin was not working', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('I have configured plugin but not working with my theme', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('Installed & configured well but disturbed my theme', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e("I have other slider which are better than your plugin", 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('The plugin broke my site completely', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('Install plugin for review purpose', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('No any reason', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('Other', 'avartan-slider-lite'); ?></label><br/>
                            <input style="display:none;width: 90%" value="" type="text" name="sol_deactivation_reason_other_avl" class="sol_deactivation_reason_other_avl" />
                        </li>
                    </ul>
                     <p>
                        <input type='checkbox' class='avl_agree' id='avl_agree_gdpr_deactivate' value='1' />
                        <label for='avl_agree_gdpr_deactivate' class='avl_agree_gdpr_lbl'><?php echo esc_attr(__('By clicking this button, you agree with the storage and handling of your data as mentioned above by this website. (GDPR Compliance)', 'avartan-slider-lite')); ?></label>
                    </p>
                    <a onclick='avl_submit_optin("deactivate")' class="button button-secondary"><?php _e('Submit', 'avartan-slider-lite'); echo ' &amp; '; _e('Deactivate', 'avartan-slider-lite'); ?></a>
                    <input type="submit" name="sbtDeactivationFormClose" id="sbtDeactivationFormCloseavl" class="button button-primary" value="<?php _e('Cancel', 'avartan-slider-lite'); ?>" />
                    <a href="javascript:void(0)" class="avl-deactivation" aria-label="<?php _e('Deactivate Avartan Slider','avartan-slider-lite'); ?>"><?php _e('Skip', 'avartan-slider-lite'); echo ' &amp; '; _e('Deactivate', 'avartan-slider-lite'); ?></a>
                </form>
                <div class="support-ticket-section">
                    <h3><?php _e('Would you like to give us a chance to help you?', 'avartan-slider-lite'); ?></h3>
                    <img src="<?php echo AVARTAN_LITE_PLUGIN_URL . '/manage/assets/images/support-ticket.png'; ?>">
                    <a href="<?php echo esc_url('http://support.solwininfotech.com/')?>"><?php _e('Create a support ticket', 'avartan-slider-lite'); ?></a>
                </div>
            </div>
        </div>
        <a style="display:none" href="#TB_inline?height=500&inlineId=sol_deactivation_widget_cover_avl" class="thickbox" id="deactivation_thickbox_avl"></a>
        <?php
    }

    /**
     * Check current page mode Add/Edit
     *
     * @since 1.3
     */
    public static function avsCheckId() {
        if (isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['asview-nouce']) && $_GET['asview-nouce'] != '') {
            self::$id = esc_attr($_GET['id']);
            self::$edit = true;
        }
    }

    /**
     * Add capability
     *
     * @since 1.3
     */
    public static function avsGetCapability() {
        $manage_options_cap = apply_filters('avs_manage_options_capability', 'manage_options');
        return $manage_options_cap;
    }

    /**
     * Add menus
     *
     * @since 1.3
     */
    public static function avsAddMenu() {
        $role = get_role('administrator');
        $role->add_cap('avartan_slider_access');
        $avs_cap = self::avsGetCapability();
        $avl_is_optin = get_option('avl_is_optin');
        if($avl_is_optin == 'yes' || $avl_is_optin == 'no') {
            add_menu_page(__('Avartan Slider', 'avartan-slider-lite'), __('Avartan Slider', 'avartan-slider-lite'), $avs_cap, 'avartanslider', 'avsLiteAdmin::avsDisplayPage', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/images/avartan.png');
        }
        else {
            add_menu_page(__('Avartan Slider', 'avartan-slider-lite'), __('Avartan Slider', 'avartan-slider-lite'), $avs_cap, 'avartanslider_welcome', 'avsLiteAdmin::avsDisplayWelcomePage', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/images/avartan.png');
        }        
        add_submenu_page('avartanslider', __('Create New Slider', 'avartan-slider-lite'), __('Create New Slider', 'avartan-slider-lite'), 'manage_options', 'avs_standard_slider', 'avsLiteAdmin::avsStandardSlider');
        add_submenu_page('avartanslider', __('Upgrade to PRO', 'avartan-slider-lite'), __('Upgrade to PRO', 'avartan-slider-lite'), 'manage_options', 'avs_upgrade_to_pro', 'avsLiteAdmin::avsUpgradeToPro');
    }

    /**
     * Create Slider
     *
     * @since 1.3
     */
    public static function avsStandardSlider() {
        global $wpdb;
        ?>
        <div class="wrap as-admin">
            <div class="as-slider-wrapper">
                <noscript class="as-no-js">
                <div class="as-message as-message-error" style="display: block;"><?php _e('JavaScript must be enabled to view this page correctly.', 'avartan-slider-lite'); ?></div>
                </noscript>
                <h1 class="as-logo" title="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>">
                    <a href="?page=avartanslider" title="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>">
                        <img src="<?php echo AVARTAN_LITE_PLUGIN_URL . '/manage/assets/images/logo.png' ?>" alt="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>" />
                    </a>
                </h1>
                <div class="as-plugin-asides">

                    <div class="as-plugin-aside pro_extentions">
                        <h3><?php _e('Avartan Slider Pro Features', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li><?php _e('7 Type of Element Support', 'avartan-slider-lite'); ?></li>
                            <li><?php _e('One click Import/Export Slider/Single Slide', 'avartan-slider-lite'); ?></li>
                            <li><?php _e('Duplicate Slide/Slides', 'avartan-slider-lite'); ?></li>
                            <li>
                                <a href="https://avartanslider.com/wordpress/features/" target="_blank"><?php _e('and much more!', 'avartan-slider-lite'); ?></a>
                            </li>
                        </ul>
                        <p><a href="https://codecanyon.net/item/avartan-slider-responsive-wordpress-slider-plugin/19973800?ref=solwin" target="_blank" class="as-plugin-buy-now"><?php _e('Upgrade to PRO!', 'avartan-slider-lite'); ?></a></p>
                    </div>

                    <div class="as-plugin-aside get_help">
                        <h3><?php _e('Get Help', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li>
                                <a href="http://avartanslider.com/demo" target="_blank"><?php _e('View Live Demo', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/wordpress-documentation/" target="_blank"><?php _e('Read the documentation', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="http://support.solwininfotech.com/" target="_blank"><?php _e('24/7 Free Support', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/pro-vs-lite/" target="_blank"><?php _e('Lite & Pro Comparison', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/faq/" target="_blank"><?php _e('FAQ', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <?php _e('Facing any issue?', 'avartan-slider-lite'); ?>&nbsp;<a href="https://avartanslider.com/contact-us/" target="_blank"><u><?php _e('Contact Us', 'avartan-slider-lite'); ?></u></a>
                            </li>
                        </ul>
                    </div>

                    <div class="as-plugin-aside pull-right support_themes">
                        <h3><?php _e('Looking for an Avartan themes?', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li><a href="http://demo.solwininfotech.com/wordpress/foodfork/" target="_blank"><?php _e('FoodFork', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/realestaty/" target="_blank"><?php _e('RealEstaty', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/veriyas-pro/" target="_blank"><?php _e('Veriyas PRO', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/myappix/" target="_blank"><?php _e('MyAppix', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/biznetic/" target="_blank"><?php _e('Biznetic', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/jewelux/" target="_blank"><?php _e('JewelUX', 'avartan-slider-lite'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="as-wrapper">
                    <?php
                    require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                    $sliders_obj = new avsLiteSlider();
                    $sliders = $sliders_obj->getAllSlider();
                    require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/preset.php';
                    require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/views/slider.php';
                    ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>

            <!-- Loader Section -->
            <div class="as-admin-preloader"></div>
        </div>
        <?php
    }


    /**
     * for upgrade to pro
     *
     * @since 1.3
     */
    public static function avsUpgradeToPro() {
        include_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/upgrade-to-pro.php';
    }

    /**
     *  Display main page of avartan
     *
     * @since 1.3
     */
    public static function avsDisplayPage() {
        global $wpdb;
        ?>
        <div class="wrap as-admin">
            <div class="as-slider-wrapper">
                <noscript class="as-no-js">
                <div class="as-message as-message-error" style="display: block;"><?php _e('JavaScript must be enabled to view this page correctly.', 'avartan-slider-lite'); ?></div>
                </noscript>
                <h1 class="as-logo" title="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>">
                    <a href="?page=avartanslider" title="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>">
                        <img src="<?php echo AVARTAN_LITE_PLUGIN_URL . '/manage/assets/images/logo.png' ?>" alt="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>" />
                    </a>
                </h1>
                <div class="as-plugin-asides">

                    <div class="as-plugin-aside pro_extentions">
                        <h3><?php _e('Avartan Slider Pro Features', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li><?php _e('7 Type of Element Support', 'avartan-slider-lite'); ?></li>
                            <li><?php _e('One click Import/Export Slider/Single Slide', 'avartan-slider-lite'); ?></li>
                            <li><?php _e('Duplicate Slide/Slides', 'avartan-slider-lite'); ?></li>
                            <li>
                                <a href="https://avartanslider.com/wordpress/features/" target="_blank"><?php _e('and much more!', 'avartan-slider-lite'); ?></a>
                            </li>
                        </ul>
                        <p><a href="https://codecanyon.net/item/avartan-slider-responsive-wordpress-slider-plugin/19973800?ref=solwin" target="_blank" class="as-plugin-buy-now"><?php _e('Upgrade to PRO!', 'avartan-slider-lite'); ?></a></p>
                    </div>

                    <div class="as-plugin-aside get_help">
                        <h3><?php _e('Get Help', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li>
                                <a href="http://avartanslider.com/demo" target="_blank"><?php _e('View Live Demo', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/wordpress-documentation/" target="_blank"><?php _e('Read the documentation', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="http://support.solwininfotech.com/" target="_blank"><?php _e('24/7 Free Support', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/pro-vs-lite/" target="_blank"><?php _e('Lite & Pro Comparison', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/faq/" target="_blank"><?php _e('FAQ', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <?php _e('Facing any issue?', 'avartan-slider-lite'); ?>&nbsp;<a href="https://avartanslider.com/contact-us/" target="_blank"><u><?php _e('Contact Us', 'avartan-slider-lite'); ?></u></a>
                            </li>
                        </ul>
                    </div>

                    <div class="as-plugin-aside pull-right support_themes">
                        <h3><?php _e('Looking for an Avartan themes?', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li><a href="http://demo.solwininfotech.com/wordpress/foodfork/" target="_blank"><?php _e('FoodFork', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/realestaty/" target="_blank"><?php _e('RealEstaty', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/veriyas-pro/" target="_blank"><?php _e('Veriyas PRO', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/myappix/" target="_blank"><?php _e('MyAppix', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/biznetic/" target="_blank"><?php _e('Biznetic', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/jewelux/" target="_blank"><?php _e('JewelUX', 'avartan-slider-lite'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="as-wrapper">
                    <?php
                    //Choose the page for display based on call
                    switch (self::$view) {
                        case 'home':
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                            $sliders_obj = new avsLiteSlider();
                            $sliders = $sliders_obj->getAllSlider();
                            $default_template = $sliders_obj->defaultTemplateArray();
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/views/home.php';
                            break;
                        case 'slider':
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                            $sliders_obj = new avsLiteSlider();
                            $sliders = $sliders_obj->getAllSlider();
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/preset.php';
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/views/slider.php';
                            break;
                        case 'slide':
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                            $sliders_obj = new avsLiteSlider();
                            $sliders = $sliders_obj->getAllSlider();
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slide.php';
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/preset.php';
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/views/slide.php';

                            break;
                    }
                    ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>

            <!-- Loader Section -->
            <div class="as-admin-preloader"></div>
        </div>
        <?php
    }
    
    /**
     *  Display welcome page of avartan
     *
     * @since 1.3
     */
    public static function avsDisplayWelcomePage() {
        global $wpdb;
        $avl_admin_email = get_option('admin_email');
        ?>
        <div class='avl_header_wizard'>
            <p><?php echo esc_attr(__('Hi there!', 'avartan-slider-lite')); ?></p>
            <p><?php echo esc_attr(__("Don't ever miss an opportunity to opt in for Email Notifications / Announcements about exciting New Features and Update Releases.", 'avartan-slider-lite')); ?></p>
            <p><?php echo esc_attr(__('Contribute in helping us making our plugin compatible with most plugins and themes by allowing to share non-sensitive information about your website.', 'avartan-slider-lite')); ?></p>
            <p><b><?php echo esc_attr(__('Email Address for Notifications', 'avartan-slider-lite')); ?> :</b></p>
            <p><input type='email' value='<?php echo $avl_admin_email; ?>' id='avl_admin_email' /></p>
            <p><?php echo esc_attr(__("If you're not ready to Opt-In, that's ok too!", 'avartan-slider-lite')); ?></p>
            <p><b><?php echo esc_attr(__('Avartan Slider will still work fine.', 'avartan-slider-lite')); ?> :</b></p>
            <p onclick="avl_show_hide_permission()" class='avl_permission'><b><?php echo esc_attr(__('What permissions are being granted?', 'avartan-slider-lite')); ?></b></p>
            <div class='avl_permission_cover' style='display:none'>
                <div class='avl_permission_row'>
                    <div class='avl_50'>
                        <i class='dashicons dashicons-admin-users gb-dashicons-admin-users'></i>
                        <div class='avl_50_inner'>
                            <label><?php echo esc_attr(__('User Details', 'avartan-slider-lite')); ?></label>
                            <label><?php echo esc_attr(__('Name and Email Address', 'avartan-slider-lite')); ?></label>
                        </div>
                    </div>
                    <div class='avl_50'>
                        <i class='dashicons dashicons-admin-plugins gb-dashicons-admin-plugins'></i>
                        <div class='avl_50_inner'>
                            <label><?php echo esc_attr(__('Current Plugin Status', 'avartan-slider-lite')); ?></label>
                            <label><?php echo esc_attr(__('Activation, Deactivation and Uninstall', 'avartan-slider-lite')); ?></label>
                        </div>
                    </div>
                </div>
                <div class='avl_permission_row'>
                    <div class='avl_50'>
                        <i class='dashicons dashicons-testimonial gb-dashicons-testimonial'></i>
                        <div class='avl_50_inner'>
                            <label><?php echo esc_attr(__('Notifications', 'avartan-slider-lite')); ?></label>
                            <label><?php echo esc_attr(__('Updates & Announcements', 'avartan-slider-lite')); ?></label>
                        </div>
                    </div>
                    <div class='avl_50'>
                        <i class='dashicons dashicons-welcome-view-site gb-dashicons-welcome-view-site'></i>
                        <div class='avl_50_inner'>
                            <label><?php echo esc_attr(__('Website Overview', 'avartan-slider-lite')); ?></label>
                            <label><?php echo esc_attr(__('Site URL, WP Version, PHP Info, Plugins & Themes Info', 'avartan-slider-lite')); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <p>
                <input type='checkbox' class='avl_agree' id='avl_agree_gdpr' value='1' />
                <label for='avl_agree_gdpr' class='avl_agree_gdpr_lbl'><?php echo esc_attr(__('By clicking this button, you agree with the storage and handling of your data as mentioned above by this website. (GDPR Compliance)', 'avartan-slider-lite')); ?></label>
            </p>
            <p class='avl_buttons'>
                <a href="javascript:void(0)" class='button button-secondary' onclick="avl_submit_optin('cancel')"><?php echo esc_attr(__('Skip', 'avartan-slider-lite')); echo ' &amp; '; echo esc_attr(__('Continue', 'avartan-slider-lite')); ?></a>
                <a href="javascript:void(0)" class='button button-primary' onclick="avl_submit_optin('submit')"><?php echo esc_attr(__('Opt-In', 'avartan-slider-lite')); echo ' &amp; '; echo esc_attr(__('Continue', 'avartan-slider-lite')); ?></a>
            </p>
        </div>
        <?php
    }

    /**
     * Enqueue admin panel js and css
     *
     * @since 1.3
     */
    public static function avsLiteAdminEnqueues($hook_suffix) {

        wp_enqueue_style('avs-dashboard-css', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/dashboard.css');
        if (self::$avs_enqueue_file == 'yes' || $hook_suffix == 'plugins.php') {
            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slide.php';
            ?>
            <script type="text/javascript">
                var avartanslider_is_wordpress_admin = true;
            </script>
            <?php
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_style('avs-manage-styles', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/manage.css');
            wp_enqueue_style('avs-manage-tools', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/manage-tools.min.css');
            wp_dequeue_style('woocommerce_admin_styles');
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_script('jquery');
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_script('jquery-ui-draggable');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_media();

            wp_enqueue_script('avs-manage-tools', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/js/manage-tools.min.js', array('wp-color-picker'));
            $colorpicker_l10n = array('clear' => __('Clear', 'avartan-slider-lite'), 'defaultString' => __('Default', 'avartan-slider-lite'), 'pick' => __('Select Color', 'avartan-slider-lite'));
            wp_localize_script('avs-manage-tools', 'wpColorPickerL10n', $colorpicker_l10n);
            wp_dequeue_script('woocommerce_settings');
            wp_register_script('avs-manage', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/js/manage.js', array('jquery-ui-tabs', 'jquery-ui-sortable', 'jquery-ui-draggable', 'wp-color-picker', 'jquery-ui-dialog','avs-manage-tools'));
            self::avsLocalization();

            wp_enqueue_script('avs-min-js', AVARTAN_LITE_PLUGIN_URL . '/views/assets/js/avartanslider.min.js', array('jquery'));
            $loader = new avsLiteSlider();
            $getSliderSettingAry = $loader->getSliderSettingAry();
            $loader_array = $getSliderSettingAry['loaders'];
            wp_localize_script('avs-min-js', 'avs_loader_array', $loader_array);
            wp_enqueue_style('avs-avartan', AVARTAN_LITE_PLUGIN_URL . '/views/assets/css/avartanslider.min.css');
            wp_enqueue_style('avs-basic-tools-css', AVARTAN_LITE_PLUGIN_URL . '/views/assets/css/basic-tools-min.css');

            wp_enqueue_script('avs-manage');

            //code for subscribe popup
            $plugin_data = get_plugin_data(AVARTAN_LITE_PLUGIN_DIR . '/avartanslider.php', $markup = true, $translate = true);
            $current_version = $plugin_data['Version'];
            $old_version = get_option('avl_version');
            if ($old_version != $current_version) {
                update_option('is_user_subscribed_cancled', '');
                update_option('avl_version', $current_version);
            }
            if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes') {
                wp_enqueue_script('thickbox');
                wp_enqueue_style('thickbox');
            }
        }
    }

    /**
     * Get current page
     *
     * @since 1.3
     */
    public static function avsGetCurrentPage() {
        if (isset($_GET['page']) && $_GET['page'] != '') {
            $trimed_page = esc_attr($_GET['page']);
            if (!empty($trimed_page)) {
                self::$avs_current_page = esc_attr($_GET['page']);
            }
        }
    }

    /**
     * Provide pages where css and js include
     *
     * @since 1.3
     */
    public static function avsEnqueueFile() {
        self::$avs_allowed_pages = apply_filters('avs_allowed_pages', array('avartanslider','avs_upgrade_to_pro', 'avs_standard_slider','avartanslider_welcome'));
        if (in_array(self::$avs_current_page, self::$avs_allowed_pages)) {
            self::$avs_enqueue_file = 'yes';
        }
    }

    /**
     * add button for allowed pages
     *
     * @since 1.3
     */
    public static function avsAddButton() {
        self::$avs_allowed_pages = apply_filters('avs_allowed_pages', array('avartanslider','avs_upgrade_to_pro', 'avs_standard_slider'));
        if (in_array(self::$avs_current_page, self::$avs_allowed_pages)) {
            self::$avs_enqueue_file = 'yes';
        }
    }

    /**
     * Remove extra footer strip and add only avartan footer
     *
     * @since 1.3
     */
    public static function avsRemoveFooterAdmin() {
        if (in_array(self::$avs_current_page, self::$avs_allowed_pages)) {
            add_filter('admin_footer_text', array('avsLiteAdmin', 'avsAddFooterText'));
        }
    }

    /**
     * Add review text for footer strip
     *
     * @since 1.3
     */
    public static function avsAddFooterText() {
        ob_start();
        ?>
        <p id="footer-left" class="alignleft">
            <?php _e('If you like ', 'avartan-slider-lite') ?>
            <a href="https://wordpress.org/plugins/avartan-slider-lite/" target="_blank"><strong><?php _e('Avartan Slider', 'avartan-slider-lite') ?></strong> </a>
            <?php _e('plugin. please leave us a', 'avartan-slider-lite') ?>
            <a class="as-review-link" data-rated="Thanks :)" target="_blank" href="https://wordpress.org/support/plugin/avartan-slider-lite/reviews?filter=5#new-post">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;</a>
            <?php _e('rating. A heartly thank you from Solwin Infotech in advance!', 'avartan-slider-lite') ?>
        </p>
        <?php
        return ob_get_clean();
    }

    /**
     * Insert button in post and page editor
     *
     * @since 1.3
     */
    public static function avsInsertButton($context) {
        global $pagenow;
        if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
            $context .= '<a href="#TB_inline?width=500&height=100&inlineId=choose-avartan-slider" class="thickbox button" title="' .
                    __("Select Avartan Slider to insert into post/page", 'avartan-slider-lite') .
                    '"><span class="wp-media-buttons-icon" style="background: url(' . AVARTAN_LITE_PLUGIN_URL .
                    '/manage/assets/images/avartan.png); background-repeat: no-repeat; background-position: left bottom;"></span> ' .
                    __("Add Avartan Slider", 'avartan-slider-lite') . '</a>';
        }

        return $context;
    }

    /**
     * Click js for avartan button on page and post
     *
     * @since 1.3
     */
    public static function avsLiteAdminFooterAvartan() {

        global $pagenow;

        // Only run in post/page creation and edit screens
        if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
            global $wpdb;
            //Get the slider information
            $sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders');
            ?>

            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('#insertAvartanSlider').on('click', function () {
                        var id = jQuery('#avartanslider-select option:selected').val();
                        window.send_to_editor('[avartanslider alias="' + id + '"]');
                        tb_remove();
                    });
                });
            </script>

            <div id="choose-avartan-slider" style="display: none;">
                <div class="wrap as-avartan-admin">
                    <?php
                    if (count($sliders)) {
                        echo "<h3 style='margin-bottom: 20px;'>" . __("Insert Avartan Slider", 'avartan-slider-lite') . "</h3>";
                        echo "<select id='avartanslider-select'>";
                        echo "<option disabled=disabled>" . __("Choose Avartan Slider", 'avartan-slider-lite') . "</option>";
                        foreach ($sliders as $slider) {
                            echo "<option value='{$slider->alias}'> {$slider->name} </option>";
                        }
                        echo "</select>";
                        echo "<button class='button primary' id='insertAvartanSlider'>" . __("Insert Avartan Slider", 'avartan-slider-lite') . "</button>";
                    } else {
                        _e("No Sliders Found", 'avartan-slider-lite');
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }

    /**
     * Display popup when click on pro features
     *
     * @since 1.3
     */
    public static function avsUpgradeToProBox(){
        ?>
        <div id="as_upgrade_to_pro_dialog" style="display: none">
            <img src="<?php echo AVARTAN_LITE_PLUGIN_URL; ?>/manage/assets/images/avs-upgrade-to-pro.png" alt="<?php _e('Upgrade to PRO!','avartan-slider-lite'); ?>"/>
            <div class="as-btn-wrap">
                <a class="upgrade" href="https://codecanyon.net/item/avartan-slider-responsive-wordpress-slider-plugin/19973800?ref=solwin" target="_blank"><?php _e('UPGRADE TO PRO','avartan-slider-lite'); ?></a>
                <a class="live-demo" href="https://avartanslider.com/" target="_blank"><?php _e('LIVE DEMO','avartan-slider-lite'); ?></a>
            </div>
        </div><?php
    }

    /**
     * Set localization which will be used in js file
     *
     * @since 1.3
     */
    public static function avsLocalization() {
        $nonce = wp_create_nonce("avs_nonce");
        // Here the translations for the admin.js file
        $avartanslider_translations = array(
            'slide' => __('Slide', 'avartan-slider-lite'),
            'show_hide_ele_title' => __('Show/Hide Element', 'avartan-slider-lite'),
            'text_element_default_video' => __('Video Element', 'avartan-slider-lite'),
            'text_element_default_image' => __('Image Element', 'avartan-slider-lite'),
            'slider_name' => __('Slider name can not be empty.', 'avartan-slider-lite'),
            'slider_generate' => __('Slider has been generated successfully.', 'avartan-slider-lite'),
            'slider_save' => __('Slider has been saved successfully.', 'avartan-slider-lite'),
            'slider_error' => __('Something went wrong during save slider!', 'avartan-slider-lite'),
            'slider_error_delete' => __('Something went wrong during delete slider', 'avartan-slider-lite'),
            'slider_already_find' => __('Some other slider with alias', 'avartan-slider-lite'),
            'slider_exists' => __('already exists.', 'avartan-slider-lite'),
            'slider_delete' => __('Slider has been deleted successfully.', 'avartan-slider-lite'),
            'slider_delete_error' => __('Something went wrong during delete slider!', 'avartan-slider-lite'),
            'slide_save' => __('Slide has been saved successfully.', 'avartan-slider-lite'),
            'slide_error' => __('Something went wrong during save slide!', 'avartan-slider-lite'),
            'slide_delete' => __('Slide has been deleted successfully.', 'avartan-slider-lite'),
            'slide_delete_error' => __('Something went wrong during delete slide!', 'avartan-slider-lite'),
            'slide_update_position_error' => __('Something went wrong during update slides position!', 'avartan-slider-lite'),
            'slide_delete_confirm' => __('The slide will be deleted. Are you sure?', 'avartan-slider-lite'),
            'slide_delete_just_one' => __('You can not delete this. You must have at least one slide.', 'avartan-slider-lite'),
            'slider_delete_confirm' => __('The slider will be deleted. Are you sure?', 'avartan-slider-lite'),
            'text_element_default_html' => __('Text Element', 'avartan-slider-lite'),
            'element_no_found_txt' => __('No element found.', 'avartan-slider-lite'),
            'youtube_video_title' => __('YouTube Video', 'avartan-slider-lite'),
            'video_not_found' => __('Video does not exists.', 'avartan-slider-lite'),
            'html5_video_title' => __('HTML5 Video', 'avartan-slider-lite'),
            'something_went_wrong_error' => __('Something went wrong.', 'avartan-slider-lite'),
            'ele_del_confirm' => __('Element will be deleted. Are you sure?', 'avartan-slider-lite'),
            'video_bg_poster' => __('You must have to set video poster image.', 'avartan-slider-lite'),
            'default_nonce' => $nonce,
            'AvartanPluginUrl' => plugins_url(__FILE__),
            'copied' => __('Copied', 'avartan-slider-lite'),
            'copy_for_support' => __('Copy for Support', 'avartan-slider-lite'),
            'delete_slider' => __('Delete Slider', 'avartan-slider-lite'),
            'slide_preset_confirm' => __('Your data will be reset. Are you sure ?', 'avartan-slider-lite'),
            'slide_preset' => __('Slide has been preset successfully.', 'avartan-slider-lite'),
            'slide_preset_error' => __('Something went wrong during preset slide!', 'avartan-slider-lite'),
            'cancel' => __('Cancel', 'avartan-slider-lite'),
            'please_select_slider' => __('Please select slider.', 'avartan-slider-lite'),
            'close' => __('Close', 'avartan-slider-lite'),
            'ok' => __('Ok', 'avartan-slider-lite'),
            'delete_slide' => __('Delete Slide', 'avartan-slider-lite'),
            'remove' => __('Remove', 'avartan-slider-lite'),
            'font_family' => __('Font Family', 'avartan-slider-lite'),
            'html5_video' => __('HTML5 Video', 'avartan-slider-lite'),
            'upload_image' => __('Upload Image', 'avartan-slider-lite'),
            'leave_not_saved' => __('By leaving now, all changes since the last saving will be lost. Really leave now?', 'avartan-slider-lite'),
            'continue' => __('Continue', 'avartan-slider-lite'),
            'create_slider' => __('Create Slider', 'avartan-slider-lite'),
            'admin_url' => get_admin_url(),
            'current_version' => avsLiteFront::avsPluginGetVersion(),
            'must_be_mp4' => __('Extension of video must be mp4.', 'avartan-slider-lite'),
            'must_be_webm' => __('Extension of video must be webm.', 'avartan-slider-lite'),
            'must_be_ogv' => __('Extension of video must be ogv.', 'avartan-slider-lite'),
        );
        wp_localize_script('avs-manage', 'avs_translations', $avartanslider_translations);
        $default_element_value = array(
            'layer_value' => array(
                'font_size' => 18,
                'line_height' => 27,
                'font_color' => '#000000',
                'background_color' => '',
                'x_position' => 100,
                'y_position' => 100,
                'width' => 'auto',
                'height' => 'auto',
                'animation_delay' => 300,
                'animation_time' => 0,
                'animation_in' => 'fade',
                'animation_out' => 'fade',
                'animation_startspeed' => 300,
                'animation_endspeed' => 300,
                'attribute_title' => '',
                'attribute_alt' => '',
                'attribute_id' => '',
                'attribute_class' => '',
                'attribute_rel' => '',
                'attribute_link_type' => 'nolink',
                'attribute_link_url' => '',
                'attribute_link_target' => 'new_tab',
                'advance_style' => '',
                'text' => '',
                'type' => '',
                'image_src' => '',
                'video_type' => 'youtube',
                'video_id' => '',
                'youtube_url' => '',
                'vimeo_url' => '',
                'html5_mp4_url' => '',
                'html5_webm_url' => '',
                'html5_ogv_url' => '',
                'video_fullscreen' => 0,
                'editor_video_image' => '',
                'current_version' => AvsLiteFront::avsPluginGetVersion(),
                'z_index' => 1
            )
        );
        wp_localize_script('avs-manage', 'avs_default_layer_value', $default_element_value);

        //Default Colors
        $colors = array(
            'colors' => array(
                "aliceblue" => "#f0f8ff",
                "antiquewhite" => "#faebd7",
                "aqua" => "#00ffff",
                "aquamarine" => "#7fffd4",
                "azure" => "#f0ffff",
                "beige" => "#f5f5dc",
                "bisque" => "#ffe4c4",
                "black" => "#000000",
                "blanchedalmond" => "#ffebcd",
                "blue" => "#0000ff",
                "blueviolet" => "#8a2be2",
                "brown" => "#a52a2a",
                "burlywood" => "#deb887",
                "cadetblue" => "#5f9ea0",
                "chartreuse" => "#7fff00",
                "chocolate" => "#d2691e",
                "coral" => "#ff7f50",
                "cornflowerblue" => "#6495ed",
                "cornsilk" => "#fff8dc",
                "crimson" => "#dc143c",
                "cyan" => "#00ffff",
                "darkblue" => "#00008b",
                "darkcyan" => "#008b8b",
                "darkgoldenrod" => "#b8860b",
                "darkgray" => "#a9a9a9",
                "darkgrey" => "#a9a9a9",
                "darkgreen" => "#006400",
                "darkkhaki" => "#bdb76b",
                "darkmagenta" => "#8b008b",
                "darkolivegreen" => "#556b2f",
                "darkorange" => "#ff8c00",
                "darkorchid" => "#9932cc",
                "darkred" => "#8b0000",
                "darksalmon" => "#e9967a",
                "darkseagreen" => "#8fbc8f",
                "darkslateblue" => "#483d8b",
                "darkslategray" => "#2f4f4f",
                "darkslategrey" => "#2f4f4f",
                "darkturquoise" => "#00ced1",
                "darkviolet" => "#9400d3",
                "deeppink" => "#ff1493",
                "deepskyblue" => "#00bfff",
                "dimgray" => "#696969",
                "dimgrey" => "#696969",
                "dodgerblue" => "#1e90ff",
                "firebrick" => "#b22222",
                "floralwhite" => "#fffaf0",
                "forestgreen" => "#228b22",
                "fuchsia" => "#ff00ff",
                "gainsboro" => "#dcdcdc",
                "ghostwhite" => "#f8f8ff",
                "gold" => "#ffd700",
                "goldenrod" => "#daa520",
                "gray" => "#808080",
                "grey" => "#808080",
                "green" => "#008000",
                "greenyellow" => "#adff2f",
                "honeydew" => "#f0fff0",
                "hotpink" => "#ff69b4",
                "indianred " => "#cd5c5c",
                "indigo " => "#4b0082",
                "ivory" => "#fffff0",
                "khaki" => "#f0e68c",
                "lavender" => "#e6e6fa",
                "lavenderblush" => "#fff0f5",
                "lawngreen" => "#7cfc00",
                "lemonchiffon" => "#fffacd",
                "lightblue" => "#add8e6",
                "lightcoral" => "#f08080",
                "lightcyan" => "#e0ffff",
                "lightgoldenrodyellow" => "#fafad2",
                "lightgray" => "#d3d3d3",
                "lightgrey" => "#d3d3d3",
                "lightgreen" => "#90ee90",
                "lightpink" => "#ffb6c1",
                "lightsalmon" => "#ffa07a",
                "lightseagreen" => "#20b2aa",
                "lightskyblue" => "#87cefa",
                "lightslategray" => "#778899",
                "lightslategrey" => "#778899",
                "lightsteelblue" => "#b0c4de",
                "lightyellow" => "#ffffe0",
                "lime" => "#00ff00",
                "limegreen" => "#32cd32",
                "linen" => "#faf0e6",
                "magenta" => "#ff00ff",
                "maroon" => "#800000",
                "mediumaquamarine" => "#66cdaa",
                "mediumblue" => "#0000cd",
                "mediumorchid" => "#ba55d3",
                "mediumpurple" => "#9370db",
                "mediumseagreen" => "#3cb371",
                "mediumslateblue" => "#7b68ee",
                "mediumspringgreen" => "#00fa9a",
                "mediumturquoise" => "#48d1cc",
                "mediumvioletred" => "#c71585",
                "midnightblue" => "#191970",
                "mintcream" => "#f5fffa",
                "mistyrose" => "#ffe4e1",
                "moccasin" => "#ffe4b5",
                "navajowhite" => "#ffdead",
                "navy" => "#000080",
                "oldlace" => "#fdf5e6",
                "olive" => "#808000",
                "olivedrab" => "#6b8e23",
                "orange" => "#ffa500",
                "orangered" => "#ff4500",
                "orchid" => "#da70d6",
                "palegoldenrod" => "#eee8aa",
                "palegreen" => "#98fb98",
                "paleturquoise" => "#afeeee",
                "palevioletred" => "#db7093",
                "papayawhip" => "#ffefd5",
                "peachpuff" => "#ffdab9",
                "peru" => "#cd853f",
                "pink" => "#ffc0cb",
                "plum" => "#dda0dd",
                "powderblue" => "#b0e0e6",
                "purple" => "#800080",
                "rebeccapurple" => "#663399",
                "red" => "#ff0000",
                "rosybrown" => "#bc8f8f",
                "royalblue" => "#4169e1",
                "saddlebrown" => "#8b4513",
                "salmon" => "#fa8072",
                "sandybrown" => "#f4a460",
                "seagreen" => "#2e8b57",
                "seashell" => "#fff5ee",
                "sienna" => "#a0522d",
                "silver" => "#c0c0c0",
                "skyblue" => "#87ceeb",
                "slateblue" => "#6a5acd",
                "slategray" => "#708090",
                "slategrey" => "#708090",
                "snow" => "#fffafa",
                "springgreen" => "#00ff7f",
                "steelblue" => "#4682b4",
                "tan" => "#d2b48c",
                "teal" => "#008080",
                "thistle" => "#d8bfd8",
                "tomato" => "#ff6347",
                "turquoise" => "#40e0d0",
                "violet" => "#ee82ee",
                "wheat" => "#f5deb3",
                "white" => "#ffffff",
                "whitesmoke" => "#f5f5f5",
                "yellow" => "#ffff00",
                "yellowgreen" => "#9acd32",
                "black" => "#000000",
                "navy" => "#000080",
                "darkblue" => "#00008b",
                "mediumblue" => "#0000cd",
                "blue" => "#0000ff",
                "darkgreen" => "#006400",
                "green" => "#008000",
                "teal" => "#008080",
                "darkcyan" => "#008b8b",
                "deepskyblue" => "#00bfff",
                "darkturquoise" => "#00ced1",
                "mediumspringgreen" => "#00fa9a",
                "lime" => "#00ff00",
                "springgreen" => "#00ff7f",
                "aqua" => "#00ffff",
                "cyan" => "#00ffff",
                "midnightblue" => "#191970",
                "dodgerblue" => "#1e90ff",
                "lightseagreen" => "#20b2aa",
                "forestgreen" => "#228b22",
                "seagreen" => "#2e8b57",
                "darkslategray" => "#2f4f4f",
                "darkslategrey" => "#2f4f4f",
                "limegreen" => "#32cd32",
                "mediumseagreen" => "#3cb371",
                "turquoise" => "#40e0d0",
                "royalblue" => "#4169e1",
                "steelblue" => "#4682b4",
                "darkslateblue" => "#483d8b",
                "mediumturquoise" => "#48d1cc",
                "indigo " => "#4b0082",
                "darkolivegreen" => "#556b2f",
                "cadetblue" => "#5f9ea0",
                "cornflowerblue" => "#6495ed",
                "rebeccapurple" => "#663399",
                "mediumaquamarine" => "#66cdaa",
                "dimgray" => "#696969",
                "dimgrey" => "#696969",
                "slateblue" => "#6a5acd",
                "olivedrab" => "#6b8e23",
                "slategray" => "#708090",
                "slategrey" => "#708090",
                "lightslategray" => "#778899",
                "lightslategrey" => "#778899",
                "mediumslateblue" => "#7b68ee",
                "lawngreen" => "#7cfc00",
                "chartreuse" => "#7fff00",
                "aquamarine" => "#7fffd4",
                "maroon" => "#800000",
                "purple" => "#800080",
                "olive" => "#808000",
                "gray" => "#808080",
                "grey" => "#808080",
                "skyblue" => "#87ceeb",
                "lightskyblue" => "#87cefa",
                "blueviolet" => "#8a2be2",
                "darkred" => "#8b0000",
                "darkmagenta" => "#8b008b",
                "saddlebrown" => "#8b4513",
                "darkseagreen" => "#8fbc8f",
                "lightgreen" => "#90ee90",
                "mediumpurple" => "#9370db",
                "darkviolet" => "#9400d3",
                "palegreen" => "#98fb98",
                "darkorchid" => "#9932cc",
                "yellowgreen" => "#9acd32",
                "sienna" => "#a0522d",
                "brown" => "#a52a2a",
                "darkgray" => "#a9a9a9",
                "darkgrey" => "#a9a9a9",
                "lightblue" => "#add8e6",
                "greenyellow" => "#adff2f",
                "paleturquoise" => "#afeeee",
                "lightsteelblue" => "#b0c4de",
                "powderblue" => "#b0e0e6",
                "firebrick" => "#b22222",
                "darkgoldenrod" => "#b8860b",
                "mediumorchid" => "#ba55d3",
                "rosybrown" => "#bc8f8f",
                "darkkhaki" => "#bdb76b",
                "silver" => "#c0c0c0",
                "mediumvioletred" => "#c71585",
                "indianred " => "#cd5c5c",
                "peru" => "#cd853f",
                "chocolate" => "#d2691e",
                "tan" => "#d2b48c",
                "lightgray" => "#d3d3d3",
                "lightgrey" => "#d3d3d3",
                "thistle" => "#d8bfd8",
                "orchid" => "#da70d6",
                "goldenrod" => "#daa520",
                "palevioletred" => "#db7093",
                "crimson" => "#dc143c",
                "gainsboro" => "#dcdcdc",
                "plum" => "#dda0dd",
                "burlywood" => "#deb887",
                "lightcyan" => "#e0ffff",
                "lavender" => "#e6e6fa",
                "darksalmon" => "#e9967a",
                "violet" => "#ee82ee",
                "palegoldenrod" => "#eee8aa",
                "lightcoral" => "#f08080",
                "khaki" => "#f0e68c",
                "aliceblue" => "#f0f8ff",
                "honeydew" => "#f0fff0",
                "azure" => "#f0ffff",
                "sandybrown" => "#f4a460",
                "wheat" => "#f5deb3",
                "beige" => "#f5f5dc",
                "whitesmoke" => "#f5f5f5",
                "mintcream" => "#f5fffa",
                "ghostwhite" => "#f8f8ff",
                "salmon" => "#fa8072",
                "antiquewhite" => "#faebd7",
                "linen" => "#faf0e6",
                "lightgoldenrodyellow" => "#fafad2",
                "oldlace" => "#fdf5e6",
                "red" => "#ff0000",
                "fuchsia" => "#ff00ff",
                "magenta" => "#ff00ff",
                "deeppink" => "#ff1493",
                "orangered" => "#ff4500",
                "tomato" => "#ff6347",
                "hotpink" => "#ff69b4",
                "coral" => "#ff7f50",
                "darkorange" => "#ff8c00",
                "lightsalmon" => "#ffa07a",
                "orange" => "#ffa500",
                "lightpink" => "#ffb6c1",
                "pink" => "#ffc0cb",
                "gold" => "#ffd700",
                "peachpuff" => "#ffdab9",
                "navajowhite" => "#ffdead",
                "moccasin" => "#ffe4b5",
                "bisque" => "#ffe4c4",
                "mistyrose" => "#ffe4e1",
                "blanchedalmond" => "#ffebcd",
                "papayawhip" => "#ffefd5",
                "lavenderblush" => "#fff0f5",
                "seashell" => "#fff5ee",
                "cornsilk" => "#fff8dc",
                "lemonchiffon" => "#fffacd",
                "floralwhite" => "#fffaf0",
                "snow" => "#fffafa",
                "yellow" => "#ffff00",
                "lightyellow" => "#ffffe0",
                "ivory" => "#fffff0",
                "white" => "#ffffff",
                "pink" => "#ffc0cb",
                "lightpink" => "#ffb6c1",
                "hotpink" => "#ff69b4",
                "deeppink" => "#ff1493",
                "palevioletred" => "#db7093",
                "mediumvioletred" => "#c71585",
                "lavender" => "#e6e6fa",
                "thistle" => "#d8bfd8",
                "plum" => "#dda0dd",
                "orchid" => "#da70d6",
                "violet" => "#ee82ee",
                "fuchsia" => "#ff00ff",
                "magenta" => "#ff00ff",
                "mediumorchid" => "#ba55d3",
                "darkorchid" => "#9932cc",
                "darkviolet" => "#9400d3",
                "blueviolet" => "#8a2be2",
                "darkmagenta" => "#8b008b",
                "purple" => "#800080",
                "mediumpurple" => "#9370db",
                "mediumslateblue" => "#7b68ee",
                "slateblue" => "#6a5acd",
                "darkslateblue" => "#483d8b",
                "rebeccapurple" => "#663399",
                "indigo " => "#4b0082",
                "lightsalmon" => "#ffa07a",
                "salmon" => "#fa8072",
                "darksalmon" => "#e9967a",
                "lightcoral" => "#f08080",
                "indianred " => "#cd5c5c",
                "crimson" => "#dc143c",
                "red" => "#ff0000",
                "firebrick" => "#b22222",
                "darkred" => "#8b0000",
                "orange" => "#ffa500",
                "darkorange" => "#ff8c00",
                "coral" => "#ff7f50",
                "tomato" => "#ff6347",
                "orangered" => "#ff4500",
                "gold" => "#ffd700",
                "yellow" => "#ffff00",
                "lightyellow" => "#ffffe0",
                "lemonchiffon" => "#fffacd",
                "lightgoldenrodyellow" => "#fafad2",
                "papayawhip" => "#ffefd5",
                "moccasin" => "#ffe4b5",
                "peachpuff" => "#ffdab9",
                "palegoldenrod" => "#eee8aa",
                "khaki" => "#f0e68c",
                "darkkhaki" => "#bdb76b",
                "greenyellow" => "#adff2f",
                "chartreuse" => "#7fff00",
                "lawngreen" => "#7cfc00",
                "lime" => "#00ff00",
                "limegreen" => "#32cd32",
                "palegreen" => "#98fb98",
                "lightgreen" => "#90ee90",
                "mediumspringgreen" => "#00fa9a",
                "springgreen" => "#00ff7f",
                "mediumseagreen" => "#3cb371",
                "seagreen" => "#2e8b57",
                "forestgreen" => "#228b22",
                "green" => "#008000",
                "darkgreen" => "#006400",
                "yellowgreen" => "#9acd32",
                "olivedrab" => "#6b8e23",
                "darkolivegreen" => "#556b2f",
                "mediumaquamarine" => "#66cdaa",
                "darkseagreen" => "#8fbc8f",
                "lightseagreen" => "#20b2aa",
                "darkcyan" => "#008b8b",
                "teal" => "#008080",
                "aqua" => "#00ffff",
                "cyan" => "#00ffff",
                "lightcyan" => "#e0ffff",
                "paleturquoise" => "#afeeee",
                "aquamarine" => "#7fffd4",
                "turquoise" => "#40e0d0",
                "mediumturquoise" => "#48d1cc",
                "darkturquoise" => "#00ced1",
                "cadetblue" => "#5f9ea0",
                "steelblue" => "#4682b4",
                "lightsteelblue" => "#b0c4de",
                "lightblue" => "#add8e6",
                "powderblue" => "#b0e0e6",
                "lightskyblue" => "#87cefa",
                "skyblue" => "#87ceeb",
                "cornflowerblue" => "#6495ed",
                "deepskyblue" => "#00bfff",
                "dodgerblue" => "#1e90ff",
                "royalblue" => "#4169e1",
                "blue" => "#0000ff",
                "mediumblue" => "#0000cd",
                "darkblue" => "#00008b",
                "navy" => "#000080",
                "midnightblue" => "#191970",
                "cornsilk" => "#fff8dc",
                "blanchedalmond" => "#ffebcd",
                "bisque" => "#ffe4c4",
                "navajowhite" => "#ffdead",
                "wheat" => "#f5deb3",
                "burlywood" => "#deb887",
                "tan" => "#d2b48c",
                "rosybrown" => "#bc8f8f",
                "sandybrown" => "#f4a460",
                "goldenrod" => "#daa520",
                "darkgoldenrod" => "#b8860b",
                "peru" => "#cd853f",
                "chocolate" => "#d2691e",
                "olive" => "#808000",
                "saddlebrown" => "#8b4513",
                "sienna" => "#a0522d",
                "brown" => "#a52a2a",
                "maroon" => "#800000",
                "white" => "#ffffff",
                "snow" => "#fffafa",
                "honeydew" => "#f0fff0",
                "mintcream" => "#f5fffa",
                "azure" => "#f0ffff",
                "aliceblue" => "#f0f8ff",
                "ghostwhite" => "#f8f8ff",
                "whitesmoke" => "#f5f5f5",
                "seashell" => "#fff5ee",
                "beige" => "#f5f5dc",
                "oldlace" => "#fdf5e6",
                "floralwhite" => "#fffaf0",
                "ivory" => "#fffff0",
                "antiquewhite" => "#faebd7",
                "linen" => "#faf0e6",
                "lavenderblush" => "#fff0f5",
                "mistyrose" => "#ffe4e1",
                "gainsboro" => "#dcdcdc",
                "lightgray" => "#d3d3d3",
                "silver" => "#c0c0c0",
                "darkgray" => "#a9a9a9",
                "dimgray" => "#696969",
                "gray" => "#808080",
                "lightslategray" => "#778899",
                "slategray" => "#708090",
                "darkslategray" => "#2f4f4f",
                "black" => "#000000"
            )
        );
        wp_localize_script('avs-manage', 'avs_default_colors', $colors);
    }

    /**
     * Add ajax back end callback, on some action to some function.
     *
     * @since 1.3
     */
    public static function avsAjaxCallAction() {

        global $wpdb;

        $user_action = AvartanSliderLiteFunctions::asGetPostVar("user_action");
        $options = AvartanSliderLiteFunctions::asGetPostVar("data");
        $nonce = AvartanSliderLiteFunctions::asGetPostVar("nonce");
        $slider_table_name = $wpdb->prefix . 'avartan_sliders';
        $slides_table_name = $wpdb->prefix . 'avartan_slides';
        $preset_table_name = $wpdb->prefix . 'avartan_preset';
        $output = true;
        $as_DBObj = new AvartanSliderLiteCore();
        $as_SCObj = new AvartansliderLiteShortcode();

        try {
            //verify the nonce
            $isVerified = wp_verify_nonce($nonce, "avs_nonce");

            if ($isVerified == false) {

                AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during nonce varification', 'avartan-slider-lite'));
            } else {

                switch ($user_action) {
                    case 'avartanslider_addSlider':

                        foreach ($options as $option) {

                            //Get slider information which are already exists
                            $select = "*";
                            $where = "alias = '" . trim($option['alias']) . "'";
                            $order_by = "";
                            $group_by = "";
                            $extra = "";
                            $format = ARRAY_A;
                            $slider_detail = $as_DBObj->fetch($select, $slider_table_name, $where, $order_by, $group_by, $extra, $format);

                            if ($slider_detail) {

                                $rowcount = $wpdb->num_rows;

                                //Check slider already exists
                                if ($rowcount > 0) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('This slider name is already exist', 'avartan-slider-lite'));
                                }
                            } else {
                                //insert slider
                                $slider_option = json_decode(stripslashes($option['slider_option']));
                                $slider_option = maybe_serialize($slider_option);

                                $slider_arr = array(
                                    'name' => sanitize_text_field($option['name']),
                                    'alias' => $option['alias'],
                                    'slider_option' => $slider_option,
                                );
                                $output = $as_DBObj->insert($slider_table_name, $slider_arr);

                                if ($output === false) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during create slider', 'avartan-slider-lite'));
                                } else {
                                    $slider_id = $wpdb->insert_id;
                                    $slide_params = new stdClass;
                                    $slide_params->slide_name = __('Slide', 'avartan-slider-lite');
                                    $slide_params->background = new stdClass;
                                    $slide_params->background->type = 'image';
                                    $slide_arr = array(
                                        'slider_parent' => $slider_id,
                                        'params' => maybe_serialize($slide_params),
                                        'position' => 1,
                                        'layers' => ''
                                    );
                                    $output = $as_DBObj->insert($slides_table_name, $slide_arr);
                                    $slide_id = $wpdb->insert_id;

                                    AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slider has been generated successfully.", 'avartan-slider-lite'), 'add_slider', AvartanSliderLiteFunctions::asGetViewRedirectUrl('slide', 'id=' . esc_attr($slide_id))); //redirect to slide now
                                }
                            }
                        }

                        break;
                    case 'avartanslider_editSlider':

                        foreach ($options as $option) {

                            $select = "*";
                            $where = "alias = '" . trim($option['alias']) . "' AND id <> " . $option['id'];
                            $order_by = "";
                            $group_by = "";
                            $extra = "";
                            $format = ARRAY_A;
                            $slider_detail = $as_DBObj->fetch($select, $slider_table_name, $where, $order_by, $group_by, $extra, $format);

                            if ($slider_detail) {
                                $rowcount = $wpdb->num_rows;

                                //check slider already exists
                                if ($rowcount > 0) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('This slider name is already exist', 'avartan-slider-lite'));
                                }
                            } else {
                                //update slider
                                $slider_option = json_decode(stripslashes($option['slider_option']));
                                $slider_option = maybe_serialize($slider_option);

                                $slider_arr = array(
                                    'name' => sanitize_text_field($option['name']),
                                    'alias' => $option['alias'],
                                    'slider_option' => $slider_option,
                                );

                                $where = array('id' => $option['id']);

                                $output = $as_DBObj->update($slider_table_name, $slider_arr, $where);

                                if ($output === false) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during edit slider', 'avartan-slider-lite'));
                                } else {
                                    AvartanSliderLiteFunctions::asAjaxResSuccess(__("Slider has been saved successfully.", 'avartan-slider-lite'), 'edit_slider');
                                }
                            }
                        }

                        break;

                    case 'delete_slider':

                        require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                        $slider_id = isset($options[0]['slider_id']) ? $options[0]['slider_id'] : '';

                        if ($slider_id == '')
                            return;
                        $sliders_obj_delete = new avsLiteSlider();
                        $output = $sliders_obj_delete->deleteSlider($slider_id);
                        if ($output === false) {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during deleting slider.', 'avartan-slider-lite'));
                        } else {
                            AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slider has been deleted successfully.", 'avartan-slider-lite'), '', AvartanSliderLiteFunctions::asGetViewRedirectUrl()); //redirect to slide now
                        }
                        break;

                    case 'as_saveSlide':
                        if (isset($options[0])) {
                            $slider_id = $options[0]['slider_id'];
                            $slide_id = $options[0]['slide_id'];

                            $slide_option = json_decode(stripslashes($options[0]['slide_option']));
                            if ($slide_option->custom_css != '') {
                                $custom_css = wp_json_encode(stripslashes($slide_option->custom_css));
                                $custom_css = substr($custom_css, 1, -1);
                                $slide_option->custom_css = $custom_css;
                            }
                            $params = maybe_serialize($slide_option);
                            $position = $options[0]['position'];
                            $slider_elements = json_decode(stripslashes($options[0]['layers']));
                            $layers = maybe_serialize($slider_elements);
                            $slider_arr = array(
                                'slider_parent' => $slider_id,
                                'position' => $position,
                                'params' => $params,
                                'layers' => $layers
                            );
                            $where = array('id' => $slide_id);
                            $output = $as_DBObj->update($slides_table_name, $slider_arr, $where);
                            if ($output === false) {
                                AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during edit slide.', 'avartan-slider-lite'));
                            } else {
                                AvartanSliderLiteFunctions::asAjaxResSuccess(__("Slide has been saved successfully.", 'avartan-slider-lite'), 'edit_slider');
                            }
                        }
                        break;

                    case 'add_slide_from_slideview' :
                        $slider_id = isset($options[0]['slider_id']) ? $options[0]['slider_id'] : '';
                        $where_count = 'slider_parent =' . $slider_id;
                        $totalSlides = $as_DBObj->countTotalData($slides_table_name, $where_count);
                        $totalSlides = $totalSlides + 1;
                        //insert slider
                        $slide_params = new stdClass;
                        $back = new stdClass;
                        $back->type = 'image';
                        $slide_params->slide_name = __('Slide', 'avartan-slider-lite');
                        $slide_params->background = new stdClass;
                        $slide_params->background->type = 'image';
                        $slider_arr = array(
                            'slider_parent' => $slider_id,
                            'params' => maybe_serialize($slide_params),
                            'position' => $totalSlides,
                            'layers' => ''
                        );
                        $output = $as_DBObj->insert($slides_table_name, $slider_arr);

                        if ($output === false) {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during creating slide.', 'avartan-slider-lite'));
                        } else {
                            AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slide created successfully", 'avartan-slider-lite'), '', AvartanSliderLiteFunctions::asGetViewRedirectUrl('slide', 'id=' . esc_attr($wpdb->insert_id))); //redirect to slide now
                        }
                        break;

                    case 'delete_slide' :
                        $slider_id = isset($options[0]['slider_id']) ? $options[0]['slider_id'] : '';
                        $slide_id = isset($options[0]['slide_id']) ? $options[0]['slide_id'] : '';
                        $current_slide = isset($options[0]['current_slide']) ? $options[0]['current_slide'] : '';
                        if ($slider_id == '' || $slide_id == '') {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during deleting slide.', 'avartan-slider-lite'));
                        }
                        $where_count = 'slider_parent =' . $slider_id;
                        $count = $as_DBObj->countTotalData($slides_table_name, $where_count);
                        if ($count > 1) {
                            $where_delete = 'id =' . $slide_id;
                            $output = $as_DBObj->delete($slides_table_name, $where_delete);
                            if ($current_slide == 'yes') {
                                $current_first = $as_DBObj->fetchSingle('id', $slides_table_name, $where_count);
                                $first_slide = $current_first->id;
                                AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slide deleted successfully", 'avartan-slider-lite'), '', AvartanSliderLiteFunctions::asGetViewRedirectUrl('slide', 'id=' . esc_attr($first_slide)));
                            } else {
                                AvartanSliderLiteFunctions::asAjaxResSuccess(__("Slide deleted successfully.", 'avartan-slider-lite'), 'delete_slide');
                            }
                        } else {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Atleast one slide require.', 'avartan-slider-lite'));
                        }

                        break;



                    case 'update_slide_position':
                        if (count($options) > 0) {
                            foreach ($options as $pos_option) {
                                if (isset($pos_option['slide_position'])) {
                                    $slider_arr = array(
                                        'position' => $pos_option['slide_position']
                                    );
                                    $where = array('id' => $pos_option['slide_id']);
                                    $output = $as_DBObj->update($slides_table_name, $slider_arr, $where);
                                    if ($output === false) {
                                        $output = false;
                                    } else {
                                        $output = true;
                                    }
                                }
                            }
                        }
                        break;

                    case 'slide_preset_layout':
                        $preset_id = isset($options[0]['preset_id']) ? $options[0]['preset_id'] : '';
                        $slide_id = isset($options[0]['slide_id']) ? $options[0]['slide_id'] : '';
                        $select = 'params,layers';
                        $from = $preset_table_name;
                        $where = 'id =' . $preset_id;
                        $preset_detail = $as_DBObj->fetch($select, $from, $where, '', '', '', ARRAY_A);
                        $params = $preset_detail[0]['params'];
                        $layers = $preset_detail[0]['layers'];
                        $slideArr = array(
                            'params' => $params,
                            'layers' => $layers
                        );
                        $where = array('id' => $slide_id);
                        $output = $as_DBObj->update($slides_table_name, $slideArr, $where);
                        if ($output === FALSE) {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Error occur during preseting slide.', 'avartan-slider-lite'));
                        } else {
                            AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slide has been preseted successfully.", 'avartan-slider-lite'), '', AvartanSliderLiteFunctions::asGetViewRedirectUrl('slide', 'id=' . esc_attr($slide_id)));
                        }
                        break;

                    case 'preview_slide':
                        $output = '';
                        $options = isset($options[0]) ? $options[0] : array();
                        $slider_id = $options['slider_id'];
                        $select = '*';
                        $from = avsLiteGlobals::$avs_slider_tbl;
                        $where = 'id = \'' . $slider_id . '\'';
                        $as_DBObj = new AvartanSliderLiteCore();
                        $slider = $as_DBObj->getRow($select, $from, $where);

                        if (!$slider) {
                            $output .= __('The slider has not been found', 'avartan-slider-lite');
                        } else {

                            $slider_option = AvartanSliderLiteFunctions::getVal($slider, 'slider_option', array());
                            $slider_option = maybe_unserialize($slider_option);

                            $slider_type = 'standard-slider';

                            $layers = '';

                            //Make HTML for Preview Slide
                            $containerStyle = '';
                            $slider_width = AvartanSliderLiteFunctions::getVal($slider_option, 'start_width', '1280');
                            $slider_height = AvartanSliderLiteFunctions::getVal($slider_option, 'start_height', '650');
                            $containerStyle .= "height:" . $slider_height . "px;";
                            $output .= '<div id="avartanslider-' . $slider_id . '_wrapper" class="avartanslider_wrapper" style="' . $containerStyle . '">';
                            $output .= '<div style="display: none;' . $containerStyle . '" class="avartanslider-slider avartanslider-slider-' . AvartanSliderLiteFunctions::getVal($slider_option, 'layout', '') . '" id="avartanslider-' . $slider_id . '">' . "\n";
                            $output .= '<ul style="display:none;">' . "\n";

                            switch ($slider_type) {
                                case "standard-slider" :
                                    //Get slide setting and set the property
                                    $params = json_decode(stripslashes($options['slide_option']));
                                    $params = maybe_unserialize(maybe_serialize($params));
                                    $params->slide_id = $options['slide_id'].'A';
                                    $params->slider_id = $slider_id;
                                    $elements = array();
                                    //Get Elements of particular slide
                                    if (isset($options['layers'])) {
                                        $layers = json_decode(stripslashes($options['layers']));
                                        $elements = maybe_unserialize(maybe_serialize($layers));
                                    }

                                    $output .= $as_SCObj->avsSlideDetail($params, $elements, true);

                                    break;
                            }
                            $output .= '</ul>' . "\n";

                            $output .= '</div>' . "\n";
                            //Get Responsiveness
                            $mobile_custom_size = 0;
                            $grid_width = AvartanSliderLiteFunctions::getVal($slider_option,'start_width','1280');

                            $grid_height = AvartanSliderLiteFunctions::getVal($slider_option,'start_height','650');

                            $grid_size = array(
                                'width' => $grid_width,
                                'height' => $grid_height
                            );
                            $output .= '<script type="text/javascript">' . "\n";
                            $output .= '(function($) {' . "\n";
                            $output .= '$(document).ready(function() {' . "\n";
                            $output .= '$("#avartanslider-' . $slider_id . '").avartanSlider({' . "\n";
                            $output .= 'layout: \'' . AvartanSliderLiteFunctions::getVal($slider_option, 'layout', 'fixed') . '\',' . "\n";
                            $output .= 'startWidth: ' . $grid_width . ',' . "\n";
                            $output .= 'startHeight: ' . $grid_height . ',' . "\n";
                            $output .= 'sliderBgColor: \'transparent\',' . "\n";
                            $output .= 'automaticSlide: true,' . "\n";
                            $output .= 'enableSwipe: true,' . "\n";
                            $output .= 'preview: true,' . "\n";
                            $output .= 'showShadowBar: false,' . "\n";
                            $output .= 'shadowClass: \'' . AvartanSliderLiteFunctions::getVal($slider_option, 'shadow_class', '') . '\',' . "\n";
                            $output .= 'pauseOnHover: true,' . "\n";
                            $output .= 'navigation : {' . "\n";
                            $output .= 'arrows: {' . "\n";
                            $output .= 'enable:false,' . "\n";
                            $output .= ' },' . "\n";
                            $output .= 'bullets: {' . "\n";
                            $output .= 'enable:false,' . "\n";
                            $output .= ' }' . "\n";
                            $output .= '}' . ',' . "\n";
                            $output .= '});' . "\n";
                            $output .= '});' . "\n";
                            $output .= '})(jQuery);' . "\n";
                            $output .= '</script>' . "\n";
                            $output .= '</div>' . "\n";
                        }
                        AvartanSliderLiteFunctions::asAjaxResData('preview_output', $output);
                        exit();
                        break;

                    default:

                        AvartanSliderLiteFunctions::throwError(__("wrong ajax action:", 'avartan-slider-lite') . ' ' . esc_attr($user_action));

                        break;
                }
            }
        } catch (Exception $e) {

            $message = $e->getMessage();
            echo $message;
            exit();
        }

        exit();
    }

    /**
     * Add ajax back end callback on deactivation reason submission
     *
     * @since 1.3
     */
    public static function avsSbtDeactivationform() {
        //Email To Admin
        $to = 'pluginsd@solwininfotech.com';
        $from = get_option('admin_email');
        $reason_id = sanitize_text_field($_POST['deactivation_option']);
        $reason_text = sanitize_text_field($_POST['deactivation_option_text']);
        if ($reason_id == 10) {
            $reason_text = sanitize_text_field($_POST['deactivation_option_other']);
        }
        $headers = "MIME-Version: 1.0;\r\n";
        $headers .= "From: " . strip_tags($from) . "\r\n";
        $headers .= "Content-Type: text/html; charset: utf-8;\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
        $subject = 'User has deactivated Plugin - Avartan Slider Lite';
        $body = '';
        ob_start();
        ?>
        <div style="background: #F5F5F5; border-width: 1px; border-style: solid; padding-bottom: 20px; margin: 0px auto; width: 750px; height: auto; border-radius: 3px 3px 3px 3px; border-color: #5C5C5C;">
            <div style="border: #FFF 1px solid; background-color: #ffffff !important; margin: 20px 20px 0;
                 height: auto; -moz-border-radius: 3px; padding-top: 15px;">
                <div style="padding: 20px 20px 20px 20px; font-family: Arial, Helvetica, sans-serif;
                     height: auto; color: #333333; font-size: 13px;">
                    <div style="width: 100%;">
                        <strong>Dear Admin (Avartan slider plugin developer)</strong>,
                        <br />
                        <br />
                        Thank you for developing useful plugin.
                        <br />
                        <br />
                        I have deactivated plugin because of following reason.
                        <br />
                        <br />
                        <div>
                            <table border='0' cellpadding='5' cellspacing='0' style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;color: #333333;width: 100%;">
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Reason ID<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo $reason_id; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Reason<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo $reason_text; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                        Website<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo home_url(); ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                        Email<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo $from; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Date<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo date('d-M-Y  h:i  A'); ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Plugin<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo 'Avartan Slider'; ?>
                                    </td>
                                </tr>
                            </table>
                            <br /><br />
                            Again Thanks you
                            <br />
                            <br />
                            Regards
                            <br />
        <?php echo home_url(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $body = ob_get_clean();
        wp_mail($to, $subject, $body, $headers);
        exit();
    }

}

new avsLiteAdmin();
?>