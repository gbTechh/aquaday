<?php
get_header();

while (have_posts()) :
    the_post();
?>

<main class="p-6 hd:px-20 pt-0 flex flex-col items-center justify-center pb-20 hd:pb-32">
    
    <article class="w-full max-w-[1200px]">
        <!-- Breadcrumbs -->
        <div class="text-sm my-10 hd:mt-20">
            <a href="<?php echo home_url(); ?>" class="link !font-medium mr-4">Inicio</a> | 
            <a href="<?php echo get_post_type_archive_link('post'); ?>" class="link !font-medium mx-4">Noticias</a> | 
            <span class="link !font-medium opacity-70 ml-4"><?php the_title(); ?></span>
        </div>

        <!-- Contenido principal -->
        <div class="flex flex-col gap-6">
            <h1 class="title !text-bg-primary font-black"><?php the_title(); ?></h1>

            <div class="meta-info text-sm text-slate-500">
                <span><?php echo get_the_date('d M Y'); ?></span>
                <!-- <?php
                $categories = get_the_category();
                if ($categories) {
                    echo ' | ';
                    foreach ($categories as $category) {
                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="link">' . esc_html($category->name) . '</a> ';
                    }
                }
                ?> -->
            </div>

            <?php if (has_post_thumbnail()) : ?>
                <div class="featured-image mb-8">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded-lg']); ?>
                </div>
            <?php endif; ?>

            <div class="content-blog prose max-w-none paragraph">
                <?php the_content(); ?>
            </div>

            <!-- Noticias relacionadas -->
            <?php
            $related_args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand'
            );
            
            $related_posts = new WP_Query($related_args);

            if ($related_posts->have_posts()) : ?>
                <div class="mt-12">
                    <h2 class="subtitle mb-6">Noticias relacionadas</h2>
                    <div class="grid grid-cols-1 hd:grid-cols-3 gap-6">
                        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="category-card p-6">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto rounded-lg mb-3']); ?>
                                <?php endif; ?>
                                <h3 class="title-card"><?php the_title(); ?></h3>
                                <span class="text-sm text-slate-500"><?php echo get_the_date('d M Y'); ?></span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php wp_reset_postdata();
            endif; ?>
        </div>
    </article>
</main>

<?php
endwhile;
get_footer();
?>