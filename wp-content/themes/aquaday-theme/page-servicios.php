<?php
/*
Template Name: Pagina de servicios
*/

get_header();
$args = array(
    'post_type' => 'servicio',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
);

$servicios = new WP_Query($args);
?>

<main class="p-6 md:px-20 pt-0 flex flex-col items-center justify-center">  
    <section class="w-full flex flex-col gap-6 max-w-[1200px]">
        <h1 class="title-categories uppercase font-black !text-gray-200 my-14 "><?php the_title(); ?></h1>
        
        <?php if ($servicios->have_posts()) : ?>
            <div class="categories-grid">
                <?php while ($servicios->have_posts()) : $servicios->the_post(); 
                    // Obtener campos ACF del servicio
                    $fields = get_fields();
                ?>
                    <div class="h-full">
                        <div class="p-8 hd:p-10 category-card gap-1 relative hd:pb-20 pb-16">
                            <h2 class="title-card"><?php the_title(); ?></h2>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <img class="image-card bg-white absolute -top-3 hd:-top-12 p-2 right-6 w-20 md:w-40 hd:w-50 object-cover" 
                                     src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" 
                                     alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>

                            <div class="mt-6 paragraph-sm">
                                <?php echo $fields['descripcion_corta']; ?>
                            </div>

                            <div class="absolute bottom-[-16px] left-0 w-full flex items-center justify-center">
                                <a href="<?php the_permalink(); ?>" 
                                   class="text-center link link-card !font-bold w-4/5 hd:w-3/5 p-2 hd:p-3 border-[1px] border-bg-secondary bg-white">
                                    Ver más
                                </a>
                            </div>
                        </div>
                        <div class="h-20"></div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </section>          
</main>

<?php get_footer(); ?>