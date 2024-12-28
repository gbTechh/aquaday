<?php
/*
Template Name: Pagina de eventos
*/

get_header();
?>

<?php 
  if (have_posts()) :
    while (have_posts()) :
        the_post();  
        ?>          
        <main class="p-6 md:px-20 flex flex-col items-center justify-center">
          <section class="flex flex-col gap-6 max-w-[1200px] w-full">
            <h1 class="hd:mt-6  py-6 text-3xl hd:text-3xl text-bg-primary font-black "><?= the_title();?></h1>
            <?= the_content()?>
            <?php          
            if (!empty(get_field('exhibiciones'))) : ?>
                <div class="flex flex-row flex-nowrap gap-1 mb-10 mt-5 overflow-x-auto">
                    <?php foreach (get_field('exhibiciones') as $image) : ?>
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" 
                              alt="<?php echo esc_attr($image['alt']); ?>"
                              class=" aspect-square hover:bg-slate-100 transition-all p-2 w-20 block h-auto rounded cursor-pointer">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>    
      
            <?php          
            if (!empty(get_field('demostraciones'))) : ?>
                <div class="flex flex-row flex-nowrap gap-1 mb-10 mt-5 overflow-x-auto">
                    <?php foreach (get_field('demostraciones') as $image) : ?>
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" 
                              alt="<?php echo esc_attr($image['alt']); ?>"
                              class=" aspect-square hover:bg-slate-100 transition-all p-2 w-20 block h-auto rounded cursor-pointer">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>    
      
            <?php          
            if (!empty(get_field('ferias'))) : ?>
                <div class="flex flex-row flex-nowrap gap-1 mb-10 mt-5 overflow-x-auto">
                    <?php foreach (get_field('ferias') as $image) : ?>
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" 
                              alt="<?php echo esc_attr($image['alt']); ?>"
                              class=" aspect-square hover:bg-slate-100 transition-all p-2 w-20 block h-auto rounded cursor-pointer">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>    
      
            
        </main>
    <?php endwhile;
  endif;
?>




<?php get_footer();?>