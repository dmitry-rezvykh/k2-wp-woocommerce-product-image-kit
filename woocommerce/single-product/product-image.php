<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
        'woocommerce-product-gallery',
        'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
        'woocommerce-product-gallery--columns-' . absint($columns),
        'col-md-6'
    )
);
$attachment_ids = $product->get_gallery_image_ids();

?>
<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>"
    data-columns="<?php echo esc_attr($columns); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <div class="swiper single-product-slider" id="single-product-slider">
        <div class="woocommerce-product-gallery__wrapper swiper-wrapper">
            <div class="swiper-slide single-product-slider__slide">
                <?php
                if (empty($post_thumbnail_id)) { ?>
                    <?= wc_placeholder_img('gallery-img') ?>
                <?php } else {
                    $mainGalleryImageInfo = wp_get_attachment_image_src($post_thumbnail_id, 'gallery-img');
                    $mainSliderImageInfo = wp_get_attachment_image_src($post_thumbnail_id, 'slider-main');
                    ?>
                    <a href="<?= $mainGalleryImageInfo[0] ?>" data-pswp-width="<?= $mainGalleryImageInfo[1] ?>"
                        data-pswp-height="<?= $mainGalleryImageInfo[2] ?>">
                        <img src="<?= $mainSliderImageInfo[0] ?>" alt="<?= wc_get_img_alt($post_thumbnail_id, $product->get_id()) ?>">
                    </a>
                <?php }
                ; ?>
            </div>
            <?php
            foreach ($attachment_ids as $image_id) :
                $imgGalleryInfo = wp_get_attachment_image_src($image_id, 'gallery-img');
                $imgSliderInfo = wp_get_attachment_image_src($image_id, 'slider-main');
                if ($imgGalleryInfo) :
                    ?>
                    <div class="swiper-slide single-product-slider__slide">
                        <a href="<?= $imgGalleryInfo[0] ?>" data-pswp-width="<?= $imgGalleryInfo[1] ?>"
                            data-pswp-height="<?= $imgGalleryInfo[2] ?>">
                            <img src="<?= $imgSliderInfo[0] ?>" alt="<?= wc_get_img_alt($image_id, $product->get_id()) ?>">
                        </a>
                    </div>
                    <?php
                endif;
            endforeach;
            ?>
        </div>

        <div class="swiper-button-prev">
            <i class="icon-arrow-left"></i>
        </div>
        <div class="swiper-button-next">
            <i class="icon-arrow-right"></i>
        </div>
    </div>
    <div class="swiper single-product-slider single-product-slider--thumbnails mt-3"
        id="single-product-slider-thumbnails">
        <div class="swiper-wrapper">
            <div class="swiper-slide single-product-slider__slide">
                <?php if (empty($post_thumbnail_id)) : ?>
                    <?= wc_placeholder_img('slider-thumb', ['class' => 'img-fluid']) ?>
                <?php else : ?>
                    <?= wp_get_attachment_image(
                        $post_thumbnail_id, 
                        'slider-thumb', 
                        false, 
                        ['class' => 'img-fluid', 'alt' => wc_get_img_alt($post_thumbnail_id, $product->get_id())]) ?>
                <?php endif; ?>
            </div>
            <?php
            foreach ($attachment_ids as $image_id) :
                $imgTag = wp_get_attachment_image(
                    $image_id, 
                    'slider-thumb', 
                    false, 
                    ['class' => 'img-fluid', 'alt' => wc_get_img_alt($image_id, $product->get_id())]);
                if (!empty($imgTag)) :
                    ?>
                    <div class="swiper-slide single-product-slider__slide">
                        <?= $imgTag ?>
                    </div>
                    <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const swiperThumbs = new Swiper('#single-product-slider-thumbnails', {
            slidesPerView: 8,
            centerInsufficientSlides: true,
        });
        const swiper = new Swiper('#single-product-slider', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });

        const closeSVG = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.4069 12.0066L23.6947 1.7188C24.0918 1.33532 24.1028 0.702587 23.7193 0.305521C23.3358 -0.0915446 22.7031 -0.102555 22.306 0.280924C22.2977 0.288948 22.2895 0.297147 22.2814 0.305521L11.9935 10.5933L1.70569 0.305463C1.30863 -0.0780163 0.675897 -0.0670062 0.292417 0.33006C-0.0816926 0.717404 -0.0816926 1.33145 0.292417 1.7188L10.5803 12.0066L0.292417 22.2944C-0.0977978 22.6847 -0.0977978 23.3174 0.292417 23.7077C0.68269 24.0979 1.31542 24.0979 1.70569 23.7077L11.9935 13.4199L22.2814 23.7077C22.6784 24.0912 23.3112 24.0802 23.6946 23.6831C24.0687 23.2958 24.0687 22.6817 23.6946 22.2944L13.4069 12.0066Z" fill="black"></path></svg>'
        const productsImgGallery = new PhotoSwipeLightbox({
            gallery: '.woocommerce-product-gallery__wrapper',
            children: 'a',
            pswpModule: PhotoSwipe,
            bgOpacity: 1,
            zoom: false,
            counter: false,
            showHideAnimationType: 'fade',
            mainClass: 'pswp--custom-bg',
            showAnimationDuration: 0,
            hideAnimationDuration: 0,
            closeSVG: closeSVG,
            paddingFn: (viewportSize) => {
                let mobile = viewportSize.x < 769 ? true : false
                return {
                    top: mobile ? 60 : 0,
                    bottom: mobile ? 75 : 0,
                    left: mobile ? 15 : 0,
                    right: mobile ? 15 : 0,
                };
            }
        })
        productsImgGallery.init();

        productsImgGallery.on('uiRegister', function () {
            productsImgGallery.pswp.ui.registerElement({
                name: 'thumbnailsIndicator',
                order: 100,
                className: 'pswp__thumbnails-indicator',
                appendTo: 'wrapper',
                onInit: (el, pswp) => {
                    const wrapper = document.createElement('div')
                    wrapper.className = 'pswp__thumbnails-indicator-wrapper'
                    el.appendChild(wrapper)
                    const thumbnailsList = document.querySelectorAll('.single-product-slider--thumbnails .swiper-slide img')
                    const thumbnails = []
                    let thumbnail, image
                    let prevIndex = -1

                    for (let i = 0; i < pswp.getNumItems(); i++) {
                        thumbnail = document.createElement('div')
                        image = document.createElement('img')
                        image.className = 'pswp__thumbnail-image'
                        image.src = thumbnailsList[i].src
                        thumbnail.className = 'pswp__thumbnail'
                        image.onclick = (e) => {
                            pswp.goTo(thumbnails.indexOf(e.target.parentNode))
                            e.target.parentNode.scrollIntoView({ behavior: 'smooth' })
                        }
                        thumbnail.appendChild(image)
                        wrapper.appendChild(thumbnail)
                        thumbnails.push(thumbnail)
                    }

                    pswp.on('change', (a) => {
                        if (prevIndex >= 0) {
                            thumbnails[prevIndex].classList.remove('pswp__thumbnail--active')
                        }
                        thumbnails[pswp.currIndex].classList.add('pswp__thumbnail--active')
                        thumbnails[pswp.currIndex].scrollIntoView({ behavior: 'smooth' })
                        prevIndex = pswp.currIndex
                    })
                },
            })
        })
    });
</script>
