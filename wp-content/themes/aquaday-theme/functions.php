<?php
if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

// Verificar si WooCommerce está activo
if (!function_exists('is_woocommerce_active')) {
    function is_woocommerce_active() {
        return class_exists('WooCommerce');
    }
}

// Mostrar aviso si WooCommerce no está activo
if (!is_woocommerce_active()) {
    add_action('admin_notices', function() {
        ?>
        <div class="error">
            <p><?php _e('Este tema requiere WooCommerce para funcionar correctamente. Por favor, instala y activa WooCommerce.', 'aquaday'); ?></p>
        </div>
        <?php
    });
    return; // Detener ejecución si WooCommerce no está activo
}

// Configuración básica del tema
function theme_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');

    register_nav_menus(array(
        'menu-principal' => esc_html__('Menú Principal', 'aquaday'),
        'tienda' => esc_html__('Tienda', 'aquaday'),
    ));
}
add_action('after_setup_theme', 'theme_setup');

// Estilos y Scripts
function theme_styles() {
    // Styles
    wp_enqueue_style('style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
    wp_enqueue_style('splide', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css');
    
    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('splide', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', array(), null, true);
    wp_register_script('app', get_template_directory_uri() . '/assets/js/app.js', array(), _S_VERSION, true);
    wp_enqueue_script('categories-slider', get_template_directory_uri() . '/assets/js/categories-slider.js', array('swiper'), _S_VERSION, true);
    wp_register_script('home', get_template_directory_uri() . '/assets/js/home.js', array('swiper'), _S_VERSION, true);
    wp_register_script('nosotros', get_template_directory_uri() . '/assets/js/nosotros.js', array('swiper'), _S_VERSION, true);
    wp_enqueue_script('app');
    // WooCommerce Custom Scripts
    wp_register_script(
        'woo-custom',
        get_template_directory_uri() . '/assets/js/woo-custom.js',
        array('jquery'),
        _S_VERSION,
        true
    );
    wp_script_add_data('woo-custom', 'type', 'module');

    // Wishlist Scripts
    wp_register_script(
        'wishlist',
        get_template_directory_uri() . '/assets/js/wishlist.js',
        array('jquery'),
        _S_VERSION,
        true
    );
    wp_script_add_data('wishlist', 'type', 'module');

    // Form Handler
    wp_register_script(
        'formHandler',
        get_template_directory_uri() . '/assets/js/formHandler.js',
        array(),
        _S_VERSION,
        true
    );
    wp_script_add_data('formHandler', 'type', 'module');

    // Conditional Loading
    if (is_front_page()) {
        wp_enqueue_script('home');
        wp_enqueue_script('carrusel');
        wp_enqueue_script('services-slider');
    }

    if (is_shop() || is_product_category() || is_product()) {
    
    }

    wp_enqueue_script('woo-custom');
    wp_enqueue_script('wishlist');

    if (is_page('contacto')) {
        wp_enqueue_script('contact');
        wp_enqueue_script('formHandler');
    }
    if (is_page('nosotros')) {
        wp_enqueue_script('nosotros');
    }

    // Localize Script for WhatsApp Share
    wp_localize_script('woo-custom', 'wooSettings', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'whatsapp_number' => get_option('theme_contact_whatsapp')
    ));
    wp_enqueue_script('jquery');
    wp_enqueue_script('cart-sidebar', get_template_directory_uri() . '/assets/js/cart-sidebar.js', array('jquery'), _S_VERSION, true);
    wp_localize_script('cart-sidebar', 'cart_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('woocommerce-cart'),
        'whatsapp_number' => get_option('theme_contact_whatsapp')
    ));
   
}
add_action('wp_enqueue_scripts', 'theme_styles');

// Botón de compartir carrito por WhatsApp
function add_whatsapp_cart_share() {
    if (!is_woocommerce_active()) return;

    $whatsapp = get_option('theme_contact_whatsapp');
    $cart = WC()->cart;

    if ($cart && !$cart->is_empty()) {
        $message = "Mi lista de productos:%0A";

        foreach ($cart->get_cart() as $item) {
            $product = wc_get_product($item['product_id']);
            if ($product) {
                $message .= "- " . $product->get_name() . " x " . $item['quantity'] . "%0A";
            }
        }

        $message = urlencode($message);
        $whatsapp_url = "https://wa.me/$whatsapp?text=$message";

        echo '<a href="' . esc_url($whatsapp_url) . '" class="button whatsapp-share" target="_blank">
                Compartir por WhatsApp
              </a>';
    }
}
add_action('woocommerce_after_cart_table', 'add_whatsapp_cart_share');

// Botón de consulta de producto por WhatsApp
function add_product_whatsapp_button() {
    if (!is_woocommerce_active()) return;

    global $product;

    if (is_object($product)) {
        $whatsapp = get_option('theme_contact_whatsapp');
        $message = urlencode("Me interesa el producto: " . $product->get_name() . " - " . get_permalink());
        $whatsapp_url = "https://wa.me/$whatsapp?text=$message";

        echo '<a href="' . esc_url($whatsapp_url) . '" class="button whatsapp-query" target="_blank">
                Consultar por WhatsApp
              </a>';
    }
}
add_action('woocommerce_after_add_to_cart_button', 'add_product_whatsapp_button');

// Agregar menú de opciones del tema
function aquaday_theme_options_page() {
    add_menu_page(
        'Configuración del Tema', // Título de la página
        'Configuración Aquaday', // Título del menú
        'manage_options', // Capacidad requerida
        'yato-options', // Slug
        'aquaday_theme_options_page_html', // Función que muestra la página
        'dashicons-admin-generic', // Icono
        20 // Posición
    );
}
add_action('admin_menu', 'aquaday_theme_options_page');

// Registrar las opciones
function aquaday_register_settings() {
    register_setting('aquaday_options', 'aquaday_social_facebook');
    register_setting('aquaday_options', 'aquaday_social_instagram');
    register_setting('aquaday_options', 'aquaday_contact_phone');
    register_setting('aquaday_options', 'aquaday_contact_email');
    register_setting('aquaday_options', 'aquaday_contact_whatsapp');
    register_setting('aquaday_options', 'aquaday_contact_address');
}
add_action('admin_init', 'aquaday_register_settings');

// HTML de la página de opciones
function aquaday_theme_options_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('aquaday_options');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Facebook</th>
                    <td>
                        <input type="url" name="aquaday_social_facebook" value="<?php echo esc_attr(get_option('aquaday_social_facebook')); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Instagram</th>
                    <td>
                        <input type="url" name="aquaday_social_instagram" value="<?php echo esc_attr(get_option('aquaday_social_instagram')); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Teléfono</th>
                    <td>
                        <input type="tel" name="aquaday_contact_phone" value="<?php echo esc_attr(get_option('aquaday_contact_phone')); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">WhatsApp</th>
                    <td>
                        <input type="tel" name="aquaday_contact_whatsapp" value="<?php echo esc_attr(get_option('aquaday_contact_whatsapp')); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>
                        <input type="email" name="aquaday_contact_email" value="<?php echo esc_attr(get_option('aquaday_contact_email')); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Dirección</th>
                    <td>
                        <textarea name="aquaday_contact_address" rows="3" class="regular-text"><?php echo esc_textarea(get_option('aquaday_contact_address')); ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button('Guardar cambios'); ?>
        </form>
    </div>
    <?php
}


// Deshabilitar Gutenberg
add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_block_editor_for_post_type', '__return_false');



function theme_add_image_sizes() {
    // Tamaño para miniaturas de productos
    add_image_size('product-thumbnail', 300, 300, true);
    
    // Tamaño para imágenes destacadas de productos
    add_image_size('product-featured', 800, 600, true);
    
    // Tamaño para banner principal
    add_image_size('banner-large', 1920, 700, true);
    
    // Tamaño para imágenes de categoría
    add_image_size('category-thumb', 400, 400, true);
    
    // Tamaño para galería de productos
    add_image_size('product-gallery', 600, 600, true);
    
    // Tamaño para imágenes del blog
    add_image_size('blog-featured', 850, 450, true);
    
    // Tamaño para thumbnails en móvil
    add_image_size('mobile-thumb', 200, 200, true);

    add_image_size('slider-mobile', 768, 800, true);
    // Tablet (1200px)
    add_image_size('slider-tablet', 1200, 800, true);
    // Desktop (1920px)
    add_image_size('slider-desktop', 1920, 800, true);
}
add_action('after_setup_theme', 'theme_add_image_sizes');
// Agregar los nuevos tamaños al selector de WordPress
function theme_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'product-thumbnail' => __('Miniatura de producto', 'aquaday'),
        'product-featured' => __('Producto destacado', 'aquaday'),
        'banner-large' => __('Banner principal', 'aquaday'),
        'category-thumb' => __('Miniatura de categoría', 'aquaday'),
        'product-gallery' => __('Galería de producto', 'aquaday'),
        'blog-featured' => __('Imagen destacada blog', 'aquaday'),
        'mobile-thumb' => __('Miniatura móvil', 'aquaday'),
        'slider-mobile' => __('Banner Slider mobile', 'aquaday'),
        'slider-tablet' => __('Banner Slider tablet', 'aquaday'),
        'slider-desktop' => __('Banner Slider desktop', 'aquaday'),
    ));
}
add_filter('image_size_names_choose', 'theme_custom_image_sizes');
// Asegurar que WooCommerce use los tamaños correctos
function theme_woocommerce_image_sizes() {
    // Tamaño de la imagen principal del producto
    update_option('woocommerce_single_image_width', 600);
    
    // Tamaño de las miniaturas de productos en catálogo
    update_option('woocommerce_thumbnail_image_width', 300);
    
    // Tamaño de las miniaturas de la galería
    update_option('woocommerce_gallery_thumbnail_width', 100);
}
add_action('after_setup_theme', 'theme_woocommerce_image_sizes');

function enqueue_custom_fonts() {
    wp_enqueue_style('sofia-pro-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_fonts');

function custom_woocommerce_catalog_orderby( $orderby ) {
    $orderby = array(
        'menu_order' => 'Orden por defecto',
        'popularity' => 'Ordenar por popularidad',
        'rating'     => 'Ordenar por calificación',
        'date'       => 'Ordenar por novedad',
        'price'      => 'Ordenar por precio: bajo a alto',
        'price-desc' => 'Ordenar por precio: alto a bajo',
    );
    return $orderby;
}
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );


// Función para añadir al carrito
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'custom_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'custom_ajax_add_to_cart');

function custom_ajax_add_to_cart() {
    check_ajax_referer('woocommerce-cart', 'security');

    if (!isset($_POST['product_id'])) {
        wp_send_json_error();
        return;
    }

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);

    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity)) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {
        $data = array(
            'error' => true,
            'message' => 'Error al agregar el producto'
        );
        wp_send_json_error($data);
    }

    wp_die();
}
// Función para obtener contenido del carrito
function get_cart_contents() {
    check_ajax_referer('woocommerce-cart', 'security');

    ob_start();
    if (WC()->cart->is_empty()) {
        echo '<p class="text-center py-4">Tu carrito está vacío</p>';
    } else {
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $product_id = $cart_item['product_id'];
            include(get_template_directory() . '/template-parts/cart/cart-item.php');
        }
    }
    $items = ob_get_clean();

    wp_send_json_success(array(
        'items' => $items,
        'cart_total' => WC()->cart->get_cart_total(),
        'cart_count' => WC()->cart->get_cart_contents_count()
    ));
}
add_action('wp_ajax_get_cart_contents', 'get_cart_contents');
add_action('wp_ajax_nopriv_get_cart_contents', 'get_cart_contents');
// Función para actualizar cantidad
function update_cart_quantity() {
    check_ajax_referer('woocommerce-cart', 'security');
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);
    
    WC()->cart->set_quantity($cart_item_key, $quantity);
    
    wp_send_json_success(array(
        'cart_total' => WC()->cart->get_cart_total(),
        'cart_count' => WC()->cart->get_cart_contents_count()
    ));
}
add_action('wp_ajax_update_cart_quantity', 'update_cart_quantity');
add_action('wp_ajax_nopriv_update_cart_quantity', 'update_cart_quantity');

// Función para eliminar productos del carrito
function remove_cart_item() {
    check_ajax_referer('woocommerce-cart', 'security');

    if (!isset($_POST['cart_item_key'])) {
        wp_send_json_error('No se proporcionó key del item');
        return;
    }

    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    
    if (WC()->cart->remove_cart_item($cart_item_key)) {
        wp_send_json_success(array(
            'cart_total' => WC()->cart->get_cart_total(),
            'cart_count' => WC()->cart->get_cart_contents_count()
        ));
    } else {
        wp_send_json_error('No se pudo eliminar el item');
    }
}
add_action('wp_ajax_remove_cart_item', 'remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item');

// Función para el mensaje de WhatsApp
function get_cart_whatsapp_message() {
    check_ajax_referer('woocommerce-cart', 'security');

    $message = "Mi lista de productos:\n\n";
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        $message .= "• " . $product->get_name() . " x " . $cart_item['quantity'] . "\n";
        $message .= "  Precio: " . strip_tags($product->get_price_html()) . "\n";
    }
    $message .= "\nTotal: " . strip_tags(WC()->cart->get_cart_total());
    
    wp_send_json_success(array(
        'message' => $message,
        'whatsapp_number' => get_option('theme_contact_whatsapp')
    ));
}
add_action('wp_ajax_get_cart_whatsapp', 'get_cart_whatsapp_message');
add_action('wp_ajax_nopriv_get_cart_whatsapp', 'get_cart_whatsapp_message');

function add_woocommerce_gallery_support() {
    add_theme_support('woocommerce', array(
        'gallery_thumbnail_image_width' => 150,
        'single_image_width' => 600,
    ));
}
add_action('after_setup_theme', 'add_woocommerce_gallery_support');

add_filter('woocommerce_single_product_image_gallery_classes', 'custom_gallery_classes');
function custom_gallery_classes($classes) {
    $classes[] = 'custom-gallery-wrapper';
    return $classes;
}

require_once get_template_directory() . '/class-custom-nav-walker.php';