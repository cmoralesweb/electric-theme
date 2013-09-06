<?php
/**
 * Portfolio type
 *
 */
get_header();
?>
<div id="primary">
    <div id="content" role="main">

        <?php while (have_posts()) : the_post(); ?>


            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <hgroup>
                        <?php //electric_title(); ?>
                    </hgroup>
                </header><!-- .entry-header -->
                <div class="images">
                    <div class="thumbnail"><?php the_post_thumbnail() ?></div>
                    <?php echo do_shortcode('[gallery id="' . get_the_ID() . '" size="portfolio-thumb" columns="2" link="file"]'); ?>
                </div>

                <div class="entry-content">
                    <h2><?php _e('Datos del trabajo') ?>:</h2>
                    <dl class="details">
                        <?php if (get_post_meta($post->ID, '_electric_portfolio_client', true)): ?>
                            <dt><?php _e('Cliente') ?>:</dt>
                            <dl><?php echo get_post_meta($post->ID, '_electric_portfolio_client', true); ?></dl>
                        <?php endif; ?>
                        <?php if (get_post_meta($post->ID, '_electric_portfolio_partner', true)): ?>
                            <dt><?php _e('Trabajo realizado para') ?>:</dt>
                            <dl><?php echo get_post_meta($post->ID, '_electric_portfolio_partner', true); ?></dl>
                        <?php endif; ?>
                        <?php if ($portfolio_url = get_post_meta($post->ID, '_electric_portfolio_url', true)): ?>
                            <dt><?php _e('URL') ?>:</dt>
                            <dl><a href="<?php echo esc_attr($portfolio_url) ?>"><?php echo esc_url($portfolio_url) ?></a></dl>
                        <?php endif; ?>
                        <?php if (get_post_meta($post->ID, '_electric_portfolio_year', true)): ?>
                            <dt><?php _e('Año') ?>:</dt>
                            <dl><?php echo get_post_meta($post->ID, '_electric_portfolio_year', true); ?></dl>
                        <?php endif; ?>
                    </dl>
                    <?php the_content(); ?>
                    <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'twentyeleven') . '</span>', 'after' => '</div>')); ?>
                </div><!-- .entry-content -->

                <footer class="entry-meta">
                    <p><?php echo get_the_term_list($post->ID, 'electric_pf_category', 'Ver otros trabajos de: ', '  ', ''); ?></p>
                    <?php edit_post_link(__('Edit', 'twentyeleven'), '<span class="edit-link">', '</span>'); ?>

                    <?php if (get_the_author_meta('description') && is_multi_author()) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries  ?>

                        <div id="author-info">
                            <div id="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('twentyeleven_author_bio_avatar_size', 68)); ?>
                            </div><!-- #author-avatar -->
                            <div id="author-description">
                                <h2><?php printf(esc_attr__('About %s', 'twentyeleven'), get_the_author()); ?></h2>
                                <?php the_author_meta('description'); ?>
                                <div id="author-link">
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                                        <?php printf(__('View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyeleven'), get_the_author()); ?>
                                    </a>
                                </div><!-- #author-link	-->
                            </div><!-- #author-description -->
                        </div><!-- #entry-author-info -->

                    <?php endif; ?>
                </footer><!-- .entry-meta -->
                <?php comments_template('', true); ?>
            </article><!-- #post-<?php the_ID(); ?> -->



        <?php endwhile; // end of the loop.  ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>