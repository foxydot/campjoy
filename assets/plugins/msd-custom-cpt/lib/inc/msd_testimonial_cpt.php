<?php 
if (!class_exists('MSDTestimonialCPT')) {
	class MSDTestimonialCPT {
		//Properties
		var $cpt = 'testimonial';
		//Methods
	    /**
	    * PHP 4 Compatible Constructor
	    */
		public function MSDTestimonialCPT(){$this->__construct();}
	
		/**
		 * PHP 5 Constructor
		 */
		function __construct(){
			global $current_screen;
        	//"Constants" setup
        	$this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
        	$this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
			//Actions
            add_action( 'init', array(&$this,'register_cpt_testimonial') );
            add_action( 'init', array( &$this, 'add_metaboxes' ) );
            
            if(class_exists('MSD_Widget_Random_Testimonial')){
                add_action('widgets_init',array('MSD_Widget_Random_Testimonial','init'),10);
            }
			add_action('admin_head', array(&$this,'plugin_header'));
			add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
			add_action('admin_print_styles', array(&$this,'add_admin_styles') );
			// important: note the priority of 99, the js needs to be placed after tinymce loads
			add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
			
			//Filters
			//add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_shortcode('testimonial',array(&$this,'testimonial_shortcode_handler'));
            add_shortcode('testimonials',array(&$this,'testimonial_shortcode_handler'));
            
            add_action('the_post',array(&$this,'single_testimonial_content'));
            
		}
		
		function register_cpt_testimonial() {
		
		    $labels = array( 
		        'name' => _x( 'Testimonials', 'testimonial' ),
		        'singular_name' => _x( 'Testimonial', 'testimonial' ),
		        'add_new' => _x( 'Add New', 'testimonial' ),
		        'add_new_item' => _x( 'Add New Testimonial', 'testimonial' ),
		        'edit_item' => _x( 'Edit Testimonial', 'testimonial' ),
		        'new_item' => _x( 'New Testimonial', 'testimonial' ),
		        'view_item' => _x( 'View Testimonial', 'testimonial' ),
		        'search_items' => _x( 'Search Testimonial', 'testimonial' ),
		        'not_found' => _x( 'No testimonial found', 'testimonial' ),
		        'not_found_in_trash' => _x( 'No testimonial found in Trash', 'testimonial' ),
		        'parent_item_colon' => _x( 'Parent Testimonial:', 'testimonial' ),
		        'menu_name' => _x( 'Testimonial', 'testimonial' ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'hierarchical' => false,
		        'description' => 'Testimonial',
		        'supports' => array('title', 'author' ,'genesis-cpt-archives-settings'),
		        'taxonomies' => array(),
		        'public' => true,
		        'show_ui' => true,
		        'show_in_menu' => true,
		        'menu_position' => 20,
		        
		        'show_in_nav_menus' => true,
		        'publicly_queryable' => true,
		        'exclude_from_search' => true,
		        'has_archive' => true,
		        'query_var' => true,
		        'can_export' => true,
		        'rewrite' => array('slug'=>'testimonial','with_front'=>false),
		        'capability_type' => 'post'
		    );
		
		    register_post_type( $this->cpt, $args );
        
		}
		
		function plugin_header() {
			global $post_type;
		}
		 
		function add_admin_scripts() {
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
			}
		}

        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'css/meta.css');
            }
        }   
			
		function print_footer_scripts()
		{
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
				?><script type="text/javascript">
                    jQuery(function($){
                        $( ".datepicker" ).datepicker({
                        onSelect : function(dateText, inst)
                        {
                            var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
                            $('.datestamp').val(epoch);
                        }
                        });
                        $('.timepicker').timepicker({ 'scrollDefaultNow': true });
                        $("#postdivrich").after($("#_testimonial_info_metabox"));
                    });
                 </script><?php
			}
		}
		
        function custom_query( $query ) {
            if(!is_admin()){
                $is_testimonial = ($query->query['post_type'] == $this->cpt)?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    $post_types = $query->query_vars['post_type'];
                    if(count($post_types)==0){
                        $post_types[] = 'post';
                        $post_types[] = 'page';
                    }
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                }
                elseif( $query->is_main_query() && $query->is_archive && $is_testimonial) {
                    $query->set( 'post_type', $this->cpt );
                    $query->set( 'meta_query', array() );
                }
            }
        } 	
        
        function testimonial_shortcode_handler($atts){
            extract( shortcode_atts( array(
                'rows' => 1,
                'columns' => 1,
                'link' => false,
                'length' => false
            ), $atts ) );
            global $testimonial_info;
            $args = array(
                'post_type' => $this->cpt,
                'orderby' => rand,
                'posts_per_page' => $rows * $columns,
            );
            $testimonials = get_posts($args);
            $ret = false;
            foreach($testimonials AS $testimonial){
                $testimonial_info->the_meta($testimonial->ID);
                $quote = apply_filters('the_content',$testimonial_info->get_the_value('quote'));
                if($length){
                    $quote = self::msd_trim_quote($quote,$length,get_the_permalink($testimonial->ID));
                }
                $name = $testimonial_info->get_the_value('attribution')!=''?'<span class="name">'.$testimonial_info->get_the_value('attribution').',</span> ':'';
                $position = $testimonial_info->get_the_value('position')!=''?'<span class="position">'.$testimonial_info->get_the_value('position').',</span> ':'';
                $organization = $testimonial_info->get_the_value('organization')!=''?'<span class="organization">'.$testimonial_info->get_the_value('organization').'</span> ':'';
                $location = $testimonial_info->get_the_value('location')!=''?'<span class="location">'.$testimonial_info->get_the_value('location').'</span> ':'';
                $ret .= '<div class="col-md-'. 12/$columns .' col-xs-12 item-wrapper">
                <div class="quote">'.$quote.'</div>
                <div class="attribution">'.$name.$position.$organization.$location.'</div>
                </div>';
            }
            if($link){
                $link_text = is_string($link)?$link:'Read More Testimonials';
                $ret .= '<div class="col-md-'. 12/$columns .' col-xs-12 link-wrapper"><a href="'.get_post_type_archive_link($this->cpt).'">'.$link_text.'</a></div>';
            }
            $ret = '<div class="msdlab_testimonial_gallery">'.$ret.'</div>';
            
            return $ret;
        } 

        function single_testimonial_content($post_object){
            if($post_object->post_type == $this->cpt){
                global $testimonial_info;
                $testimonial_info->the_meta($post_object->ID);
                $quote = apply_filters('the_content',$testimonial_info->get_the_value('quote'));
                if($length){
                    $quote = self::msd_trim_quote($quote,$length,get_the_permalink($testimonial->ID));
                }
                $name = $testimonial_info->get_the_value('attribution')!=''?'<span class="name">'.$testimonial_info->get_the_value('attribution').',</span> ':'';
                $position = $testimonial_info->get_the_value('position')!=''?'<span class="position">'.$testimonial_info->get_the_value('position').',</span> ':'';
                $organization = $testimonial_info->get_the_value('organization')!=''?'<span class="organization">'.$testimonial_info->get_the_value('organization').'</span> ':'';
                $location = $testimonial_info->get_the_value('location')!=''?'<span class="location">'.$testimonial_info->get_the_value('location').'</span> ':'';
                $ret .= '<div class="col-xs-12 item-wrapper">
                <div class="quote">'.$quote.'</div>
                <div class="attribution">'.$name.$position.$organization.$location.'</div>
                </div>';
                $post_object->post_content = $ret;
            }
            return $post_object;
        }

        function add_metaboxes(){
                global $post,$wpalchemy_media_access,$testimonial_info;                
                $testimonial_info = new WPAlchemy_MetaBox(array
                    (
                        'id' => '_testimonial_info',
                        'title' => 'Testimonial Info',
                        'types' => array('testimonial'),
                        'context' => 'normal',
                        'priority' => 'high',
                        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/testimonial-information.php',
                        'autosave' => TRUE,
                        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
                        'prefix' => '_testimonial_' // defaults to NULL
                    ));
            }

            
    function msd_trim_quote($text, $length = 35,$link = false) {
        $raw_excerpt = $text;
        if ( '' == $text ) {
            $text = get_the_content('');
        }
            $text = strip_shortcodes( $text );
            $text = preg_replace("/<img[^>]+\>/i", "", $text); 
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]&gt;', $text);
            $text = strip_tags($text);
            $excerpt_length = apply_filters('excerpt_length', $length);
            $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
            if ( count($words) > $excerpt_length ) {
                array_pop($words);
                $text = implode(' ', $words);
                if($link){
                    $text = $text . ' <a href="'.$link.'">Read More ></a>';
                } else {
                    $text = $text . ' <a href="'.get_post_type_archive_link( $this->cpt ).'">Read More ></a>';
                }
            } else {
                $text = implode(' ', $words);
            }
    
        
        return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
        //return $text;
    }
  } //End Class
} //End if class exists statement

class MSD_Widget_Random_Testimonial extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'widget_random_testimonial', 'description' => __('Displays a random testimonial.'));
        parent::__construct('widget_random_testimonial', __('Random Testimonial'), $widget_ops, $control_ops);
    }
    function widget( $args, $instance ) {
        $cpt = new MSDTestimonialCPT();
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $linktext = apply_filters( 'widget_title', empty($instance['linktext']) ? 'Read More' : $instance['linktext'], $instance, $this->id_base);
        echo $before_widget; 
        if ( !empty( $title ) ) {
             $title_array = explode(" ",$title);
             $title_bold = array_pop($title_array);
             $title = implode(" ", $title_array)." <br /><strong>". $title_bold . "</strong>";
             echo $before_title . $title . $after_title; 
        } 
        print '<div class="wrap">';
        print $cpt->testimonial_shortcode_handler(array('link'=>$linktext,'length'=>30)); 
        print '
        <div class="clearfix"></div>
        </div>';
        echo $after_widget;
    }
    
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['linktext'] = strip_tags($new_instance['linktext']);
        
        return $instance;
    }
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Link Text:'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" name="<?php echo $this->get_field_name('linktext'); ?>" type="text" value="<?php echo esc_attr($linktext); ?>" /></p>
<?php
    }
    function init() {
        if ( !is_blog_installed() )
            return;
        register_widget('MSD_Widget_Random_Testimonial');
    }  
    
}