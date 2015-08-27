<?php
add_action('wp_enqueue_scripts', 'msdlab_testimonial_add_scripts_and_styles');
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
//add_action( 'msdlab_title_area', 'genesis_do_cpt_archive_title_description' );

//add_filter('genesis_attr_entry','msdlab_testimonial_wrapper');
remove_all_actions('genesis_entry_header');
add_filter('genesis_link_post_title','msdlab_testimonial_remove_link');
//add_action('genesis_entry_header','genesis_do_post_title'); //move the title out of the content area
add_action('genesis_entry_content','msdlab_testimonial_content');

add_action('wp_footer','msdlab_testimonial_footer_scripts');

add_filter( 'genesis_attr_content', 'msdlab_bootstrap_testimonial_archive_content_sidebar_wrap', 10);


function msdlab_bootstrap_testimonial_archive_content_sidebar_wrap( $attributes ){
    
    $attributes['class'] = str_ireplace(' col-md-12',' row',$attributes['class']);
    return $attributes;
}

function msdlab_testimonial_wrapper($attributes){
    global $post;
    $columns = 3;
    $attributes['class'] .= ' col-md-'. 12/$columns .' col-sm-12';
    return $attributes;
}

function msdlab_testimonial_content(){
    global $post,$testimonial_info;
    $testimonial_info->the_meta($post->ID);
    $quote = apply_filters('the_content',$testimonial_info->get_the_value('quote'));
    $name = $testimonial_info->get_the_value('attribution')!=''?'<span class="name">'.$testimonial_info->get_the_value('attribution').',</span> ':'';
    $position = $testimonial_info->get_the_value('position')!=''?'<span class="position">'.$testimonial_info->get_the_value('position').',</span> ':'';
    $company = $testimonial_info->get_the_value('company')!=''?'<span class="company">'.$testimonial_info->get_the_value('company').'</span> ':'';
    $ret .= '<div class="item-wrapper">
    <div class="quote">'.$quote.'</div>
    <div class="attribution">'.$name.$position.$company.'</div>
    </div>';
    print $ret;
}

function msdlab_testimonial_remove_link(){
    return false;
}

function msdlab_testimonial_add_scripts_and_styles() {
    global $is_IE;
    if(!is_admin()){
        wp_enqueue_script('isotope',get_stylesheet_directory_uri().'/lib/js/isotope.pkgd.js',array('jquery'));
    }
}

function msdlab_testimonial_footer_scripts(){
    print '<script type="text/javascript">
        jQuery(window).load(function() {
            jQuery("main.content").addClass("wrap").isotope({
              itemSelector : ".type-testimonial",
              layoutMode: "fitRows",
            }); 

            jQuery( window ).scroll(function() {
                jQuery("main.content").isotope();
            });
        });
    </script>';
}

genesis();
?>