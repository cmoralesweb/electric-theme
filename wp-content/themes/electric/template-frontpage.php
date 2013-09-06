<?php
/**
 * Template Name: Frontpage Template
 *
 */
$single_page = TRUE;
get_header();
?>

<div id="primary">
    <div id="content" role="main">
        <section class="intro <?php echo is_active_sidebar( 'home-showcase-1' ) &&  is_active_sidebar( 'home-showcase-2' ) ? 'two-widgets' : 'one-widget'?>" >
            <?php if ( is_active_sidebar( 'home-showcase-1' )): ?>
                <div class="showcase1">
                    <?php dynamic_sidebar('home-showcase-1') ?>
                </div>
            <?php endif ?>
            <?php if ( is_active_sidebar( 'home-showcase-2' )): ?>
                <div class="showcase2">
                    <?php dynamic_sidebar('home-showcase-2'); ?>
                </div>
            <?php endif ?>
        </section>

        <?php if (is_active_sidebar('home-middle-1') || is_active_sidebar('home-middle-2') || is_active_sidebar('home-middle-3')):  //Use widgets if you don't know/want to edit code ?>
          <div class="middle-sidebar">
                <?php if (is_active_sidebar('home-middle-1')): ?>
                    <div class="widget-area first">
                        <?php dynamic_sidebar('home-middle-1'); ?>
                    </div><!-- .widget-area -->
                <?php endif; ?>
                <?php if (is_active_sidebar('home-middle-2')): ?>
                    <div class="widget-area second">
                        <?php dynamic_sidebar('home-middle-2'); ?>
                    </div><!-- .widget-area -->
                <?php endif; ?>
                <?php if (is_active_sidebar('home-middle-3')): ?>
                    <div class="widget-area third">
                        <?php dynamic_sidebar('home-middle-3'); ?>
                    </div><!-- .widget-area -->
                <?php endif; ?>
            </div>  <!-- Middle sidebar -->
        <?php else: //Feeling adventurous? Edit the code below yourself! Change from section to div if the content of the columns is not related ?>
        <section id="specialties" class="middle-sidebar">
            <h1 class="assistive-text"><?php _e('Specialties') //Text for SEO/Screen readers?></h1>
            <section id="specialty-1" class="specialty first">
                <h1 class="specialty-title">
                    <a  href="#" >Specialty One</a>
                </h1>
                <a class="more" title="Fake link" href="#" ><img src="<?php bloginfo('stylesheet_directory') ?>/images/sample-content/creatividade-galega.png" width="330" height="208" alt="Alt text"/></a>
                <div class="specialty-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam velit quaerat consectetur eum modi est numquam eos nisi et aliquam!</p>
                </div>
            </section><!-- specialty-1 -->
            <section id="specialty-2" class="specialty second">
                <h1 class="specialty-title">
                    <a  href="#" >Specialty Two</a>
                </h1>
                <a class="more" title="Fake link" href="#" ><img src="<?php bloginfo('stylesheet_directory') ?>/images/sample-content/gourmet.png" width="330" height="208" alt="Alt text"/></a>
                <div class="specialty-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam velit quaerat consectetur eum modi est numquam eos nisi et aliquam!</p>
                </div>
            </section><!-- specialty-2 -->
            <section id="specialty-3" class="specialty third">
                <h1 class="specialty-title">
                    <a  href="#" >Specialty Three</a>
                </h1>
                <a class="more" title="Fake link" href="#" ><img width="330" height="208" src="<?php bloginfo('stylesheet_directory') ?>/images/sample-content/chopa.jpg" alt="Alt text"/></a>
                <div class="specialty-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam velit quaerat consectetur eum modi est numquam eos nisi et aliquam!</p>
                </div>
            </section><!-- specialty-3 -->
        </section><!-- specialties -->
 <?php endif; ?>

        <?php if (is_active_sidebar('home-bottom-1') || is_active_sidebar('home-bottom-2') || is_active_sidebar('home-bottom-3')): ?>
            <section class="bottom-sidebar">
                <?php if (is_active_sidebar('home-bottom-1')): ?>
                    <div class="widget-area first">
                        <?php dynamic_sidebar('home-bottom-1'); ?>
                    </div><!-- .widget-area -->
                <?php endif; ?>
                <?php if (is_active_sidebar('home-bottom-2')): ?>
                    <div class="widget-area second">
                        <?php dynamic_sidebar('home-bottom-2'); ?>
                    </div><!-- .widget-area -->
                <?php endif; ?>
                <?php if (is_active_sidebar('home-bottom-3')): ?>
                    <div class="widget-area third">
                        <?php dynamic_sidebar('home-bottom-3'); ?>
                    </div><!-- .widget-area -->
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>