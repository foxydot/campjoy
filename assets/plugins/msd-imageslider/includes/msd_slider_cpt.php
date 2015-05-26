<?php
if (!class_exists('MSDSliderCPT')) {
    class MSDSliderCPT {
        //This is where the class variables go, don't forget to use @var to tell what they're for/**
        /**
		 * @var string The plugin version
		 */
		var $version = '0.1';
        
        /**
        * @var string The options string name for this plugin
        */
        var $optionsName = 'msd_imageslider_options';
        
		/**
		 * @var string $nonce String used for nonce security
		 */
		var $nonce = 'msd_imageslider-update-options';
		
        /**
        * @var string $localizationDomain Domain used for localization
        */
        var $localizationDomain = "msd_imageslider";
        
        /**
        * @var string $pluginurl The path to this plugin
        */ 
        var $thispluginurl = '';
        /**
        * @var string $pluginurlpath The path to this plugin
        */
        var $thispluginpath = '';
            
        /**
        * @var array $options Stores the options for this plugin
        */
        var $options = array();
                
        //Class Functions
        /**
        * PHP 4 Compatible Constructor
        */
        function msd_imageslider_slider($options = NULL){$this->__construct($options);}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct($options = NULL){
            //Language Setup
            $locale = get_locale();
            $mo = dirname(__FILE__) . "/../languages/" . $this->localizationDomain . "-".$locale.".mo";
            load_textdomain($this->localizationDomain, $mo);

            $this->options = $options;

            //Actions        
            add_action('wp_print_styles', array(&$this, 'add_css'));
            add_action('wp_print_scripts', array(&$this, 'add_js'));
            add_action('admin_print_styles', array(&$this, 'add_admin_css'));
            add_action('admin_print_scripts', array(&$this, 'add_admin_js'));
            add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
            add_action('init',array(&$this,'add_meta_boxes'));
            
            add_action( 'init', array(&$this,'register_cpt_slider') );
            
            
            //Filters
            /*
            add_filter('the_content', array(&$this, 'filter_content'), 0);
            */
            
            //Shortcodes
            add_shortcode('slider', array(&$this,'show_slider'));
        }
    	/**
		 * @desc Enqueue's the CSS for the specified theme.
		 */
		function add_css() {
		    global $post;
		    if(!is_admin()){
			    if ( preg_match( '#\[.*slider.*?type=accordion([^\]])*\]#i', $post->post_content )) {
					wp_enqueue_style('msd_imageslider', plugin_dir_url(dirname(__FILE__)).'css/accordion_opacity.css', false, $this->version, 'screen');
					wp_enqueue_style('msd_imageslider', plugin_dir_url(dirname(__FILE__)).'css/accordionslider.css', false, $this->version, 'screen');
			    } elseif (preg_match( '#\[.*slider.*?type=content([^\]])*\]#i', $post->post_content )) {
			    	wp_enqueue_style('msd_imageslider', plugin_dir_url(dirname(__FILE__)).'css/contentslider.css', false, $this->version, 'screen');
			    } else {
			    	wp_enqueue_style('msd_imageslider', plugin_dir_url(dirname(__FILE__)).'css/nivo-slider.css', false, $this->version, 'screen');
			    	wp_enqueue_style('foodbank_theme', plugin_dir_url(dirname(__FILE__)).'themes/foodbank/foodbank.css', false, $this->version, 'screen');
			    	wp_enqueue_style('foodbank_events_theme', plugin_dir_url(dirname(__FILE__)).'themes/foodbank_events/foodbank_events.css', false, $this->version, 'screen');
			    }
		    }
		}
		/**
		 * @desc Enqueue's the CSS for the specified theme.
		 */
		function add_admin_css() {
			wp_enqueue_style('thickbox');
			wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'template/meta.css');
		}
    
		/**
		 * @desc Responsible for loading the necessary scripts and localizing JavaScript messages
		 */
		function add_js() {		
		    global $post;
		    if(!is_admin()){
			    if ( preg_match( '#\[.*slider.*?type=accordion([^\]])*\]#i', $post->post_content )) {
			    	wp_enqueue_script('kwicks', plugin_dir_url(dirname(__FILE__)).'js/jquery.kwicks-1.5.1.pack.js', 'jquery', $this->version, TRUE);
			    	wp_enqueue_script('accordion-slider-init', plugin_dir_url(dirname(__FILE__)).'js/accordion_settings.js', 'kwicks', $this->version, TRUE);
			    } elseif (preg_match( '#\[.*slider.*?type=content([^\]])*\]#i', $post->post_content )) {
			    	wp_enqueue_script('lite-content-slider', plugin_dir_url(dirname(__FILE__)).'js/jquery.lite-content-slider.min.js', 'jquery', $this->version, TRUE);
			    	wp_enqueue_script('lite-content-slider-init', plugin_dir_url(dirname(__FILE__)).'js/jquery.lite-content-slider-init.js', 'lite-content-slider', $this->version, TRUE);
			    } else {
			    	wp_enqueue_script('nivo-slider', plugin_dir_url(dirname(__FILE__)).'js/jquery.nivo.slider.pack.js', 'jquery', $this->version, TRUE);
			    	wp_enqueue_script('nivo-slider-init', plugin_dir_url(dirname(__FILE__)).'js/jquery.nivo-init.js', array('jquery','nivo-slider'), $this->version, TRUE);
			    }
		    }
		}
        
		/**
		 * @desc Responsible for loading the necessary scripts and localizing JavaScript messages
		 */
		function add_admin_js() {		
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_register_script('my-upload', plugin_dir_url(dirname(__FILE__)).'js/msd-upload-file.js', array('jquery','media-upload','thickbox'),FALSE,TRUE);
			wp_enqueue_script('my-upload');
			wp_register_script('my-dragdrop', plugin_dir_url(dirname(__FILE__)).'js/msd-dragdrop.js', array('jquery','jquery-ui-sortable'),'0.9.7',TRUE);
			wp_enqueue_script('my-dragdrop');
		}
		
		/**
		 * @desc Adds scripts to the footer for using the thickbox uploader to embed files into custom meta boxes
		 */
    	function print_footer_scripts()
		{
			print '<script type="text/javascript">/* <![CDATA[ */
				jQuery(function($)
				{
					var i=1;
					$(\'.customEditor textarea\').each(function(e)
					{
						var id = $(this).attr(\'id\');
		 
						if (!id)
						{
							id = \'customEditor-\' + i++;
							$(this).attr(\'id\',id);
						}
		 
						tinyMCE.execCommand(\'mceAddControl\', false, id);
		 
					});
				});
			/* ]]> */</script>';
		}
		
        /**
         * @desc Create content type
         */
	    function register_cpt_slider() {
		
		    $labels = array( 
		        'name' => _x( 'Sliders', 'slider' ),
		        'singular_name' => _x( 'Slider', 'slider' ),
		        'add_new' => _x( 'Add New', 'slider' ),
		        'add_new_item' => _x( 'Add New Slider', 'slider' ),
		        'edit_item' => _x( 'Edit Slider', 'slider' ),
		        'new_item' => _x( 'New Slider', 'slider' ),
		        'view_item' => _x( 'View Slider', 'slider' ),
		        'search_items' => _x( 'Search Sliders', 'slider' ),
		        'not_found' => _x( 'No sliders found', 'slider' ),
		        'not_found_in_trash' => _x( 'No sliders found in Trash', 'slider' ),
		        'parent_item_colon' => _x( 'Parent Slider:', 'slider' ),
		        'menu_name' => _x( 'Sliders', 'slider' ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'hierarchical' => false,
		        'description' => 'Slideable images for various slider instances',
		        'supports' => array( 'title','editor','page-attributes' ),
		        'taxonomies' => array( 'msd_slider_instance' ),
		        'public' => true,
		        'show_ui' => true,
		        'show_in_menu' => true,
		        'menu_position' => 20,
		        
		        'show_in_nav_menus' => true,
		        'publicly_queryable' => true,
		        'exclude_from_search' => false,
		        'has_archive' => true,
		        'query_var' => true,
		        'can_export' => true,
		        'rewrite' => array('slug'=>'sliders','with_front'=>false),
		        'capability_type' => 'post'
		    );
		
		    register_post_type( 'msd_slider', $args );
		}
		
		/**
		 * @desc Load custom meta boxes
		 */
		function add_meta_boxes(){
			global $msd_imageslider_var,$msd_slider_image_meta;
			$msd_slider_image_meta = new WPAlchemy_MetaBox(array
			(
				'id' => '_slider',
				'title' => 'Slider Images',
				'types' => array('msd_slider'), // added only for pages and to custom post type "events"
				'context' => 'normal', // same as above, defaults to "normal"
				'priority' => 'high', // same as above, defaults to "high"
				'template' => $msd_imageslider_var->thispluginpath.'template/attach_file.php'
			));
		}	
		
		/**
		 * @desc Create shortcode
		 */
	    function show_slider( $atts ) {
			global $msd_slider_image_meta;
			extract( shortcode_atts( array(
				'name' => 'homepage-slider',
				'slider' => 'nivo',
				'theme' => 'foodbank'
			), $atts ) );
			
			$args = array( 'post_type' => 'msd_slider', 'numberposts' => 1, );
			if(!empty($name)){
				$args['name'] = $name;
			}
			$items = get_posts($args);
			
			$uploads = wp_upload_dir();
			
			$ret = '
			<div class="slider-wrapper theme-'.$theme.'">
			<div id="'.$name.'" class="slider">';
			
		    foreach($items AS $item){ 
	    	$msd_slider_image_meta->the_meta($item->ID);
		    	while($msd_slider_image_meta->have_fields_and_multi('docs')): 
		    		$link = $msd_slider_image_meta->get_the_value('link')!=''?' href="'.$msd_slider_image_meta->get_the_value('link').'"':'';
		    		$title = $msd_slider_image_meta->get_the_value('title')!=''?' title="'.$msd_slider_image_meta->get_the_value('title').'"':'';
		    		$target = $msd_slider_image_meta->get_the_value('target')!=''?' target="'.$msd_slider_image_meta->get_the_value('target').'"':'';
		    		$alt = $msd_slider_image_meta->get_the_value('title')!=''?' alt="'.$msd_slider_image_meta->get_the_value('title').'"':'';
		    		$caption = $msd_slider_image_meta->get_the_value('caption')!=''?' title="'.$msd_slider_image_meta->get_the_value('caption').'"':'';
		    		$imagepath = image_resize(preg_replace('@'.$uploads['baseurl'].'@i',$uploads['basedir'],$msd_slider_image_meta->get_the_value('uploadfile')),$width,$height,TRUE,$width.'x'.$height,$uploads['path']);
					if(!is_string($imagepath)){ 
						$imageurl = $msd_slider_image_meta->get_the_value('uploadfile');
					} else {
		    			$imageurl =  preg_replace('@'.$uploads['basedir'].'@i',$uploads['baseurl'],$imagepath);
					}
		    		$ret .=	'
		    		<a'.$link.$title.$target.'><img src="'.$imageurl.'"'.$alt.$caption.' /></a>';
				endwhile; 
		    }
		    
		    
			$ret .= '</div>
			</div>
			<div class="clear"></div>'; //end slider div
		    print $ret;
		}
        
  } //End Class
} //End if class exists statement