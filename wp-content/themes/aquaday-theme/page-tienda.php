<?php
/**
 * Template Name: Página Tienda
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="text-sm mb-8">
        <?php
        if (function_exists('woocommerce_breadcrumb')) {
            woocommerce_breadcrumb();
        }
        ?>
    </div>

    <!-- Título -->
    <h1 class="text-3xl font-bold mb-8"><?php echo get_the_title(); ?></h1>

    <!-- Categorías Slider -->
    <div class="relative mb-12">
        <div class="swiper categories-slider">
            <div class="swiper-wrapper">
                <?php
                $categories = get_terms([
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                    'parent' => 0
                ]);

                foreach ($categories as $category) :
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $image = wp_get_attachment_url($thumbnail_id);
                    ?>
                    <div class="swiper-slide">
                        <a href="<?php echo get_term_link($category); ?>" 
                           class="block relative group">
                            <div class="aspect-square rounded-lg overflow-hidden bg-blue-100">
                                <?php if ($image) : ?>
                                    <img src="<?php echo $image; ?>" 
                                         alt="<?php echo $category->name; ?>"
                                         class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <h3 class="text-center mt-3 font-semibold">
                                <?php echo $category->name; ?>
                            </h3>
                            <span class="text-sm text-gray-500 block text-center">
                                <?php echo $category->count; ?> productos
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <?php foreach ($categories as $category) : ?>
        <div class="mb-16">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold"><?php echo $category->name; ?></h2>
                <a href="<?php echo get_term_link($category); ?>" 
                   class="text-blue-600 hover:text-blue-800">
                    Ver todo
                </a>
            </div>

            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $category->term_id,
                    ),
                ),
            );
            $products = new WP_Query($args);
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                while ($products->have_posts()) : $products->the_post();
                    global $product;
                    ?>
                    <div class="product-card border rounded-lg p-4 hover:shadow-lg transition-shadow">
                        <a href="<?php the_permalink(); ?>">
                            <div class="aspect-square mb-4">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('woocommerce_thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                                <?php endif; ?>
                            </div>
                            <h3 class="font-semibold mb-2"><?php the_title(); ?></h3>
                            <div class="text-gray-600">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Filtros de precio y ordenamiento -->
    <div class="flex justify-between items-center mb-8">
        <div class="price-filter">
            <?php
            $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
            $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
            ?>
            <form method="get" class="flex gap-4">
                <input type="number" name="min_price" value="<?php echo $min_price; ?>" 
                       placeholder="Precio mínimo" class="border p-2 rounded">
                <input type="number" name="max_price" value="<?php echo $max_price; ?>" 
                       placeholder="Precio máximo" class="border p-2 rounded">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Filtrar
                </button>
            </form>
        </div>

        <div class="sorting">
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>