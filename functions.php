<?php

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    if (is_product()) {

        //Swiper
        wp_enqueue_script('swiper-slider', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', ['jquery'], '', true);
        wp_enqueue_style('swiper-slider', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css');
        
        //Photoswipe
        wp_enqueue_script('photoswipe-5', get_stylesheet_directory_uri() . '/assets/js/photoswipe.umd.min.js', ['jquery'], '', true);
        wp_enqueue_script('photoswipe-5-lightbox', get_stylesheet_directory_uri() . '/assets/js/photoswipe-lightbox.umd.min.js', ['jquery'], '', true);
        
        wp_enqueue_style('photoswipe-5', get_stylesheet_directory_uri() . '/assets/css/photoswipe.css');
    }
}

add_action('after_setup_theme', 'remove_photoswipe_css', 11);
function remove_photoswipe_css()
{
    remove_theme_support('wc-product-gallery-zoom');
    remove_theme_support('wc-product-gallery-lightbox');
    remove_theme_support('wc-product-gallery-slider');
}

add_action('wp_enqueue_scripts', 'dequeue_photoswipe_css', 999);
function dequeue_photoswipe_css()
{
    wp_dequeue_style('photoswipe');
    wp_dequeue_style('photoswipe-default-skin-css');

    wp_dequeue_script('photoswipe-ui-default');
    wp_dequeue_script('photoswipe');
}