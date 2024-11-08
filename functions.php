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

require_once 'inc/_woo-product-image.php';
