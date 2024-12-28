 <footer class="bg-bg-secondary text-white">
    <div class="container mx-auto px-5 py-20">
        <!-- Sección principal -->
        <div class="flex flex-col hd:flex-row gap-10 mb-16">
            <!-- Columna 1: Logo y descripción -->
            <div class="flex-1">
                <h2 class="text-4xl font-black text-bg-primary mb-6 uppercase">Aquaday</h2>
                <h3 class="text-4xl text-white font-black mb-3 uppercase">Te mostramos el camino</h3>
                <p class="text-white text-lg mb-4">
                    <?php echo esc_html(get_option('aquaday_description')); ?>
                </p>
            </div>

            <!-- Columna 2: Enlaces del Menú Principal -->
            <div class="flex-1">
                <h4 class="text-sm text-white mb-6">Nuestra web</h4>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'menu-principal',
                        'container' => false,
                        'menu_class' => 'space-y-3',
                        'link_class' => '!text-white hover:text-bg-primary transition-colors capitalize'
                    ));
                ?>
            </div>

            <!-- Columna 3: Información de contacto -->
            <div class="flex-1">
                <h4 class="text-sm text-white mb-6 uppercase">Encuéntranos en</h4>
                <address class="not-italic space-y-3 text-white">
                    <p class="text-white"><?php echo esc_html(get_option('aquaday_contact_address')); ?></p>
                    <p class="font-bold">
                        <a href="tel:<?php echo esc_attr(get_option('aquaday_contact_phone')); ?>" 
                           class="text-white text-2xl hover:text-bg-primary transition-colors">
                            <?php echo esc_html(get_option('aquaday_contact_phone')); ?>
                        </a>
                    </p>
                    <p>
                        <a href="mailto:<?php echo esc_attr(get_option('aquaday_contact_email')); ?>"
                           class="text-white text-2xl hover:text-bg-primary transition-colors">
                            <?php echo esc_html(get_option('aquaday_contact_email')); ?>
                        </a>
                    </p>
                </address>
            </div>
        </div>

        <!-- Línea divisora -->
        <div class="border-t border-gray-700 pb-8"></div>

        <!-- Sección inferior -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Redes sociales -->
            <div class="flex gap-4">
                <?php if(get_option('aquaday_social_facebook')): ?>
                    <a href="<?php echo esc_url(get_option('aquaday_social_facebook')); ?>" 
                       target="_blank"
                       class="text-white hover:text-bg-primary transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                <?php endif; ?>
                
                <?php if(get_option('aquaday_social_instagram')): ?>
                    <a href="<?php echo esc_url(get_option('aquaday_social_instagram')); ?>" 
                       target="_blank"
                       class="text-white hover:text-bg-primary transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                <?php endif; ?>
                
                <?php if(get_option('aquaday_social_linkedin')): ?>
                    <a href="<?php echo esc_url(get_option('aquaday_social_linkedin')); ?>" 
                       target="_blank"
                       class="text-white hover:text-bg-primary transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.7 3H4.3A1.3 1.3 0 003 4.3v15.4A1.3 1.3 0 004.3 21h15.4a1.3 1.3 0 001.3-1.3V4.3A1.3 1.3 0 0019.7 3zM8.339 17.3H5.667v-8.59h2.672v8.59zM7.004 7.547A1.547 1.547 0 115.457 6a1.547 1.547 0 011.547 1.547zM17.3 17.3h-2.669v-4.177c0-.996-.017-2.278-1.387-2.278-1.389 0-1.601 1.086-1.601 2.206v4.249h-2.667v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092V17.3z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            
        </div>
    </div>
</footer>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <?php wp_footer(); ?>
  
</body>
</html>