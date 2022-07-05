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

        $this->pluginName = 'ApiResource';

        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePublicHooks();
        $this->createWidget();
        $this->createShortCode();
        $this->setEntriesPage();
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

    /**
     * Returns the url of REST API resource.
     *
     * @since     1.0.0
     * @return    string    The url of REST API resource.
     */
    public static function getRestApiUrl()
    {
        $url = 'http://127.0.0.1:8000/api';
        $widget = get_option('widget_api_resource_widget');

        if ($widget && is_array($widget)) {
            foreach ($widget as $key => $value) {
                if (is_array($value) && !empty($value['url'])) {
                    $url = $value['url'];
                }
            }
        }

        return $url;
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
     * Create widget for REST API resource.
     *
     * @since    1.0.0
     * @access   private
     */
    private function createWidget()
    {
        $widget = new ApiResourceWidget();

        // Register ApiResourceWidget widget
        add_action('widgets_init', function () {
            register_widget('ApiResourceWidget');
        });
    }

    /**
     * Create shortcode for REST API resource.
     * [api_resource_entries]
     *
     * @since    1.0.0
     * @access   private
     */
    private function createShortCode()
    {
        add_shortcode('api_resource_entries', function () {
            $url = ApiResource::getRestApiUrl();
            $fetcher = new ApiResourceFetcher($url);

            $books = $fetcher->fetchBooks();
            $result = '<ul>';

            if ($books && is_array($books) && count($books) > 0) {
                foreach ($books as $book) {
                    $result .= '<li>' . $book->name . '</li>';
                }
            }

            $result .= '</ul>';

            return $result;
        });
    }

    /**
     * Creates or updates detailed page for entries fetched from REST API resource.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setEntriesPage()
    {
        $title = 'Entries details';
        $page = get_page_by_title($title, 'OBJECT', 'page');
        $entriesContent = $this->createEntriesContent();

        if (empty($page)) {
            $postDetails = [
                'post_title'    => $title,
                'post_content'  => $entriesContent,
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type' => 'page'
            ];

            wp_insert_post($postDetails);
        } else {
            add_filter('the_content', function ($content) use ($page, $entriesContent) {
                if (is_page($page->ID)) {
                    $content = $entriesContent;
                }

                return $content;
            });
        }
    }

    /**
     * Creates content with entries fetched from REST API resource.
     *
     * @since    1.0.0
     * @access   private
     */
    private function createEntriesContent()
    {
        $url = ApiResource::getRestApiUrl();
        $fetcher = new ApiResourceFetcher($url);

        $books = $fetcher->fetchBooks();
        $content = '<ul>';

        if ($books && is_array($books) && count($books) > 0) {
            foreach ($books as $book) {
                $content .= '<li>' . $book->name . '<span style="margin-left:30px; color: #6d6d6d; font-size: 0.8em;">' . $book->categoryTite . '</span></li>';
                $content .= '<img src="' . $book->image . '" style="width: 100px;" />';
                $content .= '<blockquote class="wp-block-quote">' . $book->description . '</blockquote>';
                $content .= '<p>' . $book->extraInfo . '</p>';
                $content .= '<p style="font-size: 0.8em; margin-bottom: 50px;">' . $book->tagsText . '</p>';
            }
        }

        $content .= '</ul>';

        return $content;
    }
}
