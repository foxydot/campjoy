		<div class="feature" style="padding-top:0px; padding-bottom:5px;">

			<div class="feature_entry">
			
			<!-- content slider -->
			<div id="slider">
			<div class="underslider"></div>
			<!-- Add the class "contentWrap" and the property "content" to the element of class "content" -->
			<div class="contentWrap" style="width:960px; height:340px; overflow:hidden;">
			<!-- SLIDER BEGIN -->
<?php
$full_content_cat = get_option('bb_full_content_cat');
if($full_content_cat == NULL || $full_content_cat == 'Choose a category') {$full_content_cat = 'slider';}
  $temp = $wp_query;
  $wp_query= null;
  $wp_query = new WP_Query('category_name=' . $full_content_cat . '&posts_per_page=-1&order=ASC');
  $count = 0;
  while ($wp_query->have_posts()) : $wp_query->the_post();
  $count++;
?>
			<!-- displays the slider posts -->
			
			<div class="content"<?php if(get_post_meta($post->ID, vimeo_embed_value, true) == NULL && get_post_meta($post->ID, youtube_embed_value, true) == NULL) { ?> style="background:url('<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php if (get_post_meta($post->ID, large_image_value, true) != NULL) {echo get_post_meta($post->ID, large_image_value, $single = true);} else if (get_post_meta($post->ID, fullsize_value, true) != NULL) {echo get_post_meta($post->ID, fullsize_value, $single = true);} else {echo get_post_meta($post->ID, accordion_image_value, true);} ?>&amp;h=340&amp;w=960&amp;zc=1') top left no-repeat;"><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title="<?php the_title(); ?>" style="display:block;width:100%;height:100%;position:absolute;">&nbsp;</a><?php } else if(get_post_meta($post->ID, vimeo_embed_value, true) != NULL) { echo '>'; ?>
<!-- Vimeo -->
<?php $vimeo = preg_replace('/\D*(\d+(\.\d+)?)/', "$1", get_post_meta($post->ID, vimeo_embed_value, true)); ?>

<object width="604" height="340"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $vimeo; ?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $vimeo; ?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="604" height="340"></embed></object>


<div class="left" style="width:311px;"><h1><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title="<?php the_title(); ?>"><?php if(get_post_meta($post->ID, slider_short_title_value, true) != NULL) {echo get_post_meta($post->ID, slider_short_title_value, true);} else {echo the_title();} ?></a></h1><p><?php if(get_post_meta($post->ID, slider_desc_value, true) != NULL) {echo get_post_meta($post->ID, slider_desc_value, true);} else {echo the_content();} ?></p></div>

			<?php } else if(get_post_meta($post->ID, youtube_embed_value, true) != NULL) { echo '>'; ?>
<!-- Youtube -->
<?php
function my_strip($start,$end,$total){
$total = stristr($total,$start);
$f2 = stristr($total,$end);
return substr($total,strlen($start),-strlen($f2));
}
$string=get_post_meta($post->ID, youtube_embed_value, true);
$youtube=my_strip("?v=","&",$string);
?> 
<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/<?php echo $youtube; ?>?fs=1&amp;hl=en_US&amp;color1=0x3a3a3a&amp;color2=0x999999" width="560" height="340"><param name="movie" value="http://www.youtube.com/v/<?php echo $youtube; ?>?fs=1&amp;hl=en_US&amp;color1=0x3a3a3a&amp;color2=0x999999"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param></object>

<div class="left"><h1><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title="<?php the_title(); ?>"><?php if(get_post_meta($post->ID, slider_short_title_value, true) != NULL) {echo get_post_meta($post->ID, slider_short_title_value, true);} else {echo the_title();} ?></a></h1><p><?php if(get_post_meta($post->ID, slider_desc_value, true) != NULL) {echo get_post_meta($post->ID, slider_desc_value, true);} else {echo the_content();} ?></p></div>

<?php } ?>
<?php if(get_post_meta($post->ID, vimeo_embed_value, true) == NULL && get_post_meta($post->ID, youtube_embed_value, true) == NULL) { ?>
<div class="right"><h1><a href="<?php if(get_post_meta($post->ID, external_link_value, true) != NULL) {echo get_post_meta($post->ID, external_link_value, true);} else{the_permalink();} ?>" title="<?php the_title(); ?>"><?php if(get_post_meta($post->ID, slider_short_title_value, true) != NULL) {echo get_post_meta($post->ID, slider_short_title_value, true);} else {echo the_title();} ?></a></h1><p><?php if(get_post_meta($post->ID, slider_desc_value, true) != NULL) {echo get_post_meta($post->ID, slider_desc_value, true);} else {echo the_content();} ?></p></div>
<?php } ?></div>
				
			<!-- end slider posts display -->  
 <?php endwhile; $wp_query = null; $wp_query = $temp; ?>
			<!-- SLIDER POSTS END -->
			</div>
			
			<div class="buttonsWrap">
<?php
$full_content_cat = get_option('bb_full_content_cat');
if($full_content_cat == NULL || $full_content_cat == 'Choose a category') {$full_content_cat = 'slider';}
  $temp = $wp_query;
  $wp_query= null;
  $wp_query = new WP_Query('category_name=' . $full_content_cat . '&posts_per_page=-1&order=ASC');
  $count = 0;
  while ($wp_query->have_posts()) : $wp_query->the_post();
  $count++;
?>
<!-- displays the slider controls -->
				<a href="#" class="buttons bt<?php echo $count; ?> <?php if ($count == 1) {echo "active";} ?>" rel="<?php echo $count; ?>"></a>
 <?php endwhile; $wp_query = null; $wp_query = $temp; ?>
<!-- end slider controls -->
			</div>
			</div>

			</div><!-- end div.feature_entry -->

		</div><!-- end div.feature -->