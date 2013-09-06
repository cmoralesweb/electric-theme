<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
?>
<div class="widgetarea-container">
    <div id="secondary" class="widget-area" role="complementary">
        <?php do_action('before_sidebar'); ?>
        <?php if (!dynamic_sidebar('main-sidebar')) : ?>

            <aside id="archives" class="widget">
                <h1 class="widget-title"><?php _e('Archives', 'electric'); ?></h1>
                <ul>
                    <?php wp_get_archives(array('type' => 'monthly')); ?>
                </ul>
            </aside>

            <aside id="meta" class="widget">
                <h1 class="widget-title"><?php _e('Meta', 'electric'); ?></h1>
                <ul>
                    <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
                </ul>
            </aside>
        <?php endif; // end sidebar widget area ?>

    </div><!-- #secondary .widget-area -->
    <?php if (is_active_sidebar('secondary-sidebar')): ?>
        <div id="tertiary" class="widget-area" role="complementary">
            <?php do_action('before_sidebar'); ?>
            <?php dynamic_sidebar('secondary-sidebar') ?>
        </div><!-- #tertiary .widget-area -->
    <?php endif; ?>
</div>