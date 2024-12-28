<?php
/*
Template Name: Pagina de nosotros
*/

get_header();
?>

<?php 
  if (have_posts()) :
    while (have_posts()) :
        the_post();  
        $img = get_field('imagen');
        $title = get_field('titulo');
        $mobile_img = wp_get_attachment_image_src($img['ID'], 'slider-mobile');
        $tablet_img = wp_get_attachment_image_src($img['ID'], 'slider-tablet');
        $desktop_img = wp_get_attachment_image_src($img['ID'], 'slider-desktop');
        $nosotros = get_field('nosotros');
        ?>          
        <main class="w-full">
          <header class="w-full h-screen max-h-[400px] relative">
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
              <div class="absolute top-1/2 left-0 transform -translate-y-1/2 w-full px-4 md:px-10 lg:px-20 max-w-[1400px] mx-auto">
                <div class="w-full h-auto">
                  <?php if (!empty($title)) : ?>
                    <h1 class="text-white title-lg text-shadow font-black">
                      <?php echo esc_html($title); ?>
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
          </header>
          <section class="container section flex flex-col-reverse hd:flex-row gap-10 hd:gap-5">
            <div class="flex-1 hd:justify-center flex flex-col">
              <h2 class="title-section mb-5 text-texto-primary font-semibold"><?= $nosotros['titulo'] ?></h2>  
              <p class="paragraph text-texto-paragraph"><?= $nosotros['texto']?></p>        
            </div>
            <div class="flex-1  flex items-center justify-center relative">
              <div class="bg-bg-primary w-36 div-year h-36 hd:w-44 hd:h-44 rounded-2xl absolute top-0 left-0 flex items-center justify-center flex-col">
                <p class="text-white font-bold text-5xl text-center">+20</p>
                <p class="text-white font-bold text-2xl text-center">años experiencia</p>
              </div>
              <img src="<?=$nosotros['imagen']['url'] ?>" class="w-full h-full block rounded-2xl max-w-[300px]"/>
            </div>
          </section>
          <div class="my-20"></div>
          <section class="section-p bg-gray-200">
            <div class="container flex flex-col hd:flex-row w-full gap-10">
              <div class="bg-white flex-1 rounded-xl p-10 hd:px-20 flex flex-col">
                <h2 class="title-section-sm text-center mb-5">Nuestra misión</h2>  
                <p class="text-center paragraph-sm text-texto-paragraph flex-1 flex items-center"><?= get_field('mision')?></p>     
              </div>          
              <div class="bg-white flex-1 rounded-xl p-10 hd:px-20 flex flex-col">
                <h2 class="title-section-sm text-center mb-5">Nuestra visión</h2>  
                <p class="text-center paragraph-sm text-texto-paragraph flex-1 flex items-center"><?= get_field('vision')?></p>     
              </div>           
            </div>
          </section>
          <section class="section-p">
            <h2 class="container title-section w-full text-center mb-10 ">Nuestra historia</h2>
            <div class="swiper slider-nosotros !p-10">
              <div class="swiper-wrapper">               
                <?php 
                  foreach (get_field('linea_del_tiempo') as $item) { ?>
                    <div class="overflow-hidden swiper-slide flex flex-col px-10 relative rounded-lg hover:shadow-lg pb-5">
                      <!-- Fecha -->
                      <div class="w-full pb-6">
                        <h3 class="text-4xl font-medium text-right text-gray-300 pr-5"><?= $item['year']?></h3>
                      </div>
                      
                      <!-- Línea punteada y círculo -->
                      <div class="absolute right-24 top-6 h-full flex items-center">
                        <div class="w-px h-full border-r border-dashed border-gray-300"></div>
                        <div class="absolute top-1/2 -right-2.5">
                          <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2-1h8a1 1 0 011 1v12a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Contenido -->
                      <div class="pt-6 flex">
                        <div class="flex flex-col gap-4 flex-1">
                          <h4 class="paragraph text-texto-title w-full capitalize text-right"><?= $item['titulo']?></h4>
                          <p class="text-sm text-right text-gray-600"><?= $item['texto']?></p>
                        </div>
                        <div class="w-20"></div> <!-- Espacio para la línea y el círculo -->
                      </div>
                    </div>
                <?php }
                ?>
              </div>        
            </div>
          </section>
          <section class="section-p container">
            <div class="grid-galery-nosotros">
              <?php 
                $galeria = get_field('galeria');
                if ($galeria && is_array($galeria)) {
                    foreach ($galeria as $item) {
                        // Verifica si el tamaño 'thumbnail' está disponible
                        if (isset($item['sizes']['category-thumb'])) { ?>
                            <img class="object-cover w-full aspect-square" src="<?= esc_url($item['sizes']['category-thumb']) ?>" alt="<?= esc_attr($item['alt'] ?? '') ?>"/>
                <?php   }
                    }
                }
                ?>
              </div>
          </section>
          <div class="section"></div>
        </main>
    <?php endwhile;
  endif;
?>




<?php get_footer();?>