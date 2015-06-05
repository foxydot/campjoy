<?php
add_shortcode('hex','msdlab_make_hex');
function msdlab_make_hex($atts, $content = null){
    extract( shortcode_atts( array(
      'color' => 'green',
      ), $atts ) );
        $ret = '
        <div class="hexa '.$color.'">
            <div class="hexa_text">'.$content.'</div>
            <div class="hexa_image"></div>
            <div class="hexagon scale_0">
              <div class="h_sq t_sq_1 color_0"></div>
              <div class="h_sq t_sq_2 color_0"></div>
              <div class="h_sq t_sq_3 color_0"></div>
              <div class="h_sq t_sq_4 color_0"></div>
              <div class="h_sq t_sq_5 color_0"></div>
              <div class="h_sq t_sq_6 color_0"></div>
            </div>
            <div class="hexagon scale_1">
              <div class="h_sq t_sq_1 color_1"></div>
              <div class="h_sq t_sq_2 color_1"></div>
              <div class="h_sq t_sq_3 color_1"></div>
              <div class="h_sq t_sq_4 color_1"></div>
              <div class="h_sq t_sq_5 color_1"></div>
              <div class="h_sq t_sq_6 color_1"></div>
            </div>
            <div class="hexagon scale_2">
              <div class="h_sq t_sq_1 color_2"></div>
              <div class="h_sq t_sq_2 color_2"></div>
              <div class="h_sq t_sq_3 color_2"></div>
              <div class="h_sq t_sq_4 color_2"></div>
              <div class="h_sq t_sq_5 color_2"></div>
              <div class="h_sq t_sq_6 color_2"></div>
            </div>
            <div class="hexagon scale_3">
              <div class="h_sq t_sq_1 color_3"></div>
              <div class="h_sq t_sq_2 color_3"></div>
              <div class="h_sq t_sq_3 color_3"></div>
              <div class="h_sq t_sq_4 color_3"></div>
              <div class="h_sq t_sq_5 color_3"></div>
              <div class="h_sq t_sq_6 color_3"></div>
            </div>
      </div>';
      return $ret;
}

add_shortcode('menu','msdlab_display_menu');
function msdlab_display_menu($atts, $content = null){
    extract( shortcode_atts( array(
      'menu_id' => false,
      ), $atts ) );
      if($menu_id){
          $args = array(
            'theme_location'  => '',
            'menu'            => $menu_id,
            'container'       => 'nav',
            'container_class' => 'genesis-nav-menu',
            'container_id'    => '',
            'menu_class'      => 'menu',
            'menu_id'         => '',
            'echo'            => false,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'           => 0,
            'walker'          => ''
        );
        return wp_nav_menu( $args );
      } else {
          return false;
      }
}
add_shortcode('team_output','msdlab_team');
function msdlab_team(){
            global $post,$msd_custom,$contact_info_metabox,$jobtitle_metabox;
    
            $msd_team_display = new MSDTeamDisplay;
            $team = $msd_team_display->get_all_team_members();
            $ret = '<div id="team-members"><div class="hex_row_odd">';
            $row = $i = 1;
            foreach($team AS $team_member){
                $headshot = get_the_post_thumbnail($team_member->ID,'headshot-md');
                $headshot_url = msdlab_get_thumbnail_url($team_member->ID,'headshot-md');
                $terms = wp_get_post_terms($team_member->ID,'practice_area');
                $jobtitle_metabox->the_meta($team_member->ID);
                $practice_areas = '';
                if(count($terms)>0){
                    foreach($terms AS $term){
                        $practice_areas[] = $term->slug;
                    }
                    
                    $practice_areas = implode(' ', $practice_areas);
                }
                $mini_bio = msdlab_excerpt($team_member->ID);
                $team_contact_info = '';
                $contact_info_metabox->the_meta($team_member->ID);
                $teamstr = '<div class="center">
    <div class="hexagon bkg">
      <div class="hex1 bkg">
        <div class="hex2 bkg">
        </div>
      </div>
    </div>
    <div class="hexagon fg">
      <div class="hex1">
        <div class="hex2" style="background: url('.$headshot_url.') center no-repeat">
          <div class="desc">
            <h2>'.$team_member->post_title.'</h2>
            <p class="jobtitle">'.$jobtitle_metabox->get_the_value('jobtitle').'</p>
            <p class="email">'.msd_str_fmt($contact_info_metabox->get_the_value('_team_email'),'email').'</p>
            <p class="phone">'.msd_str_fmt($contact_info_metabox->get_the_value('_team_phone'),'phone').'</p>
          </div>  
        </div><!--/hex2--> 
      </div><!--/hex1-->
    </div><!--/hexagon--> 
  </div><!--/center-->';
                $ret .= $teamstr;   
                $i++;
                $eo = $row%2==0?'even':'odd';
                if(($eo=='even' && $i==7) || ($eo=='odd' && $i==6)){
                    $eo = $row%2==0?'even':'odd';
                    $ret .= '</div><div class="hex_row_'.$eo.'">';
                    $i = 0;
                    $row++;
                } 
            }
            $ret .= '</div>';
            $ret .= '</div>';
            return $ret;
        }
add_shortcode('button','msdlab_button_function');
function msdlab_button_function($atts, $content = null){	
	extract( shortcode_atts( array(
      'url' => null,
	  'target' => '_self'
      ), $atts ) );
      if(strstr($url,'mailto:',0)){
          $parts = explode(':',$url);
          if(is_email($parts[1])){
              $url = $parts[0].':'.antispambot($parts[1]);
          }
      }
	$ret = '<div class="button-wrapper">
<a class="button" href="'.$url.'" target="'.$target.'">'.remove_wpautop($content).'</a>
</div>';
	return $ret;
}
add_shortcode('hero','msdlab_landing_page_hero');
function msdlab_landing_page_hero($atts, $content = null){
	$ret = '<div class="hero">'.remove_wpautop($content).'</div>';
	return $ret;
}
add_shortcode('callout','msdlab_landing_page_callout');
function msdlab_landing_page_callout($atts, $content = null){
	$ret = '<div class="callout">'.remove_wpautop($content).'</div>';
	return $ret;
}
function column_shortcode($atts, $content = null){
	extract( shortcode_atts( array(
	'cols' => '3',
	'position' => '',
	), $atts ) );
	switch($cols){
		case 5:
			$classes[] = 'one-fifth';
			break;
		case 4:
			$classes[] = 'one-fouth';
			break;
		case 3:
			$classes[] = 'one-third';
			break;
		case 2:
			$classes[] = 'one-half';
			break;
	}
	switch($position){
		case 'first':
		case '1':
			$classes[] = 'first';
		case 'last':
			$classes[] = 'last';
	}
	return '<div class="'.implode(' ',$classes).'">'.$content.'</div>';
}
add_shortcode('mailto','msdlab_mailto_function');
function msdlab_mailto_function($atts, $content){
    extract( shortcode_atts( array(
    'email' => '',
    ), $atts ) );
    $content = trim($content);
    if($email == '' && preg_match('|[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}|i', $content, $matches)){
        $email = $matches[0];
    }
    $email = antispambot($email);
    return '<a href="mailto:'.$email.'">'.$content.'</a>';
}

add_shortcode('columns','column_shortcode');

add_shortcode('sitemap','msdlab_sitemap');