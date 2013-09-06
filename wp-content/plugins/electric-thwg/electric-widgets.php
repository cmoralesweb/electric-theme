<?php
/*
  Plugin Name: Electric Widgets
  Description: Widgets for the Electric Theme.
  Author: Carlos Morales
  Author URI: http://www.cmorales.es
  Version: 0.4
 */

/*
 * Ephemera widget, based on the one included with TwentyEleven...
 */

class Electric_Ephemera_Widget extends WP_Widget {
    /*
     * From Twentyeleven original widget
     */

    private function electric_thwg_url_grabber() {
        if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches))
            return false;

        return esc_url_raw($matches[1]);
    }

    /**
     * Constructor
     *
     * @return void
     * */
    function Electric_Ephemera_Widget() {
        $widget_ops = array('classname' => 'electric-ephemera-widget', 'description' => __('A widget for your "short" content: aside, status, links...', 'electric_thwg'));
        $this->WP_Widget('electric_ephemera_widget', __('Electric Ephemera', 'electric_thwg'), $widget_ops);
        $this->alt_option_name = 'electric_ephemera_widget';

        add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('deleted_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array An array of standard parameters for widgets in this theme
     * @param array An array of settings for this widget instance
     * @return void Echoes it's output
     * */
    function widget($args, $instance) {
        $cache = wp_cache_get('electric_ephemera_widget', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = null;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args, EXTR_SKIP);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Ephemera', 'electric_thwg') : $instance['title'], $instance, $this->id_base);

        if (!isset($instance['number']))
            $instance['number'] = '5';

        if (!$number = absint($instance['number']))
            $number = 5;

        $ephemera_args = array(
                               'order' => 'DESC',
                               'posts_per_page' => $number,
                               'no_found_rows' => true,
                               'post_status' => 'publish',
                               'post__not_in' => get_option('sticky_posts'),
                               'tax_query' => array(
                                                    array(
                                                          'taxonomy' => 'post_format',
                                                          'terms' => array('post-format-aside', 'post-format-link', 'post-format-status', 'post-format-quote'),
                                                          'field' => 'slug',
                                                          'operator' => 'IN',
                                                          ),
                                                    ),
                               );

        $ephemera_args = apply_filters('electric_ephemera_args', $ephemera_args);
        $ephemera = new WP_Query($ephemera_args);

        if ($ephemera->have_posts()) :

            echo $before_widget;
        echo $before_title;
            echo $title; // Can set this with a widget option, or omit altogether
            echo $after_title;
            ?>
            <div class="widget-content slider-container">
                <div class="flexslider">
                    <ul class="slides">
                        <?php while ($ephemera->have_posts()) : $ephemera->the_post(); ?>

                        <?php if ('link' != get_post_format()) : ?>
                        <?php if ('status' == get_post_format()) : ?>
                        <li class="widget-entry-title">
                            <?php the_content(); ?>
                            <p class="comments-link">
                                <?php comments_popup_link(__('0 <span class="reply">comments &rarr;</span>', 'electric_thwg'), __('1 <span class="reply">comment &rarr;</span>', 'electric_thwg'), __('% <span class="reply">comments &rarr;</span>', 'electric_thwg')); ?>
                            </p>
                        </li>

                    <?php else : ?>
                    <li class="widget-entry-title">
                        <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'electric_thwg'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_excerpt(); ?></a>
                        <p class="comments-link">
                            <?php comments_popup_link(__('0 <span class="reply">comments &rarr;</span>', 'electric_thwg'), __('1 <span class="reply">comment &rarr;</span>', 'electric_thwg'), __('% <span class="reply">comments &rarr;</span>', 'electric_thwg')); ?>
                        </p>
                    </li>

                <?php endif; ?>

            <?php else : ?>

            <li class="widget-entry-title">
                <?php
                                    // Grab first link from the post content. If none found, use the post permalink as fallback.
                $link_url = $this->electric_thwg_url_grabber();

                if (empty($link_url))
                    $link_url = get_permalink();
                ?>
                <a href="<?php echo esc_url($link_url); ?>" title="<?php printf(esc_attr__('Link to %s', 'electric_thwg'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?>&nbsp;<span>&rarr;</span></a>
                <p class="comments-link">
                    <?php comments_popup_link(__('0 <span class="reply">comments &rarr;</span>', 'electric_thwg'), __('1 <span class="reply">comment &rarr;</span>', 'electric_thwg'), __('% <span class="reply">comments &rarr;</span>', 'electric_thwg')); ?>
                </p>
            </li>

        <?php endif; ?>

    <?php endwhile; ?>
</ul>
</div>
</div>
<?php
echo $after_widget;

// Reset the post globals as this query will have stomped on it
wp_reset_postdata();

// end check for ephemeral posts
endif;

$cache[$args['widget_id']] = ob_get_flush();
wp_cache_set('electric_ephemera_widget', $cache, 'widget');
}

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     * */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['electric_ephemera_widget']))
            delete_option('electric_ephemera_widget');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('electric_ephemera_widget', 'widget');
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     * */
    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 10;
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'electric_thwg'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

            <p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of posts to show:', 'electric_thwg'); ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
                <?php
            }

        }

/**
 * Recent_Posts widget class, based on WP default. Shows the excerpt.
 *
 */
class Electric_Recent_Posts extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'electric-recent-entries', 'description' => __("The most recent posts on your site, including their excerpt.", 'electric_thwg'));
        parent::__construct('electric-recent-posts', __('Electric Recent Posts'), $widget_ops);
        $this->alt_option_name = 'electric_recent_entries';

        add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('deleted_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('electric_recent_posts', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 5;

        $query_args = array(
                            'posts_per_page' => $number,
                            'tax_query' => array(
                                                 array(
                                                       'taxonomy' => 'post_format',
                                                       'field' => 'slug',
                                                       'terms' => array('post-format-aside', 'post-format-link',
                        'post-format-status', 'post-format-quote'), //Short posts are excluded by default
                                                       'operator' => 'NOT IN'
                                                       )
                                                 ),
                            'no_found_rows' => true,
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => true
                            );
        $query_args = apply_filters('electric_recent_query_args', $query_args);
        $r = new WP_Query($query_args);
        if ($r->have_posts()) :
//            remove_filter('the_content', 'sharing_display', 19);
//            remove_filter('the_excerpt', 'sharing_display', 19);
            ?>

        <?php echo $before_widget; ?>
        <?php if ($title) echo $before_title . $title . $after_title; ?>
        <div class="widget-content slider-container">
            <div class="flexslider">
                <ul class="slides">
                    <?php while ($r->have_posts()) : $r->the_post(); ?>
                    <li>
                        <h2 class="entry-title">
                            <a href="<?php esc_attr(the_permalink()) ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
                                <?php echo get_the_title() ? the_title() : the_ID(); ?>
                            </a>
                        </h2>
                        <?php echo get_the_excerpt(); ?>
                        <a class="more-link" href="<?php esc_attr(the_permalink()) ?>">
                            <?php _e('Read more ', 'electric_thwg')?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php echo $after_widget; ?>
    <?php
// Reset the global $the_post as this query will have stomped on it
    wp_reset_postdata();

    endif;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('electric_recent_posts', $cache, 'widget');
}

function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['number'] = (int) $new_instance['number'];
    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');
    if (isset($alloptions['electric_recent_entries']))
        delete_option('electric_recent_entries');

    return $instance;
}

function flush_widget_cache() {
    wp_cache_delete('electric_recent_posts', 'widget');
}

function form($instance) {
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $number = isset($instance['number']) ? absint($instance['number']) : 5;
    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
            <?php
        }

    }

/**
 * Electric_Recent_Comments widget class, based on WP default. Shows a bit more info.
 *
 */
class Electric_Recent_Comments extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'electric-recent-comments', 'description' => __('The most recent comments, including nice avatars.'));
        parent::__construct('electric-recent-comments', __('Electric Recent Comments', 'electric_thwg'), $widget_ops);
        $this->alt_option_name = 'electric_recent_comments';


        add_action('comment_post', array(&$this, 'flush_widget_cache'));
        add_action('transition_comment_status', array(&$this, 'flush_widget_cache'));
    }

    function flush_widget_cache() {
        wp_cache_delete('electric_recent_comments', 'widget');
    }

    function widget($args, $instance) {
        global $comments, $comment;

        $cache = wp_cache_get('electric_recent_comments', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }



        extract($args, EXTR_SKIP);
        $output = '';
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title'], $instance, $this->id_base);

        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 5;

        $comments = get_comments(apply_filters('electric_comments_args', array('number' => $number, 'status' => 'approve', 'post_status' => 'publish')));
        $output .= $before_widget;
        if ($title)
            $output .= $before_title . $title . $after_title;



        if ($comments) {
            $output .= '<div class="widget-content slider-container">';
            $output .= '<div class="flexslider">';
            $output .= '<ul class="recent-comments slides">';
            foreach ((array) $comments as $comment) {
                $content = strip_tags($comment->comment_content);
                if (strlen($content) > 150) {
                    $content = substr($content, 0, 150) . '...';
                }
                $output .= '<li class="comment">'
                . '<div class="comment-author">' . get_avatar($comment, 68) .
                get_comment_author_link() .
                '</div>' .
                '<div class="posted-in">' .
                __('in: ', 'electric_thwg') .
                '<a href="' . esc_url(get_permalink($comment->comment_post_ID )) . '">' .
                get_the_title($comment->comment_post_ID) .
                '</a>
                </div>' .
                '<p class="comment-content">' . $content . '</p>
                <a class="more-link" href="' . esc_url(get_comment_link($comment->comment_ID)) . '">'
                .__('Read more ', 'electric_thwg') .'
                </a>
                </li>';
            }
            $output .= '</ul>';
            $output .= '</div>'; //Flexslider div
            $output .= '</div>'; //widget-content div
        } else {
            $output .= '<p>' . __('No recent comments', 'electric_thwg') . '</p>';
        }

        $output .= $after_widget;

        echo $output;
        $cache[$args['widget_id']] = $output;
        wp_cache_set('electric_recent_comments', $cache, 'widget');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = absint($new_instance['number']);
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['electric_recent_comments']))
            delete_option('electric_recent_comments');

        return $instance;
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:'); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
                <?php
            }

        }

/**
 * new WordPress Widget format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Electric_Twitter_Posts_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function Electric_Twitter_Posts_Widget() {
        $widget_ops = array( 'classname' => 'electric-twitter-posts', 'description' => 'Displays your tweets as posts, relies on Twitter Tools plugin' );
        $this->WP_Widget( 'electric-twitter-posts', 'Electric Twitter Posts', $widget_ops );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $query_args = array(
                            'post_type' => 'aktt_tweet'
                            );
        $tweets = new WP_Query($query_args);
        echo $before_widget;
        echo $before_title;
        echo $instance['title']; // Can set this with a widget option, or omit altogether
        echo $after_title;
        ?>
        <?php if ( $tweets->have_posts()): ?>
        <div class="widget-content slider-container">
            <div class="flexslider">
                <ul class="recent-comments slides">
                    <?php while ( $tweets->have_posts() ): $tweets->the_post() ;?>
                    <li>
                     <?php the_content(); ?>
                     <a class="more-link" href="<?php esc_attr(the_permalink()) ?>">
                            <?php _e('Read more ', 'electric_thwg')?>
                        </a>
                 </li>
             <?php endwhile; ?>
         </ul>
     </div>
 </div>
<?php endif ?>
<?php

echo $after_widget;
}

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/
    function update( $new_instance, $old_instance ) {

        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'number_of_posts' => 5, 'title' => "Twitter Posts" ) );
        $num_posts = esc_attr($instance['number_of_posts']);
        $title = esc_attr($instance['title']);
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p>
                <label for="<?php echo $this->get_field_id('number_of_posts'); ?>"><?php _e('Number of Posts:', 'electric_thwg' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('number_of_posts'); ?>" name="<?php echo $this->get_field_name('number_of_posts'); ?>" type="text" value="<?php echo $num_posts; ?>" />
            </p>
            <?php
        }
    }


    function electric_register_widgets() {
        register_widget("electric_recent_posts");
        register_widget("electric_ephemera_widget");
        register_widget("electric_recent_comments");
        register_widget( 'Electric_Twitter_Posts_Widget' );
    }

    add_action('widgets_init', 'electric_register_widgets');