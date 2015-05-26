		<div class="feature">
			
			<div class="feature_entry">
			
			<!-- content slider -->
			<div id="slider">
			<ul class="kwicks reset" >
			
 <!-- SLIDER BEGIN -->
<?php
$accordion_cat = get_option('bb_accordion_cat');
if($accordion_cat == NULL || $accordion_cat == 'Choose a category') {$accordion_cat = 'slider';}
  $temp = $wp_query;
  $wp_query= null;
  $wp_query = new WP_Query('category_name=' . $accordion_cat . '&showposts=4');
  $count = 0;
  while ($wp_query->have_posts()) : $wp_query->the_post();
  $count++;
?>

 <!-- displays the slider posts -->
			
				<li id="kwick<?php echo $count; ?>"><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title=""><img src="<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php if(get_post_meta($post->ID, accordion_image_value, true) != NULL) {echo get_post_meta($post->ID, accordion_image_value, true);} else if(get_post_meta($post->ID, large_image_value, true) != NULL) {echo get_post_meta($post->ID, large_image_value, $single = true);} else {echo get_post_meta($post->ID, fullsize_value, $single = true);} ?>&amp;h=340&amp;w=650&amp;zc=1" alt="<?php the_title(); ?>" /></a><div class="headline"><div class="title"><h4><?php if (get_post_meta($post->ID, slider_short_title_value, true) != NULL){echo get_post_meta($post->ID, slider_short_title_value, true);} else {the_title();} ?></h4><p><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title=""><?php echo get_post_meta($post->ID, accordion_desc_value, true); ?></a></p></div><div class="title_active hidden"><h4><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title=""><?php the_title(); ?></a></h4><p><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title=""><?php echo get_post_meta($post->ID, slider_desc_value, true); ?></a></p></div></div></li>
				
 <!-- end slider posts display -->  
 <?php endwhile; $wp_query = null; $wp_query = $temp; ?>
 <!-- SLIDER POSTS END -->
 
			</ul>
			</div>

			</div><!-- end div.feature_entry -->

		</div><!-- end div.feature -->