<?php
/**
 * Plugin Name: WCA2 Search Suggestions demo.
 * Plugin URI:  http://rzen.net
 * Description: Some sample code for producing suggested search results wherein we convert traditional AJAX requests to REST API requests.
 * Author:      Brian Richards
 * Author URI:  http://rzen.net
 * Text Domain: wca2
 * Domain Path: /languages
 * Version:     0.1.0
 */

/**
 * Enqueue our scripts and styles.
 *
 * @since 0.1.0
 */
function wca2_ajax_enqueue() {
	wp_enqueue_script( 'wca2-ajax', plugin_dir_url( __FILE__ ) . 'assets/js/wca2-ajax.js', 'jquery', '1.0.0', true );
	wp_enqueue_style( 'wca2-ajax', plugin_dir_url(__FILE__ ) . 'assets/css/wca2-frontend.css', null, '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'wca2_ajax_enqueue' );
