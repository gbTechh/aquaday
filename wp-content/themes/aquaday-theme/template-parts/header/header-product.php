<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
  <?php wp_head(); ?>
</head>
<body class="min-h-screen relative">
  <!-- Carrito lateral -->
  <div id="cart-sidebar" class="fixed top-0 right-0 w-[400px] h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-[60]">
    <div class="h-full flex flex-col">
      <!-- Header del carrito -->
      <div class="flex justify-between items-center p-4 border-b">
        <h2 class="text-lg font-semibold flex items-center gap-2">
          <i class='bx bx-cart'></i>
          Carrito de compras
          <span id="cart-count" class="text-sm text-gray-500"></span>
        </h2>
        <button id="close-cart" class="text-gray-400 hover:text-gray-600">
          <i class='bx bx-x text-2xl'></i>
        </button>
      </div>

      <!-- Contenido del carrito -->
      <div class="flex-grow overflow-y-auto p-4" id="cart-items">
        <?php
        if (class_exists('WooCommerce')) {
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $product = $cart_item['data'];
                $product_id = $cart_item['product_id'];
                ?>
                <div class="flex items-center gap-4 mb-4 cart-item" data-key="<?php echo $cart_item_key; ?>">
                    <img src="<?php echo get_the_post_thumbnail_url($product_id, 'thumbnail'); ?>" 
                         alt="<?php echo $product->get_name(); ?>"
                         class="w-20 h-20 object-cover rounded">
                    <div class="flex-grow">
                        <h3 class="font-medium"><?php echo $product->get_name(); ?></h3>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-2">
                                <button class="quantity-minus px-2 py-1 border rounded">-</button>
                                <input type="number" 
                                       value="<?php echo $cart_item['quantity']; ?>" 
                                       class="w-12 text-center border rounded"
                                       min="1">
                                <button class="quantity-plus px-2 py-1 border rounded">+</button>
                            </div>
                            <span class="font-semibold"><?php echo $product->get_price_html(); ?></span>
                        </div>
                    </div>
                    <button class="remove-item text-gray-400 hover:text-red-500" data-key="<?php echo $cart_item_key; ?>">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </div>
                <?php
            }
        }
        ?>
      </div>

      <!-- Footer del carrito -->
      <div class="border-t p-4 space-y-4">
        <!-- Subtotal -->
        <div class="flex justify-between items-center">
          <span>Subtotal</span>
          <span class="font-semibold" id="cart-subtotal">
            <?php echo WC()->cart->get_cart_subtotal(); ?>
          </span>
        </div>

        <!-- Botones de acción -->
        <div class="space-y-2">
          <!-- Botón de WhatsApp -->
          <button id="share-whatsapp" 
                  class="w-full bg-green-500 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2 hover:bg-green-600">
              <i class='bx bxl-whatsapp'></i>
              Compartir en WhatsApp
          </button>
                    
          <!-- Botón de Checkout -->
          <!-- <a href="<?php echo wc_get_checkout_url(); ?>" class="block w-full bg-bg-primary text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700">
            Ir a pagar
          </a> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Overlay para el fondo oscuro -->
  <div id="cart-overlay" class="fixed inset-0 bg-black opacity-50 hidden z-50"></div>

 
  <!-- Header principal -->
  <div class=" h-auto shadow-sm flex flex-col  relative z-50 w-full">
    <div class="w-full flex justify-between items-center bg-white px-6 md:px-8 h-14 gap-10 rounded-full">
      <!-- Logo -->
      <div class="logo-container">
        <?php if (has_custom_logo()): 
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        ?>
            <a href="<?php echo home_url('/'); ?>" class="w-[80px] block">
                <img src="<?php echo esc_url($logo[0]); ?>" 
                     alt="<?php echo get_bloginfo('name'); ?>" 
                     class="w-full logo" />
            </a>
        <?php else: ?>
            <a href="<?php echo home_url('/'); ?>" class="text-xl">
                <?php echo get_bloginfo('name'); ?>
            </a>
        <?php endif; ?>
      </div>
     
      <!-- Menú principal -->
      <?php 
      wp_nav_menu(array(
        'theme_location' => 'menu-principal',
        'container' => 'nav',
        'container_class' => 'hidden hd:flex menu-item capitalize w-full h-full justify-start items-center',
        'menu_class' => 'flex items-center gap-6 h-full', // Agregamos esta clase
        'walker' => new Custom_Nav_Walker() // Usaremos un walker personalizado
      ));
      ?>
    
      <!-- Navegación de tienda y carrito -->
      <div class="menu-nav h-full w-full hd:w-[450px] hd:min-w-[450px] flex items-center justify-between gap-4">
        <?php 
        wp_nav_menu(array(
          'theme_location' => 'tienda',
          'container' => 'nav',
          'container_class' => ' menu-tienda w-full flex items-center justify-end  flex-1 h-full'
        ));
        ?>
        
        <!-- Icono del carrito -->
        <?php if (class_exists('WooCommerce')) : ?>
            <div class="cart-icon relative cursor-pointer">
              <button class="flex items-center text-texto-primary">
                  <i class='bx bx-cart text-2xl'></i>
                  <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
                      <span class="cart-count absolute -top-2 -right-2 bg-bg-primary text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                          <?php echo WC()->cart->get_cart_contents_count(); ?>
                      </span>
                  <?php endif; ?>
              </button>
          </div>
        <?php endif; ?>
        <div class="burguer grid place-items-center">
          <button class="text-2xl flex items-center justify-center js-btn-burguer" >
            <i class='bx bx-menu-alt-right'></i>
          </button>
        </div>
      </div>
    </div>
  </div>


  <!-- Menú móvil -->
  <div id="mobile-menu" class="mobile-menu fixed hidden top-0 left-0 w-full h-screen bg-white transform -translate-x-full transition-transform duration-300 z-50">
      <div class="h-full flex flex-col">
          <div class="flex justify-between items-center p-4 border-b">
              <h2 class="text-lg font-semibold">Menú</h2>
              <button id="close-mobile-menu" class="text-gray-400 hover:text-gray-600">
                  <i class='bx bx-x text-2xl'></i>
              </button>
          </div>
          <div class="flex-grow overflow-y-auto p-4">
              <?php 
              wp_nav_menu(array(
                  'theme_location' => 'menu-principal',
                  'container' => 'nav',
                  'container_class' => 'mobile-menu-items',
                  'menu_class' => 'space-y-4'
              ));
              
              wp_nav_menu(array(
                  'theme_location' => 'tienda',
                  'container' => 'nav',
                  'container_class' => 'mobile-menu-items mt-6',
                  'menu_class' => 'space-y-4'
              ));
              ?>
          </div>
      </div>
  </div>

  <!-- Mini notificación para productos agregados -->
  <div id="cart-notification" class="fixed top-4 -right-14 bg-green-500 text-white p-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50 hidden">
    Producto agregado al carrito
  </div>

<script>
// Función para formatear precio
function formatPrice(price) {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
}

// Función para generar el mensaje de WhatsApp con los productos del carrito
function generateWhatsAppMessage() {
    const cartItems = document.querySelectorAll('#cart-items .cart-item');
    let message = "Hola, me interesan los siguientes productos:\n\n";
    let total = 0;

    cartItems.forEach((item) => {
        const productName = item.querySelector('h3').textContent;
        const quantity = item.querySelector('input[type="number"]').value;
        const price = parseFloat(item.querySelector('.font-semibold').textContent.replace(/[^0-9.]/g, ''));
        const subtotal = quantity * price;
        total += subtotal;

        message += `▪️ ${productName}\n`;
        message += `   Cantidad: ${quantity}\n`;
        message += `   Precio unitario: ${formatPrice(price)}\n`;
        message += `   Subtotal: ${formatPrice(subtotal)}\n\n`;
    });

    message += `\nTotal: ${formatPrice(total)}`;
    return message;
}

// Event listener para el botón de WhatsApp
document.addEventListener('DOMContentLoaded', function() {
    const whatsappButton = document.getElementById('share-whatsapp');
    if (whatsappButton) {
        whatsappButton.addEventListener('click', function() {
            const message = generateWhatsAppMessage();
            const encodedMessage = encodeURIComponent(message);
            window.open(`https://api.whatsapp.com/send?text=${encodedMessage}`, '_blank');
        });
    }

    // Actualizar mensaje cuando cambian las cantidades
    const quantityInputs = document.querySelectorAll('.cart-item input[type="number"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Actualizar subtotal y total si es necesario
            updateCartTotals();
        });
    });

    // Event listeners para los botones + y -
    document.querySelectorAll('.quantity-plus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
            input.dispatchEvent(new Event('change'));
        });
    });

    document.querySelectorAll('.quantity-minus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
});

// Función para actualizar los totales del carrito
function updateCartTotals() {
    // Aquí puedes agregar la lógica para actualizar los subtotales y total
    // si lo necesitas en tiempo real
}
</script>