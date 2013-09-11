<?php
/**
 * Portfolio type, single view
 *
 */
$single_page = TRUE;
get_header();
?>
<div id="primary">
    <div id="content" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php electric_the_title()?>
                </header><!-- .entry-header -->
                <div class="images">
                    <div class="thumbnail"><?php the_post_thumbnail() ?></div>
                    <?php $gallery = electric_pf_get_gallery_images(get_the_ID(), 'portfolio-thumb')?>
                    <?php if ( $gallery ): ?>
                        <div class="gallery">
                            <?php foreach ( $gallery as $key => $image): ?>
                                <?php $full_img = wp_get_attachment_image_src( $image['attachment_id'], 'full'); ?>
                                <a href="<?php echo esc_url( $full_img[0] ) ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ) ?>">
                                    <img src="<?php echo esc_url( $image['src'] ) ?>" alt="<?php echo $image['alt'] ?>">
                                </a>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <h2 class="about-job"><?php _e('About this job', 'electric') ?>:</h2>
                        <dl class="details">
                            <?php if (get_post_meta($post->ID, '_electric_pf_client', true)): ?>
                                <dt><?php _e('Client', 'electric') ?>:</dt>
                                <dl><?php echo get_post_meta($post->ID, '_electric_pf_client', true); ?></dl>
                            <?php endif; ?>
                            <?php if (get_post_meta($post->ID, '_electric_pf_partner', true)): ?>
                                <dt><?php _e('In partnership with', 'electric') ?>:</dt>
                                <dl><?php echo get_post_meta($post->ID, '_electric_pf_partner', true); ?></dl>
                            <?php endif; ?>
                            <?php if ($portfolio_url = get_post_meta($post->ID, '_electric_pf_url', true)): ?>
                                <dt>URL:</dt>
                                <dl><a href="<?php echo esc_attr($portfolio_url) ?>"><?php echo esc_url($portfolio_url) ?></a></dl>
                            <?php endif; ?>
                            <?php if (get_post_meta($post->ID, '_electric_pf_year', true)): ?>
                                <dt><?php _e('Year', 'electric') ?>:</dt>
                                <dl><?php echo get_post_meta($post->ID, '_electric_pf_year', true); ?></dl>
                            <?php endif; ?>
                        </dl>
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-meta">
                        <p><?php echo get_the_term_list($post->ID, 'electric_pf_category', __('See other jobs in: ', 'electric'), '  ', ''); ?></p>
                        <p><?php echo get_the_term_list($post->ID, 'electric_pf_tool', __('Built with: ', 'electric'), '  ', ''); ?></p>
                        <?php edit_post_link(__('Edit', 'electric'), '<span class="edit-link">', '</span>'); ?>
                    </footer><!-- .entry-meta -->
                    <?php comments_template('', true); ?>
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->
        <?php endwhile; // end of the loop.  ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>