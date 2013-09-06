<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
?>

</div><!-- #main .site-main -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <?php
    /* A sidebar in the footer? Yep. You can can customize
     * your footer with three columns of widgets.
     */
    get_sidebar('footer');
    ?>

    <div class="site-info">
        <?php do_action('electric_credits'); ?>
        <a href="http://wordpress.org/" title="<?php esc_attr_e('A Semantic Personal Publishing Platform', 'electric'); ?>" rel="generator"><?php printf(__('Proudly powered by %s', 'electric'), 'WordPress'); ?></a>
        <span class="sep"> | </span>
        <?php printf(__('Theme: %1$s by %2$s.', 'electric'), 'Electric Theme', '<a href="http://cmorales.es" rel="designer">Carlos Morales</a>'); ?>
        <p>Sample images and illustrations by <a href="http://www.behance.net/danolas">Daniel Rivera, Danolas</a>. </p>
    </div><!-- .site-info -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->
</div><!-- #outer-wrapper -->
<?php wp_footer(); ?>

</body>
</html>