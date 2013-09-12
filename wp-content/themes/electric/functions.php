<?php

/**
 * Electric Theme functions and definitions
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Electric Theme 1.0
 */
if (!isset($content_width))
    $content_width = 640; /* pixels */

if (!function_exists('electric_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * @since Electric Theme 1.0
     */
function electric_setup() {

        /**
         * Custom template tags for this theme.
         */
        require( get_template_directory() . '/inc/template-tags.php' );

        /**
         * Custom functions that act independently of the theme templates
         */
        require( get_template_directory() . '/inc/extras.php' );

        /**
         * Custom Theme Options
         */
        require( get_template_directory() . '/inc/theme-options/theme-options.php' );

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on Electric Theme, use a find and replace
         * to change 'electric' to the name of your theme in all the template files
         */
        load_theme_textdomain('electric', get_template_directory() . '/languages');

        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support('automatic-feed-links');

        /**
         * Enable support for Post Thumbnails
         */
        add_theme_support('post-thumbnails');

        /* Set sizes for thumbnails */
        // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
        set_post_thumbnail_size(668, 296, true); // Feature image for post (main)
// Add custom image sizes
        add_image_size('home-featured', 740, 400, true); // Featured post in the home page
        add_image_size('home-featured-thumb', 180, 80, true); // Thumbnail for featured post in the home page
        add_image_size('post-thumb', 333, 148, true); // Regular post thumb
        add_image_size('portfolio-thumb', 159, 71, true); // Portfolio type thumb
        add_image_size('portfolio-medium', 250, 167, true); // Portfolio medium thumb

        /**
         * Enable support for Infinite Scroll
         */
        add_theme_support('infinite-scroll', array(
                          'container' => 'content',
                          'type' => 'click',
                          'render' => 'electric_infinite_scroll_render'
                          ));

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus(array(
                           'primary' => __('Primary Menu', 'electric'),
                           ));

        /**
         * Add support for the Aside Post Formats
         */
        add_theme_support('post-formats', array('aside', 'link', 'status', 'quote', 'image'));
    }

endif; // electric_setup
add_action('after_setup_theme', 'electric_setup');

if (!function_exists('electric_infinite_scroll_render')) :
    function electric_infinite_scroll_render() {
        while( have_posts() ) {
            the_post();
            if ( get_post_type( get_the_ID()) == 'post') {
                get_template_part( 'content', get_post_format() );
            } else {
                get_template_part( 'content', get_post_type() );
            }
        }
    }
    endif;

    if (!function_exists('electric_thop_options')) :
    /**
     * Show a notice reminding to edit the theme options with a link to the page, only after the theme is activated.
     */
function electric_thop_options() {
   function my_admin_notice(){
    $options_url = network_admin_url('themes.php?page=theme_options');
        //network_admin_url works for both single installations and network installations, admin_url only for single
    ?><div class="updated">
    <p><?php printf(__('You can customize this theme to better suit your neeeds. Please visit the <a href="%s" title="Theme Options page">Theme Options page</a> to adjust it.', 'electric'), $options_url);?></p>
</div>
<?php
}
add_action('admin_notices', 'my_admin_notice');
}
endif;
add_action('after_switch_theme', 'electric_thop_options');




//Let's include some widget areas
include('inc/widget-areas.php');


/**
 * Enqueue scripts and styles
 */
function electric_scripts() {
//Check if cache buster is used, false otherwise
   $theme_options = get_option('electric_theme_options');
   $cache = FALSE;
   if(!empty($theme_options['use_cache_buster']) && !empty($theme_options['cache_buster_value'])){
       $cache = $theme_options['cache_buster_value'];
   }

   //Enqueue Prefix First soon to avoid FOUC
   wp_enqueue_script('prefixfree', get_template_directory_uri() . '/js/vendor/prefixfree.min.js', array(), $cache, false);



     //Check if Icon Fonts are used
   if(!empty($theme_options['use_icon_fonts']) ) {
    wp_enqueue_style('electric-theme-font-style', get_template_directory_uri(). '/fonts/style.css', array('electric-theme-style'), $cache);
    }

     //Check if Google Fonts are used
if(!empty($theme_options['use_google_fonts']) ){
   $google_link = "http://fonts.googleapis.com/css?family=";
         preg_match("{family=(.+)'}", $theme_options['google_fonts_choice'], $matches);//Capture the family parameter in $matches[1]
         if(!empty($matches[1])){
             $google_link .= $matches[1] ;
             wp_enqueue_style('electric-theme-google-fonts', $google_link, 'electric-theme-style', FALSE);
         }
     }

     //Check if the Tooltip script should be loaded
     if(!empty($theme_options['use_tooltip_js']) ){
        wp_enqueue_script('electric-theme-use-tooltip-js', get_template_directory_uri() . '/js/jquery-tooltip.js', array('jquery'), $cache, true);
    }
     ////


///Enqueue resources now
    wp_enqueue_style('electric-theme-style', get_stylesheet_uri(), FALSE, $cache);
    wp_enqueue_script('electric-theme-modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', FALSE, $cache, FALSE); //This must load as soon as possible
    wp_enqueue_script('electric-theme-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), $cache, true);
    wp_enqueue_script('electric-theme-main', get_template_directory_uri() . '/js/main.js', array('jquery'), $cache, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular() && wp_attachment_is_image()) {
        wp_enqueue_script('keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), $cache, TRUE);
    }
}

add_action('wp_enqueue_scripts', 'electric_scripts');



require( get_template_directory() . '/inc/plugin-activation.php' );

add_action( 'tgmpa_register', 'electric_register_required_plugins' );

/**
 * Register the required plugins for this theme. Thanks to https://github.com/thomasgriffin/TGM-Plugin-Activation
 * *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function electric_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
                     array(
            'name'                  => 'Electric Portfolio', // The plugin name
            'slug'                  => 'electric-portfolio', // The plugin slug (typically the folder name)
            'source'                => get_template_directory() . '/lib/plugins/electric-portfolio.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
                     array(
            'name'                  => 'Electric Availability', // The plugin name
            'slug'                  => 'electric-availability', // The plugin slug (typically the folder name)
            'source'                => get_template_directory() . '/lib/plugins/electric-availability.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
                     array(
			'name'     				=> 'Electric Theme Widgets', // The plugin name
			'slug'     				=> 'electric-thwg', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/lib/plugins/electric-thwg.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
          ),
		// Plugin from the WordPress Plugin Repository
                     array(
                           'name'      => 'Jetpack',
                           'slug'      => 'jetpack',
                           'required'  => false,
                           ),
                     array(
                           'name' 		=> 'Twitter Tools',
                           'slug' 		=> 'twitter-tools',
                           'required' 	=> false,
                           ),

                     );

$theme_text_domain = 'electric';

	/**
	 * Array of configuration settings. Amend each line as needed.	 *
	 */
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
                               'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
                               'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
          )
);

tgmpa( $plugins, $config );

}


/**
 * Implement the Custom Header feature
 */
// require( get_template_directory() . '/inc/custom-header.php' );
