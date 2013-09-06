<?php

/*
 * Renders the notification text input
 */
function electric_sfield_notification_text(){
    $options = electric_thop_get_options();
    ?>
    <input type="text" name="electric_theme_options[notification_text]" id="notification-text" value="<?php echo esc_attr($options['notification_text']); ?>" />
     <label class="description" for="notification-text"><?php _e('Insert your text for the notification. Leave blank to hide it', 'electric'); ?></label>
    <?php
}
