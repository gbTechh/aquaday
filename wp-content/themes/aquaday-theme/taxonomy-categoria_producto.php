<?php
get_header();
$current_category = get_queried_object();
?>

<main class="p-6 md:px-20 pt-0 flex flex-col items-center justify-center mb-40">
    <section class="w-full flex flex-col gap-6 max-w-[1200px]">
        <h1 class="text-texto-primary uppercase font-black my-10 hd:mt-20">
            <?php echo esc_html($current_category->name); ?>
        </h1>
        <!-- Agregar esto después del h1 en taxonomy-categoria_producto.php -->
        <div class="wrap-categorias gap-32">
            <!-- Sidebar de categorías -->
            <aside class="w-full">
                <h2 class="text-sm text-slate-400 uppercase mb-4">Todas las categorías</h2>
                <?php
                $categories = get_terms([
                    'taxonomy' => 'categoria_producto',
                    'hide_empty' => false
                ]);

                if (!empty($categories)) : ?>
                    <ul class="space-y-4">
                        <?php foreach ($categories as $cat) : 
                            $active_class = ($cat->term_id === $current_category->term_id) ? 'text-blue-600 !font-bold ' : '';
                        ?>
                            <li class="<?php echo $active_class; ?>">
                                <a href="<?php echo get_term_link($cat); ?>" class="<?php echo $active_class; ?> link ">
                                    <?php echo esc_html($cat->name); ?> 
                                    (<?php echo $cat->count; ?>)
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </aside>

            <!-- Contenido de productos -->
            <div class="w-full">
              <?php
                // Obtener productos de esta categoría
                $args = array(
                    'post_type' => 'producto',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categoria_producto',
                            'field'    => 'term_id',
                            'terms'    => $current_category->term_id,
                        ),
                    ),
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) : ?>
                    <div class="grid-products -mt-10">
                        <?php while ($query->have_posts()) : $query->the_post(); 
                            // Obtener campos ACF del producto si los tienes
                            $product_fields = get_fields(get_the_ID());
                        ?>
                            <article class="product-card mt-10">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="product-image">
                                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto']); ?>
                                    </div>
                                <?php endif; ?>
                                <h2 class="uppercase text-bg-secondary text-lg p-6"><?php the_title(); ?></h2>

                                <div class="p-6 bg-bg-gray relative pb-16">
                                    
                                    <div class="paragraph-sm">
                                        <?php echo get_field('descripcion_corta') ?>
                                    </div>
                                    <div class="w-full absolute -bottom-8 left-0 h-auto flex items-center justify-center">
                                      <a href="<?php the_permalink(); ?>" class="link-card link p-4 border-[1px] border-bg-secondary text-center w-4/5 bg-white">Ver detalles</a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    // Paginación si la necesitas
                    wp_reset_postdata();
                else : ?>
                    <p>No hay productos en esta categoría.</p>
              <?php endif; ?>
            </div>
        </div>
        
    </section>
</main>

<?php get_footer(); ?>