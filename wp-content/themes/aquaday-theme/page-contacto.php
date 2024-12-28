<?php
/* Template Name: Página de Contacto */

get_header();
?>

<main class="p-6 md:px-20 pt-20 flex flex-col items-center justify-center">
    <div class="w-full max-w-[800px]">
        <h1 class="title-categories uppercase font-black !text-gray-200 my-14">Contacto</h1>

        <form id="contactForm" class="space-y-6" method="POST">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
            </div>

            <div>
                <label for="asunto" class="block text-sm font-medium text-gray-700">Asunto</label>
                <input type="text" name="asunto" id="asunto" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
            </div>

            <div>
                <label for="mensaje" class="block text-sm font-medium text-gray-700">Mensaje</label>
                <textarea name="mensaje" id="mensaje" rows="4" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2"></textarea>
            </div>

            <?php wp_nonce_field('submit_mensaje', 'mensaje_nonce'); ?>

            <div>
                <button type="submit" class="bg-bg-primary text-white px-6 py-2 rounded hover:bg-red-600 transition-colors">
                    Enviar mensaje
                </button>
            </div>

            <div id="form-mensaje" class="hidden"></div>
        </form>
    </div>
</main>

<?php get_footer(); ?>