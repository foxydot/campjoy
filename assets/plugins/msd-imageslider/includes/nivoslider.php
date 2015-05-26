		<div class="feature">

			<div class="feature_entry">
			
			<!-- nivo slider -->
			<div id="slider">
			<!-- SLIDER BEGIN -->
<?php
$nivo_cat = get_option('bb_nivo_cat');
if($nivo_cat == NULL || $nivo_cat == 'Choose a category') {$nivo_cat = 'slider';}
  $temp = $wp_query;
  $wp_query= null;
  $wp_query = new WP_Query('category_name=' . $nivo_cat . '&showposts=5');
  $count = 0;
  while ($wp_query->have_posts()) : $wp_query->the_post();
  $count++;
?>
			<!-- displays the slider posts -->
			<a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title="<?php the_title(); ?>"><img src="<?php if (get_post_meta($post->ID, large_image_value, true) != NULL) {echo get_post_meta($post->ID, large_image_value, $single = true);} else if (get_post_meta($post->ID, fullsize_value, true) != NULL) {echo get_post_meta($post->ID, fullsize_value, $single = true);} else {echo get_post_meta($post->ID, accordion_image_value, true);} ?>" alt="<?php the_title(); ?>" /></a>
			
			<!-- end slider posts display -->  
 <?php endwhile; $wp_query = null; $wp_query = $temp; ?>
			<!-- SLIDER POSTS END -->
			</div>
			
			<div class="sliderbar"></div>

			</div><!-- end div.feature_entry -->

		</div><!-- end div.feature -->