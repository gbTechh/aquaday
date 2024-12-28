<?php
/**
 * The template for displaying product content in the single-product.php template
 */

defined('ABSPATH') || exit;

global $product;
$description = $product->get_description();

?>

<div class="flex flex-col md:flex-row gap-8">
    <!-- Columna Izquierda: Galería -->
    <div class="relative w-full md:w-1/2">
        <?php if ($product->is_on_sale()) : ?>
            <span class="absolute top-2 right-2 bg-blue-500 text-white px-2 py-1 text-xs rounded-full z-10">
                <?php
                $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                echo "-{$percentage}%";
                ?>
            </span>
        <?php endif; ?>

        <?php
        if ($product->is_featured()) : ?>
            <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded-full z-10">HOT</span>
        <?php endif; ?>

        <!-- Imagen principal -->
        <?php
        if (has_post_thumbnail()) {
            $main_image = wp_get_attachment_image(get_post_thumbnail_id(), 'large');
            echo '<div class="main-image mb-4">' . $main_image . '</div>';
        }
        ?>

        <!-- Galería de imágenes -->
        <?php
        $attachment_ids = $product->get_gallery_image_ids();
        if ($attachment_ids) {
            echo '<div class="flex flex-row overflow-x-scroll flex-nowrap gap-4">';
            foreach ($attachment_ids as $attachment_id) {
                $gallery_image = wp_get_attachment_image($attachment_id, 'thumbnail', false, array('class' => 'gallery-image cursor-pointer'));
                echo '<div class="gallery-image-wrapper">' . $gallery_image . '</div>';
            }
            echo '</div>';
        }
        ?>
       
    </div>

    <!-- Columna Derecha: Información -->
    <div class="w-full md:w-1/2 space-y-3">
        <h1 class="text-3xl font-bold text-texto-primary"><?php the_title(); ?></h1>
         <!-- Precio -->
        <div class="w-full my-1">
            <?php if ($product->is_on_sale()) : ?>
                <p class="text-texto-paragraph line-through text-sm">
                    <?php echo wc_price($product->get_regular_price()); ?>
                </p>
            <?php endif; ?>
            <p class="text-3xl font-bold text-texto-title">
                <?php echo wc_price($product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price()); ?>
            </p>
        </div>
        <?php 
        $ficha_tecnica = get_field('ficha_tecnica');
        if($ficha_tecnica): ?>
            <div class="mt-4">
                <a href="<?php echo esc_url($ficha_tecnica['url']); ?>" 
                  target="_blank"
                  class="inline-flex items-center gap-2 bg-slate-200 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Descargar Ficha Técnica
                </a>
            </div>
        <?php endif; ?>
        <!-- Características -->
        <div class="space-y-4">
            <?php
            // Mostrar la descripción corta del producto
            $short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

            if (!empty($short_description)) {
                echo '<div class="product-short-description">';
                echo wp_kses_post($short_description);
                echo '</div>';
            }
            ?>
        </div>

       
        <!-- Cantidad y Botones -->
        <div class="space-y-4">
            <form class="cart" method="post" enctype="multipart/form-data">
                <!-- Cantidad -->
                <div class="flex items-center gap-4 mb-4">
                  <label for="quantity" class="text-gray-600 font-bold">Cantidad:</label>
                  <?php
                  woocommerce_quantity_input(array(
                      'input_id'   => 'quantity',
                      'input_name' => 'quantity',
                      'input_value'=> isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                      'min_value'  => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                      'max_value'  => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                      'classes'    => array('bg-gray-200 rounded-full px-4 py-2 w-20 text-center focus:outline-none focus:ring-2 focus:ring-blue-500'),
                  ));
                  ?>
              </div>


                <!-- Botones de acción -->
                <div class="flex flex-row gap-2 flex-wrap">
                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
                            class="p-4 flex-1 min-w-fit bg-bg-primary hover:bg-black text-white font-medium py-3 px-6 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Agregar al Carrito
                    </button>

                   <a href="<?php 
                    $initial_message = "Hola, me interesa este producto " . $product->get_name() . " [1]. Precio total " . wc_price($product->get_price());
                    echo esc_url('https://api.whatsapp.com/send?text=' . urlencode($initial_message));
                    ?>" 
                  id="whatsapp-button"
                  target="_blank"
                  class="bg-green-500 flex-1 min-w-fit hover:bg-green-600 text-white font-medium py-3 px-6 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Comprar por WhatsApp
                </a>
                </div>
            </form>
        </div>
        <div class="rounded-md p-4 bg-blue-100">
          <?php
          $randomNumber = mt_rand(15, 20);
          ?>
          <p class="paragraph-sm text-texto-paragraph"><span class="text-texto-primary"><?= $randomNumber?></span> ¡Personas viendo este producto ahora!</p>
        </div>
        <div class="border-b-[1px] border-b-gray-200 w-full mt-2"></div>
        <div>
          <div class="w-full">
            <div class="space-y-4">
              <!-- Accordion Item 1 -->
              <div class="rounded-lg overflow-hidden bg-white hover:bg-gray-50 shadow-sm">
                <button
                  class="w-full gap-1 flex  justify-start items-center p-4  transition-all  text-gray-800 font-medium  focus:outline-none"
                  onclick="toggleAccordion(event)"
                >
                  
                  <svg
                    class="w-4 h-4 transform transition-transform"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"
                    />
                  </svg>
                  <span class="parapgraph-sm  text-gray-700 ">Despacho a domicilio</span>
                </button>
                <div class="p-4 pt-0 bg-transparent hidden text-texto-paragraph">
                  <?= get_field('despacho', get_the_ID())?>
                </div>
              </div>
              <div class="rounded-lg overflow-hidden bg-white hover:bg-gray-50 shadow-sm">
                <button
                  class="w-full gap-1 flex  justify-start items-center p-4  transition-all  text-gray-800 font-medium  focus:outline-none"
                  onclick="toggleAccordion(event)"
                >
                  
                  <svg
                    class="w-4 h-4 transform transition-transform"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"
                    />
                  </svg>
                  <span class="parapgraph-sm  text-gray-700 ">Retira tu compra</span>
                </button>
                <div class="p-4 pt-0 bg-transparent hidden text-texto-paragraph">
                  <?= get_field('retira_tu_compra', get_the_ID())?>
                </div>
              </div>
              <div class="rounded-lg overflow-hidden bg-white hover:bg-gray-50 shadow-sm">
                <button
                  class="w-full gap-1 flex  justify-start items-center p-4  transition-all  text-gray-800 font-medium  focus:outline-none"
                  onclick="toggleAccordion(event)"
                >
                  
                  <svg
                    class="w-4 h-4 transform transition-transform"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"
                    />
                  </svg>
                  <span class="parapgraph-sm  text-gray-700 ">Información adicional</span>
                </button>
                <div class="p-4 pt-0 bg-transparent hidden text-texto-paragraph">
                  <?= get_field('informacion__adicional', get_the_ID())?>
                </div>
              </div>

            
            </div>
          </div>
        </div>
    </div>
</div>

<div class="w-full py-5 border-t-[1px] border-gray-200 my-5">
  <h2 class="border-b-[1px] border-gray-200 pb-5 w-full text-center">Descripción</h2>
  <?php 
    if ($description) { ?>
        <div class="flex flex-col mt-4 gap-4 paragraph-sm text-texto-paragraph"><?=  apply_filters('the_content', $description)?></div>
    <?php }
  ?>
</div>

<?php
// Productos relacionados
$related_limit = 4; // Número de productos relacionados a mostrar
$related_ids = wc_get_related_products($product->get_id(), $related_limit);

if ($related_ids) : ?>
    <div class="mt-12 border-t border-gray-200 py-8 pb-20">
        <h2 class="text-2xl font-bold text-texto-primary mb-6 text-left">Productos Relacionados</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($related_ids as $related_id) :
                $related_product = wc_get_product($related_id);
                if (!$related_product) continue;
            ?>
                <div class="group relative bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <a href="<?php echo esc_url($related_product->get_permalink()); ?>" class="block">
                        <!-- Imagen del producto -->
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
                            <?php echo $related_product->get_image('woocommerce_thumbnail', array('class' => 'w-full h-full object-center object-cover')); ?>
                        </div>

                        <!-- Información del producto -->
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-texto-primary">
                                <?php echo esc_html($related_product->get_name()); ?>
                            </h3>

                            <div class="mt-2 flex items-center justify-between">
                                <div>
                                    <?php if ($related_product->is_on_sale()) : ?>
                                        <span class="text-xs line-through text-gray-500">
                                            <?php echo wc_price($related_product->get_regular_price()); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="text-lg font-bold text-texto-primary">
                                        <?php echo wc_price($related_product->get_price()); ?>
                                    </span>
                                </div>

                                <?php if ($related_product->is_on_sale()) : ?>
                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                        <?php
                                        $percentage = round((($related_product->get_regular_price() - $related_product->get_sale_price()) / $related_product->get_regular_price()) * 100);
                                        echo "-{$percentage}%";
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<script>
  // Variables globales del producto
const productData = {
    name: <?php echo json_encode($product->get_name()); ?>,
    price: <?php echo $product->get_price(); ?>
};
// Función para formatear el precio
function formatPrice(price) {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
}

// Función para actualizar el enlace de WhatsApp
function updateWhatsAppLink() {
    const quantityInput = document.querySelector('input[name="quantity"]');
    if (!quantityInput) return;

    const quantity = parseInt(quantityInput.value) || 1;
    const totalPrice = quantity * productData.price;
    
    const message = `Hola, me interesa este producto ${productData.name} [${quantity}]. Precio total ${formatPrice(totalPrice)}`;
    const whatsappButton = document.getElementById('whatsapp-button');
    if (whatsappButton) {
        whatsappButton.href = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.querySelector('.main-image img');
    const galleryImages = document.querySelectorAll('.gallery-image');
    console.log({mainImage})
    console.log({galleryImages})
    galleryImages.forEach((image, index) => {
        image.addEventListener('click', () => {
          console.log('click')
          mainImage.src = image.src;
          mainImage.srcset = image.srcset;
        });
    });
    const quantityInput = document.querySelector('input[name="quantity"]');
    if (quantityInput) {
        quantityInput.addEventListener('change', updateWhatsAppLink);
        quantityInput.addEventListener('input', updateWhatsAppLink);
    }
    
});

function toggleAccordion(event) {
    const button = event.currentTarget;
    const content = button.nextElementSibling;
    const isOpen = !content.classList.contains("hidden");

    // Close all other accordion items
    document.querySelectorAll(".space-y-4 > div > div").forEach((item) => {
      item.classList.add("hidden");
      item.previousElementSibling.querySelector("svg").classList.remove("rotate-180");
    });

    // Toggle the current accordion item
    if (isOpen) {
      content.classList.add("hidden");
      button.querySelector("svg").classList.remove("rotate-180");
    } else {
      content.classList.remove("hidden");
      button.querySelector("svg").classList.add("rotate-180");
    }
  }
function updateWhatsAppLink() {
    const quantity = document.querySelector('input[name="quantity"]').value;
    const productName = <?php echo json_encode($product->get_name()); ?>;
    const productPrice = <?php echo $product->get_price(); ?>;
    const totalPrice = (quantity * productPrice).toFixed(2);
    
    const message = `Hola, me interesa este producto ${productName} [${quantity}]. Precio total $${totalPrice}`;
    const encodedMessage = encodeURIComponent(message);
    
    document.getElementById('whatsapp-button').href = `https://api.whatsapp.com/send?text=${encodedMessage}`;
}


</script>