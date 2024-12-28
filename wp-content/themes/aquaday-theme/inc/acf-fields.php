<?php
// inc/acf-fields.php

if (!function_exists('get_header_fields')) {
    function get_header_fields() {
      return get_field('header');        
    }
}

// inc/acf-fields.php

if (!function_exists('get_product_categories_with_fields')) {
  function get_product_categories_with_fields() {
    // Obtener todas las categorías de productos
    $categories = get_terms([
      'taxonomy' => 'categoria_producto',
      'hide_empty' => false, // false para mostrar también categorías sin productos
    ]);

    $categories_data = [];

    if (!empty($categories) && !is_wp_error($categories)) {
      foreach ($categories as $category) {
        // Crear objeto con datos básicos de la categoría
        $category_data = new stdClass();
        $category_data->id = $category->term_id;
        $category_data->name = $category->name;
        $category_data->slug = $category->slug;
        $category_data->description = $category->description;
        $category_data->count = $category->count;
        
        // Obtener campos ACF de la categoría
        $acf_fields = get_fields('term_' . $category->term_id);
        
        if ($acf_fields) {
          foreach ($acf_fields as $key => $value) {
            // Si es una imagen o galería, procesar diferente
          if ($key === 'imagen' && is_array($value)) {
              $category_data->$key = [
                'id' => $value['ID'],
                'url' => $value['url'],
                'alt' => $value['alt'],
                'sizes' => $value['sizes']
              ];
            } else {
              $category_data->$key = $value;
            }
          }
        }
        
        $categories_data[] = $category_data;
      }
    }

    return $categories_data;
  }
}

function yato_get_social_links() {
    $social_links = array(
        'facebook' => get_option('yato_social_facebook'),
        'instagram' => get_option('yato_social_instagram'),
        'whatsapp' => get_option('yato_contact_whatsapp'),
        'email' => get_option('yato_contact_email'),
        'phone' => get_option('yato_contact_phone'),
        'address' => get_option('yato_contact_address')
    );
    
    return $social_links;
}