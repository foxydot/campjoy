<?php global $wpalchemy_media_access; 
?>

<ul class="meta_control">
     <li>
        <?php $metabox->the_field('video_url'); ?>
            <label>Video URL</label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
</ul>
<script>
jQuery(function($){
    $("#postdivrich").after($("#_memory_info_metabox"));
});</script>
