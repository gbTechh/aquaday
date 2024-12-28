<?php
/**
 * Single Product Thumbnails
 */

defined('ABSPATH') || exit;

global $product;

$attachment_ids = $product->get_gallery_image_ids();

if ($attachment_ids && $product->get_image_id()) {
    echo '<div class="product-thumbnails grid grid-cols-4 gap-4">';
    foreach ($attachment_ids as $attachment_id) {
        echo '<div class="thumbnail-item">';
        echo wp_get_attachment_image($attachment_id, 'woocommerce_gallery_thumbnail', false, array(
            'class' => 'w-full h-full object-cover cursor-pointer rounded'
        ));
        echo '</div>';
    }
    echo '</div>';
}