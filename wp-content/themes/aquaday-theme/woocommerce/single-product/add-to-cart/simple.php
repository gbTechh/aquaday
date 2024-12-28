<?php
/**
 * Simple product add to cart
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product);

if ($product->is_in_stock()) : ?>
    <div class="cart-actions space-y-4">
        <div class="flex items-center gap-4">
            <div class="quantity flex border rounded">
                <button class="px-3 py-2 hover:bg-gray-100 quantity-minus" type="button">-</button>
                <input 
                    type="number" 
                    id="quantity" 
                    class="w-16 text-center border-x" 
                    name="quantity" 
                    value="1" 
                    min="1" 
                    max="<?php echo $product->get_max_purchase_quantity(); ?>"
                >
                <button class="px-3 py-2 hover:bg-gray-100 quantity-plus" type="button">+</button>
            </div>
        </div>

        <button 
            type="submit" 
            name="add-to-cart" 
            value="<?php echo esc_attr($product->get_id()); ?>" 
            class="w-full bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition-colors add-to-cart-button"
        >
            Agregar al carrito
        </button>

        <?php 
        // Botón de WhatsApp si existe el campo ACF
        if (function_exists('get_field')) : 
            $whatsapp = get_option('theme_contact_whatsapp');
            if ($whatsapp) :
                $message = urlencode("Me interesa el producto: " . get_the_title() . " - " . get_permalink());
                $whatsapp_url = "https://wa.me/$whatsapp?text=$message";
        ?>
            <a 
                href="<?php echo esc_url($whatsapp_url); ?>" 
                target="_blank"
                class="w-full bg-green-500 text-white text-center px-6 py-3 rounded hover:bg-green-600 transition-colors flex items-center justify-center gap-2"
            >
                <i class="fab fa-whatsapp"></i>
                Consultar por WhatsApp
            </a>
        <?php 
            endif;
        endif;
        ?>
    </div>
<?php endif; ?>