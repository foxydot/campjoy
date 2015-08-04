<?php 
if (!class_exists('MSDFactsCPT')) {
	class MSDFactsCPT {
		//Properties
		var $cpt = 'fact';
		//Methods
	    /**
	    * PHP 4 Compatible Constructor
	    */
		public function MSDFactsCPT(){$this->__construct();}
	
		/**
		 * PHP 5 Constructor
		 */
		function __construct(){
			global $current_screen;
        	//"Constants" setup
        	$this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
        	$this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
			//Actions
            add_action( 'init', array(&$this,'register_cpt_fact') );
            add_action( 'init', array( &$this, 'add_metaboxes' ) );
            
            if(class_exists('MSD_Widget_Fact_Slider')){
                add_action('widgets_init',array('MSD_Widget_Fact_Slider','init'),10);
            }
			add_action('admin_head', array(&$this,'plugin_header'));
			add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
			add_action('admin_print_styles', array(&$this,'add_admin_styles') );
			// important: note the priority of 99, the js needs to be placed after tinymce loads
			add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
			
			//Filters
			//add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_shortcode('fact',array(&$this,'fact_shortcode_handler'));
            add_shortcode('facts',array(&$this,'fact_shortcode_handler'));
		}
		
		function register_cpt_fact() {
		
		    $labels = array( 
		        'name' => _x( 'Facts', 'fact' ),
		        'singular_name' => _x( 'Fact', 'fact' ),
		        'add_new' => _x( 'Add New', 'fact' ),
		        'add_new_item' => _x( 'Add New Fact', 'fact' ),
		        'edit_item' => _x( 'Edit Fact', 'fact' ),
		        'new_item' => _x( 'New Fact', 'fact' ),
		        'view_item' => _x( 'View Fact', 'fact' ),
		        'search_items' => _x( 'Search Fact', 'fact' ),
		        'not_found' => _x( 'No fact found', 'fact' ),
		        'not_found_in_trash' => _x( 'No fact found in Trash', 'fact' ),
		        'parent_item_colon' => _x( 'Parent Fact:', 'fact' ),
		        'menu_name' => _x( 'Fact', 'fact' ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'hierarchical' => false,
		        'description' => 'Fact',
		        'supports' => array('title', 'editor', 'author' ,'genesis-cpt-archives-settings'),
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
		        'rewrite' => array('slug'=>'fact','with_front'=>false),
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
                        $("#postdivrich").after($("#_fact_info_metabox"));
                    });
                 </script><?php
			}
		}
		
        function custom_query( $query ) {
            if(!is_admin()){
                $is_fact = ($query->query['post_type'] == $this->cpt)?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    $post_types = $query->query_vars['post_type'];
                    if(count($post_types)==0){
                        $post_types[] = 'post';
                        $post_types[] = 'page';
                    }
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                }
                elseif( $query->is_main_query() && $query->is_archive && $is_fact) {
                    $query->set( 'post_type', $this->cpt );
                    $query->set( 'meta_query', array() );
                }
            }
        } 	
        
        function fact_shortcode_handler($atts){
            extract( shortcode_atts( array(
                'rows' => 1,
                'columns' => 1,
                'link' => false,
                'length' => false
            ), $atts ) );
            global $fact_info;
            $args = array(
                'post_type' => $this->cpt,
                'orderby' => rand,
                'posts_per_page' => $rows * $columns,
            );
            $facts = get_posts($args);
            $ret = false;
            foreach($facts AS $fact){
                $fact_info->the_meta($fact->ID);
                $ret .= '<div class="col-md-'. 12/$columns .' col-xs-12 item-wrapper">
                '.apply_filters('the_content',$fact->post_content).'
                </div>';
            }
            if($link){
                $link_text = is_string($link)?$link:'Read More Facts';
                $ret .= '<div class="col-md-'. 12/$columns .' col-xs-12 link-wrapper"><a href="'.get_post_type_archive_link($this->cpt).'">'.$link_text.'</a></div>';
            }
            $ret = '<div class="msdlab_fact_gallery">'.$ret.'</div>';
            
            return $ret;
        } 

        function add_metaboxes(){
                global $post,$wpalchemy_media_access,$fact_info;
                $fact_info = new WPAlchemy_MetaBox(array
                    (
                        'id' => '_fact_info',
                        'title' => 'Fact Info',
                        'types' => array('fact'),
                        'context' => 'normal',
                        'priority' => 'high',
                        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/fact-information.php',
                        'autosave' => TRUE,
                        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
                        'prefix' => '_fact_' // defaults to NULL
                    ));
            }
            
            
    function msd_trim_quote($text, $length = 35) {
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
                $text = $text . ' <a href="'.get_post_type_archive_link( $this->cpt ).'">Read More ></a>';
            } else {
                $text = implode(' ', $words);
            }
    
        
        return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
        //return $text;
    }
  } //End Class
} //End if class exists statement

class MSD_Widget_Fact_Slider extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'widget_fact_slider', 'description' => __('Displays some random facts in a slider.'));
        parent::__construct('widget_fact_slider', __('Fact Slider'), $widget_ops, $control_ops);
    }
    function widget( $args, $instance ) {
        $cpt = new MSDFactsCPT();
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $linktext = apply_filters( 'widget_title', empty($instance['linktext']) ? 'Read More' : $instance['linktext'], $instance, $this->id_base);
        $args = array(
                'post_type' => $cpt->cpt,
                'orderby' => rand,
                'posts_per_page' => $instance['items'],
            );
        $facts = get_posts($args);
        echo $before_widget; 
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
        print '<div id="fact-carousel" class="carousel slide" data-ride="carousel">
        <div class="wrap carousel-inner" role="listbox">';
        $i = 0;
        foreach($facts as $fact){
            $active = $i == 0?' active':'';
            print '<div class="item'.$active.'">';
            print apply_filters('the_content',$fact->post_content);
            print '</div>';
            $i++;
        }
        print '
        </div>
        <a class="left carousel-control" href="#fact-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#fact-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
        </div>';
        echo $after_widget;
    }
    
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['linktext'] = strip_tags($new_instance['linktext']);
        $instance['items'] = $new_instance['items'];
        
        return $instance;
    }
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Link Text:'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" name="<?php echo $this->get_field_name('linktext'); ?>" type="text" value="<?php echo esc_attr($linktext); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('items'); ?>"><?php _e('Number of Facts:'); ?></label><select class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>">
            <?php
            for($i=1;$i<10;$i++){
                ?>
                <option value="<?php print $i; ?>"<?php print $i == $instance['items']?' selected':''; ?>><?php print $i; ?></option>
                <?php
            }
             ?>
        </select></p>
<?php
    }
    function init() {
        if ( !is_blog_installed() )
            return;
        register_widget('MSD_Widget_Fact_Slider');
    }  
}