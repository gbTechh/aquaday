<?php
/**
 * The Template for displaying all single products
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="container mt-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm mb-8">
        <a href="<?php echo home_url(); ?>" class="text-gray-600 hover:text-texto-title">Home</a>
        <?php 
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            echo '<span class="text-gray-400">/</span>';
            echo '<a href="' . get_term_link($terms[0]->term_id) . '" class="text-gray-600 hover:text-texto-title">' . $terms[0]->name . '</a>';
        }
        ?>
        <span class="text-gray-400">/</span>
        <span class="text-gray-900"><?php the_title(); ?></span>
    </nav>

    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <?php wc_get_template_part('content', 'single-product'); ?>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>