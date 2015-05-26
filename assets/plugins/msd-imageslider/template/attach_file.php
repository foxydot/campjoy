<div class="my_meta_control">
<a style="float:right; margin:0 10px;" href="#" class="dodelete-docs button">Remove All</a>
 
	<p>Add images to the slider.</p>
 	<input id="post_id_reference" name="post_id_reference" type="hidden" value="<?php print $post->ID; ?>" />
	<?php while($mb->have_fields_and_multi('docs')): ?>
	<?php $mb->the_group_open(); ?>
		<?php $mb->the_field('title'); ?>
		<label>Title</label>
		<p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
		<?php $mb->the_field('uploadfile'); ?>
		<label>Image</label>
		<p><img src="<?php $mb->the_value(); ?>" class="attached-slider-image-preview" /></p>
		<p><input type="text" class="uploadfile" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<a href="#" class="uploadbtn button" onclick="return false;">Attach Image</a></p>
		<?php $mb->the_field('link'); ?>
		<label>Link</label>
		<p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<?php $mb->the_field('target'); ?>
		<input type="checkbox" name="<?php $mb->the_name(); ?>" value="_blank"<?php $mb->the_checkbox_state('_blank'); ?>/> Open in New Window
		</p>
		<?php $mb->the_field('caption'); ?>
		<label>Caption</label>
		<p><textarea name="<?php $mb->the_name(); ?>"><?php $mb->the_value(); ?></textarea>
		<p><a href="#" class="dodelete button">Remove Slide</a></p>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-docs button">Add Another Image</a></p>
</div>
