<?php
/*
  Template Name: About
 */
  get_header();
  ?>

  <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
       <?php the_post(); ?>
       <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content(); ?>

            <?php edit_post_link( __( 'Edit', 'electric' ), '<span class="edit-link">', '</span>' ); ?>
        </div><!-- .entry-content -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php comments_template('', true); ?>
</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php if (is_active_sidebar('about-aside')): ?>
  <div class="widgetarea-container">
    <div id="about-aside" class="widget-area">
      <?php dynamic_sidebar('about-aside'); ?>
  </div><!-- .widget-area -->
</div>
<?php endif; ?>
<?php get_footer(); ?>