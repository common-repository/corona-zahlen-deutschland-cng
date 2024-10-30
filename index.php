<?php
/*
Plugin Name: Corona Zahlen Deutschland (CNG)
Description: Tagesaktuelle Coronazahlen in Deutschland auf Ihrer Website
Version: 1.0
Author: Marcus C. J. Hartmann
Author URI: http://www.marcuscjhartmann
*/
require("inc/cng-interface.php");
require("inc/cng-abstract.php");
require("inc/cng-overlay.php");
require("inc/cng-widget.php");
require("inc/cng-shortcode.php");
require("inc/cng-autoinsert.php");
require("inc/cng-page.php");

add_action("wp_enqueue_scripts","coronanumbers_enqueue_scripts");
function coronanumbers_enqueue_scripts(){
	wp_register_script ( 'cng_script', plugins_url ( 'src/js/script.js', __FILE__ ),array(),false,true);
	wp_register_style('cng_overlay_styles',plugins_url('src/css/cng_overlay.css',__FILE__),array());
	wp_register_style('cng_shortcode_styles',plugins_url('src/css/cng_shortcode.css',__FILE__),array());
	wp_register_style('cng_widget_styles',plugins_url('src/css/cng_widget.css',__FILE__),array());
}