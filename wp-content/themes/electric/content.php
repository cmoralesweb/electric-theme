<?php
/**
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php electric_the_title(); ?>
        <?php if ('post' == get_post_type() && !is_search()): ?>
            <div class="entry-meta">
                <?php if (comments_open() && !post_password_required()) : ?>
                    <div class="comments-link">
                        <?php comments_popup_link('<span class="leave-reply">0</span>', '1', '%'); ?>
                    </div>
                <?php endif; ?>
                <div class="published">
                    <?php electric_posted_on_no_author(); ?>
                </div>
                <?php if (has_post_thumbnail()): ?>
                    <?php electric_the_thumbnail('post-thumbnail', FALSE); ?>
                    <?php electric_display_tags(5, true); ?>
                    <p class="more"><a class="more-link" href="<?php the_permalink(); ?>"><?php echo __('Continue reading', 'electric'); ?></a></p>
                <?php else: ?>
                    <?php electric_display_tags(5, true); ?>
                <?php endif; //if post thumb ?>

            </div><!-- .entry-meta -->
        <?php endif; // if post ?>
    </header><!-- .entry-header -->

    <?php if (is_search()) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content">
            <?php the_content(__('Continue reading', 'electric')); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links">' . __('Pages:', 'electric'), 'after' => '</div>')); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php if (is_search()): ?>
            <?php if ('post' == get_post_type()) : // Hide category and tag text for pages on Search ?>
                <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list(__('<span class="sep">, </span>', 'electric'));
                if ($categories_list && electric_categorized_blog()) :
                    ?>
                    <div class="cat-links">
                        <?php printf(__('Posted in %1$s', 'electric'), $categories_list); ?>
                    </div>
                <?php endif; // End if categories ?>

                <?php
                /* translators: used between list items, there is a space after the comma */
                $tags_list = get_the_tag_list('', __('<span class="sep">, </span> ', 'electric'));
                if ($tags_list) :
                    ?>
                    <span class="sep"> | </span>
                    <div class="tags-links">
                        <?php printf(__('Tagged %1$s', 'electric'), $tags_list); ?>
                    </div>
                <?php endif; // End if $tags_list ?>
            <?php endif; // End if 'post' == get_post_type() ?>

            <?php if (!post_password_required() && ( comments_open() || '0' != get_comments_number() )) : ?>
                <span class="sep"> | </span>
                <span class="comments-link"><?php comments_popup_link(__('Leave a comment', 'electric'), __('1 Comment', 'electric'), __('% Comments', 'electric')); ?></span>
            <?php endif; ?>
        <?php endif; //If search?>
        <?php edit_post_link(__('Edit', 'electric'), '<span class="sep"> | </span><span class="edit-link">', '</span>'); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
