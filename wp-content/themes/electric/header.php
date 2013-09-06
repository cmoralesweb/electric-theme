<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Electric Theme
 * @since Electric Theme 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php language_attributes(); ?> class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width" />

    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->

        <?php electric_gog_analytics() ?>


        <?php wp_head();?>
        <?php global $single_page; ?>
    </head>

    <body <?php body_class(isset($single_page) ? "single-page" : "multi-column-page"); ?>>
        <!--[if lt IE 7]>
               <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
               <![endif]-->
            <?php electric_the_notification_area(); ?>
            <div id="outer-wrapper">
               <div id="page" class="hfeed site">
                <?php do_action('before'); ?>
                <header id="masthead" class="site-header" role="banner">
                    <div id="brand">
                        <h1 class="site-title">
                            <a id="homelink" href="<?php echo esc_url(home_url('/')); ?>"
                               title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                               <?php electric_the_logo(); ?>
                               <span><?php electric_the_custom_title(); ?></span>
                           </a>
                       </h1>
                       <p class="site-description"><?php electric_the_description(); ?></p>
                   </div>
                   <div class="widget-area first">
                    <?php if (!dynamic_sidebar('top-1')): ?>
                    The availabilty widget works best here
                <?php endif; ?>
            </div><!-- .widget-area -->
            <div class="widget-area second">
                <?php if (!dynamic_sidebar('top-2')): ?>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </div><!-- .widget-area -->

    </header><!-- #masthead .site-header -->
    <nav role="navigation" class="site-navigation main-navigation">
        <h1 class="assistive-text">
            <span aria-hidden="true" data-icon="&#xe024;"></span>
            <?php _e('Menu', 'electric'); ?>
        </h1>
        <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e('Skip to content', 'electric'); ?>"><?php _e('Skip to content', 'electric'); ?></a></div>

        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
    </nav><!-- .site-navigation .main-navigation -->
    <div id="main" class="site-main">

