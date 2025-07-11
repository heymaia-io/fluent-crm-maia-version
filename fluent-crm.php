<?php defined('ABSPATH') or die;

/**
 * Plugin Name:  FluentCRM - Maia Custom Version
 * Plugin URI:   https://fluentcrm.com
 * Description:  CRM and Email Newsletter Plugin for WordPress (Maia Custom Version with enhanced capabilities)
 * Version:      2.9.60-maia-custom
 * Author:       WP Email Newsletter Team - FluentCRM (Customized by Maia)
 * Author URI:   https://fluentcrm.com
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  fluent-crm-maia
 * Domain Path:  /language
 * Update URI:   false
 * Network:      false
 */

if (defined('FLUENTCRM')) {
    return;
}

define('FLUENTCRM', 'fluentcrm');
define('FLUENTCRM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FLUENTCRM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('FLUENTCRM_PLUGIN_VERSION', '2.9.60-maia-custom');
define('FLUENTCRM_MIN_PRO_VERSION', '2.9.60');

define('FLUENTCRM_DB_VERSION', '2.9.50');

define('FLUENTCRM_FRAMEWORK_VERSION', 3);
define('FLUENT_CRM_STARTING_TIME', microtime(true));

if (!defined('FLUENTCRM_UPLOAD_DIR')) {
    define('FLUENTCRM_UPLOAD_DIR', '/fluentcrm');
}

require __DIR__ . '/vendor/autoload.php';

call_user_func(function ($bootstrap) {
    $bootstrap(__FILE__);
}, require(__DIR__ . '/boot/app.php'));

// Prevent automatic updates for this custom version - COMPREHENSIVE BLOCKING
add_filter('site_transient_update_plugins', 'fluentcrm_maia_disable_plugin_updates');
add_filter('pre_site_transient_update_plugins', 'fluentcrm_maia_disable_plugin_updates');
add_filter('transient_update_plugins', 'fluentcrm_maia_disable_plugin_updates');
add_filter('http_request_args', 'fluentcrm_maia_disable_update_check', 10, 2);
add_filter('plugins_api', 'fluentcrm_maia_disable_plugin_api', 10, 3);
add_filter('pre_http_request', 'fluentcrm_maia_block_wp_api_calls', 10, 3);
add_action('admin_init', 'fluentcrm_maia_hide_plugin_updates');

function fluentcrm_maia_disable_plugin_updates($value) {
    $plugin_file = plugin_basename(__FILE__);
    
    if (isset($value->response[$plugin_file])) {
        unset($value->response[$plugin_file]);
    }
    
    if (isset($value->no_update[$plugin_file])) {
        unset($value->no_update[$plugin_file]);
    }
    
    return $value;
}

function fluentcrm_maia_disable_update_check($args, $url) {
    // Prevent update checks to WordPress.org for this plugin
    if (strpos($url, 'api.wordpress.org/plugins/update-check') !== false) {
        $plugin_file = plugin_basename(__FILE__);
        if (isset($args['body']['plugins']) && strpos($args['body']['plugins'], $plugin_file) !== false) {
            // Remove this plugin from the update check request
            $plugins = json_decode($args['body']['plugins'], true);
            if (isset($plugins['plugins'][$plugin_file])) {
                unset($plugins['plugins'][$plugin_file]);
                $args['body']['plugins'] = json_encode($plugins);
            }
        }
    }
    return $args;
}

function fluentcrm_maia_disable_plugin_api($result, $action, $args) {
    // Block plugin info requests for FluentCRM
    if ($action == 'plugin_information' && isset($args->slug) && $args->slug == 'fluent-crm') {
        return new WP_Error('plugin_not_found', 'Plugin not found.');
    }
    return $result;
}

function fluentcrm_maia_block_wp_api_calls($result, $parsed_args, $url) {
    // Block any WordPress.org API calls related to fluent-crm
    if (strpos($url, 'api.wordpress.org') !== false && strpos($url, 'fluent-crm') !== false) {
        return new WP_Error('blocked', 'API call blocked for custom plugin');
    }
    return $result;
}

function fluentcrm_maia_hide_plugin_updates() {
    global $wp_version;
    $plugin_file = plugin_basename(__FILE__);
    
    // Remove from update cache completely
    $current = get_site_transient('update_plugins');
    if (isset($current->response[$plugin_file])) {
        unset($current->response[$plugin_file]);
        set_site_transient('update_plugins', $current);
    }
    
    // Hide update notices using CSS if they still appear
    add_action('admin_head', function() use ($plugin_file) {
        echo '<style>
            tr[data-plugin="' . $plugin_file . '"] .update-message,
            .plugins tr[data-plugin="' . $plugin_file . '"] .plugin-update-tr {
                display: none !important;
            }
        </style>';
    });
}

add_filter('plugin_row_meta', 'fluentcrm_plugin_row_meta', 10, 2);

function fluentcrm_plugin_row_meta($links, $file)
{
    $plugin_file = plugin_basename(__FILE__);
    if ($plugin_file == $file) {
        $row_meta = array(
            'custom_version' => '<span style="color: #e74c3c;font-weight: 600;">' . esc_html__('Maia Custom Version - Updates Disabled', 'fluent-crm') . '</span>',
            'docs'           => '<a rel="noopener" href="https://fluentcrm.com/docs/" style="color: #23c507;font-weight: 600;" aria-label="' . esc_attr(esc_html__('View FluentCRM Documentation', 'fluent-crm')) . '" target="_blank">' . esc_html__('Docs & FAQs', 'fluent-crm') . '</a>',
            'support'        => '<a rel="noopener" href="https://wpmanageninja.com/support-tickets/#/" style="color: #23c507;font-weight: 600;" aria-label="' . esc_attr(esc_html__('Get Support', 'fluent-crm')) . '" target="_blank">' . esc_html__('Support', 'fluent-crm') . '</a>',
            'developer_docs' => '<a rel="noopener" href="https://developers.fluentcrm.com" style="color: #23c507;font-weight: 600;" aria-label="' . esc_attr(esc_html__('Developer Docs', 'fluent-crm')) . '" target="_blank">' . esc_html__('Developer Docs', 'fluent-crm') . '</a>',
        );

        if (!defined('FLUENTCAMPAIGN')) {
            $row_meta['pro'] = '<a rel="noopener" href="https://fluentcrm.com" style="color: #7742e6;font-weight: bold;" aria-label="' . esc_attr(esc_html__('Upgrade to Pro', 'fluent-crm')) . '" target="_blank">' . esc_html__('Upgrade to Pro', 'fluent-crm') . '</a>';
        }
        return array_merge($links, $row_meta);
    }

    return (array)$links;
}
