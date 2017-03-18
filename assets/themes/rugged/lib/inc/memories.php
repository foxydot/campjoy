<?php
add_action('pre_get_posts','memory_alter_query');
 
function memory_alter_query($query) {
    //gets the global query var object
    global $wp_query;
    
    if (!$query->is_archive()) 
        return;
    
    if($query->query_vars['post_type'] != 'memory')
        return;
 
    if ( !$query->is_main_query() )
        return;

    $query->set('orderby' ,'rand');
    $query->set('nopaging' ,true);
    $query->set('posts_per_page' ,-1);
}