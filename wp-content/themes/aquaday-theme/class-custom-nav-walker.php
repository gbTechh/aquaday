<?php
class Custom_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= "<ul class='submenu absolute top-full left-0 bg-white shadow-lg rounded-lg py-2 min-w-[200px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200'>";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $has_children = in_array('menu-item-has-children', $item->classes);
        
        $classes = ['relative'];
        if ($has_children) {
            $classes[] = 'group';
        }
        
        $output .= "<li class='" . implode(' ', $classes) . "'>";
        
        $output .= '<a href="' . $item->url . '" class="flex items-center px-4 py-2 hover:text-blue-500 transition-colors whitespace-nowrap">';
        $output .= $item->title;
        
        if ($has_children) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>';
        }
        
        $output .= '</a>';
    }
}