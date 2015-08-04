<?php global $wpalchemy_media_access; 
?>

<ul class="meta_control">
    <li>
            <label>Small Print</label>
            <div class="input_container">
                <?php 
                $mb->the_field('smallprint');
                $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                $mb_editor_id = sanitize_key($mb->get_the_name());
                $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5','media_buttons' => false);
                wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                ?>
           </div>
        </li>
</ul>
<script>
jQuery(function($){
    $("#postdivrich").after($("#_fact_info_metabox"));
});</script>
