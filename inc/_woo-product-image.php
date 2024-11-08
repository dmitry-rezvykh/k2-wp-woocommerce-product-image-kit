<?php
/**
 * functions for Woocommerce product image slider and photoswiper
 */

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

if (function_exists('add_image_size')) {
    add_image_size('slider-thumb', 80, 9999);
    add_image_size('slider-main', 750, 9999);
    add_image_size('gallery-img', 1200, 9999);
}

function wc_get_img_alt(int $imgId, int $productId):string
{
    $imgAlt = get_post_meta($imgId, '_wp_attachment_image_alt', true);
    if (!empty($imgAlt)) {
        return $imgAlt;
    }
    $title = '';
    if (function_exists('carbon_get_post_meta')) {
        $title .= carbon_get_post_meta($productId, 'crb_long_name') . " ";
    }
    $title .= get_the_title($productId);

    return $title;
}
