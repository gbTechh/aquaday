<?php
/**
 * The Template for displaying product archives, including the main shop page
 */

get_header(); 

// Obtener el ID de la página de tienda de WooCommerce
$shop_page_id = wc_get_page_id('shop');
$img = get_field('imagen', $shop_page_id);

if($img) {
    $mobile_img = wp_get_attachment_image_src($img['ID'], 'slider-mobile');
    $tablet_img = wp_get_attachment_image_src($img['ID'], 'slider-tablet');
    $desktop_img = wp_get_attachment_image_src($img['ID'], 'slider-desktop');
    ?>
        <header class="w-full h-screen max-h-[280px] hd:max-h-[320px] relative">
          <div class="absolute inset-0 bg-black/50"></div>
          <picture class="w-full h-full">
              <!-- Móvil -->
              <source 
                media="(max-width: 767px)"
                srcset="<?php echo esc_url($mobile_img[0]); ?>"
              >
              <!-- Tablet -->
              <source 
                media="(max-width: 1199px)"
                srcset="<?php echo esc_url($tablet_img[0]); ?>"
              >
              <!-- Desktop -->
              <img 
                src="<?php echo esc_url($desktop_img[0]); ?>" 
                alt="<?php echo esc_attr($slide['imagen']['alt']); ?>"
                class="w-full h-full object-cover"
                loading="lazy"
              >
            </picture>
            <div class="absolute top-1/2  transform -translate-y-1/3 hd:-translate-y-1/2 w-full px-4 md:px-10 lg:px-20  mx-auto">
              <div class="w-full h-auto translate-y-5">
                <h1 class="text-white title-lg text-shadow font-black w-full text-center">
                    Tienda
                </h1>
                <!--BUSCADOR-->
                <div class="max-w-2xl mx-auto mt-6">
                  <form role="search" method="get" class="w-full flex" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="hidden" name="post_type" value="product" />
                      <div class="relative w-full">
                        <input type="search" 
                                name="s" 
                                placeholder="Buscar productos..." 
                                class="w-full px-4 py-2 rounded-lg text-black border-0"
                                value="<?php echo get_search_query(); ?>">
                        <button type="submit" 
                                  class="absolute right-0 top-0 h-full px-6 bg-bg-primary text-white rounded-lg hover:bg-blue-700 transition-colors">
                          <svg xmlns="http://www.w3.org/2000/svg" 
                                  class="h-5 w-5" 
                                  fill="none" 
                                  viewBox="0 0 24 24" 
                                  stroke="currentColor">
                            <path stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                          </svg>
                        </button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
        </header>         
        
<?php
}
?>

<div class="container-xl mx-auto px-4 py-8">
  <!-- Breadcrumbs -->
  <div class="flex items-center gap-2 text-sm mb-8">
      <a href="<?php echo home_url(); ?>" class="text-gray-600 hover:text-texto-title">Home</a>
      <span class="text-gray-400">/</span>
      <span class="text-gray-900">Tienda</span>
  </div>

  <!-- Contenedor principal con grid -->
  <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Sidebar -->
    <aside class="lg:col-span-1 bg-gray-100 rounded-lg p-4 h-fit">
      <!-- Categorías -->
      <div class="mb-8">
        <h3 class="text-lg font-semibold">Categorías</h3>
        <div class="border-b-[1px] border-b-gray-200 my-3 mb-6 block w-full h-1"></div>
        <ul class="space-y-4">
          <!-- Agregar "Todas las categorías" al inicio -->
          <li>
              <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" 
               class="<?php echo $current_cat ? 'text-blue-600 font-medium' : 'text-gray-700'; ?> hover:text-texto-primary">
                  <span>Todas las categorías</span>
                  <span class="text-sm text-texto-paragraph">(<?php echo wp_count_posts('product')->publish; ?>)</span>
              </a>
          </li>
          <?php
          $args = array(
              'taxonomy' => 'product_cat',
              'hide_empty' => true,
              'parent' => 0
          );
          
          $product_categories = get_terms($args);
          
          foreach($product_categories as $category) {
              // Obtener subcategorías
              $sub_cats = get_terms(array(
                  'taxonomy' => 'product_cat',
                  'hide_empty' => true,
                  'parent' => $category->term_id
              ));
              
              $current_cat = is_tax('product_cat', $category->term_id);
              ?>
              <li>
                  <a href="<?php echo get_term_link($category); ?>" 
                      class="<?php echo $current_cat ? 'text-blue-600 font-medium' : 'text-gray-700'; ?> hover:text-texto-primary">
                      <?php echo $category->name; ?>
                      <span class="text-texto-paragraph text-sm">(<?php echo $category->count; ?>)</span>
                  </a>
                  
                  <?php if(!empty($sub_cats)): ?>
                      <ul class="pl-4 mt-2 space-y-1">
                          <?php foreach($sub_cats as $sub_cat): 
                              $current_sub = is_tax('product_cat', $sub_cat->term_id);
                              ?>
                              <li>
                                  <a href="<?php echo get_term_link($sub_cat); ?>" 
                                      class="<?php echo $current_sub ? 'text-blue-600' : 'text-gray-600'; ?> hover:text-blue-600 text-sm">
                                      <?php echo $sub_cat->name; ?>
                                      <span class="text-gray-400">(<?php echo $sub_cat->count; ?>)</span>
                                  </a>
                              </li>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>
              </li>
          <?php } ?>
        </ul>
      </div>

      <div class="border-b-[1px] border-b-gray-200 my-3 mb-6 block w-full h-1"></div>

    
      <!-- Filtro de Precio -->
      <div class="mb-2">
          <h3 class="text-lg font-semibold mb-4">Precio</h3>
          <div class="price-filter">
              <form method="get" class="space-y-4">
                  <div class="flex items-center gap-2">
                      <input type="number" 
                              name="min_price" 
                              placeholder="Mín" 
                              class="w-full px-3 py-2 border rounded"
                              value="<?php echo isset($_GET['min_price']) ? esc_attr($_GET['min_price']) : ''; ?>">
                      <span>-</span>
                      <input type="number" 
                              name="max_price" 
                              placeholder="Máx" 
                              class="w-full px-3 py-2 border rounded"
                              value="<?php echo isset($_GET['max_price']) ? esc_attr($_GET['max_price']) : ''; ?>">
                  </div>
                  <button type="submit" 
                          class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                      Filtrar
                  </button>
              </form>
          </div>
      </div>
    </aside>

  
    <!-- Contenido Principal -->
    <main class="lg:col-span-3">
      <!-- Ordenamiento y vista -->
      <div class="flex justify-between items-center mb-8 hd:flex-row flex-col gap-2">
          <div class="flex items-center gap-4 ">
            <span class="text-sm text-gray-600">Mostrar:</span>
            <div class="flex gap-2">
              <?php
              $per_page_options = array(9, 12, 18, 24);
              foreach ($per_page_options as $option) :
                  $current = isset($_GET['per_page']) ? $_GET['per_page'] : wc_get_default_products_per_row() * wc_get_default_product_rows_per_page();
              ?>
                <a href="<?php echo add_query_arg('per_page', $option); ?>" 
                    class="px-3 py-1 rounded text-sm <?php echo $current == $option ? 'bg-blue-600 text-white' : 'bg-gray-100'; ?>">
                    <?php echo $option; ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="ordering-container">
            <?php
            $orderby = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));
            $catalog_orderby_options = apply_filters('woocommerce_catalog_orderby', array(
              'menu_order' => 'Orden por defecto',
              'popularity' => 'Ordenar por popularidad',
              'rating'     => 'Ordenar por calificación',
              'date'       => 'Ordenar por novedad',
              'price'      => 'Ordenar por precio: bajo a alto',
              'price-desc' => 'Ordenar por precio: alto a bajo',
            ));
            ?>
            <form class="woocommerce-ordering" method="get">
              <select name="orderby" class="orderby bg-white border border-gray-300 text-texto-primary py-2 px-4 pr-8 rounded leading-tight ont-normal focus:outline-none focus:bg-white focus:border-bg-primary cursor-pointer title-card-product">
                <?php foreach ($catalog_orderby_options as $id => $name) : ?>
                  <option class="font-normal" value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>>
                      <?php echo esc_html($name); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?php wc_query_string_form_fields(null, array('orderby', 'submit')); ?>
            </form>
          </div>
      </div>

            <!-- Grid de Productos -->
      <?php if (woocommerce_product_loop()): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            while (have_posts()):
                the_post();
                global $product;
            ?>
              <div class=" relative border-[1px] border-slate-100 rounded-lg overflow-hidden group">
                <!-- Etiquetas -->
                 
                <?php if ($product->is_featured()): ?>
                    <span class="absolute top-2 left-2 bg-red-500 text-white p-1 pt-2 flex items-center justify-center text-xs rounded-full z-10 min-w-[50px] text-center">HOT</span>
                <?php endif; ?>
                <?php if ($product->is_on_sale()): ?>
                    <span class="absolute top-2 right-2 bg-blue-500 text-white p-1 pt-2 flex items-center justify-center text-xs rounded-full z-10 min-w-[50px] text-center pb-2">
                        <?php
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                        echo "-{$percentage}%";
                        ?>
                    </span>
                <?php endif; ?>

                <!-- Imagen -->
                <div class="relative overflow-hidden group">
                  <a href="<?php the_permalink(); ?>" class="block aspect-square ">
                      <?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail', ['class' => 'w-full h-full object-cover block']); ?>
                  </a>
                   <!-- Botón -->
                  <div class="mt-4 absolute bottom-0 left-0 translate-y-10 transition-all duration-300 group-hover:-translate-y-1 w-full flex items-center justify-center">
                    <?php
                      $product_type = $product->get_type();
                      
                      // Para productos variables o que requieren selección
                      if ($product->is_type('variable') || $product->is_type('grouped')) {
                          echo sprintf(
                              '<a href="%s" class="block text-center w-[90%%] z-10 rounded-full bg-bg-primary text-white px-4 py-2 hover:bg-blue-700">%s</a>',
                              esc_url(get_permalink($product->get_id())),
                              esc_html__('Ver opciones', 'woocommerce')
                          );
                      } 
                      // Para productos simples y descargables
                      else {
                          echo sprintf(
                              '<a href="%s" data-quantity="1" class="add_to_cart_button ajax_add_to_cart block text-center w-[90%%] z-10 rounded-full bg-bg-primary text-white px-4 py-2 hover:bg-blue-700" data-product_id="%d">%s</a>',
                              esc_url($product->add_to_cart_url()),
                              esc_attr($product->get_id()),
                              esc_html__('Añadir al carrito', 'woocommerce')
                          );
                      }
                      ?>
                  </div>
                </div>

                <!-- Info -->
                <div class="p-4">
                 <h2 title="<?php the_title();?> " class="title-card-product overflow-hidden text-ellipsis whitespace-nowrap mb-2">
                  <a href="<?php the_permalink(); ?>" class="hover:text-black">
                    <?php the_title(); ?>
                  </a>
                </h2>
                <div class="text-gray-900 font-bold price-card flex items-center gap-2">
                  <?php if ($product->is_on_sale()) : ?>
                    <span class="text-texto-paragraph line-through text-sm">
                      <?php echo wc_price($product->get_regular_price()); ?>
                    </span>
                    <span class="text-texto-title">
                      <?php echo wc_price($product->get_sale_price()); ?>
                    </span>
                  <?php else : ?>
                    <span class="text-texto-title">
                      <?php echo wc_price($product->get_regular_price()); ?>
                    </span>
                  <?php endif; ?>
              </div>

                 
                </div>
              </div>
            <?php endwhile; ?>
          </div>

        <!-- Paginación -->
        <div class="mt-8 flex justify-center">
          <?php
          $args = array(
              'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>',
              'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>',
              'type' => 'list',
              'end_size' => 1,
              'mid_size' => 2,
          );
          ?>
          <div class="woocommerce-pagination">
              <?php echo paginate_links($args); ?>
          </div>
        </div>

      <?php else: ?>
          <p class="text-center py-8">No se encontraron productos.</p>
      <?php endif; ?>
    </main>
  </div>
    
</div>

<!-- Script para el slider de categorías -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.category-slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 6,
            },
        },
    });
  // Manejar cambios en los checkboxes de filtros
  const filterCheckboxes = document.querySelectorAll('input[type="checkbox"][name*="[]"]');
  filterCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      let currentUrl = new URL(window.location.href);
      let searchParams = currentUrl.searchParams;
      
      // Obtener todos los checkboxes marcados del mismo tipo
      let checkboxName = this.name.replace('[]', '');
      let checkedBoxes = document.querySelectorAll(`input[name="${this.name}"]:checked`);
      let values = Array.from(checkedBoxes).map(cb => cb.value);
      
      // Actualizar o eliminar el parámetro
      if (values.length > 0) {
        searchParams.set(checkboxName, values.join(','));
      } else {
        searchParams.delete(checkboxName);
      }
      
      // Redirigir a la nueva URL
      window.location.href = currentUrl.toString();
    });
  });
});
</script>

<?php get_footer(); ?>