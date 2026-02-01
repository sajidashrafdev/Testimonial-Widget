<?php
/**
 * Plugin Name: Testimonial Slider for Elementor
 * Description: Custom testimonial/quote slider widget with style controls and top-left navigation.
 * Version: 1.0.1
 * Author: Sajid Ashraf
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GEISS_TS_PATH', plugin_dir_path( __FILE__ ) );
define( 'GEISS_TS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register frontend assets
 */
function geiss_ts_register_assets() {
    wp_register_style(
        'geiss-testimonial',
        GEISS_TS_URL . 'assets/css/geiss-testimonial.css',
        [],
        '1.0.1'
    );

    wp_register_script(
        'geiss-testimonial',
        GEISS_TS_URL . 'assets/js/geiss-testimonial.js',
        [ 'jquery' ],
        '1.0.1',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'geiss_ts_register_assets' );

/**
 * Register widget
 */
function geiss_ts_register_widget( $widgets_manager ) {
    require_once GEISS_TS_PATH . 'widgets/class-geiss-testimonial-slider.php';
    $widgets_manager->register( new \Geiss_Testimonial_Slider_Widget() );
}
add_action( 'elementor/widgets/register', 'geiss_ts_register_widget' );
