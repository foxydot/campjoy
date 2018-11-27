<?
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
//add_action( 'msdlab_title_area', 'genesis_do_cpt_archive_title_description' );
remove_action('genesis_after_header', 'msdlab_do_post_subtitle','30');

remove_action('genesis_loop','genesis_do_loop');
add_action('genesis_loop', array('MSDMemoryCPT','memory_loop'));

genesis();
