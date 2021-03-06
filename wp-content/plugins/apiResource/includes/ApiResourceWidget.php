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
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'api_resource_widget', // Base ID
            'API Resource Widget', // Name
            array('description' => __('Fecthed list of entries', 'apiResource'),) // Args
        );
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
        $fetcher = new ApiResourceFetcher($instance['url']);
        $books = $fetcher->fetchBooks();
        $count = $books ? count($books) : 0;

        extract($args);
        $title = 'Number of entries:';

        echo $before_widget;
        echo $before_title . $title . $after_title;
        echo __($count . ' books', 'apiResource');
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
        if (isset($instance['url'])) {
            $url = $instance['url'];
        } else {
            $url = __(ApiResource::getRestApiUrl(), 'apiResource');
        }
?>
        <p>
            <label for="<?php echo $this->get_field_name('url'); ?>"><?php _e('API url:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
        </p>
<?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $newInstance Values just sent to be saved.
     * @param array $oldInstance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($newInstance, $oldInstance)
    {
        $instance = array();
        $instance['url'] = (!empty($newInstance['url'])) ? strip_tags($newInstance['url']) : '';

        return $instance;
    }
} // class ApiResourceWidget