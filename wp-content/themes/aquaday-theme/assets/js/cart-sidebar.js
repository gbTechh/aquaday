jQuery(document).ready(function ($) {
  // Elementos del DOM
  const cartSidebar = $('#cart-sidebar');
  const cartOverlay = $('#cart-overlay');
  const headerCartIcon = $('.cart-icon');
  const closeCart = $('#close-cart');
  const cartItemsContainer = $('#cart-items');
  const cartCount = $('.cart-count');
  const cartSubtotal = $('#cart-subtotal');
  const shareWhatsApp = $('#share-whatsapp');
  const notification = $('#cart-notification');

  // Función para mostrar notificaciones
  function showNotification(message) {
    notification.text(message).removeClass('hidden').addClass('flex');
    setTimeout(() => {
      notification.removeClass('flex').addClass('hidden');
    }, 3000);
  }

  // Función para abrir el carrito
  function openCart() {
    cartSidebar.removeClass('translate-x-full');
    cartOverlay.removeClass('hidden');
    updateCart();
  }

  // Función para cerrar el carrito
  function closeCartSidebar() {
    cartSidebar.addClass('translate-x-full');
    cartOverlay.addClass('hidden');
  }

  // Función para actualizar todo el carrito
  function updateCart() {
    $.ajax({
      url: cart_vars.ajax_url,
      type: 'POST',
      data: {
        action: 'get_cart_contents',
        security: cart_vars.security
      },
      success: function (response) {
        if (response.success) {
          cartItemsContainer.html(response.data.items);
          if (response.data.cart_count > 0) {
            cartCount.text(response.data.cart_count).show();
          } else {
            cartCount.hide();
          }
          cartSubtotal.html(response.data.cart_total);
        }
      }
    });
  }

  // Función para actualizar cantidad de un item
  function updateCartItemQuantity(cartItemKey, quantity, $input) {
    $.ajax({
      url: cart_vars.ajax_url,
      type: 'POST',
      data: {
        action: 'update_cart_quantity',
        cart_item_key: cartItemKey,
        quantity: quantity,
        security: cart_vars.security
      },
      success: function (response) {
        if (response.success) {
          $input.val(quantity);
          cartSubtotal.html(response.data.cart_total);
          if (response.data.cart_count > 0) {
            cartCount.text(response.data.cart_count).show();
          } else {
            cartCount.hide();
          }
        }
      }
    });
  }

  // Event Listeners
  headerCartIcon.on('click', function (e) {
    e.preventDefault();
    openCart();
  });

  closeCart.on('click', function (e) {
    e.preventDefault();
    closeCartSidebar();
  });

  cartOverlay.on('click', closeCartSidebar);

  // Manejar click en añadir al carrito
  $(document).on('click', '.add_to_cart_button', function (e) {
    e.preventDefault();
    const $button = $(this);
    const productId = $button.data('product_id');

    $button.addClass('loading');

    $.ajax({
      type: 'POST',
      url: cart_vars.ajax_url,
      data: {
        action: 'woocommerce_ajax_add_to_cart',
        product_id: productId,
        quantity: 1,
        security: cart_vars.security
      },
      success: function (response) {
        $button.removeClass('loading');
        if (response.fragments) {  // WooCommerce devuelve fragments
          showNotification('Producto agregado al carrito');
          updateCart();
          openCart();
        } else {
          showNotification('Error al agregar el producto');
        }
      },
      error: function () {
        $button.removeClass('loading');
        showNotification('Error al agregar el producto');
      }
    });
  });

  // Compartir por WhatsApp
  shareWhatsApp.on('click', function (e) {
    e.preventDefault();
    $.ajax({
      url: cart_vars.ajax_url,
      type: 'POST',
      data: {
        action: 'get_cart_whatsapp',
        security: cart_vars.security
      },
      success: function (response) {
        if (response.success) {
          const whatsappUrl = `https://wa.me/${response.data.whatsapp_number}?text=${encodeURIComponent(response.data.message)}`;
          window.open(whatsappUrl, '_blank');
        }
      }
    });
  });

  // Manejo de cantidad en el carrito
  $(document).on('click', '.quantity-minus, .quantity-plus', function (e) {
    e.preventDefault();
    const $input = $(this).siblings('input[type="number"]');
    const currentVal = parseInt($input.val());
    const isPlus = $(this).hasClass('quantity-plus');
    const newVal = isPlus ? currentVal + 1 : Math.max(1, currentVal - 1);
    const cartItemKey = $(this).closest('.cart-item').data('key');

    updateCartItemQuantity(cartItemKey, newVal, $input);
  });

  $(document).on('change', '.cart-item input[type="number"]', function () {
    const $input = $(this);
    const newVal = parseInt($input.val());
    const cartItemKey = $input.closest('.cart-item').data('key');

    if (newVal >= 1) {
      updateCartItemQuantity(cartItemKey, newVal, $input);
    }
  });

  // Eliminar item del carrito
  $(document).on('click', '.remove-item', function (e) {
    e.preventDefault();
    const $item = $(this).closest('.cart-item');
    const key = $(this).data('key');

    $.ajax({
      url: cart_vars.ajax_url,
      type: 'POST',
      data: {
        action: 'remove_cart_item',
        cart_item_key: key,
        security: cart_vars.security
      },
      beforeSend: function () {
        $item.addClass('opacity-50');
      },
      success: function (response) {
        if (response.success) {
          $item.fadeOut(300, function () {
            $(this).remove();
            updateCart();
          });
        }
      },
      error: function () {
        $item.removeClass('opacity-50');
      }
    });
  });

  // Debug
  console.log('Cart sidebar JS loaded');
});