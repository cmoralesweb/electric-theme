<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
if (!function_exists('electric_content_nav')) :

    /**
     * Display navigation to next/previous pages when applicable
     *
     * @since Electric Theme 1.0
     */
function electric_content_nav($nav_id) {
    global $wp_query, $post;

        // Don't print empty markup on single pages if there's nowhere to navigate.
    if (is_single()) {
        $previous = ( is_attachment() ) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);

        if (!$next && !$previous)
            return;
    }

        // Don't print empty markup in archives if there's only one page.
    if ($wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ))
        return;

    $nav_class = 'site-navigation paging-navigation';
    if (is_single())
        $nav_class = 'site-navigation post-navigation';
    ?>
    <nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
        <h1 class="assistive-text"><?php _e('Post navigation', 'electric'); ?></h1>

        <?php if (is_single()) : // navigation links for single posts  ?>

        <?php previous_post_link('<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'electric') . '</span> %title'); ?>
        <?php next_post_link('<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'electric') . '</span>'); ?>

    <?php elseif ($wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() )) : // navigation links for home, archive, and search pages  ?>

    <?php if (get_next_posts_link()) : ?>
    <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'electric')); ?></div>
<?php endif; ?>

<?php if (get_previous_posts_link()) : ?>
    <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'electric')); ?></div>
<?php endif; ?>

<?php endif; ?>

</nav><!-- #<?php echo $nav_id; ?> -->
<?php
}

endif; // electric_content_nav

if (!function_exists('electric_comment')) :

    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     * @since Electric Theme 1.0
     */
function electric_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type) :
    case 'pingback' :
    case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e('Pingback:', 'electric'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'electric'), ' '); ?></p>
        <?php
        break;
        default :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                <footer>
                    <div class="comment-author vcard">

                        <?php echo ($depth > 1) ? get_avatar($comment, 60) : get_avatar($comment, 80); //Smaller avatars for thread?>
                        <?php printf(__('%s <span class="says">says:</span>', 'electric'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
                    </div><!-- .comment-author .vcard -->
                    <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php _e('Your comment is awaiting moderation.', 'electric'); ?></em>
                    <br />
                <?php endif; ?>

                <div class="comment-meta commentmetadata">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><time pubdate datetime="<?php comment_time('c'); ?>">
                        <?php
                        /* translators: 1: date, 2: time */
                        printf(__('%1$s at %2$s', 'electric'), get_comment_date(), get_comment_time());
                        ?>
                    </time></a>
                    <?php edit_comment_link(__('(Edit)', 'electric'), ' ');
                    ?>
                </div><!-- .comment-meta .commentmetadata -->
            </footer>

            <div class="comment-content"><?php comment_text(); ?></div>

            <div class="reply">
                <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->

        <?php
        break;
        endswitch;
    }

    endif; // ends check for electric_comment()

    if (!function_exists('electric_posted_on')) :

        /**
         * Prints HTML with meta information for the current post-date/time and author.
         *
         * @since Electric Theme 1.0
         */
    function electric_posted_on() {
        printf(__('Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'electric'), esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s', 'electric'), get_the_author())), esc_html(get_the_author())
            );
    }

    endif;

    if (!function_exists('electric_posted_on_no_author')) :

        function electric_posted_on_no_author() {
            printf(__('<span class="posted-on">Posted on</span> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate><span class="date">%4$s</span><span class="sep">-</span><span class="month">%5$s</span><span class="sep">-</span><span class="year">%6$s</span></time></a>', 'electric'), esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date('d')), esc_html(get_the_date('m')), esc_html(get_the_date('Y'))
                );
        }

        endif;

    /**
     * Returns true if a blog has more than 1 category
     *
     * @since Electric Theme 1.0
     */
    function electric_categorized_blog() {
        if (false === ( $all_the_cool_cats = get_transient('all_the_cool_cats') )) {
            // Create an array of all the categories that are attached to posts
            $all_the_cool_cats = get_categories(array(
                'hide_empty' => 1,
                ));

            // Count the number of categories that are attached to the posts
            $all_the_cool_cats = count($all_the_cool_cats);

            set_transient('all_the_cool_cats', $all_the_cool_cats);
        }

        if ('1' != $all_the_cool_cats) {
            // This blog has more than 1 category so electric_categorized_blog should return true
            return true;
        } else {
            // This blog has only 1 category so electric_categorized_blog should return false
            return false;
        }
    }

    /**
     * Flush out the transients used in electric_categorized_blog
     *
     * @since Electric Theme 1.0
     */
    function electric_category_transient_flusher() {
        // Like, beat it. Dig?
        delete_transient('all_the_cool_cats');
    }

    add_action('edit_category', 'electric_category_transient_flusher');
    add_action('save_post', 'electric_category_transient_flusher');



    if (!function_exists('electric_get_post_thumbnail_caption')) :
        /*
         * Gets the caption for the post thumbnail (WP doesn't do it automatically)
         * http://wordpress.org/support/topic/display-caption-with-the_post_thumbnail?replies=10#post-1468414
         */

    function electric_get_post_thumbnail_caption($post_ID) {

        $thumbnail_id = get_post_thumbnail_id($post_ID);
        $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

        if ($thumbnail_image && isset($thumbnail_image[0])) {
            return $thumbnail_image[0]->post_excerpt;
        } else {
            return false;
        }
    }

    endif; //electric_get_post_thumbnail_caption

    if (!function_exists('electric_the_thumbnail')) :
    /**
     * Checks wheter the post thumbnail has a caption and displays a different html in each case
     * @param  string  $size         [description]
     * @param  boolean $show_caption [description]
     * @return [type]                [description]
     */
function electric_the_thumbnail($size = "post-thumbnail", $show_caption = true, $attr = array()) {
    global $post;
    if (($caption = electric_get_post_thumbnail_caption($post->ID)) && $show_caption) {
        ?>
        <div class="thumbnail wp-caption">
            <?php echo get_the_post_thumbnail($post->ID, $size, $attr) ?>
            <div class="wp-caption-text"><?php echo $caption ?></div>
        </div>
        <?php
    } else {
        ?>
        <div class="thumbnail"><?php echo get_the_post_thumbnail($post->ID, $size, $attr) ?></div>
        <?php
    }
}

    endif; //electric_the_thumbnail

    if (!function_exists('electric_the_notification_area')) :
        /*
         *  Shows a notification area if it's set in the theme options
         *
         */

    function electric_the_notification_area() {
        $options = get_option('electric_theme_options');
        if (isset($options['notification_text']) && !empty($options['notification_text'])) {
            ?>
            <div id="notification-area">
                <p><?php echo wp_kses_data($options['notification_text']) ?></p>

                <button type="button" name="close" id="close" >
                    <span aria-hidden="true" data-icon="&#x2612;"></span>
                    <span class="assistive-text">
                        <?php _e('Close', 'electric') ?>
                    </span>
                </button>
                </div><?php
            }
        }

endif; //electric_the_notification_area

if (!function_exists('electric_the_title')) :
    /*
     * Displays the title and subtitle (if there is one)
     */

function electric_the_title() {
    if (is_page()) {
        $title_class = "page-title";
    } else {
        $title_class = "entry-title";
    }
    ?>
    <div class="title-group">
        <h1 class="<?php echo $title_class; ?>"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'electric'), the_title_attribute('echo=0'))); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php
                //Show subtitle if it's set
        if ($subtitle = wp_kses_data(get_post_meta(get_the_ID(), '_elth_subtitle', true))) :
            ?>
        <p class="entry-subtitle"><?php echo $subtitle ?></p>
    <?php endif; ?>
</div>
<?php
}

    endif; //electric_the_title



    if (!function_exists('electric_display_tags')) :
        /*
         * Displays the post tags
         */

    function electric_display_tags($tag_number = 4, $display_text = false) {
        if ('post' == get_post_type()) {
                //// Hide category and tag text for pages
            $tags_list = get_the_tags();
            if ($tags_list) {
                if ($tag_number > 0) {
                    if (count($tags_list) > $tag_number) {
                        $tags_list = array_slice($tags_list, 0, $tag_number);
                    }
                }
                ?>
                <div class="tag-links-wrapper">
                    <p>
                        <?php
                        if ($display_text) {
                            ?>
                            <?php _e('Tags: ', 'electric') ?>
                            <?php
                        }
                        $tag_count = 1;
                        foreach ($tags_list as $tag) {
                            echo '<a rel="tag" title="' . __('View more posts tagged with: ', 'electric') . '' . esc_attr($tag->name) . '" href="' . esc_url(get_tag_link($tag->term_id)) . '">' . $tag->name . '</a> ';
                            if ($tag_count < count($tags_list)) {
                                echo '<span class="sep"> | </span>';
                            }
                            $tag_count++;
                        }
                        ?>
                    </p>
                </div>

                <?php
                } // End if $tags_list
            } // End if 'post' == get_post_type()
        }

    endif; //electric_display_tags



 if (!function_exists('electric_gog_analytics')) :

        /*
         * Displays Google Analytics tracking code if it's set in the theme's options
         */

function electric_gog_analytics() {
        $theme_options = get_option('electric_theme_options');
        if (!empty($theme_options['google_analytics'])):
            if (!is_admin()):
                ?>
            <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo esc_js($theme_options['google_analytics']) ?>']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

            </script>

            <?php
            endif;
            endif;
        }

 endif;

if (!function_exists('electric_the_description')) :
        /*
         * Displays the tagline set in the theme's options or WP description if it's not set
         */

    function electric_the_description() {
        $theme_options = get_option('electric_theme_options');
        if (!empty($theme_options['tagline'])):
          echo wp_kses_data($theme_options['tagline']);
          else:
           bloginfo('description');
       endif;
}

endif;


if (!function_exists('electric_the_custom_title')) :

/**
 * Displays a custom title if set in the theme options. Otherwise, displays the Blog title
 */
    function electric_the_custom_title() {
        $theme_options = get_option('electric_theme_options');
        if (!empty($theme_options['custom_title'])):
          echo wp_kses_data($theme_options['custom_title']);
          else:
           bloginfo('name');
       endif;
}

endif;


if (!function_exists('electric_the_logo')) :

/**
 * Displays a custom title if set in the theme options. Otherwise, displays the Blog title
 */
    function electric_the_logo() {
        $theme_options = get_option('electric_theme_options');
        if (!empty($theme_options['use_logo_image']) && !empty($theme_options['logo_image'])):?>
         <img src="<?php echo esc_url($theme_options['logo_image']) ?>" alt="<?php echo esc_attr(get_bloginfo('name')) ?>">
       <?php endif;
}

endif;


if ( !function_exists('electric_get_tweet')) {
    /*
    Get raw twitter data from post meta data
     */
    function electric_get_tweet($post_ID) {
        $raw_tweet = json_decode(get_post_meta( $post_ID, '_aktt_tweet_raw_data', true ));
        return $raw_tweet;
    }
}

if ( !function_exists('electric_the_twitter_avatar')) {
    /*
    Displays twitter avatar
     */
    function electric_the_twitter_avatar($raw_tweet) {
        ?>
        <img class="twitter-avatar" src="<?php echo esc_url($raw_tweet->user->profile_image_url_https)?>" alt="<?php echo esc_attr($raw_tweet->user->name)?>">
        <?php
    }
}

if ( !function_exists('electric_the_twitter_meta')) {
    /*
    Displays tweet meta
     */
    function electric_the_twitter_meta($raw_tweet) {
        ?>
        <div class="twitter-meta">
             <a href="<?php echo esc_url( AKTT::status_url($raw_tweet->user->screen_name, $raw_tweet->id)) ?>" title="<?php _e('View original in Twitter', 'electric') ?>">
                <?php echo gmdate('l, m-d-Y, H:i', strtotime($raw_tweet->created_at )) ?>
            </a>

             <?php if ( $raw_tweet->in_reply_to_status_id ): ?>
             <p class="reply-to">
                 <?php _e('In reply to:', 'electric') ?> <a href="<?php echo esc_url( AKTT::status_url($raw_tweet->in_reply_to_screen_name, $raw_tweet->in_reply_to_status_id)) ?>"><?php echo $raw_tweet->in_reply_to_screen_name?></a>
             </p>

             <?php endif ?>
        </div>
        <?php
    }
}

if ( !function_exists('electric_the_related_posts')) {
    function electric_the_related_posts($post_ID){
        /*
         * Display related posts
         */
        if (!is_search() && !is_archive()) {
            $tags = wp_get_post_tags($post_ID);
            if ($tags) {
                        //Store tags in an array to later create a query
                $tags_list = array();
                foreach ($tags as $tag) {
                    $tags_list[] = $tag->term_id;
                }
                $args = array(
                              'tag__in' => $tags_list,
                            'post__not_in' => array($post_ID), //Exclude the current post
                            'showposts' => 5,
                            'ignore_sticky_posts' => 1
                            );
                $args = apply_filters('electric_related_articles_args', $args);
                $my_query = new WP_Query($args);
                if ($my_query->have_posts()) {
                    ?>
                    <aside class="related-articles slider-container">
                        <h1><?php _e('Related articles:', 'electric') ?></h1>
                        <div class="flexslider">
                            <ul class="slides">
                                <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                <li>
                                    <h2 class="entry-title">  <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'electric'), the_title_attribute('echo=0'))); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                    <?php if (has_post_thumbnail()): ?>
                                    <div class="thumbnail">
                                        <?php the_post_thumbnail('thumbnail') ?>
                                    </div>
                                    <?php endif; ?>
                                <?php echo get_the_excerpt(); ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </aside>
            <?php
        }
        }
        wp_reset_postdata();
        }
    }
}