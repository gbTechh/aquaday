<div class="flex items-center gap-4 mb-4 cart-item" data-key="<?php echo $cart_item_key; ?>">
  <img src="<?php echo get_the_post_thumbnail_url($product_id, 'thumbnail'); ?>" 
        alt="<?php echo esc_attr($product->get_name()); ?>"
        class="w-20 h-20 object-cover rounded">
  
  <div class="flex-grow">
    <h3 class="font-medium"><?php echo esc_html($product->get_name()); ?></h3>
    <div class="flex items-center justify-between mt-2">
      <div class="flex items-center gap-2">
        <button class="quantity-minus px-2 py-1 border rounded">-</button>
        <input type="number" 
                value="<?php echo esc_attr($cart_item['quantity']); ?>" 
                class="w-12 text-center border rounded"
                min="1">
        <button class="quantity-plus px-2 py-1 border rounded">+</button>
      </div>
      <span class="font-semibold"><?php echo $product->get_price_html(); ?></span>
    </div>
  </div>
  
  <button class="remove-item text-gray-400 hover:text-red-500" 
        data-key="<?php echo esc_attr($cart_item_key); ?>">
    <i class='bx bx-x text-xl'></i>
</button>
</div>