<?php 
/*
  Plugin Name: Aquaday - Post Types
  Plugin Uri:
  Descripcion: Añade Post Types al sitio Aquaday
  Version: 1.0.0
  Author: Rodrigo Silva Murillo
  Author Uri:
  Text Domain: aquaday
*/

if (!defined('ABSPATH')) {
    exit;
}


function aquaday_registrar_post_type_mensajes() {
    $labels = array(
        'name'               => 'Mensajes',
        'singular_name'      => 'Mensaje',
        'menu_name'          => 'Mensajes de Contacto',
        'add_new'           => 'Añadir nuevo',
        'add_new_item'      => 'Añadir nuevo mensaje',
        'edit_item'         => 'Editar mensaje',
        'view_item'         => 'Ver mensaje',
        'search_items'      => 'Buscar mensajes',
        'not_found'         => 'No se encontraron mensajes',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-email',
        'supports'           => array('title'),
    );

    register_post_type('mensaje', $args);
}
add_action('init', 'aquaday_registrar_post_type_mensajes');

// Función para la activación del plugin
function aquaday_activar_plugin() {
    aquaday_registrar_post_type_mensajes();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'aquaday_activar_plugin');

// Función para la desactivación del plugin
function aquaday_desactivar_plugin() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'aquaday_desactivar_plugin');