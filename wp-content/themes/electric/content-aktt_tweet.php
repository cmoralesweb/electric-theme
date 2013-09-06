 <?php $raw_tweet = electric_get_tweet(get_the_ID()); ?>
 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <div class="media">
            <div class="media-object-container"><?php electric_the_twitter_avatar($raw_tweet); ?></div>
            <div class="media-body"><?php the_content() ?></div>
        </div>
        <?php electric_the_thumbnail(  ) ?>
        <?php electric_the_twitter_meta($raw_tweet) ?>
    </div>
    <?php if (!is_search() && !is_archive()) : ?>
        <?php comments_template('', true); ?>
    <?php else: ?>
     <footer class="entry-meta">
        <a class="more-link" href="<?php esc_attr(the_permalink()) ?>">
             <?php _e('Read more ', 'electric')?>
         </a>
     </footer>
    <?php endif; ?>
</article>
<?php if (!is_search() && !is_archive()) : ?>
    <?php electric_content_nav("nav-single") ?>
<?php endif; ?>