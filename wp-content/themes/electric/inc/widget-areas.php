<?php

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Electric Theme 1.0
 */

function electric_widgets_init() {
    register_sidebar(array(
        'name' => __('Main sidebar', 'electric'),
        'description' => __('The main sidebar for the blog', 'electric'),
        'id' => 'main-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Secondary sidebar', 'electric'),
        'description' => __('Auxiliary sidebar for the blog,  hidden for mobile, ideally for advertising', 'electric'),
        'id' => 'secondary-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Top area 1', 'electric'),
        'id' => 'top-1',
        'description' => __('A widget area in your header', 'electric'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Top area 2', 'electric'),
        'id' => 'top-2',
        'description' => __('A second widget area in your header', 'electric'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Footer area One', 'electric'),
        'id' => 'footer-sidebar-1',
        'description' => __('An optional widget area for your site footer', 'electric'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Footer area two', 'electric'),
        'id' => 'footer-sidebar-2',
        'description' => __('An optional widget area for your site footer', 'electric'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Footer area three', 'electric'),
        'id' => 'footer-sidebar-3',
        'description' => __('An optional widget area for your site footer', 'electric'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Home showcase 1', 'electric'),
        'description' => __('Big showcase space at the front page', 'electric'),
        'id' => 'home-showcase-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>'
    ));

    register_sidebar(array(
        'name' => __('Home showcase 2', 'electric'),
        'description' => __('Big showcase space at the front page', 'electric'),
        'id' => 'home-showcase-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>'
    ));

    register_sidebar(array(
        'name' => __('Home middle 1', 'electric'),
        'description' => __('Widget area in the front page, below the showcase, 1', 'electric'),
        'id' => 'home-middle-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Home middle 2', 'electric'),
        'description' => __('Widget area in the front page, below the showcase, 2', 'electric'),
        'id' => 'home-middle-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Home middle 3', 'electric'),
        'description' => __('Widget area in the front page, below the showcase, 3', 'electric'),
        'id' => 'home-middle-3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Home bottom 1', 'electric'),
        'description' => __('Widget area in the front page, over the footer, 1', 'electric'),
        'id' => 'home-bottom-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Home bottom 2', 'electric'),
        'description' => __('Widget area in the front page, over the footer, 2', 'electric'),
        'id' => 'home-bottom-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Home bottom 3', 'electric'),
        'description' => __('Widget area in the front page, over the footer, 3', 'electric'),
        'id' => 'home-bottom-3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('About aside', 'electric'),
        'description' => __('Widget area in the about template', 'electric'),
        'id' => 'about-aside',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));

    register_sidebar(array(
        'name' => __('Contact Sidebar', 'electric'),
        'description' => __('Widget area in the contact template', 'electric'),
        'id' => 'contact-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>'
    ));
}

add_action('widgets_init', 'electric_widgets_init');
?>
