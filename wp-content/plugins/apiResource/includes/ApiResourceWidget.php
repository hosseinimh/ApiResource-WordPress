<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://hosseinimh.com
 * @since      1.0.0
 *
 * @package    ApiResource
 * @subpackage ApiResource/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    ApiResource
 * @subpackage ApiResource/includes
 * @author     Mahmoud Hosseini <hosseinimh@gmail.com>
 */
class ApiResourceWidget extends WP_Widget
{

    /**
     * The fetcher that's responsible for fetching data from REST API resource.
     *
     * @since    1.0.0
     * @access   private
     * @var      ApiResourceFetcher    $fetcher    Maintains and registers all hooks for the plugin.
     */
    private $fetcher;

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'api_resource_widget', // Base ID
            'API_Resource_Widget_name', // Name
            array('description' => __('API Resource Widget', 'apiResource'),) // Args
        );

        // $this->fetcher = $fetcher;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $url = 'http://127.0.0.1:8000/api';
        $fetcher = new ApiResourceFetcher($url);
        $books = $fetcher->fetchBooks();
        $count = $books ? count($books) : 0;

        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        echo __('Hello, World! ' . $count, 'apiResource');
        echo $after_widget;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'text_domain');
        }
?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
<?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
} // class ApiResourceWidget