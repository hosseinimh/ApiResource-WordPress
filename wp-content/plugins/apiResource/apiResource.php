<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wp-api-resoure.hosseinimh.com
 * @since             1.0.0
 * @package           ApiResource
 *
 * @wordpress-plugin
 * Plugin Name:       API Resource
 * Plugin URI:        http://wp-api-resource.hosseinimh.com/
 * Description:       This plugin fetch books and categories data with REST API.
 * Version:           1.0.0
 * Author:            Mahmoud Hosseini
 * Author URI:        http://hosseinimh.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       apiResource
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 */
define('API_RESOURCE_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/ApiResourceActivator.php
 */
function activateApiResource()
{
    require_once plugin_dir_path(__FILE__) . 'includes/ApiResourceActivator.php';

    ApiResourceActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/ApiResourceDeactivator.php
 */
function deactivateApiResource()
{
    require_once plugin_dir_path(__FILE__) . 'includes/ApiResourceDeactivator.php';

    ApiResourceDeactivator::deactivate();
}

register_activation_hook(__FILE__, 'activateApiResource');
register_deactivation_hook(__FILE__, 'deactivateApiResource');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/ApiResource.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function runApiResource()
{

    $apiResource = new ApiResource();

    $apiResource->run();
}

runApiResource();
