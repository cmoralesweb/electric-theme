<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				
				<?php get_template_part( 'content', 'single' ); ?>

				<?php electric_content_nav( 'nav-below' ); ?>

				

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>