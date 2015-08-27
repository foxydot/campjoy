<?php
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
//add_action( 'msdlab_title_area', 'genesis_do_cpt_archive_title_description' );

remove_all_actions('genesis_entry_header');
add_filter('genesis_link_post_title','msdlab_testimonial_remove_link');
add_action('genesis_entry_header','genesis_do_post_title'); //move the title out of the content area
remove_action('genesis_entry_content','genesis_do_post_content');
add_action('genesis_entry_content','msdlab_testimonial_content');

function msdlab_testimonial_content(){
    global $post,$testimonial_info;
    $testimonial_info->the_meta($post->ID);
    $quote = apply_filters('the_content',$testimonial_info->get_the_value('quote'));
    $name = $testimonial_info->get_the_value('attribution')!=''?'<span class="name">'.$testimonial_info->get_the_value('attribution').'</span>':'';
    $position = $testimonial_info->get_the_value('position')!=''?'<span class="position">'.$testimonial_info->get_the_value('position').'</span>':'';
    $company = $testimonial_info->get_the_value('company')!=''?'<span class="company">'.$testimonial_info->get_the_value('company').'</span>':'';
    if($name !='' && ($position != '' || $company !='')){
        $name .= ', ';
    }
    if($position != '' && $company !=''){
        $position .= ', ';
    }
    $ret .= '<div class="item-wrapper">
    <div class="quote">'.$quote.'</div>
    <div class="attribution">'.$name.$position.$company.'</div>
    </div>';
    print $ret;
}

function msdlab_testimonial_remove_link(){
    return false;
}
genesis();
?>