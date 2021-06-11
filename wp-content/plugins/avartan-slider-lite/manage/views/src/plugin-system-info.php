<?php
if (!defined('ABSPATH'))
    exit();
?>
<div id="as_system_info" class="changelog">
    <div class="changelog-section">
        <table class="avs_status_table widefat" cellspacing="0" id="status">
            <tbody>
                <tr>
                    <td class="get-status" colspan="3" data-export-label="Avartan Slider">
                        <span class="get-system-status"><a href="#" class="button-primary debug-status-report"><?php _e('Get System Report', 'avartan-slider-lite'); ?></a><span class="system-report-msg"><?php _e('Click the button to produce a report, then copy and paste into your support ticket.', 'avartan-slider-lite'); ?></span></span>

                        <div id="debug-report">
                            <textarea id="copyText" readonly="readonly"></textarea>
                            <p class="submit">
                                <button id="copy-for-support" class="button-primary" data-clipboard-target="#copyText" href="#" data-tip="<?php _e('Copied!', 'avartan-slider-lite'); ?>"><?php _e('Copy for Support', 'avartan-slider-lite'); ?></button></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="avs_status_table widefat" cellspacing="0" id="status">
            <thead>
                <tr>
                    <th colspan="3" data-export-label="WordPress Environment"><h2><?php _e('WordPress Environment', 'avartan-slider-lite'); ?></h2></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first_td" data-export-label="Home URL"><?php _e('Home URL', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('The URL of your site\'s homepage.', 'avartan-slider-lite')); ?></td>
                    <td><?php form_option('home'); ?></td>
                </tr>
                <tr>
                    <td class="first_td" data-export-label="Site URL"><?php _e('Site URL', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('The root URL of your site.', 'avartan-slider-lite')); ?></td>
                    <td><?php form_option('siteurl'); ?></td>
                </tr>

                <tr>
                    <td class="first_td" data-export-label="WP Version"><?php _e('WP Version', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('The version of WordPress installed on your site.', 'avartan-slider-lite')); ?></td>
                    <td><?php bloginfo('version'); ?></td>
                </tr>
                <tr>
                    <td class="first_td" data-export-label="WP Memory Limit"><?php _e('WP Memory Limit', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('The maximum amount of memory (RAM) that your site can use at one time.', 'avartan-slider-lite')); ?></td>
                    <td><?php
                        $memory = avartan_let_to_num(WP_MEMORY_LIMIT);

                        if (function_exists('memory_get_usage')) {
                            $system_memory = avartan_let_to_num(@ini_get('memory_limit'));
                            $memory = max($memory, $system_memory);
                        }
                        echo '<mark class="yes">' . size_format($memory) . '</mark>';
                        ?></td>
                </tr>
                <tr>
                    <td class="first_td" data-export-label="WP Debug Mode"><?php _e('WP Debug Mode', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('Displays whether or not WordPress is in Debug Mode.', 'avartan-slider-lite')); ?></td>
                    <td>
                        <?php
                        if (defined('WP_DEBUG') && WP_DEBUG) : ?>
                            <mark class="yes"><?php _e('TRUE', 'avartan-slider-lite'); ?></mark><?php
                        else : ?>
                            <mark class="yes"><?php _e('FALSE', 'avartan-slider-lite'); ?></mark><?php
                        endif;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="first_td" data-export-label="Language"><?php _e('Language', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('The current language used by WordPress. Default = English', 'avartan-slider-lite')); ?></td>
                    <td><?php echo get_locale(); ?></td>
                </tr>
            </tbody>
        </table>
        <table class="avs_status_table widefat" cellspacing="0"  id="status">
            <thead>
                <tr>
                    <th colspan="3" data-export-label="Server Environment"><h2><?php _e('Server Environment', 'avartan-slider-lite'); ?></h2></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first_td" data-export-label="Server Info"><?php _e('Server Info', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('Information about the web server that is currently hosting your site.', 'avartan-slider-lite')); ?></td>
                    <td><?php echo esc_html($_SERVER['SERVER_SOFTWARE']); ?></td>
                </tr>
                <tr>
                    <td class="first_td" data-export-label="PHP Version"><?php _e('PHP Version', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('The version of PHP installed on your hosting server.', 'avartan-slider-lite')); ?></td>
                    <td><?php
                        // Check if phpversion function exists.
                        if (function_exists('phpversion')) {
                            $php_version = phpversion();

                            if (version_compare($php_version, '5.6', '<')) {
                                echo '<mark class="error"><span class="dashicons dashicons-warning"></span> '.esc_html($php_version).' - ' .__('We recommend a minimum PHP version of 5.6. See', 'avartan-slider-lite').': <a href="'. esc_url('https://docs.woocommerce.com/document/how-to-update-your-php-version/') .'" target="_blank">' . __('How to update your PHP version', 'avartan-slider-lite') . '</a>' . '</mark>';
                            } else {
                                echo '<mark class="yes">' . esc_html($php_version) . '</mark>';
                            }
                        } else {
                            _e("Couldn't determine PHP version because phpversion() doesn't exist.", 'avartan-slider-lite');
                        }
                        ?></td>
                </tr>
                <?php if (function_exists('ini_get')) : ?>
                    <tr>
                        <td class="first_td" data-export-label="PHP Post Max Size"><?php _e('PHP Post Max Size', 'avartan-slider-lite'); ?>:</td>
                        <td class="help"><?php echo avartan_help_tip(__('The largest filesize that can be contained in one post.', 'avartan-slider-lite')); ?></td>
                        <td><?php echo size_format(avartan_let_to_num(ini_get('post_max_size'))); ?></td>
                    </tr>
                    <?php $max_execution_time = ini_get('max_execution_time'); ?>
                    <tr>
                        <td class="first_td" data-export-label="PHP Time Limit"><?php _e('PHP Time Limit', 'avartan-slider-lite'); ?>:</td>
                        <td class="help"><?php echo avartan_help_tip(__('The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'avartan-slider-lite')); ?></td>
                        <td class="yes"><?php echo ini_get('max_execution_time'); ?></td>
                    </tr>
                    <tr>
                        <td class="first_td" data-export-label="PHP Max Input Vars"><?php _e('PHP Max Input Vars', 'avartan-slider-lite'); ?>:</td>
                        <td class="help"><?php echo avartan_help_tip(__('The maximum number of variables your server can use for a single function to avoid overloads.', 'avartan-slider-lite')); ?></td>
                        <td class="yes"><?php echo ini_get('max_input_vars'); ?></td>
                    </tr>
                    <?php
                endif;
                ?>
                <tr>
                    <td class="first_td" data-export-label="ZipArchive"><?php _e('ZipArchive', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(); ?></td>
                    <td>
                        <?php
                        if (class_exists('ZipArchive')) : ?>
                            <mark class="yes"><?php _e('TRUE', 'avartan-slider-lite'); ?></mark><?php
                        else :?>
                            <mark class="no"><?php _e('FALSE', 'avartan-slider-lite'); ?></mark><?php
                        endif;
                        ?>
                    </td>
                </tr>
                <?php
                $ver = '';
                if ($wpdb->use_mysqli) {
                    $ver = mysqli_get_server_info($wpdb->dbh);
                }
                if (!empty($wpdb->is_mysql) && !stristr($ver, 'MariaDB')) :
                    ?>
                    <tr>
                        <td class="first_td" data-export-label="MySQL Version"><?php _e('MySQL Version', 'avartan-slider-lite'); ?>:</td>
                        <td class="help"><?php echo avartan_help_tip(__('The version of MySQL installed on your hosting server.', 'avartan-slider-lite')); ?></td>
                        <td>
                            <?php
                            $mysql_version = $wpdb->db_version();
                            if (version_compare($mysql_version, '5.6', '<')) {
                                echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html($mysql_version). '-' . __('We recommend a minimum MySQL version of 5.6. See:', 'avartan-slider-lite') . '<a href="'. esc_url('https://wordpress.org/about/requirements/') .'" target="_blank">' . __('WordPress Requirements', 'avartan-slider-lite') . '</a>'. '</mark>';
                            } else {
                                echo '<mark class="yes">' . esc_html($mysql_version) . '</mark>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td class="first_td" data-export-label="Max Upload Size"><?php _e('Max Upload Size', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('The largest filesize that can be uploaded to your WordPress installation.', 'avartan-slider-lite')); ?></td>
                    <td><?php echo size_format(wp_max_upload_size()); ?></td>
                </tr>

                <tr>
                    <td class="first_td" data-export-label="Uploads folder writable"><?php _e('Uploads folder writable', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('Determine if a Uploads folder directory is writable or not.', 'avartan-slider-lite')); ?></td>
                    <td>
                        <?php $dir = wp_upload_dir();
                        if(wp_is_writable($dir['basedir'].'/')){ ?>
                            <mark class="yes"><?php _e('TRUE', 'avartan-slider-lite'); ?></mark><?php
                        }else{  ?>
                            <mark class="no"><?php _e('FALSE', 'avartan-slider-lite'); ?></mark><?php
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td class="first_td" data-export-label="DOMDocument"><?php _e('DOMDocument', 'avartan-slider-lite'); ?>:</td>
                    <td class="help"><?php echo avartan_help_tip(__('Your server does not have the DOMDocument class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'avartan-slider-lite')); ?></td>
                    <td>
                        <?php
                        if (class_exists('DOMDocument')) : ?>
                            <mark class="yes"><?php _e('TRUE', 'avartan-slider-lite'); ?></mark><?php
                        else :  ?>
                            <mark class="no"><?php _e('FALSE', 'avartan-slider-lite'); ?></mark><?php
                        endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>