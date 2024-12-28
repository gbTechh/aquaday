<?php
get_header();

while (have_posts()) :
    the_post();
    
    //botón whatsapp
    $servicio_nombre = get_the_title();
    $servicio_url = get_the_permalink();
    $servicio_imagen = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $mensaje = "Hola, estoy interesado en el servicio: *{$servicio_nombre}*\n\n{$servicio_url}";
    $mensaje_codificado = urlencode($mensaje);
    $numero_whatsapp = esc_html(get_option('yato_contact_whatsapp'));
    
    $fields = get_fields();
?>

<main class="p-6 hd:px-20 pt-0 flex flex-col items-center justify-center pb-20 hd:pb-32">
    <div class="w-full max-w-[1200px] ">
        <!-- Breadcrumbs -->
        <div class="text-sm my-10 hd:mt-20">
            <a href="<?php echo home_url(); ?>" class="link !font-medium mr-4">Inicio</a> | 
            <a href="<?php echo home_url('/servicios'); ?>" class="link !font-medium mx-4">Servicios</a> | 
            <span class="link !font-medium opacity-70 ml-4"><?php the_title(); ?></span>
        </div>

        <!-- Contenido principal -->
        <div class="flex flex-col hd:flex-row gap-10 items-start">
            <!-- Columna de imagen -->
            <div class="aspect-square flex items-center flex-col justify-center w-full hd:w-[400px] h-auto gap-5">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-4 border-[1px] border-gray-300 p-10">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded-lg']); ?>
                    </div>
                <?php endif; ?>
                <a href="https://api.whatsapp.com/send?phone=<?php echo $numero_whatsapp; ?>&text=<?php echo $mensaje_codificado; ?>" 
                   target="_blank" 
                   style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/pattern-blue.svg');" 
                   class="bg-no-repeat bg-cover p-10 bg-bg-secondarysoft flex-1 w-full block text-white font-black uppercase text-left">
                    Whatsapp
                </a>
               
            </div>

            <!-- Columna de información -->
            <div class="product-info flex-1">
                <h1 class="title !text-bg-primary font-black "><?php the_title(); ?></h1>
                 <?php
                if (!empty($fields['galeria'])) : ?>
                    <div class="flex flex-row flex-nowrap gap-1 mb-10 mt-5 overflow-x-auto">
                        <?php foreach ($fields['galeria'] as $image) : ?>
                            <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" 
                                 alt="<?php echo esc_attr($image['alt']); ?>"
                                 class="aspect-square hover:bg-slate-100 transition-all p-2 w-20 block h-auto rounded cursor-pointer">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>    

                <?php if (!empty($fields['descripcion_corta'])) : ?>
                    <p class="paragraph my-8">
                        <?php echo esc_html($fields['descripcion_corta']); ?>
                    </p>
                <?php endif; ?>

                <div class="description-product mb-8">
                    <h2 class="subtitle mb-6">Descripción del servicio</h2>
                    <?php the_content(); ?>
                </div>

                <?php
                if (!empty($fields['especificaciones'])) : ?>
                   <?php $especificaciones = get_field('especificaciones'); ?>
                    <div class="overflow-x-auto">
                        <h2 class="subtitle mb-6">Especificaciones</h2>
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border p-2 text-left">Características</th>
                                    <?php
                                    for($i = 1; $i <= 6; $i++) {
                                        if(!empty($especificaciones[0]['columna'.$i])) {
                                            echo '<th class="border p-2 text-left">' . esc_html($especificaciones[0]['columna'.$i]) . '</th>';
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for($i = 1; $i < count($especificaciones); $i++): ?>
                                    <tr class="even:bg-gray-50">
                                        <td class="border p-2 font-medium">
                                            <?php echo esc_html($especificaciones[$i]['caracteristicas']); ?>
                                        </td>
                                        <?php
                                        for($j = 1; $j <= 6; $j++) {
                                            if(!empty($especificaciones[0]['columna'.$j])) {
                                                echo '<td class="border p-2">' . esc_html($especificaciones[$i]['columna'.$j]) . '</td>';
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Servicios relacionados -->
        <?php
        $related_args = array(
            'post_type' => 'servicio',
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand'
        );
        
        $related_services = new WP_Query($related_args);

        if ($related_services->have_posts()) : ?>
            <div class="mt-12">
                <h2 class="subtitle mb-6">Servicios relacionados</h2>
                <div class="grid grid-cols-1 hd:grid-cols-3 gap-6">
                    <?php while ($related_services->have_posts()) : $related_services->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="product-related-card p-6 flex items-center justify-center flex-col">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto rounded-lg mb-3']); ?>
                            <?php endif; ?>
                            <h3 class="link"><?php the_title(); ?></h3>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php wp_reset_postdata();
        endif;
        ?>
    </div>
</main>

<?php
endwhile;
get_footer();
?>