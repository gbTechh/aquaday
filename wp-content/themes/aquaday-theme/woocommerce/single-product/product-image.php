<?php
/**
 * Single Product Image
 */

defined('ABSPATH') || exit;

global $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
$wrapper_classes = apply_filters('woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--with-images',
    'images',
    'relative'
));
?>
<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>">
    <figure class="woocommerce-product-gallery__wrapper mb-4">
        <?php
        if ($product->get_image_id()) {
            $html = wc_get_gallery_image_html($product->get_image_id(), true);
        } else {
            $html = '<div class="woocommerce-product-gallery__image--placeholder">';
            $html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
            $html .= '</div>';
        }

        echo $html;
        ?>
    </figure>
</div>