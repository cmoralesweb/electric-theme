<?php
/*
Scripts and styles options
 */


/**
 * Renders the Scripts and styles options section.
 */
function electric_thop_render_scripts_section(){
	echo "<p>" . __('You are not forced to use everything that the theme includes. If you are not going to use a feature (because you don\'t like it or because you prefer a different solution, just uncheck it. You will save some kb to load.','electric') . "</p>" ;
	echo "<p>" . __('If you use these styles/scripts they will be loaded individually. If you want to boost performance, you can combine them into a single file using a plugin (W3 Total Cache is suggested, but you can use any option or do it manually)','electric') . "</p>" ;
}

/**
 * Renders the Icon Fonts checkbox setting field.
 */
function electric_sfield_use_icon_fonts() {
    $options = electric_thop_get_options();
    ?>

    <label for="use-icon-fonts" class="description">
        <input type="checkbox" name="electric_theme_options[use_icon_fonts]" id="use-icon-fonts" <?php checked('on', $options['use_icon_fonts']); ?> />
    <?php _e('Check this if you want to use the icon font.', 'electric'); ?>
    </label>
    <p class="description"><?php _e('You can customize the icons uploading the file electric/fonts/fonts/electric.dev.svg to <a href="http://icomoon.io">icomoon.io</a>.', 'electric'); ?></p>
    <?php
}
/**
 * Renders the Google Fonts checkbox setting field.
 */
function electric_sfield_use_google_fonts() {
    $options = electric_thop_get_options();
    ?>

    <label for="use-google-fonts" class="description">
        <input type="checkbox" name="electric_theme_options[use_google_fonts]" id="use-google-fonts" <?php checked('on', $options['use_google_fonts']); ?> />
    <?php _e('Check this if you want to use fonts from Google Web Fonts', 'electric'); ?>
    </label>
    <p class="description"><?php _e('Allows you to use fonts from <a href="http://www.google.com/webfonts">Google Web Fonts</a>', 'electric') ?></p>
    <?php
}

/**
 * Renders the Google Fonts Family input setting field.
 */
function electric_sfield_google_fonts_choice() {
    $options = electric_thop_get_options();
    ?>
    <input type="text" name="electric_theme_options[google_fonts_choice]" id="google-fonts-choice" value="<?php echo esc_attr($options['google_fonts_choice']); ?>" />
    <label class="description" for="google-fonts-choice"><?php _e('Your font family choice', 'electric'); ?></label>
    <p class="description"><?php _e('If you want to use a different set than the default (Comfortaa + Open Sans):', 'electric') ?></p>
    <ol class="description">
        <li><?php _e('Choose the font(s) you like and click "Use"', 'electric') ?></li>
        <li><?php _e('Choose the style(s) you want and character set(s) at point 1 and 2', 'electric') ?></li>
        <li><?php _e('Copy the code at the "Standard" tab at point 3 ', 'electric') ?></li>
    </ol>
    <?php
}

/**
 * Renders the tooltip checkbox setting field.
 */
function electric_sfield_use_tooltip_js() {
    $options = electric_thop_get_options();
    ?>

    <label for="use-tooltip-js" class="description">
        <input type="checkbox" name="electric_theme_options[use_tooltip_js]" id="use-tooltip-js" <?php checked('on', $options['use_tooltip_js']); ?> />
    <?php _e('Uncheck this if you don\'t want to load the Tooltip script', 'electric'); ?>
    </label>
    <p class="description"><?php _e('This script is used to display a tooltip in the menus and in the availability widget.
    If you don\'t want them, don\'t include the plugin and save some kb', 'electric') ?></p>
    <p class="description"><?php _e('More info about this tooltip <a href="http://jquerytools.org/demos/tooltip/index.html">here</a>', 'electric') ?></p>
    <?php
}

