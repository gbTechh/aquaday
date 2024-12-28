<?php get_header(); ?>

<header class="relative h-screen max-h-[800px] min-h-[500px] w-full overflow-hidden hd:rounded-br-[5rem] hd:rounded-bl-[5rem]">
  <div class="swiper slider-header w-full h-full">
    <div class="swiper-wrapper">
      <?php 
      if (have_posts()) :
        while (have_posts()) :
          the_post();
          $header_data = get_field('slider');
          
          if ($header_data && is_array($header_data)) :
            foreach ($header_data as $slide) :
              if (!empty($slide['imagen'])) :
                $mobile_img = wp_get_attachment_image_src($slide['imagen']['ID'], 'slider-mobile');
                $tablet_img = wp_get_attachment_image_src($slide['imagen']['ID'], 'slider-tablet');
                $desktop_img = wp_get_attachment_image_src($slide['imagen']['ID'], 'slider-desktop');
              ?>
              <div class="swiper-slide relative w-full h-full">
                <picture class="w-full h-full">
                  <!-- Imágenes responsive como estaban antes -->
                  <source media="(max-width: 767px)" srcset="<?php echo esc_url($mobile_img[0]); ?>">
                  <source media="(max-width: 1199px)" srcset="<?php echo esc_url($tablet_img[0]); ?>">
                  <img src="<?php echo esc_url($desktop_img[0]); ?>" 
                       alt="<?php echo esc_attr($slide['imagen']['alt']); ?>"
                       class="w-full h-full object-cover"
                       loading="lazy"
                       width="<?php echo $desktop_img[1]; ?>"
                       height="<?php echo $desktop_img[2]; ?>">
                </picture>
                  
                <div class="absolute inset-0 bg-black/20"></div>
                  
                <div class="absolute top-1/2 left-0 transform -translate-y-1/2 w-full px-4 md:px-10 lg:px-20 max-w-[1400px] mx-auto">
                  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                    <div class="max-w-[600px] h-auto">
                      <?php if (!empty($slide['titulo'])) : ?>
                        <h1 class="text-white title-xl text-shadow font-black">
                          <?php echo esc_html($slide['titulo']); ?>
                        </h1>
                      <?php endif; ?>
                      
                      <?php if (!empty($slide['texto'])) : ?>
                        <p class="paragraph-slider-home text-white text-shadow my-5 font-semibold">
                          <?php echo esc_html($slide['texto']); ?>
                        </p>
                      <?php endif; ?>

                      <?php if (!empty($slide['link'])) : ?>
                        <a href="<?php echo esc_html($slide['link']); ?>" class="paragraph border-[1px] link-no-underline hover:bg-white/50 transition-all border-white p-2 rounded-lg !text-white text-shadow my-5 font-semibold no-underline mt-10">
                          Tienda
                        </a>
                      <?php endif; ?>
                    </div>

                 

                  </div>
                </div>
              </div>
              <?php 
              endif;
            endforeach;
          endif;
        endwhile;
      endif; 
      ?>
    </div>
    <div class="swiper-pagination"></div>
  </div>

  <!-- Slider de productos destacados -->
  <div class="hidden lg:block absolute top-1/2 w-[300px] bg-white transform -translate-y-1/2  backdrop-blur-sm rounded-3xl p-2  right-28 8 z-40">
      <?php
      // Consulta actualizada para productos destacados
      $args = array(
          'post_type'      => 'product',
          'posts_per_page' => 5,
          'tax_query'      => array(
              array(
                  'taxonomy' => 'product_visibility',
                  'field'    => 'name',
                  'terms'    => 'featured',
                  'operator' => 'IN',
              ),
          ),
          'post_status'    => 'publish'
      );
      
      $featured_query = new WP_Query($args);
      
      if ($featured_query->have_posts()) :
          ?>
          <div class="swiper featured-products-slider">
              <div class="swiper-wrapper">
              <?php
              while ($featured_query->have_posts()) : $featured_query->the_post();
                  global $product;
                  ?>
                  <div class="swiper-slide">
                      <div class="bg-white rounded-lg overflow-hidden ">
                          <a href="<?php the_permalink(); ?>" class="block">
                              <?php 
                              if (has_post_thumbnail()) {
                                  echo get_the_post_thumbnail(null, 'medium', array('class' => 'w-full h-48 object-cover rounded-2xl'));
                              }
                              ?>
                              <div class="p-4">
                                  <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2"><?php the_title(); ?></h4>
                                  <div class="flex justify-between items-center">
                                      <span class="text-lg font-bold text-gray-900">
                                          <?php echo $product->get_price_html(); ?>
                                      </span>
                                      <?php if ($product->is_on_sale()) : ?>
                                          <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                              Oferta
                                          </span>
                                      <?php endif; ?>
                                  </div>
                              </div>
                          </a>
                      </div>
                  </div>
              <?php
              endwhile;
              wp_reset_postdata();
              ?>
              </div>
              <div class="swiper-pagination hidden"></div>
          </div>
          <?php
      else :
          echo '<div>No se encontraron productos destacados</div>';
      endif;
      ?>
  </div>
  <!-- Slider de productos destacados -->
</header>

<main class="">
    <section class="container section">
      <h2 class="title-section text-center"><?= get_field('bienvenida')['titulo']?></h2>
      <p class="paragraph text-texto-paragraph my-4 text-center w-full"><?= get_field('bienvenida')['texto']?></p>
    </section>
    <section class="container section flex hd:flex-row flex-col gap-10">
      <img src="<?= get_field('beneficios')['imagen']['url']?>" class="flex-1 w-full max-w-[600px] object-cover rounded-lg">
      <div class="flex-1">
        <h2 class="title-section text-left"><?= get_field('beneficios')['titulo']?></h2>
         <p class="paragraph text-texto-paragraph my-4 text-left w-full"><?= get_field('beneficios')['texto']?></p>
      </div>
    </section>
    <section class="mt-20 w-full hd:rounded-tr-[5rem] hd:rounded-tl-[5rem] bg-slate-50">
      <div class="container py-20">
        <h2 class="title-section text-center mb-10">Nuestras Categorías</h2>
        
        <?php
        $categories = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'parent'     => 0
        ));

        if (!empty($categories) && !is_wp_error($categories)) : ?>
            <div class="swiper categories-slider">
                <div class="swiper-wrapper">
                    <?php 
                    foreach ($categories as $category) : 
                        // Obtener imagen de la categoría
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_image_url($thumbnail_id, 'medium');
                        ?>
                        <div class="swiper-slide">
                            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="block">
                                <div class="bg-white rounded-lg overflow-hidden shadow">
                                    <?php if ($image) : ?>
                                        <img src="<?php echo esc_url($image); ?>" 
                                            alt="<?php echo esc_attr($category->name); ?>"
                                            class="w-full h-48 object-cover">
                                    <?php endif; ?>
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold mb-2"><?php echo esc_html($category->name); ?></h3>
                                        <span class="text-sm text-gray-600"><?php echo $category->count; ?> productos</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.categories-slider', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2
                        },
                        1024: {
                            slidesPerView: 4
                        }
                    },
                    autoplay: {
                        delay: 3000,
                    },
                });
            });
            </script>

        <?php else : ?>
            <p>No se encontraron categorías.</p>
        <?php endif; ?>
      </div>
    </section>
    <section class="section relative" style="background-image: url('<?php echo get_field('banner')['imagen']['url']?>');">
      <div class="bg-black/50 absolute top-0 left-0 w-full h-full"></div>
      <div class="container flex flex-col z-10 relative pb-20">
        <h2 class="max-w-[400px] uppercase !text-white !font-black text-[40px] hd:text-[50px] leading-none"><?= get_field('banner')['titulo'] ?></h2>
        <div class="flex flex-col hd:flex-row gap-10 mt-20 items-center justify-between hd:w-2/3 hd:mx-auto">
          <div class="flex flex-col gap-1 w-full">
            <p class="hd:text-center text-left text-white font-black text-[40px] hd:text-[60px] leading-none"><?= get_field('banner')['years']?></p>
            <p class="hd:text-center text-left text-white font-black text-[20px] hd:text-[30px] w-full ">años</p>
          </div>
          <div class="flex flex-col gap-1 w-full">
            <p class="hd:text-center text-left text-white font-black text-[40px] hd:text-[60px] leading-none"><?= get_field('banner')['piscinas']?></p>
            <p class="hd:text-center text-left text-white font-black text-[20px] hd:text-[30px] w-full ">piscinas</p>
          </div>
          <div class="flex flex-col gap-1 w-full">
            <p class="hd:text-center text-left text-white font-black text-[40px] hd:text-[60px] leading-none"><?= get_field('banner')['distribuidores']?></p>
            <p class="hd:text-center text-left text-white font-black text-[20px] hd:text-[30px] w-full">distribuidores</p>
          </div>          
        </div>
      </div>
    </section>
    <section class="container section-p ">
      <h2 class="title-section text-center mb-10">Últimas Noticias</h2>
      
      <?php
      $args = array(
          'post_type'      => 'post',
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'DESC'
      );

      $latest_posts = new WP_Query($args);

      if ($latest_posts->have_posts()) : ?>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                  <article class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                      <?php if (has_post_thumbnail()) : ?>
                          <a href="<?php the_permalink(); ?>" class="block aspect-w-16 aspect-h-9">
                              <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover')); ?>
                          </a>
                      <?php endif; ?>
                      
                      <div class="p-6">
                          <!-- Fecha -->
                          <div class="text-sm text-gray-500 mb-2">
                              <?php echo get_the_date('j F, Y'); ?>
                          </div>
                          
                          <!-- Título -->
                          <h3 class="text-xl font-bold mb-2 text-texto-primary hover:text-texto-secondary">
                              <a href="<?php the_permalink(); ?>">
                                  <?php the_title(); ?>
                              </a>
                          </h3>
                          
                          <!-- Extracto -->
                          <div class="text-texto-paragraph mb-4 line-clamp-3">
                              <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                          </div>
                          
                          <!-- Botón Leer más -->
                          <a href="<?php the_permalink(); ?>" 
                            class="inline-flex items-center text-bg-primary hover:text-bg-secondary transition-colors">
                              Leer más
                              <svg xmlns="http://www.w3.org/2000/svg" 
                                  class="h-4 w-4 ml-2" 
                                  fill="none" 
                                  viewBox="0 0 24 24" 
                                  stroke="currentColor">
                                  <path stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                              </svg>
                          </a>
                      </div>
                  </article>
              <?php endwhile; ?>
          </div>
          
          <!-- Botón Ver todas las noticias -->
          <div class="text-center mt-10">
              <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" 
                class="inline-flex items-center justify-center px-6 py-3 bg-bg-primary text-white rounded-full hover:bg-bg-secondary transition-colors">
                  Ver todas las noticias
              </a>
          </div>
      <?php 
      else :
          echo '<p class="text-center text-gray-500">No hay noticias disponibles.</p>';
      endif;
      wp_reset_postdata();
      ?>
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Slider principal
    new Swiper('.slider-header', {
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        autoplay: {
            delay: 5000,
        },
        loop: true
    });

    // Slider de productos destacados
    new Swiper('.featured-products-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: {
            delay: 2000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        loop: true
    });
});
</script>

<?php get_footer(); ?>
               