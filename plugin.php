<?php

/*
Plugin Name: OH Youtube In Lightbox
Plugin URI: http://ohav.co.il/plugins
Description: Display your Youtube video in a lightbox
Version: 1.10
Author: Ariel Hein
Author URI: http://ohav.co.il
Author Email: ariel@ohav.co.il
License:

  Copyright 2011 OH Recent Entries (ariel@ohav.co.il)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class OH_Youtube_In_Lightbox extends WP_Widget {
    private $plugin_name , $plugin_slug, $loc;
	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	/**
	 * The widget constructor. Specifies the classname and description, instantiates
	 * the widget, loads localization files, and includes necessary scripts and
	 * styles.
	 */
	function OH_Youtube_In_Lightbox() {

    // Define constants used throughout the plugin
    $this->init_plugin_constants();
	
	add_action( 'wp_enqueue_scripts', array( $this, 'oh_plugin_scripts' ), 0 );

	load_textdomain($this->loc, dirname( __FILE__  ) . '/lang/'. get_locale() .'.mo' );
	$widget_opts = array (
		'classname' => $this->plugin_slug,
		'description' => __("Display your Youtube video in a lightbox.", $this->loc)
	);	
	
	$this->WP_Widget($this->plugin_slug, __($this->plugin_name, $this->loc), $widget_opts);

		
    // Load JavaScript and stylesheets
    $this->register_scripts_and_styles(); //no need for that
	
	
		
	} // end constructor

	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @args			The array of form elements
	 * @instance
	 */
	function widget($args, $instance) {

		extract($args, EXTR_SKIP);

		echo $before_widget;

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $yt_url =  empty($instance['yt_url']) ? '' : $instance['yt_url'];
        $image =  empty($instance['image']) ? '' : $instance['image'];
        $lb_title =  empty($instance['lb_title']) ? '' : $instance['lb_title'];
        $is_btn =  empty($instance['is_btn']) ? '' : $instance['is_btn'];


        include(dirname(__FILE__) . '/views/widget.php');



		
		echo $after_widget;
		
	} // end widget


	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance	The previous instance of values before the update.
	 * @old_instance	The new instance of values to be generated via the update.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] 	= strip_tags(stripslashes($new_instance['title']));
        $instance['yt_url'] 	= strip_tags(stripslashes($new_instance['yt_url']));
        $instance['image'] 	= strip_tags(stripslashes($new_instance['image']));
        $instance['lb_title'] 	= strip_tags(stripslashes($new_instance['lb_title']));
        $instance['is_btn'] 	= strip_tags(stripslashes($new_instance['is_btn']));





		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance	The array of keys and values for the widget.
	 */
	function form($instance) {
	
		$instance = wp_parse_args(
			(array)$instance,
			array(
                'title' => '',
				'yt_url' => '',
			    'image' => '',
			    'lb_title' => '',
			    'is_btn' => '',


			)
		);
    
    $title = strip_tags(stripslashes($instance['title']));
    $yt_url = strip_tags(stripslashes($instance['yt_url']));
    $image = strip_tags(stripslashes($instance['image']));
    $lb_title = strip_tags(stripslashes($instance['lb_title']));
    $is_btn = strip_tags(stripslashes($instance['is_btn']));



	// Display the admin form
    include(dirname(__FILE__) . '/views/admin.php');
		
	} // end form
	
	/*--------------------------------------------------*/
	/* Private Functions
	/*--------------------------------------------------*/
	
  /**
   * Initializes constants used for convenience throughout 
   * the plugin.
   */
	  private function init_plugin_constants() {
		  $this->loc =  'oh' ;
		  $this->define_constants();
		  $this->plugin_name =  'OH Youtube In Lighbox';
		  $t = __('OH Youtube In Lighbox', $this->loc ); // we do that so the poedit will scan this
		  $this->plugin_slug = 'oh_youtube_in_lighbox';
		
	  
	 
	  
	  } // end init_plugin_constants 

	function define_constants(){
		define('OH_YOUTUBE_IN_LB_URL', $this->plugin_url());
	}
	


	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if(is_admin()) {
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			$this->load_file($this->plugin_name, 'css/admin.css');
			$this->load_file($this->plugin_name, 'js/admin.js');
			wp_enqueue_style('thickbox');
		}

	} // end register_scripts_and_styles
	
	function oh_plugin_scripts() {
		if (!is_admin()) 
		{
			$version = "1.0.0";
			wp_enqueue_script	( 'prettyPhoto', 		OH_YOUTUBE_IN_LB_URL .  ('/js/jquery.prettyPhoto.js'), 				array( 'jquery' ), $version, true );
			wp_enqueue_script	( 'scripts', 		OH_YOUTUBE_IN_LB_URL .  ('/js/scripts.js'), 				array( 'jquery' ), $version, true );
			wp_enqueue_style	( 'prettyphoto', 		OH_YOUTUBE_IN_LB_URL .  ('/css/prettyPhoto.css') );
		}else{
            wp_enqueue_script	( 'oh_youtube_script', 		OH_YOUTUBE_IN_LB_URL .  ('/js/admin.js'), 				array( 'jquery' ), $version, true );
        }
    }	

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	    function plugin_url(){ 
            if ( $this->plugin_url ) return $this->plugin_url;
            return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
        }
	 
	private function load_file($name, $file_path, $is_script = false) {
        $url = plugins_url($file_path , __FILE__);
        $file = dirname( __FILE__ ) . '/'. $file_path;
        if(file_exists($file)) {
            if($is_script) {
                wp_register_script($name, $url);
                wp_enqueue_script($name);
            } else {
                wp_register_style($name, $url);
                wp_enqueue_style($name);
            } // end if
        } // end if

	} // end load_file
	
} // end class
add_action('widgets_init', create_function('', 'register_widget("OH_Youtube_In_Lightbox");'));
?>