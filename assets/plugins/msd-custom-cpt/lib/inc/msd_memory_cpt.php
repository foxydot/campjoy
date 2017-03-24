<?php 
if (!class_exists('MSDMemoryCPT')) {
    class MSDMemoryCPT {
        //Properties
        var $cpt = 'memory';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDMemoryCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_taxonomy_memory_type') );
            add_action( 'init', array(&$this,'register_cpt_memory') );
            add_action( 'init', array( &$this, 'add_metaboxes' ) );
            
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_print_styles', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
            
            //Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
            add_shortcode('memory_grid', array(&$this,'memory_grid'));
            add_shortcode('memory-grid', array(&$this,'memory_grid'));
        }

        function register_taxonomy_memory_type(){
            
            $labels = array( 
                'name' => _x( 'Memory types', 'memory-types' ),
                'singular_name' => _x( 'Memory type', 'memory-types' ),
                'search_items' => _x( 'Search memory types', 'memory-types' ),
                'popular_items' => _x( 'Popular memory types', 'memory-types' ),
                'all_items' => _x( 'All memory types', 'memory-types' ),
                'parent_item' => _x( 'Parent memory type', 'memory-types' ),
                'parent_item_colon' => _x( 'Parent memory type:', 'memory-types' ),
                'edit_item' => _x( 'Edit memory type', 'memory-types' ),
                'update_item' => _x( 'Update memory type', 'memory-types' ),
                'add_new_item' => _x( 'Add new memory type', 'memory-types' ),
                'new_item_name' => _x( 'New memory type name', 'memory-types' ),
                'separate_items_with_commas' => _x( 'Separate memory types with commas', 'memory-types' ),
                'add_or_remove_items' => _x( 'Add or remove memory types', 'memory-types' ),
                'choose_from_most_used' => _x( 'Choose from the most used memory types', 'memory-types' ),
                'menu_name' => _x( 'Memory types', 'memory-types' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'memory-type','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'memory_type', array($this->cpt), $args );
        }
        
        function register_cpt_memory() {
        
            $labels = array( 
                'name' => _x( 'Memories', 'memory' ),
                'singular_name' => _x( 'Memory', 'memory' ),
                'add_new' => _x( 'Add New', 'memory' ),
                'add_new_item' => _x( 'Add New Memory', 'memory' ),
                'edit_item' => _x( 'Edit Memory', 'memory' ),
                'new_item' => _x( 'New Memory', 'memory' ),
                'view_item' => _x( 'View Memory', 'memory' ),
                'search_items' => _x( 'Search Memory', 'memory' ),
                'not_found' => _x( 'No memory found', 'memory' ),
                'not_found_in_trash' => _x( 'No memory found in Trash', 'memory' ),
                'parent_item_colon' => _x( 'Parent Memory:', 'memory' ),
                'menu_name' => _x( 'Memory', 'memory' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Memory',
                'supports' => array( 'title', 'editor', 'author', 'thumbnail' ,'genesis-cpt-archives-settings'),
                'taxonomies' => array( 'memory_type' ),
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
                'rewrite' => array('slug'=>'memory','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }
        
        function add_metaboxes(){
                global $post,$wpalchemy_media_access,$memory_info;                
                $memory_info = new WPAlchemy_MetaBox(array
                    (
                        'id' => '_memory_info',
                        'title' => 'Memory Info',
                        'types' => array('memory'),
                        'context' => 'normal',
                        'priority' => 'high',
                        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/memory-meta.php',
                        'autosave' => TRUE,
                        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
                        'prefix' => '_memory_' // defaults to NULL
                    ));
                    
                $adtl_files = new WPAlchemy_MetaBox(array
                    (
                        'id' => '_adtl_files',
                        'title' => 'Additional Images',
                        'types' => array('memory'),
                        'context' => 'normal',
                        'priority' => 'high',
                        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/additional-files.php',
                        'autosave' => TRUE,
                        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
                        'prefix' => '_adtl_' // defaults to NULL
                    ));
            }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_register_script('my-upload', plugin_dir_url(dirname(__FILE__)).'/js/msd-upload-file.js', array('jquery','media-upload','thickbox'),FALSE,TRUE);
                wp_enqueue_script('my-upload');
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'/css/meta.css');
            }
        }   
            
        function print_footer_scripts()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
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
        }
        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Memory Title','memory');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                        jQuery('#postdivrich').before(jQuery('#_contact_info_metabox'));
                    </script><?php
            }
        }
        

        function custom_query( $query ) {
            if(!is_admin()){
                $is_memory = ($query->query['post_type'] == $this->cpt)?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    $post_types = $query->query_vars['post_type'];
                    if(count($post_types)==0){
                        $post_types[] = 'post';
                        $post_types[] = 'page';
                    }
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                }
                elseif( $query->is_main_query() && $query->is_archive && $is_memory) {
                    $query->set( 'post_type', $this->cpt );
                    $query->set( 'meta_query', array() );
                }
            }
        }       
        
        function memory_loop(){
            global $subtitle_metabox;
            if(have_posts()){
                while ( have_posts() ) {
                    the_post();
                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
                    $background = $featured_image[0];
                    $size = '';
                    if(empty($background)){
                        $background = get_stylesheet_directory_uri().'/lib/img/trees.png';
                        $size = 'background-size: 70%;';
                    }
                    $subtitle_metabox->the_meta($post->ID);
                    $ret .= '<a href='.get_the_permalink( $post->ID ).' class="memory col-xs-12 col-sm-3">
                    <div class="wrapper" style="background-image:url('.$background.')">
                    <div class="fader">
                    <div class="titles">
                    <span class="name">' . $subtitle_metabox->get_the_value('subtitle') . '</span> 
                    <span class="title">' . get_the_title( $post->ID ) . '</span>
                    </div>
                    </div>
                    </div>
                    </a>';
                }
            if(strlen($ret) > 0){
                $ret = '<div class="memory-grid row">'.$ret.'</div>
                <div><a class="add-memory button" href="/share-your-memory/">Share Your Memory</a></div>
                
                <style>
                    .memory-grid .memory{
                        padding-top: 1em;
                        padding-bottom: 1em;
                    }
                    .memory-grid .memory .wrapper{
                        background-position: center center;
                        background-size: cover; 
                        background-repeat: no-repeat;
                        min-height: 184px;
                        background-color: rgb(29, 57, 141);
                        border: 6px solid rgb(29, 57, 141);
                        position: relative;
                    }
                    .memory-grid .memory .wrapper .fader{
                        opacity: 0;
                          -webkit-transition: all 0.5s ease;
                          -moz-transition: all 0.5s ease;
                          -ms-transition: all 0.5s ease;
                          -o-transition: all 0.5s ease;
                          transition: all 0.5s ease;
                        background-color: rgba(255,255,255,0.8);
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        top: 0;
                    }                    
                    .memory-grid .memory:hover .wrapper .fader{
                        opacity: 1;
                    }
                    .memory-grid .memory .wrapper .fader .titles{
                        bottom: 30px;
                        left: 30px;
                        position: absolute;
                        right: 30px;
                        top: 30px;
                        text-align: center;
                        line-height: 1;
                    }
                    .memory-grid .memory .wrapper .fader .titles .name,
                    .memory-grid .memory .wrapper .fader .titles .title{
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: pre-line;
                        color: #2f2e2e;
                        max-height: 3em;
                        display: block;
                    }
                    .memory-grid .memory .wrapper .fader .titles .name:not(:empty),
                    .memory-grid .memory .wrapper .fader .titles .title:not(:empty) {
                        margin-top: 5px;
                    }
                    .memory-grid .memory .wrapper .fader .titles .name{
                        font-size: 16px;
                    }
                    .memory-grid .memory .wrapper .fader .titles .title{
                        font-size: 12px;
                    }
                </style>
                ';
            }
            print $ret;
            }
        }
        
        function memory_grid( $atts ){
            global $subtitle_metabox;
            extract( shortcode_atts( array(
                'rows' => 4,
                'columns' => 4,
                'link' => true,
            ), $atts ) );
            $bs_cols = floor(12/$columns);
            if($rows == -1 || $columns == -1){
                $ppp = -1;
            } else {
                $ppp = $rows * $columns;
            }
            $args = array(
                'post_type' => 'memory',
                'orderby' => 'rand',
                'posts_per_page' => $ppp,
                'update_post_term_cache' => false,
            );
            $my_query = new WP_Query($args);
            
            $ret = '';
            // The 2nd Loop
            if($my_query->have_posts()){
                while ( $my_query->have_posts() ) {
                    $my_query->the_post();
                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
                    $background = $featured_image[0];
                    $size = '';
                    if(empty($background)){
                        $background = get_stylesheet_directory_uri().'/lib/img/trees.png';
                        $size = 'background-size: 70%;';
                    }
                    $subtitle_metabox->the_meta($my_query->post->ID);
                    $ret .= '<a href='.get_the_permalink( $my_query->post->ID ).' class="memory col-xs-12 col-sm-'.$bs_cols.'">
                    <div class="wrapper" style="background-image:url('.$background.');'.$size.'">
                    <div class="fader">
                    <div class="titles">
                    <span class="name">' . $subtitle_metabox->get_the_value('subtitle') . '</span> 
                    <span class="title">' . get_the_title( $my_query->post->ID ) . '</span>
                    </div>
                    </div>
                    </div>
                    </a>';
                }
            }
            if(strlen($ret) > 0){
                $ret = '<div class="memory-grid cols-'.$columns.' row">'.$ret.'</div>
                <style>
                    .memory-grid .memory{
                        padding-top: 1em;
                        padding-bottom: 1em;
                    }
                    .memory-grid .memory .wrapper{
                        background-position: center center;
                        background-size: cover; 
                        background-repeat: no-repeat;
                        min-height: 184px;
                        background-color: rgb(29, 57, 141);
                        border: 6px solid rgb(29, 57, 141);
                        position: relative;
                    }
                    .memory-grid .memory .wrapper .fader{
                        opacity: 0;
                          -webkit-transition: all 0.5s ease;
                          -moz-transition: all 0.5s ease;
                          -ms-transition: all 0.5s ease;
                          -o-transition: all 0.5s ease;
                          transition: all 0.5s ease;
                        background-color: rgba(255,255,255,0.8);
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        top: 0;
                    }                    
                    .memory-grid .memory:hover .wrapper .fader{
                        opacity: 1;
                    }
                    .memory-grid .memory .wrapper .fader .titles{
                        bottom: 30px;
                        left: 30px;
                        position: absolute;
                        right: 30px;
                        top: 30px;
                        text-align: center;
                        line-height: 1;
                    }
                    .memory-grid .memory .wrapper .fader .titles .name,
                    .memory-grid .memory .wrapper .fader .titles .title{
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: pre-line;
                        color: #2f2e2e;
                        max-height: 3em;
                        display: block;
                    }
                    .memory-grid .memory .wrapper .fader .titles .name:not(:empty),
                    .memory-grid .memory .wrapper .fader .titles .title:not(:empty) {
                        margin-top: 5px;
                    }
                    .memory-grid .memory .wrapper .fader .titles .name{
                        font-size: 16px;
                    }
                    .memory-grid .memory .wrapper .fader .titles .title{
                        font-size: 12px;
                    }
                </style>
                ';
            }
            // Restore original Post Data
            wp_reset_postdata();
            return $ret;
        }
           
  } //End Class
} //End if class exists statement