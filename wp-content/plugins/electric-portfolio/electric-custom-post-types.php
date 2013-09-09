<?php
/*
  Plugin Name: Electric Portfolio
  Plugin URI: http://www.cmorales.es
  Description: Custom post types for portfolio.
  Author: Carlos Morales
  Version: 0.3
  Author URI: http://www.cmorales.es
 */

  class Electric_Portfolio {
    protected $textdomain = "electric_portfolio";
    protected $prefix = "electric_pf_";
    protected $prefix_alt = "electric-pf-";
    protected $longname = "electric_portfolio";
    protected $longname_alt = "electric-portfolio";
    protected $plugin_dir = "";

    function __construct() {
        $this->plugin_dir = plugin_dir_url(__FILE__);

        /* Add all the actions to their corresponding hooks */
        add_action('init', array(&$this,'post_types_register')); //Register the post type
        add_action('init', array(&$this, 'category_taxonomy'), 0);//Create taxonomy
        add_action('init', array(&$this, 'technology_taxonomy'), 0);//Create taxonomy

        //Add hook save function
        add_action('save_post', array(&$this,'save_custom_fields'), 10, 2);

        //Add scripts
        add_action('admin_enqueue_scripts', array(&$this,'add_scripts'));
        add_action('wp_enqueue_scripts', array(&$this,'front_scripts'));

        //Modify routes
        //add_filter('rewrite_rules_array', array(&$this,'mmp_rewrite_rules'));
        //add_filter('post_type_link', array(&$this,'filter_post_type_link'), 10, 2);
    }


    function add_scripts(){
        /* Add scripts for the image interface */
        wp_enqueue_media();
        wp_enqueue_script( $this->prefix . 'add_images', $this->plugin_dir . '/js/add-images.js', 'jquery', false, true );
    }

    /* Front-end scripts */
    function front_scripts(){
        wp_enqueue_script( $this->prefix . 'quicksand', $this->plugin_dir . '/js/quicksand.js', 'jquery', false, true );
    }

    /*
     * Register the post type
     */
    function post_types_register() {
        register_post_type(
                           $this->longname,
                           array(
                                 'labels' => array(
                                                   'name' => __('Portfolio', $this->textdomain),
                                                   'all_items' => __('All Portfolio items', $this->textdomain),
                                                   'singular_name' => __('Portfolio item', $this->textdomain),
                                                   'add_new' => __('Add new Portfolio item', $this->textdomain),
                                                   'add_new_item' => __('Add new Portfolio item', $this->textdomain),
                                                   'edit' => __('Edit', $this->textdomain),
                                                   'edit_item' => __('Edit Portfolio item', $this->textdomain),
                                                   'new_item' => __('New Portfolio item', $this->textdomain),
                                                   'view' => __('View Portfolio item', $this->textdomain),
                                                   'view_item' => __('View Portfolio item', $this->textdomain),
                                                   'search_items' => __('Search Portfolio items', $this->textdomain),
                                                   'not_found' => __('No Portfolio items found', $this->textdomain),
                                                   'not_found_in_trash' => __('There are no Portfolio items in the trash', $this->textdomain),
                                                   ),
'hierarchical' => false,
'public' => true,
'menu_position' => 25,
            //'menu_icon' => plugins_url( 'icons/user_comment.png' , __FILE__ ),
            'has_archive' => false, //Archive is created using a Custom Page
            'rewrite' => array('slug' => __('portfolio', $this->textdomain)),
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'page-attributes'),
            'taxonomies' => array($this->prefix .'category', $this->prefix .'technology'),
            'description' => __('Collection of your best jobs', $this->textdomain),
            'register_meta_box_cb' => array(&$this,'add_custom_fields_box')
            )
);
}

    /**
     * Create a custom taxonomy for the portfolio elements
     */
    function category_taxonomy() {
        $portfoliolabels = array(
                                 'name' => __('Portfolio category', $this->textdomain),
                                 'singular_name' => __('Portfolio category', $this->textdomain),
                                 'search_items' => __('Search by Portfolio category', $this->textdomain),
                                 'popular_items' => __('Popular Portfolio categories', $this->textdomain),
                                 'all_items' => __('All Portfolio categories', $this->textdomain),
                                 'edit_item' => __('Edit Portfolio category', $this->textdomain),
                                 'update_item' => __('Update Portfolio category', $this->textdomain),
                                 'add_new_item' => __('Add new Portfolio category', $this->textdomain),
                                 'new_item_name' => __('New Portfolio category', $this->textdomain),
                                 'separate_items_with_commas' => __('Separate categories with commas', $this->textdomain),
                                 'add_or_remove_items' => __('Add or remove Portfolio categories', $this->textdomain),
                                 'choose_from_most_used' => __('Choose from most used Portfolio categories', $this->textdomain),
                                 'menu_name' => __('Categories', $this->textdomain),
                                 );
register_taxonomy(
                  $this->prefix .'category', $this->longname, array(
                                                                    'hierarchical' => true,
                                                                    'labels' => $portfoliolabels,
                                                                    'query_var' => $this->prefix_alt .'category',
                                                                    'rewrite' => array('slug' => __('portfolio/category', $this->textdomain), 'hierarchical' => true )
                                                                    )
                  );
}

function technology_taxonomy() {
    $labels = array(
                    'name' => __('Portfolio technology', $this->textdomain),
                    'singular_name' => __('Technology', $this->textdomain),
                    'search_items' => __('Technology', $this->textdomain),
                    'popular_items' => __('Popular Portfolio technologies', $this->textdomain),
                    'all_items' => __('All Portfolio technologies', $this->textdomain),
                    'edit_item' => __('Edit Portfolio technology', $this->textdomain),
                    'update_item' => __('Update Portfolio technology', $this->textdomain),
                    'add_new_item' => __('Add new Portfolio technology', $this->textdomain),
                    'new_item_name' => __('New Portfolio technology', $this->textdomain),
                    'separate_items_with_commas' => __('Separate items with commas', $this->textdomain),
                    'add_or_remove_items' => __('Add or remove items', $this->textdomain),
                    'choose_from_most_used' => __('Choose from most used Portfolio technologies', $this->textdomain),
                    'menu_name' => __('Technologies', $this->textdomain),
                    );
register_taxonomy(
                  $this->prefix .'technology', $this->longname, array(
                                                                      'hierarchical' => false,
                                                                      'labels' => $labels,
                                                                      'query_var' => $this->prefix_alt .'technology',
                                                                      'rewrite' => array(
                                                                                         'slug' => __('portfolio/technology', $this->textdomain),
                                                                                         'hierarchical' => true )
                                                                      )
                  );
}


/**
 * Render custom fields to add our custom data
 *
 * underscore in front of field name to hide it from showing in EVERY post
 */
function render_custom_fields() {
    global $post;
    $custom = get_post_custom($post->ID);
    $client = "";
    $partner = "";
    $url = "";
    $year = "";
    if ($custom) {
        $client = !empty($custom["_" . $this->prefix . "client"][0]) ? $custom["_" . $this->prefix . "client"][0] : "";
        $partner = !empty($custom["_" . $this->prefix . "partner"][0]) ? $custom["_" . $this->prefix . "partner"][0] : "";
        $url = !empty($custom["_" . $this->prefix . "url"][0]) ? $custom["_" . $this->prefix . "url"][0] : "";
        $year = !empty($custom["_" . $this->prefix . "year"][0]) ? $custom["_" . $this->prefix . "year"][0] : "";
    }
    ?>
    <?php wp_nonce_field($this->prefix."custom_fields_render", $this->prefix."custom_fields_nonce") ?>
    <p>
        <label><?php esc_attr_e('Client', $this->textdomain) ?>:</label><br />
        <input type="text" size="45" name="<?php echo "_" . $this->prefix ?>client"
        value="<?php echo esc_attr($client); ?>" />
    </p>
    <p>
        <label><?php esc_attr_e('Working with', $this->textdomain) ?>:</label><br />
        <input type="text" size="45" name="<?php echo "_" . $this->prefix ?>partner"
        value="<?php echo esc_attr($partner); ?>" />
    </p>
    <p>
        <label><?php esc_attr_e('URL', $this->textdomain) ?>:</label><br />
        <input type="url" size="45" name="<?php echo "_" . $this->prefix ?>url"
        value="<?php echo esc_attr($url); ?>" />
    </p>
    <p>
        <label><?php esc_attr_e('Year', $this->textdomain) ?>:</label><br />
        <input type="number" size="45" name="<?php echo "_" . $this->prefix ?>year"
        value="<?php echo esc_attr($year); ?>" />
    </p>
    <?php

}


/**
 * Renders the Gallery fields
 */
function render_gallery_field(){
    global $post;
    $gallery_id = get_post_meta( $post->ID, '_electric_pf_gallery_id', true );
    $gallery = electric_pf_get_gallery_images( $post->ID, 'thumbnail' );
    ?>
    <?php wp_nonce_field($this->prefix."custom_fields_render", $this->prefix."custom_fields_nonce") ?>
    <p>
        <input id="<?php echo "_" . $this->prefix ?>gallery_button" type="button" data-upload-options='{"multiple": true,  "previewSize": "thumbnail"}'  class="electric-upload-button button" value="<?php _e( 'Upload Gallery', $this->textdomain ); ?>" />
        <input type="hidden" id="<?php echo "_" . $this->prefix ?>gallery_id" name="<?php echo "_" . $this->prefix ?>gallery_id" value="<?php echo esc_attr( $gallery_id ) ?>" />
        <?php if ( $gallery ): ?>
        <input id="<?php echo "_" . $this->prefix ?>clear_gallery_button" name="<?php echo "_" . $this->prefix ?>clear_gallery_button" type="submit" class="button" value="<?php _e( 'Clear gallery', $this->textdomain ); ?>" />
    <?php endif; ?>
    </p>
    <div id="<?php echo "_" . $this->prefix ?>gallery_preview" style="min-height: 100px;">
        <?php if ( $gallery ): ?>
            <?php foreach ( $gallery as $key => $gallery_el ): ?>
                <img src="<?php echo $gallery_el['src'] ?>" alt="<?php echo $gallery_el['alt'] ?>">
            <?php endforeach ?>
        <?php endif; ?>
    </div>
    <p class="description"><?php _e('Upload a gallery for this element.', 'electric' ); ?></p>
<?php
}


/*
 * Add custom fields box
 */
function add_custom_fields_box(){
  add_meta_box(
    "info", //ID
    __('Job details', $this->textdomain), //Label
    array(&$this,'render_custom_fields'),//Callback
    "electric_portfolio", //Post type to be attached
    "normal",//Context (side of the screen)
    "high" // Priority
    );
  add_meta_box(
    "gallery", //ID
    __('Gallery', $this->textdomain), //Label
    array(&$this,'render_gallery_field'),//Callback
    "electric_portfolio", //Post type to be attached
    "normal",//Context (side of the screen)
    "high" // Priority
    );
}

/*
 * Save custom fields
 *
 */
function save_custom_fields() {
    global $post;
    if ($post) {
        //Make sure we only do this for this custom post type
        //(otherwise the nonce would fail, for example)
        if (get_post_type( $post ) == $this->longname){
            // Bail if we're doing an auto save
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || (defined('DOING_AJAX') && DOING_AJAX) ) return;

            // if our current user can't edit this post, bail
            if( !current_user_can( 'edit_post' , $post->ID) ) return;

            //Check nonce for security
            if(!empty($_POST) && check_admin_referer($this->prefix."custom_fields_render", $this->prefix."custom_fields_nonce")){
                //Now for the real thing:

                update_post_meta($post->ID, "_" . $this->prefix . "client", esc_attr( $_POST["_" . $this->prefix . "client"]));
                update_post_meta($post->ID, "_" . $this->prefix . "partner", esc_attr( $_POST["_" . $this->prefix . "partner"]) );
                update_post_meta($post->ID, "_" . $this->prefix . "url", esc_url($_POST["_" . $this->prefix . "url"]));
                update_post_meta($post->ID, "_" . $this->prefix . "year", esc_attr( $_POST["_" . $this->prefix . "year"]) );

                if ( !empty($_POST["_" . $this->prefix ."clear_gallery_button"]) ) {
                    //User wants to clear the gallery
                    update_post_meta($post->ID, "_" . $this->prefix . "gallery_id", "");
                } else {
                    update_post_meta($post->ID, "_" . $this->prefix . "gallery_id", esc_attr( $_POST["_" . $this->prefix . "gallery_id"]) );
                }
            }
        }
    }
}
}

new Electric_Portfolio;
include_once 'widget.php';

/* Template functions */
function electric_pf_get_gallery_images( $post_ID, $size = 'full' ){
    $image_array = false;
    $gallery_images_IDs = get_post_meta( $post_ID, '_electric_pf_gallery_id', true );
    if( $gallery_images_IDs ) {
        $gallery_images_IDs = explode(',', $gallery_images_IDs);
        foreach ( $gallery_images_IDs as $image_ID ) {
            $image_array[] = electric_pf_get_attachment( $image_ID, $size );
        }
    }
    return $image_array;
}


function electric_pf_get_attachment( $attachment_id, $size = 'full' ) {
    $attachment = get_post( $attachment_id );
    //Returns an array, allows us to choose size:
    $attachment_img = wp_get_attachment_image_src( $attachment_id, $size);
    return array(
                 'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                 'caption' => $attachment->post_excerpt,
                 'description' => $attachment->post_content,
                 'href' => get_permalink( $attachment->ID ),
                 'src' => $attachment_img[0],
                 'title' => $attachment->post_title,
                 'attachment_id' => $attachment_id
                 );
}
?>