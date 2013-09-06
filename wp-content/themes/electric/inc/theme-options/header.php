<?php

/**
 * Renders the tagline input setting field.
 */
function electric_sfield_tagline() {
    $options = electric_thop_get_options();
    ?>
    <input type="text" name="electric_theme_options[tagline]" id="tagline" value="<?php echo esc_attr($options['tagline']); ?>" />
    <label class="description" for="tagline"><?php _e('Your catchy tagline', 'electric'); ?></label>
    <p class="description"><?php
    _e('This will display in the header. If you leave it blank, WP description will be used', 'electric') ?></p>
    <?php
}


/**
 * Renders the logo image checkbox
 */
function electric_sfield_use_logo_image() {
    $options = electric_thop_get_options();
    ?>
    <label for="use-logo-image" class="description">
        <input type="checkbox" name="electric_theme_options[use_logo_image]" id="use-logo-image" <?php checked('on', $options['use_logo_image']); ?> />
        <?php _e('Check this if you want to use an image as your logo.', 'electric'); ?>
    </label>

    <?php
}

/**
 * Renders the custom title input setting field.
 */
function electric_sfield_custom_title() {
    $options = electric_thop_get_options();
    ?>
    <input type="text" name="electric_theme_options[custom_title]" id="custom-title" value="<?php echo esc_attr($options['custom_title']); ?>" />
    <label class="description" for="custom-title"><?php _e('Your custom title', 'electric'); ?></label>
    <p class="description"><?php
    _e('Insert your custom title to appear in the header. If you leave it blank, your default blog title will be used instead.', 'electric') ?></p>
    <?php
}

/**
 * Renders the image upload setting field.
 */
function electric_sfield_logo_image(){
    $options = electric_thop_get_options();
    ?>
    <input type="text" id="logo-image" name="electric_theme_options[logo_image]" value="<?php echo $options['logo_image'] ? esc_url( $options['logo_image'] ) : ""; ?>" />
    <input id="upload-logo-button" type="button" class="button" value="<?php _e( 'Upload Logo', 'electric' ); ?>" />
    <input type="hidden" id="logo-image-id" name="electric_theme_options[logo_image_id]" value="<?php echo $options['logo_image_id'] ? esc_attr( $options['logo_image_id'] ) : ""; ?>" />
     <?php if ( '' != $options['logo_image'] ): ?>
            <input id="delete_logo_button" name="electric_theme_options[delete_logo]" type="submit" class="button" value="<?php _e( 'Delete Logo', 'electric' ); ?>" />
        <?php endif; ?>
    <p class="description"><?php _e('Upload an image as your logo.', 'electric' ); ?></p>
    <?php
}

function electric_sfield_logo_image_preview()
{
    $options = electric_thop_get_options();  ?>
   <div id="upload-logo-preview" style="min-height: 100px;">
    <img style="max-width:100%;" src="<?php echo $options['logo_image'] ? esc_url( $options['logo_image'] ) : ""; ?>" />
</div>
<?php
}
?>