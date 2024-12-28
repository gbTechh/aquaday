jQuery(document).ready(function ($) {
  // Manejar el click en "Añadir al carrito"
  $(document).on('click', '.add_to_cart_button', function (e) {
    e.preventDefault();

    var $button = $(this);
    var $form = $button.closest('form');
    var productId = $button.data('product_id');

    // Añadir clase de carga
    $button.addClass('loading');

    $.ajax({
      type: 'POST',
      url: wc_add_to_cart_params.ajax_url,
      data: {
        action: 'woocommerce_ajax_add_to_cart',
        product_id: productId,
        quantity: 1
      },
      success: function (response) {
        if (response.fragments) {
          // Actualizar fragmentos del carrito
          $.each(response.fragments, function (key, value) {
            $(key).replaceWith(value);
          });
        }
        // Actualizar contador del carrito
        $('.cart-icon .count').text(response.cart_contents_count);

        // Mostrar notificación
        showNotification('Producto añadido al carrito');

        $button.removeClass('loading');
      },
      error: function () {
        showNotification('Error al añadir al carrito', 'error');
        $button.removeClass('loading');
      }
    });
  });

  // Función para mostrar notificaciones
  function showNotification(message, type = 'success') {
    const notification = $(`
            <div class="fixed top-4 right-4 bg-white shadow-lg rounded-lg p-4 notification ${type}">
                ${message}
            </div>
        `);

    $('body').append(notification);

    setTimeout(() => {
      notification.fadeOut(() => notification.remove());
    }, 3000);
  }
});