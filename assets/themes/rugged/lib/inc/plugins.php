<?php
add_filter('gform_print_styles','msdlab_tighten_print_css');
function msdlab_tighten_print_css($value,$form){
    wp_register_style( 'print_entry', get_stylesheet_directory_uri().'/lib/css/formprint.css' );
    $value[] = 'print_entry';
    return $value;
}