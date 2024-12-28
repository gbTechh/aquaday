<?php
/*
Template Name: Pagina de categorías
*/

get_header();

$categories = get_product_categories_with_fields();
?>

<?php 
  if (have_posts()) :
    while (have_posts()) :
        the_post();  
        ?>          
        <main class="p-6 md:px-20 pt-0 flex flex-col items-center justify-center">  
          <section class="w-full flex flex-col gap-6 max-w-[1200px]">
            <h1 class="title-categories uppercase font-black !text-gray-200 my-14 ">Categorías</h1>
           <?php
            if (!empty($categories)) {
            echo '<div class="categories-grid">';
            foreach ($categories as $category) {
                ?>
                <div class="h-full">
                  <div class="p-8 hd:p-10  category-card gap-1 relative hd:pb-20 pb-16">
                    <h2 class="title-card"><?php echo esc_html($category->name); ?></h2>
                    <span class="text-xs text-slate-500 uppercase"><?= "Productos: " . esc_html($category->count) ?></span>
                    <?php if (isset($category->imagen)) : ?>
                        <img class="image-card absolute -top-3 hd:-top-12 right-6 w-20 md:w-40 hd:w-50 object-cover" src="<?php echo esc_url($category->imagen['url']); ?>" 
                            alt="<?php echo esc_attr($category->imagen['alt']); ?>">
                    <?php endif; ?>

                    <?php 
                    // Acceder a otros campos ACF
                    if (isset($category->description)) {
                        echo '<p class="mt-6 paragraph-sm">' . esc_html($category->description) . '</p>';
                    }
                    
                   
                    ?>
                    <div class="absolute bottom-[-16px] left-0 w-full flex items-center justify-center">
                      <a href="<?php echo get_term_link($category->id, 'categoria_producto'); ?>" class="text-center link link-card !font-bold w-4/5 hd:w-3/5 p-2 hd:p-3 border-[1px] border-bg-secondary bg-white ">Ver productos</a>
                    </div>

                  </div>
                  <div class="h-20">

                  </div>
                </div>
                
                <?php
            }
            echo '</div>';
        }
        ?>


          
          </section>          
        </main>
    <?php endwhile;
  endif;
?>




<?php get_footer();?>