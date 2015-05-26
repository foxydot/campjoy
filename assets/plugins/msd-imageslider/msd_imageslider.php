<?php
/*
Plugin Name: MSD Image Slider
Plugin URI: 
Description: 
Author: Catherine Sandrick
Version: 0.1
Author URI: http://MadScienceDept.com
*/   
   
/*  Copyright 2011  

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* Guess the wp-content and plugin urls/paths
*/
// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

if(!class_exists('WPAlchemy_MetaBox')){
	include_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)).'/includes/wpalchemy/MetaBox.php');
}

if (!class_exists('MSDImageSlider')) {
    class MSDImageSlider {
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
        function msd_imageslider(){$this->__construct();}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct(){
            //Language Setup
            $locale = get_locale();
            $mo = dirname(__FILE__) . "/languages/" . $this->localizationDomain . "-".$locale.".mo";
            load_textdomain($this->localizationDomain, $mo);

            //"Constants" setup
            $this->thispluginurl = WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)).'/';
            $this->thispluginpath = WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)).'/';
            
            //Initialize the options
            //This is REQUIRED to initialize the options when the plugin is loaded!
            $this->get_options();
            
            //Actions        
            add_action("admin_menu", array(&$this,"admin_menu_link"));

            
            //Widget Registration Actions
            //add_action('plugins_loaded', array(&$this,'register_widgets'));
            
            /*
            add_action('wp_print_styles', array(&$this, 'add_css'));
            add_action('wp_print_scripts', array(&$this, 'add_js'));
            */
            
            //Filters
            /*
            add_filter('the_content', array(&$this, 'filter_content'), 0);
            */
            $this->make_slider();
        }
        
    
        
        /**
        * @desc Adds the options subpanel
        */
        function admin_menu_link() {
            //If you change this from add_options_page, MAKE SURE you change the filter_plugin_actions function (below) to
            //reflect the page filename (ie - options-general.php) of the page your plugin is under!
            add_options_page('Image Slider', 'Image Slider', 10, basename(__FILE__), array(&$this,'admin_options_page'));
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2 );
        }
        
    
            
        /**
        * Adds settings/options page
        */
        function admin_options_page() { 
            if($_POST['msd_imageslider_save']){
                if (! wp_verify_nonce($_POST['_wpnonce'], 'msd_imageslider-update-options') ) die('Whoops! There was a problem with the data you posted. Please go back and try again.'); 
                $this->options['msd_imageslider_path'] = $_POST['msd_imageslider_path'];                   
                $this->options['msd_imageslider_allowed_groups'] = $_POST['msd_imageslider_allowed_groups'];
                $this->options['msd_imageslider_enabled'] = ($_POST['msd_imageslider_enabled']=='on')?true:false;
                                        
                $this->saveAdminOptions();
                
                echo '<div class="updated"><p>Success! Your changes were sucessfully saved!</p></div>';
            }
			require_once $this->thispluginpath.'includes/admin_options_page.php';
        }
        
    	/**
		 * @desc Loads the Image Slider options. Responsible for 
		 * handling upgrades and default option values.
		 * @return array
		 */
		function check_options() {
			$options = null;
			if (!$options = get_option($this->optionsName)) {
				// default options for a clean install
				$options = array(
					'shortcut' => true,
					'theme' => 'default',
					'version' => $this->version,
					'reset' => true
				);
				update_option($this->optionsName, $options);
			}
			else {
				// check for upgrades
				if (isset($options['version'])) {
					if ($options['version'] < $this->version) {
						// post v1.0 upgrade logic goes here
					}
				}
				else {
					// pre v1.0 updates
					if (isset($options['admin'])) {
						unset($options['admin']);
						$options['shortcut'] = true;
						$options['version'] = $this->version;
						$options['reset'] = true;
						update_option($this->optionsName, $options);
					}
				}
			}

			return $options;
		}
		
		
    	/**
		 * @desc Retrieves the plugin options from the database.
		 */
		function get_options() {
			$options = $this->check_options();
			$this->options = $options;
		}
		
		/**
		 * @desc Determines if request is an AJAX call
		 * @return boolean
		 */
		function is_ajax() {
			return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
					&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
		}

		/**
		 * @desc Checks to see if the given plugin is active.
		 * @return boolean
		 */
		function is_plugin_active($plugin) {
			return in_array($plugin, (array) get_option('active_plugins', array()));
		}
    
		/**
		 * @desc Enqueue's the CSS for the specified theme.
		 */
		function add_css() {
			//wp_enqueue_style('msd_imageslider', $this->pluginurl . "css/style.css", false, $this->version, 'screen');
		}
    
		/**
		 * @desc Responsible for loading the necessary scripts and localizing JavaScript messages
		 */
		function add_js() {
			//wp_enqueue_script('jquery-msd_imageslider', $this->pluginurl . 'js/jquery.msd_imageslider.js', array('jquery'), $this->version, true);
		}
        /**
        * Saves the admin options to the database.
        */
        function saveAdminOptions(){
            return update_option($this->optionsName, $this->options);
        }
        
        /**
        * @desc Adds the Settings link to the plugin activate/deactivate page
        */
        function filter_plugin_actions($links, $file) {
           //If your plugin is under a different top-level menu than Settiongs (IE - you changed the function above to something other than add_options_page)
           //Then you're going to want to change options-general.php below to the name of your top-level page
           $settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
           array_unshift( $links, $settings_link ); // before other links

           return $links;
        }
        
        /**
         * @desc Content type with context and shortcode
         */
		function make_slider(){
			include_once('includes/msd_slider_cpt.php');
			$this->slider = new MSDSliderCPT($this->options);
		}
        
  } //End Class
} //End if class exists statement

//instantiate the class
if (class_exists('MSDImageSlider')) {
    $msd_imageslider_var = new MSDImageSlider();
}
?>