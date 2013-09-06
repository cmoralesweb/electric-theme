<?php

class Electric_Availability_Widget extends WP_Widget {

    public $textdomain = "electric_availability";

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array('classname' => 'electric-availability-widget', 'description' => __('A widget to display your availability to accept new jobs', $this->textdomain));
        parent::__construct('electric_availability_widget', __('Electric Availability Widget', $this->textdomain), $widget_ops);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);
        $options = get_option('electric_availability_options');
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if (!empty($title))
            echo $before_title . esc_attr($title) . $after_title;

        switch ($options['status_field']) {
            case "low":
            $status_text = wp_kses_data($options['low_level_text']);
            $status_short_text = __('Low', $this->textdomain);
            break;
            case "med":
            $status_text = wp_kses_data($options['med_level_text']);
            $status_short_text = __('Medium', $this->textdomain);
            break;
            case "high":
            $status_text =  wp_kses_data($options['high_level_text']);
            $status_short_text = __('High', $this->textdomain);
            break;
            default:
            echo "There has been an error";
            break;
        }
        ?>
        <div class="widget-content">
            <div class="availability">
                <p class="availability-level <?php echo esc_attr($options['status_field']) ?>">
                    <a href="<?php echo esc_url($options['link']) ?>" title="<?php echo __('Availability', $this->textdomain) . ": " . esc_attr($status_short_text); ?>">
                        <span class="assistive-text"><?php echo esc_html($status_short_text);?></span>
                    </a>
                </p>
            </div>
            <div class="tooltip-container">
                <?php
                echo $status_text;
                ?>
            </div>
        </div>
        <?php
        echo $after_widget;
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
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['status'] = esc_attr($new_instance['status']);
        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Availability', $this->textdomain);
        }
        ?>

        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        <?php
    }

}

function electric_availability_register_widget() {
    register_widget('electric_availability_widget');
}

add_action('widgets_init', 'electric_availability_register_widget');