<?php
class MSDSectionedPage{
    /**
         * A reference to an instance of this class.
         */
        private static $instance;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new MSDSectionedPage();
                } 

                return self::$instance;

        } 
        
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
   function __construct() {      
        }
        
    function add_metaboxes(){
        global $post,$sectioned_page_metabox,$wpalchemy_media_access;
        $sectioned_page_metabox = new WPAlchemy_MetaBox(array
        (
            'id' => '_sectioned_page',
            'title' => 'Page Sections',
            'types' => array('page'),
            'context' => 'normal', // same as above, defaults to "normal"
            'priority' => 'high', // same as above, defaults to "high"
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-specialty-pages/msd-specialty-pages.php'). '/lib/template/metabox-sectioned-page.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_msdlab_', // defaults to NULL
            //'include_template' => 'sectioned-page.php',
        ));
    }
    
    function default_output($section,$i){
        //ts_data($section);
        global $parallax_ids;
        $eo = ($i+1)%2==0?'even':'odd';
        $title = apply_filters('the_title',$section['content-area-title']);
        $section_name = $section['section-name']!=''?$section['section-name']:$title;
        $slug = sanitize_title_with_dashes(str_replace('/', '-', $section_name));
        $background = '';
        if($section['background-color'] || $section['background-image']){
            if($section['background-color'] && $section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');background-color: '.$section['background-color'].';"';
            } elseif($section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');"';
            } else{
               $background = 'style="background-color: '.$section['background-color'].';"';
            }
            if($section['background-image'] && $section['background-image-parallax']){
                $parallax_ids[] = $slug;
            }
        }
        $wrapped_title = trim($title) != ''?'<div class="section-title">
            <h3 class="wrap">
                '.$title.'
            </h3>
        </div>':'';
        $subtitle = $section['content-area-subtitle'] !=''?'<h4 class="section-subtitle">'.$section['content-area-subtitle'].'</h4>':'';
        $header = apply_filters('the_content',$section['header-area-content']);
        $content = apply_filters('the_content',$section['content-area-content']);
        $footer = apply_filters('the_content',$section['footer-area-content']);
                $float = $section['feature-image-float']!='none'?' class="align'.$section['feature-image-float'].'"':'';
        $featured_image = $section['content-area-image'] !=''?'<img src="'.$section['content-area-image'].'"'.$float.' />':'';
        $classes = array(
            'section',
            'section-'.$slug,
            $section['css-classes'],
            'section-'.$eo,
            'clearfix',
        );
        //think about filtering the classes here
        $ret = '
        <div id="'.$slug.'" class="'.implode(' ', $classes).'"'.$background.'>
        
                '.$wrapped_title.'
            <div class="section-body">
                <div class="wrap">
                    '.$featured_image.'
                    '.$subtitle.'
                    '.$header.'
                    '.$content.'
                    '.$footer.'
                </div>
            </div>
        </div>
        ';
        return $ret;
    }


    function column_output($section,$i){
        //ts_data($section);
        global $parallax_ids;
        $eo = ($i+1)%2==0?'even':'odd';
        $title = apply_filters('the_title',$section['content-area-title']);
        $section_name = $section['section-name']!=''?$section['section-name']:$title;
        $slug = sanitize_title_with_dashes(str_replace('/', '-', $section_name));
        $background = '';
        if($section['background-color'] || $section['background-image']){
            if($section['background-color'] && $section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');background-color: '.$section['background-color'].';"';
            } elseif($section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');"';
            } else{
               $background = 'style="background-color: '.$section['background-color'].';"';
            }
            if($section['background-image'] && $section['background-image-parallax']){
                $parallax_ids[] = $slug;
            }
        }
        $wrapped_title = trim($title) != ''?'<div class="section-title">
            <h3 class="wrap">
                '.$title.'
            </h3>
        </div>':'';
        $subtitle = $section['content-area-subtitle'] !=''?'<h4 class="section-subtitle">'.$section['content-area-subtitle'].'</h4>':'';
        $header = '<div class="section-header-area">'.apply_filters('the_content',$section['header-area-content']).'</div>';
        $content = '<div class="section-content column-1 col-sm-12 col-md-'.$section['content-area-width'].'">'.apply_filters('the_content',$section['content-area-content']).'</div>';
        $content2 = '<div class="section-content column-2 col-sm-12 col-md-'.$section['column-2-area-width'].'">'.apply_filters('the_content',$section['column-2-area-content']).'</div>';
        $content3 = '<div class="section-content column-3 col-sm-12 col-md-'.$section['column-3-area-width'].'">'.apply_filters('the_content',$section['column-3-area-content']).'</div>';
        $content4 = '<div class="section-content column-4 col-sm-12 col-md-'.$section['column-4-area-width'].'">'.apply_filters('the_content',$section['column-4-area-content']).'</div>';
        $footer = '<div class="section-footer-area">'.apply_filters('the_content',$section['footer-area-content']).'</div>';
        $float = $section['feature-image-float']!='none'?' class="align'.$section['feature-image-float'].'"':'';
        $featured_image = $section['content-area-image'] !=''?'<img src="'.$section['content-area-image'].'"'.$float.' />':'';
        $classes = array(
            'section',
            'section-'.$slug,
            $section['css-classes'],
            'section-'.$eo,
            'clearfix',
        );
        switch($section['layout']){
            case 'four-col':
                $central_content = $content4;
            case 'three-col':
                $central_content = $content3.$central_content;
            case 'two-col':
                $central_content = $content2.$central_content;
            default:
                $central_content = $content.$central_content;
            break;
        }
        
        $central_content = '<div class="row">'.$central_content.'</div>';
        //think about filtering the classes here
        $ret = '
        <div id="'.$slug.'" class="'.implode(' ', $classes).'"'.$background.'>
        
                '.$wrapped_title.'
            <div class="section-body">
                <div class="wrap">
                    '.$featured_image.'
                    '.$subtitle.'
                    '.$header.'
                    '.$central_content.'
                    '.$footer.'
                </div>
            </div>
        </div>
        ';
        return $ret;
    }
    
    function sectioned_page_output(){
        wp_enqueue_script('sticky',WP_PLUGIN_URL.'/'.plugin_dir_path('msd-specialty-pages/msd-specialty-pages.php'). '/lib/js/jquery.sticky.js',array('jquery'),FALSE,TRUE);
        global $post,$subtitle_metabox,$sectioned_page_metabox,$nav_ids;
        $i = 0;
        $meta = $sectioned_page_metabox->the_meta();
        if(is_object($sectioned_page_metabox)){
        while($sectioned_page_metabox->have_fields('sections')){
            $layout = $sectioned_page_metabox->get_the_value('layout');
            switch($layout){
                case "four-col":
                    $sections[] = self::column_output($meta['sections'][$i],$i);
                    break;
                case "three-col":
                    $sections[] = self::column_output($meta['sections'][$i],$i);
                    break;
                case "two-col":
                    $sections[] = self::column_output($meta['sections'][$i],$i);
                    break;
                default:
                    $sections[] = self::default_output($meta['sections'][$i],$i);
                    break;
            }
            $i++;
        }//close while
        print '<div class="sectioned-page-wrapper">';
        print implode("\n",$sections);
        print '</div>';
        }//clsoe if
    }

    function sectioned_page_footer_js(){
        global $nav_ids,$parallax_ids; //http://julian.com/research/velocity/ llook at this to speed up animations
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
        //do some little stuff for parralaxing
        // init controller
        var section_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: $(window).height()*4}});
    
        // build scenes
        <?php
            $i = 0;
            foreach($parallax_ids AS $p_id):
        ?>
        new ScrollScene({options:{triggerElement:"#<?php print $p_id; ?>"}})
            .setTween(TweenMax.fromTo("#<?php print $p_id; ?>", 1, {css:{'background-position':"50% 100%"}, ease: Linear.easeNone}, {css:{'background-position':"50% 0%"}, ease: Linear.easeNone}))
            .addTo(section_controller);
        <?php 
            $i++;
            endforeach;
        ?>
            $("#floating_nav").sticky({ topSpacing: 0 });
        });
        </script>
        <?php
    }
        function info_footer_hook()
        {
            $postid = is_admin()?$_GET['post']:$post->ID;
            $template_file = get_post_meta($postid,'_wp_page_template',TRUE);
            if($template_file == 'page-sectioned.php'){
            ?><script type="text/javascript">
                jQuery(function($){
                    $("#wpa_loop-sections").sortable({
                        change: function(){
                            $("#warning").show();
                        }
                    });
                    $("#postdivrich").after($("#_page_sectioned_metabox"));
                    $(".colorpicker").spectrum({
                        preferredFormat: "rgb",
                        showAlpha: true,
                        showInput: true,
                        allowEmpty: true,
                    });
                    $('.cols-2').each(function(){
                        var layout = $(this).parents('.wpa_group-sections').find($('select.layout')).val();
                        if(layout == 'two-col'){
                            $(this).show();
                        }
                    });
                    $('.cols-3').each(function(){
                        var layout = $(this).parents('.wpa_group-sections').find($('select.layout')).val();
                        if(layout == 'three-col'){
                            $(this).show();
                        }
                    });
                    $('.cols-4').each(function(){
                        var layout = $(this).parents('.wpa_group-sections').find($('select.layout')).val();
                        if(layout == 'four-col'){
                            $(this).show();
                        }
                    });
                    $('.range-value').html(function(){
                        var section = $(this).parents('.cell');
                        var range = section.find('.input-range').val();
                        $(this).html(range + '/12 columns');
                    });
                    $('select.layout').change(function(){
                        var layout = $(this).val();
                        var section = $(this).parents('.wpa_group-sections');
                        section.find($('.cols-2, .cols-3, .cols-4')).hide();
                        if(layout == 'two-col'){
                            section.find($('.cols-2')).show();
                        }
                        if(layout == 'three-col'){
                            section.find($('.cols-3')).show();
                        }
                        if(layout == 'four-col'){
                            section.find($('.cols-4')).show();
                        }
                    });
                    $('.input-range').change(function(){
                        var range = $(this).val();
                        var section = $(this).parents('.cell');
                        section.find($('.range-value')).html(range + '/12 columns');
                    });
                });
                </script><?php
            }
        }
        
        function enqueue_admin(){
            wp_enqueue_script('spectrum',WP_PLUGIN_URL.'/msd-specialty-pages/lib/js/spectrum.js',array('jquery'));
            wp_enqueue_style('sectioned-admin',WP_PLUGIN_URL.'/msd-specialty-pages/lib/css/sectioned.css');
            wp_enqueue_style('spectrum',WP_PLUGIN_URL.'/msd-specialty-pages/lib/css/spectrum.css');
        }
}