<?php

/**
 * Custom functions that act independently of the theme templates. Filters and action hooks.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Electric Theme 1.0
 */
function electric_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}

add_filter('wp_page_menu_args', 'electric_page_menu_args');

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Electric Theme 1.0
 */
function electric_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    return $classes;
}



add_filter('body_class', 'electric_body_classes');

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Electric Theme 1.0
 */
function electric_enhanced_image_navigation($url, $id) {
    if (!is_attachment() && !wp_attachment_is_image($id))
        return $url;

    $image = get_post($id);
    if (!empty($image->post_parent) && $image->post_parent != $id)
        $url .= '#main';

    return $url;
}

add_filter('attachment_link', 'electric_enhanced_image_navigation', 10, 2);

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Electric Theme 1.1
 */
function electric_wp_title($title, $sep) {
    global $page, $paged;

    if (is_feed())
        return $title;

    // Add the blog name
    $title .= get_bloginfo('name');

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() ))
        $title .= " $sep $site_description";

    // Add a page number if necessary:
    if ($paged >= 2 || $page >= 2)
        $title .= " $sep " . sprintf(__('Page %s', 'electric'), max($paged, $page));

    return $title;
}

add_filter('wp_title', 'electric_wp_title', 10, 2);


/*
 * Adds a class to the post to check if it has a post thumb(featured image) or not
 */

function electric_thumb_post_class($classes) {
    global $post;
    if (has_post_thumbnail($post->ID)) {
        $classes[] = 'with-thumb';
    } else {
        $classes[] = 'no-thumb';
    }
    return $classes;
}

add_filter('post_class', 'electric_thumb_post_class');


/*
 * Shorter excerpt
 */

function electric_custom_excerpt_length($length) {
    return 25;
}

add_filter('excerpt_length', 'electric_custom_excerpt_length', 999);



/*
 * Exclude the aside post formats from the main loop if it's checked in the theme options
 */

function electric_exclude_aside_loop($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    if (is_home()) {
        $theme_options = get_option('electric_theme_options');
        $exclude = array(
                         'post-format-aside',
                         'post-format-link',
                         'post-format-status',
                         'post-format-quote',
                         'post-format-image'
        ); //Which posts to exclude

        $exclude = apply_filters('electric_exclude_aside', $exclude); //Hook to change which post format to exclude
        if (!empty($theme_options['exclude_asides'])) {
            $tax_query = array(array(
                               'taxonomy' => 'post_format',
                               'field' => 'slug',
                               'terms' => $exclude,
                               'operator' => 'NOT IN',
                               ));
            $query->set('tax_query', $tax_query);
            return;
        }
    }
}

add_action('pre_get_posts', 'electric_exclude_aside_loop', 1);


/***-------------------***/
/**--Add subtitle as a custom field box ---*/
/***-------------------***/

 /*
 Render the custom field box
  */
 function electric_custom_subtitle_render() {
    global $post;
    $prefix = "elth";
    //If there are custom fields already defined, get the current values:
    $custom = get_post_custom($post->ID);
    $subtitle = isset($custom["_". $prefix ."_subtitle"][0]) ? $custom["_". $prefix ."_subtitle"][0] : "";

    ?>
    <?php wp_nonce_field($prefix ."subtitle_nonce_render", $prefix ."subtitle_nonce") ?>
    <p class="description"><?php _e('You can add a nice, longer subtitle to your entries:', 'electric')?></p>
    <p>
        <label><?php _e('Subtitle', 'electric') ?></label>
        <input type="text" size="45" name="_<?php echo $prefix?>_subtitle"
        value="<?php echo esc_attr($subtitle); ?>" />
    </p>

    <?php

}

/*
 * Add custom fields box
 */
function electric_add_subtitle_box(){
  add_meta_box(
    "electric_add_subtitle_box", //ID
    __('Subtitle', 'electric'), //Label
    'electric_custom_subtitle_render',//Callback
    "post", //Post type to be attached
    "normal", //Context (side of the screen)
    "high"
    );
}

/*
 * Save custom fields
 */
function electric_subtitle_save() {
    $prefix = "elth";
    global $post;
    if ($post) {
        //Make sure we only do this for this custom post type
        //(otherwise the nonce would fail, for example)
        if (get_post_type( $post ) == 'post'){
        // Bail if we're doing an auto save
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || (defined('DOING_AJAX') && DOING_AJAX) ) return;

         // if our current user can't edit this post, bail
            if( !current_user_can( 'edit_post' , $post->ID) ) return;

         //Check nonce for security
            if(check_admin_referer($prefix ."subtitle_nonce_render", $prefix ."subtitle_nonce")){
        //Now for the real thing:
                if ($_POST) {
                    update_post_meta($post->ID, "_". $prefix ."_subtitle", wp_kses_data($_POST["_". $prefix ."_subtitle"]));
                }
            }
        }
    }
}

//Add custom fields to edit view and hook save function
add_action('admin_init', 'electric_add_subtitle_box');
add_action('save_post', 'electric_subtitle_save', 10, 2);

/***-------------------***/

/* Add class to items with submenus */
function electric_add_menu_parent_class( $items ) {

    $parents = array();
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
            $parents[] = $item->menu_item_parent;
        }
    }

    foreach ( $items as $item ) {
        if ( in_array( $item->ID, $parents ) ) {
            $item->classes[] = 'menu-parent-item';
        }
    }

    return $items;
}

add_filter( 'wp_nav_menu_objects', 'electric_add_menu_parent_class' );
