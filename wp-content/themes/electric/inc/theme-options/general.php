<?php
/**
 * Renders the aside exclude checkbox setting field.
 */
function electric_sfield_exclude_asides() {
    $options = electric_thop_get_options();
    ?>
    <label for="exclude-asides" class="description">
        <input type="checkbox" name="electric_theme_options[exclude_asides]" id="exclude-asides" <?php checked('on', $options['exclude_asides']); ?> />
    <?php _e('Check this if you use a widget to display your ephemera posts (status, aside, etc) and want to remove them from the main content', 'electric'); ?>
    </label>
    <?php
}

/**
 * Renders the cache buster checkbox setting field.
 */
function electric_sfield_use_cache_buster() {
    $options = electric_thop_get_options();
    ?>

    <label for="use-cache-buster" class="description">
        <input type="checkbox" name="electric_theme_options[use_cache_buster]" id="use-cache-buster" <?php checked('on', $options['use_cache_buster']); ?> />
    <?php _e('Check this if you want to use a cache buster', 'electric'); ?>
    </label>
    <p class="description"><?php _e('If you cache your CSS and JS files (which you should) you can use a "cache buster" (a number added at the end of the resource URL) to force browsers to download the new version when you make a change to those files.', 'electric') ?></p>
    <?php
}

/**
 * Renders the cache buster input setting field.
 */
function electric_sfield_cache_buster_value() {
    $options = electric_thop_get_options();
    ?>
    <input type="number" name="electric_theme_options[cache_buster_value]" id="cache-buster-value" value="<?php echo esc_attr($options['cache_buster_value']); ?>" />
    <label class="description" for="cache-buster-value"><?php _e('Cache buster value (number)', 'electric'); ?></label>
    <?php
}


/**
 * Renders the Google Analytics input setting field.
 */
function electric_sfield_google_analytics() {
    $options = electric_thop_get_options();
    ?>
    <input type="text" name="electric_theme_options[google_analytics]" id="google-analytics" value="<?php echo esc_attr($options['google_analytics']); ?>" />
    <label class="description" for="google-analytics"><?php _e('Your account code', 'electric'); ?></label>
    <p class="description"><?php _e('Your account code looks like this: UA-12345678-9', 'electric') ?></p>
    <p class="description"><?php _e('Leave blank not to use Google Analytics', 'electric') ?></p>
    <?php
}
