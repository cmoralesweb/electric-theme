<?php
/**
 * The Footer widget areas.
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
?>

<?php
/* The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if (!is_active_sidebar('footer-sidebar-1')
        && !is_active_sidebar('footer-sidebar-1')
        && !is_active_sidebar('footer-sidebar-1')
)
    return;
// If we get this far, we have widgets. Let do this.
?>
<div id="supplementary">
    <?php do_action('before_sidebar'); ?>
    <?php if (is_active_sidebar('footer-sidebar-1')) : ?>
        <div class="first widget-area" >
            <?php dynamic_sidebar('footer-sidebar-1'); ?>
        </div><!-- #first .widget-area -->
    <?php endif; ?>

    <?php do_action('before_sidebar'); ?>
    <?php if (is_active_sidebar('footer-sidebar-2')) : ?>
        <div class="second widget-area">
            <?php dynamic_sidebar('footer-sidebar-2'); ?>
        </div><!-- #second .widget-area -->
    <?php endif; ?>

    <?php do_action('before_sidebar'); ?>
    <?php if (is_active_sidebar('footer-sidebar-3')) : ?>
        <div  class="third widget-area">
            <?php dynamic_sidebar('footer-sidebar-3'); ?>
        </div><!-- #third .widget-area -->
    <?php endif; ?>
</div><!-- #supplementary -->