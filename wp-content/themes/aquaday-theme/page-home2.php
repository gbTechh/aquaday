<?php
/*
Template Name: Pagina de home2
*/

get_header();
 ?>

<header class="header flex gap-0">
    <?php 
    if (have_posts()) :
        while (have_posts()) :
            the_post();            
            $header_data = get_field('header');            
            ?>
            <div class="w-2/5 h-full">
              <div class="w-full h-full overflow-hidden">
              <?php 
                foreach ($header_data['gallery'] as $value) { ?>
                  <img src="<?= $value['url'] ?>" class=" w-full h-full block object-cover" />
                <?php }
              ?>
              </div>
            </div>
            <div class="w-3/5 flex flex-col">
              <div class="py-20 px-20 pb-16 w-full">
                <h1 class="text-bg-secondary title-header max-w-[35vw]"><?= $header_data['title'] ?></h1>
              </div>
              <div class="w-full flex flex-nowrap h-full relative">
                <span class="w-52 block aspect-square absolute left-0 bottom-0 bg-bg-primary"></span>
                <div class="flex-grow-[5] w-[200px]"></div>
                <div class="flex-grow-[3] pl-52 pr-20">
                  <p class=" text-2xl lg:pt-10 z-20 relative"><?=  $header_data['paragraph'] ?></p>               
                  <a class="mt-5 w-full z-20 block uppercase text-bg-secondary font-bold no-underline" href="<?=$header_data['link'][0]->guid ?>">Ver nuestro catálogo</a>
                </div>
              </div>
            </div>
            <?php
        endwhile;
    endif;
    ?>
</header>

<header class="header-movil">
  <?php 
    if (have_posts()) :
      while (have_posts()) :
        the_post();            
        $header_data = get_field('header');            
        ?>
        <div class="w-full aspect-square relative">
          <?php 
            foreach ($header_data['gallery'] as $value) { ?>
              <img src="<?= $value['url'] ?>" class="w-full h-full block object-cover" />
            <?php }
          ?>
          <div class="p-6 px-8 w-full absolute bottom-0">
            <h1 class="text-white title-header"><?= $header_data['title'] ?></h1>
          </div>
        </div>
        <div class=" pl-8 w-full h-auto flex flex-nowrap ">
          <div class="w-full flex items-center flex-col justify-center py-6">
            <p class="text-base sm:text-lg w-full flex-1 flex items-center pr-4"><?= $header_data['paragraph'] ?></p>
            <a class="w-full flex-1 z-20 uppercase flex items-center text-bg-secondary font-bold no-underline" href="<?=$header_data['link'][0]->guid ?>">Ver nuestro catálogo</a>

          </div>
          <span class="bg-bg-primary aspect-square w-24"></span>
        </div>
        <?php
      endwhile;
    endif;
  ?>
</header>
<?php 
  if (have_posts()) :
    while (have_posts()) :
        the_post();  
        $services_data = get_field('services');  
        $ambiental = get_field('responsabilidad_ambiental');  
        ?>          
        <main class=" pb-20 hd:pb-32">
          <section class="px-5 py-14 hd:p-20 flex flex-col hd:flex-row  flex-nowrap gap-20">
            <div class="flex-[2] flex flex-col gap-8">
              <h1 class="title"><?= $services_data['title']?></h1>
              <p class="paragraph" ><?= $services_data['paragraph'] ?></p>          
              <a class="link" href="<?= $services_data['link'] ?>">Nuestros servicios</a>

            </div>
            <div class="flex-[3] hidden hd:flex">
              <!--AGREGAR SEVICIOS-->
              <div class="swiper services-slider max-w-[500px]">
                <!-- Navegación personalizada -->
          
                
                <div class="swiper-wrapper">
                    <?php
                    $args = array(
                        'post_type' => 'servicio',
                        'posts_per_page' => -1,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );

                    $servicios = new WP_Query($args);

                    if ($servicios->have_posts()) :
                        while ($servicios->have_posts()) : $servicios->the_post(); ?>
                            <div class="swiper-slide">
                                <div class="service-card bg-white relative flex flex-col gap-4">
                                   <a href="<?php the_permalink(); ?>" 
                                      class="title link !text-4xl !text-bg-primary uppercase !font-black mb-6">
                                         <?php the_title(); ?>
                                    </a>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="relative min-h-[400px]  p-8">
                                            <?php the_post_thumbnail('medium', array(
                                                'class' => 'w-full h-full  object-contain  z-10'
                                            )); ?>
                                        </div>
                                    <?php endif; ?>
                                
                                  

                                   
                                </div>
                            </div>
                        <?php endwhile;
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>
              </div>
            </div>
          </section>
          <!--MOSTRAR CATEGOIRIAS-->
          <section class="py-20 pl-5 hd:pl-20">
            <div class="">
                <div class="swiper categories-slider">
                   <!-- Navegación personalizada -->
                  <div class="flex justify-end mt-8 gap-4 pr-20 pb-20">
                    <h1 class="title w-full text-left">Categorías</h1>
                      <button class="swiper-button-prev !static !w-12 !h-12 bg-bg-secondary !text-white after:!text-lg hover:!text-bg-secondary"></button>
                      <button class="swiper-button-next !static !w-12 !h-12 bg-bg-secondary !text-white after:!text-lg hover:!text-bg-secondary"></button>
                  </div>
                  <div class="swiper-wrapper">
                    <?php 
                    $args = array(
                        'taxonomy' => 'categoria_producto',
                        'hide_empty' => false
                    );
                    $categories = get_terms($args);

                    if (!empty($categories)) :
                        foreach ($categories as $category) : 
                            $imagen = get_field('imagen', 'term_' . $category->term_id);
                    ?>
                      <div class="swiper-slide">
                        <a href="<?php echo get_term_link($category); ?>" class="block link"> <!-- Agregamos el enlace aquí -->
                            <div class="animation-card-bg-slider bg-white flex flex-col h-full relative shadow-card p-8 cursor-pointer"> <!-- Agregamos cursor-pointer -->
                                <h3 class="z-10 text-bg-primary font-black text-2xl uppercase mb-8">
                                    <?php echo esc_html($category->name); ?>
                                </h3>

                                <?php if ($imagen) : ?>
                                    <div class="flex-1 flex items-center justify-center min-h-[300px]">
                                        <img src="<?php echo esc_url($imagen['url']); ?>" 
                                            alt="<?php echo esc_attr($category->name); ?>"
                                            class="w-3/4 shadow-img-black max-h-[300px] object-contain absolute bottom-10 -right-2 block z-10">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                  </div>
                  
                 
                </div>
            </div>
          </section>
          <!--END MOSTRAR CATEGOIRIAS-->
          <section class="px-5 py-14 hd:p-20 flex flex-col hd:flex-row  flex-nowrap gap-14 hd:gap-20">
        
            <div class="flex-1 flex justify-center flex-col gap-6">
              <h1 class="title"><?= $ambiental["titulo"]?></h1>
              <p class="paragraph">
                <?= $ambiental["texto"]?>
              </p>
            </div>
            <div class="flex-1">
             <img src="<?= $ambiental["imagen"]["url"]?>">
            </div>
            
          </section>
        </main>
    <?php endwhile;
  endif;
?>



<?php get_footer(); ?>