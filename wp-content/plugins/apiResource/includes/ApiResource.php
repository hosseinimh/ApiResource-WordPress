<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://hosseinimh.com
 * @since      1.0.0
 *
 * @package    ApiResource
 * @subpackage ApiResource/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ApiResource
 * @subpackage ApiResource/includes
 * @author     Mahmoud Hosseini <hosseinimh@gmail.com>
 */
class ApiResource
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      ApiResourceLoader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The remote url of REST API resource.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $remoteUrl    The remote url of REST API resource.
     */
    private $remoteUrl;

    /**
     * The fetcher that's responsible for fetching data from REST API resource.
     *
     * @since    1.0.0
     * @access   private
     * @var      ApiResourceFetcher    $fetcher    Maintains and registers all hooks for the plugin.
     */
    private $fetcher;

    /**
     * The widget that's responsible for presenting data from REST API resource to the user.
     *
     * @since    1.0.0
     * @access   private
     * @var      ApiResourceWidget    $widget    Presents data from REST API resource to the user.
     */
    private $widget;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $pluginName    The string used to uniquely identify this plugin.
     */
    protected $pluginName;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('API_RESOURCE_VERSION')) {
            $this->version = API_RESOURCE_VERSION;
        } else {
            $this->version = '1.0.0';
        }

        $this->pluginName = 'apiResource';
        $this->remoteUrl = 'http://127.0.0.1:8000/api';

        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePublicHooks();
        $this->setFetcher();
        $this->createWidget();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - ApiResourceLoader. Orchestrates the hooks of the plugin.
     * - ApiResourceI18n. Defines internationalization functionality.
     * - ApiResourceAdmin. Defines all hooks for the admin area.
     * - ApiResourcePublic. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function loadDependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ApiResourceLoader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ApiResourceI18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/ApiResourceAdmin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/ApiResourcePublic.php';

        /**
         * The class responsible for fetching data from REST API resource.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ApiResourceFetcher.php';

        /**
         * The class responsible for presenting data from REST API resource to the user.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ApiResourceWidget.php';

        $this->loader = new ApiResourceLoader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the ApiResourceI18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setLocale()
    {

        $pluginI18n = new ApiReourceI18n();

        $this->loader->addAction('plugins_loaded', $pluginI18n, 'loadPluginTextdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineAdminHooks()
    {

        $pluginAdmin = new ApiResourceAdmin($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('admin_enqueue_scripts', $pluginAdmin, 'enqueueStyles');
        $this->loader->addAction('admin_enqueue_scripts', $pluginAdmin, 'enqueueScripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function definePublicHooks()
    {

        $pluginPublic = new ApiResourcePublic($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('wp_enqueue_scripts', $pluginPublic, 'enqueueStyles');
        $this->loader->addAction('wp_enqueue_scripts', $pluginPublic, 'enqueueScripts');
    }

    /**
     * Set fetcher for REST API resource.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setFetcher()
    {

        $this->fetcher = new ApiResourceFetcher($this->remoteUrl);
    }

    /**
     * Create widget for REST API resource.
     *
     * @since    1.0.0
     * @access   private
     */
    private function createWidget()
    {

        $this->widget = new ApiResourceWidget();

        // Register ApiResourceWidget widget
        add_action('widgets_init', function () {
            register_widget('ApiResourceWidget');
        });
        // $this->loader->addAction('widgets_init', $this, 'registerApiResourceWidget');
        //add_action('widgets_init', 'registerApiResourceWidget');
    }

    /**
     * Registers a widget for REST API resource.
     *
     * @since    1.0.0
     * @access   private
     */
    public function registerApiResourceWidget()
    {
        register_widget($this->widget);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    ApiResourceLoader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }
}