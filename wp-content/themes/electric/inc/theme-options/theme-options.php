<?php
/**
 * Electric Theme Options
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */


/**
 * Register the form setting for our electric_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, electric_thop_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 *
 * @since Electric Theme 1.0
 */
function electric_thop_init() {
    register_setting(
            'electric_options', // Options group, see settings_fields() call in electric_thop_render_page()
            'electric_theme_options', // Database option, see electric_thop_get_options()
            'electric_thop_validate' // The sanitization callback, see electric_thop_validate()
            );

    // Register our settings field group
    add_settings_section(
            'general', // Unique identifier for the settings section
            'General', // Section title
            '__return_false', // Section callback (we don't want anything)
            'theme_options' // Menu slug, used to uniquely identify the page; see electric_thop_add_page()
            );

    // Register our settings field group
    add_settings_section(
            'header', // Unique identifier for the settings section
            'Header', // Section title
            '__return_false', // Section callback (we don't want anything)
            'theme_options' // Menu slug, used to uniquely identify the page; see electric_thop_add_page()
            );


     // Register our notifications settings group
    add_settings_section(
            'notifications', // Unique identifier for the settings section
            'Notifications', // Section title
            '__return_false', // Section callback (we don't want anything)
            'theme_options' // Menu slug, used to uniquely identify the page; see electric_thop_add_page()
            );

     // Register our scripts and styles settings group
    add_settings_section(
            'scripts-styles', // Unique identifier for the settings section
            'Scripts and Styles', // Section title
            'electric_thop_render_scripts_section', // Section callback (we don't want anything)
            'theme_options' // Menu slug, used to uniquely identify the page; see electric_thop_add_page()
            );

    // Register our individual settings fields
    add_settings_field(
            'exclude_asides', // Unique identifier for the field for this section
            __('Exclude asides from Loop?', 'electric'), // Setting field label
            'electric_sfield_exclude_asides', // Function that renders the settings field
            'theme_options', // Menu slug, used to uniquely identify the page; see electric_thop_add_page()
            'general' // Settings section. Same as the first argument in the add_settings_section() above
            );

    //General fields
    add_settings_field('use_cache_buster', __('Use cache buster?', 'electric'), 'electric_sfield_use_cache_buster', 'theme_options', 'general');
    add_settings_field('cache_buster_value', __('Cache buster value', 'electric'), 'electric_sfield_cache_buster_value', 'theme_options', 'general');
    add_settings_field('google_analytics', __('Google Analytics code', 'electric'), 'electric_sfield_google_analytics', 'theme_options', 'general');

    //Header fields
    add_settings_field('use_logo_image', __('Use image for logo?', 'electric'), 'electric_sfield_use_logo_image', 'theme_options', 'header');
    add_settings_field('logo_image', __('Your logo', 'electric'), 'electric_sfield_logo_image', 'theme_options', 'header');
    add_settings_field('logo_image_preview', __('Preview your logo', 'electric'), 'electric_sfield_logo_image_preview', 'theme_options', 'header');
    add_settings_field('custom_title', __('Custom title', 'electric'), 'electric_sfield_custom_title', 'theme_options', 'header');
    add_settings_field('tagline', __('Tagline', 'electric'), 'electric_sfield_tagline', 'theme_options', 'header');


    //Scripts and styles
    add_settings_field('use_icon_fonts', __('Use Icon Fonts?', 'electric'), 'electric_sfield_use_icon_fonts', 'theme_options', 'scripts-styles');
    add_settings_field('use_google_fonts', __('Use Google Fonts?', 'electric'), 'electric_sfield_use_google_fonts', 'theme_options', 'scripts-styles');
    add_settings_field('google_fonts_choice', __('Google Fonts Families', 'electric'), 'electric_sfield_google_fonts_choice', 'theme_options', 'scripts-styles');
    add_settings_field('use_tooltip_js', __('Load Tooltip Script', 'electric'), 'electric_sfield_use_tooltip_js', 'theme_options', 'scripts-styles');



    //Notifications fields
    add_settings_field('notification_text', __('Notification text', 'electric'), 'electric_sfield_notification_text', 'theme_options', 'notifications');

    //Add a filter to remove the "Insert into post" in upload modal
    global $pagenow;

    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
            // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'electric_thop_replace_thickbox_text'  , 1, 3 );
    }
}

add_action('admin_init', 'electric_thop_init');

 require( get_template_directory() . '/inc/theme-options/general.php' ); //Functions in external file for clarity
 require( get_template_directory() . '/inc/theme-options/header.php' ); //Functions in external file for clarity
 require( get_template_directory() . '/inc/theme-options/notifications.php' ); //Functions in external file for clarity
 require( get_template_directory() . '/inc/theme-options/scripts.php' ); //Functions in external file for clarity

/**
 * Change the capability required to save the 'electric_options' options group.
 *
 * @see electric_thop_init() First parameter to register_setting() is the name of the options group.
 * @see electric_thop_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function electric_option_page_capability($capability) {
    return 'edit_theme_options';
}

add_filter('option_page_capability_electric_options', 'electric_option_page_capability');

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Electric Theme 1.0
 */
function electric_thop_add_page() {
    $theme_page = add_theme_page(
            __('Electric Theme Options', 'electric'), // Name of page (html title)
            __('Electric Theme Options', 'electric'), // Label in menu
            'edit_theme_options', // Capability required
            'theme_options', // Menu slug, used to uniquely identify the page
            'electric_thop_render_page' // Function that renders the options page
            );
}

add_action('admin_menu', 'electric_thop_add_page');


/**
 * Returns the options array for Electric Theme.
 *
 * @since Electric Theme 1.0
 */
function electric_thop_get_options() {
    $saved = (array) get_option('electric_theme_options');
    $defaults = array(
        'exclude_asides' => 'off',
        'use_cache_buster' => 'off',
        'cache_buster_value' => '1',
        'use_icon_fonts' => 'off',
        'use_google_fonts' => 'off',
        'google_fonts_choice' => "<link href='http://fonts.googleapis.com/css?family=Comfortaa:400,700|Open+Sans:400,600,600italic,400italic' rel='stylesheet' type='text/css'>",
        'google_analytics' => '',
        'tagline' => '',
        'use_logo_image' => 'on',
        'logo_image' => '',
        'custom_title' => '',
        'use_tooltip_js' => 'on',


        'notification_text' => ''


        );

    $defaults = apply_filters('electric_default_theme_options', $defaults);

    $options = wp_parse_args($saved, $defaults);
    $options = array_intersect_key($options, $defaults);

    return $options;
}



/**
 * Renders the Theme Options administration screen.
 *
 * @since Electric Theme 1.0
 */
function electric_thop_render_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <?php $theme_name = function_exists('wp_get_theme') ? wp_get_theme() : get_current_theme(); ?>
        <h2><?php printf(__('%s Options', 'electric'), $theme_name); ?></h2>
        <?php settings_errors(); ?>
        <h3><?php _e('Customize the Electric Theme', 'electric') ?>.</h3>
        <p><?php _e('Thank you for using this theme. Please take a look at the following options and set them according to your needs.', 'electric') ?></p>
        <form id="electric-theme-options-form" method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('electric_options');
            do_settings_sections('theme_options');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see electric_thop_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 *
 * @since Electric Theme 1.0
 */
function electric_thop_validate($input) {
    $output = array();
    $options = electric_thop_get_options();

    // These checkboxes will only be present if checked.
    if (isset($input['exclude_asides']))
        $output['exclude_asides'] = 'on';
    if (isset($input['use_cache_buster']))
        $output['use_cache_buster'] = 'on';
    if (isset($input['use_icon_fonts']))
        $output['use_icon_fonts'] = 'on';
    if (isset($input['use_google_fonts']))
        $output['use_google_fonts'] = 'on';


    $output['use_tooltip_js'] = (isset($input['use_tooltip_js'])) ? 'on' : 'off';
    $output['use_logo_image'] = (isset($input['use_logo_image'])) ? 'on' : 'off';

    if (isset($input['logo_image']) && !empty($input['logo_image'])){
        //If there is already a logo, delete that old one:
        if ( $options['logo_image'] != $input['logo_image'] && $options['logo_image'] != '' ){
            electric_thop_delete_image($options['logo_image']);
        }
        $output['logo_image'] = $input['logo_image'];
    }

    //Delete logo if the user request it
    $delete_logo = ! empty($input['delete_logo']) ? true : false;
    if ( $delete_logo ) {
        electric_thop_delete_image( $options['logo_image'] );
        $output['logo_image'] = '';
    }

    // The cache buster input must be a number
    if (isset($input['cache_buster_value']) && !empty($input['cache_buster_value'])) {
        $cache_int = absint($input['cache_buster_value']);
        if ($cache_int) {
            $output['cache_buster_value'] = $input['cache_buster_value'];
        } else {
            add_settings_error('cache_buster_value', 'cache_buster_value_error', __('Cache buster value must be a number', 'electric'), 'error');
        }
    }

    if (isset($input['google_fonts_choice']) && !empty($input['google_fonts_choice'])) {
     $output['google_fonts_choice'] = $input['google_fonts_choice'];
 }

 if (isset($input['google_analytics'])) {
     $output['google_analytics'] = wp_filter_nohtml_kses($input['google_analytics']);
 }

 if (isset($input['notification_text']) && !empty($input['notification_text'])) {
     $output['notification_text'] = wp_kses_data($input['notification_text']);
 }

if (isset($input['tagline'])) {
   $output['tagline'] = wp_kses_data($input['tagline']);
}
if (isset($input['custom_title'])) {
   $output['custom_title'] = wp_kses_data($input['custom_title']);
}

return apply_filters('electric_thop_validate', $output, $input);
}

/*
Loads the scripts needed for the file upload
 */
function electric_thop_enqueue_scripts() {
 wp_register_script( 'electric-theme-upload', get_template_directory_uri() .'/js/electric-theme-upload.js', array('jquery') );


    if ( 'appearance_page_theme_options' == get_current_screen() -> id ) {

        wp_enqueue_media();
        wp_enqueue_script('electric-theme-upload');

        //Create a js object with the needed values to translate
        $translation_array = array(
            'choose_logo' => __( 'Choose your logo', 'electric' ),
            'insert' => __( 'Insert', 'electric' )
            );
        wp_localize_script( 'electric-theme-upload', 'electricThOp', $translation_array );
    }

}
add_action('admin_enqueue_scripts', 'electric_thop_enqueue_scripts');


/*
Replaces the "Insert into Post" text with a different one in the upload logo field, not to confuse users.
 */
function electric_thop_replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'electric-theme-settings' );
        if ( $referer != '' ) {
            return __('Use this as my logo', 'electric' );
        }
    }
    return $translated_text;
}

/*
Deletes an image
 */
function electric_thop_delete_image($image_url){
    global $wpdb;
    // We need to get the image's meta ID.
    $query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";
    $results = $wpdb->get_results($query);

    // And delete it
    foreach ( $results as $row ) {
        wp_delete_attachment( $row->ID );
    }


}