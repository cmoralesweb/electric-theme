<?php
/**
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php electric_the_title(); ?>
        <div class="entry-meta">
            <?php if (comments_open() && !post_password_required()) : ?>
            <div class="comments-link">
                <?php comments_popup_link('<span class="leave-reply">0</span>', '1', '%'); ?>
            </div>
        <?php endif; ?>
        <div class="published"><?php electric_posted_on_no_author(); ?></div>
    </div><!-- .entry-meta -->
</header><!-- .entry-header -->
<div class="entry-content">
    <?php if (has_post_thumbnail()): ?>
    <?php electric_the_thumbnail() ?>
<?php endif; ?>
<?php the_content(); ?>
<?php wp_link_pages(array('before' => '<div class="page-links">' . __('Pages:', 'electric'), 'after' => '</div>')); ?>
</div><!-- .entry-content -->

<footer class="entry-meta">
    <div class="meta">
        <?php
        /* translators: used between list items, there is a space after the comma */
        $category_list = get_the_category_list(__('<span class="sep">,</span> ', 'electric'));

        if (electric_categorized_blog()) {
            ?>
            <div class="categories">
                <?php
                    // Only display categories if there are more than one
                printf(__('This entry was posted in %1$s', 'electric'), $category_list);
                ?>
            </div>
            <?php
            } // end check for categories on this blog
            ?>
            <?php electric_display_tags(FALSE, TRUE); ?>
            <p class="permalink"><?php printf(__('Bookmark the <a href="%1$s" title="Permalink to %2$s" rel="bookmark">permalink</a>.', 'electric'), get_permalink(), the_title_attribute('echo=0')); ?></p>
            <?php edit_post_link(__('Edit', 'electric'), '<span class="edit-link">', '</span>'); ?>
        </div>
        <?php if (get_the_author_meta('description') && is_multi_author()) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries   ?>
        <div id="author-info">
            <div id="author-avatar">
                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('electric_author_bio_avatar_size', 80)); ?>
            </div><!-- #author-avatar -->
            <div id="author-description">
                <h2><?php printf(esc_attr__('About %s', 'electric'), get_the_author()); ?></h2>
                <?php the_author_meta('description'); ?>
                <div id="author-link">
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                        <?php printf(__('View all posts by %s <span class="meta-nav">&rarr;</span>', 'electric'), get_the_author()); ?>
                    </a>
                </div><!-- #author-link	-->
            </div><!-- #author-description -->
        </div><!-- #entry-author-info -->

    <?php endif; ?>

    <?php electric_the_related_posts(get_the_ID())?>


</footer><!-- .entry-meta -->
<?php
    // If comments are open or we have at least one comment, load up the comment template: Articles inside of the main article as the spec suggest
if (comments_open() || '0' != get_comments_number())
    comments_template('', true);
?>
<a href="<?php echo esc_url( get_theme_mod( 'jetpack-facebook' ) ); ?>">
    <?php _e( 'Facebook', 'textdomain' ); ?>
</a>

