<?php
/*
  Template Name: Portfolio Archive
 */
  $single_page = TRUE;
  get_header();
  ?>

  <div id="primary">
    <div id="content" role="main">

        <?php while (have_posts()) : the_post(); ?>
        <section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header>
                <h1 class="page-title">
                    <?php the_title(); ?>
                </h1>
            </header><!-- .entry-header -->
            <div class="entry-content">
                <?php the_content(); ?>
            </div><!-- .entry-content -->
            <div class="filter-wrapper">
                <h3 class="filter-title"><?php _e('Filter', 'electric') ?>:</h3>
                <ul class="filter">
                    <li class="active"><a href="#all" class="all main-button"><?php _e('All', 'electric') ?></a></li>
                    <?php
                    $terms = get_terms('electric_pf_category', array('parent' => 0));
                    $term_list = "";
                    if ( count($terms) > 0) {
                        foreach ($terms as $term) {
                            $term_link = get_term_link( $term, 'electric_pf_category' );
                            if( is_wp_error( $term_link ) ) {
                                continue;
                            }
                            $term_list .= '<li><a href="#'. esc_attr($term->slug) .'" class="main-button ' . esc_attr($term->slug) . '">' . $term->name . '</a></li>';
                        }
                        echo $term_list;
                    }
                    ?>
                </ul>
            </div>
            <ul class="filterable-grid">
                <?php
                    //Secondary loop
                $args = array(
                              'post_type' => "electric_portfolio",
                              'posts_per_page' => '-1'
                              );
                $the_query = new WP_Query($args);
                while ($the_query->have_posts()) :
                    $the_query->the_post();
                    $post_terms = get_the_terms(get_the_ID(), 'electric_pf_category');
                ?>
                <?php //Why data-id and not id? Quicksand plugin clones elements, so there would be several items with same id => not a good idea?>
                <li data-id="id-<?php echo $the_query->current_post; ?>" data-type="<?php
                foreach ($post_terms as $term) {
                    echo esc_attr($term->slug) . ' ';
                }
                ?>">
                <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('See more about %s', 'electric'), the_title_attribute('echo=0')); ?>" rel="bookmark">
                    <h2 class="portfolio-title"><?php the_title(); ?></h2>
                    <div class="thumbnail"><?php the_post_thumbnail('portfolio-thumb'); ?></div>
                </a>
            </li>
            <?php
            endwhile;
            ?>
        </ul>
        <?php
        wp_reset_postdata();
        ?>

        <?php if (current_user_can('edit_post')): ?>
        <div class="entry-meta">
            <?php edit_post_link(__('Edit', 'electric'), '<span class="edit-link">', '</span>'); ?>
        </div>
    <?php endif; ?>
</section>
<?php endwhile; // end of the main loop.     ?>

</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
