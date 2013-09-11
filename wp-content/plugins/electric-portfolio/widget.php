<?php
class Electric_Featured_Works_Widget extends WP_Widget {

    protected $textdomain = "electric-portfolio";
    protected $widget_style_options = array();

    function Electric_Featured_Works_Widget() {
        $widget_ops = array(
                            'classname' => 'electric-featured-works',
                            'description' => __("Shows portfolio works in a slider", $this->textdomain)
                            );
        parent::WP_Widget('electric-featured-works', __("Electric Featured Works", $this->textdomain), $widget_ops);
        $this->widget_style_options = array(
                                            'frontpage' => __('Frontpage', $this->textdomain),
                                            'small_widget' => __('Small widget', $this->textdomain)
                                            );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('electric-featured-works', $instance['title']);
        $widget_query = new WP_Query(array(
                                     "posts_per_page" => 4,
                                     "post_type" => "electric_portfolio",
                                     "orderby" => "menu_order"
                                     ));
        if ($widget_query->have_posts()) {
            ?>
            <?php if ( $instance['widget_style'] == 'small_widget' ): ?>
            <?php echo $before_widget;
            if (!empty($title))
                echo $before_title . esc_attr($title) . $after_title; ?>
            <div class="widget-content">
            <?php endif; ?>
            <div class="portfolio-showcase <?php echo $instance['widget_style'] ? $instance['widget_style'] : ''?>">
                <div class="flexslider">
                    <ul class="slides">
                        <?php
                        while ($widget_query->have_posts()) {
                            $widget_query->the_post();
                            ?>
                            <li>
                                <a href="<?php the_permalink() ?>" title="<?php _e('More about', $this->textdomain) ?>: <?php the_title() ?>">
                                    <div>
                                        <div class="portfolio-image"><?php the_post_thumbnail('home-featured'); ?></div>
                                        <div class="flex-caption">
                                            <h2 class="caption-title"><?php the_title() ?></h2>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php }
                            $widget_query->rewind_posts();
                            ?>
                        </ul>
                    </div>
                    <?php if ( $instance['widget_style'] == 'frontpage' ): ?>
                    <ol class="thumbs">
                        <?php
                        while ($widget_query->have_posts()) {
                            $widget_query->the_post();
                            ?>
                            <li>
                                <a>
                                    <?php the_post_thumbnail('home-featured-thumb'); ?>
                                </a>
                            </li>
                            <?php }
                            ?>
                        </ol>
                    <?php endif; ?>
                </div>
                <?php if ( $instance['widget_style'] == 'small_widget' ): ?>
            </div>
            <?php echo $after_widget; ?>
        <?php endif; ?>
        <?php
    }
        //If we don't have any results, just don't show anything
    wp_reset_postdata();
}

function update($new_instance, $old_instance) {
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    $instance['widget_style'] = esc_attr($new_instance['widget_style']);

    return $instance;
}

function form($instance) {
    if (!empty($instance['title'])) {
        $title = esc_attr($instance['title']);
    } else {
        $title = "";
    }
    if (!empty($instance['widget_style'])) {
        $widget_style = esc_attr($instance['widget_style']);
    } else {
        $widget_style = 'frontpage';
    }
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('title') ?>"><?php _e( 'Title', $this->textdomain ) ?>:
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text"
            value="<?php echo $title ?>" />
        </label>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('widget_style') ?>"><?php _e( 'Widget style', $this->textdomain ) ?>:</label>
        <select name="<?php echo $this->get_field_name('widget_style') ?>" id="<?php echo $this->get_field_id('widget_style') ?>">
            <?php foreach ($this->widget_style_options as $option_value => $option_text): ?>
            <option value="<?php echo esc_attr( $option_value ) ?>" <?php selected( $widget_style, esc_attr( $option_value ), true ) ?>><?php echo $option_text ?></option>
        <?php endforeach ?>
    </select>

</p>
<?php
}

}

add_action( 'widgets_init', create_function( '', "register_widget( 'Electric_Featured_Works_Widget' );" ) );
