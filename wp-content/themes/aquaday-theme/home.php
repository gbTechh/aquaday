
<?php
get_header();
$page_for_posts_id = get_option('page_for_posts');

// Usa el ID para obtener los valores de ACF
$img = get_field('imagen', $page_for_posts_id);
$mobile_img = wp_get_attachment_image_src($img['ID'], 'slider-mobile');
$tablet_img = wp_get_attachment_image_src($img['ID'], 'slider-tablet');
$desktop_img = wp_get_attachment_image_src($img['ID'], 'slider-desktop');
?>
 <header class="w-full h-screen max-h-[350px] hd:max-h-[400px] relative">
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
        <div class="absolute top-1/2 left-0 transform  -translate-y-1/3 hd:-translate-y-1/2 w-full px-4 md:px-10 lg:px-20 max-w-[1400px] mx-auto">
        <div class="w-full h-auto">
            <h1 class="text-white title-lg text-shadow font-black">
                BLOG
            </h1>
            
            <p class="paragraph-slider-home text-white text-shadow my-5 font-semibold">
                Todas las entradas de nuestra web aqui
            </p>
            <?php if (!empty($slide['link'])) : ?>
            <a href="<?php echo esc_html($slide['link']); ?>" class="paragraph border-[1px] link-no-underline hover:bg-white/50 transition-all border-white p-2 rounded-lg !text-white text-shadow my-5 font-semibold no-underline mt-10">
                Tienda
            </a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main class="container">
    <div class="section-p">

        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="h-full">
                        <div class=" category-card gap-1 relative rounded-xl ">
                            <?php if (has_post_thumbnail()) : ?>
                                <img class="relative object-cover rounded-xl"
                                     src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>"
                                     alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            <div class="p-8 hd:p-10 hd:pb-20 pb-16 hd:pt-2 pt-2">
                              <h2 class="title-card"><?php the_title(); ?></h2>
                              
                              <span class="text-xs text-slate-500 uppercase">
                                  <?php echo get_the_date('d M Y'); ?>
                              </span>
  
                              <div class="mt-6 paragraph-sm">
                                  <?php the_excerpt(); ?>
                              </div>
  
                              <div class="absolute bottom-[-16px] left-0 w-full flex items-center justify-center">
                                  <a href="<?php the_permalink(); ?>" 
                                     class="text-center link !font-bold w-4/5 hd:w-3/5 p-2 hd:p-3 border-[1px] hover:text-white hover:bg-bg-secondary border-bg-secondary bg-white rounded-full transition-all">
                                      Leer más
                                  </a>
                              </div>
                            </div>
                        </div>
                        <div class="h-20"></div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="mt-8">
                <?php the_posts_pagination(array(
                    'prev_text' => __('Anterior'),
                    'next_text' => __('Siguiente'),
                )); ?>
            </div>
        <?php else : ?>
            <p>No hay entradas disponibles.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>