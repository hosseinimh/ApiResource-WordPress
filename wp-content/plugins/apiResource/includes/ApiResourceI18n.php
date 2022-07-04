<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://hosseinimh.com
 * @since      1.0.0
 *
 * @package    ApiReource
 * @subpackage ApiReource/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    ApiReource
 * @subpackage ApiReource/includes
 * @author     Mahmoud Hosseini <hosseinimh@gmail.com>
 */
class ApiReourceI18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function loadPluginTextdomain()
    {

        load_plugin_textdomain(
            'apiResource',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
