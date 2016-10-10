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
	wp_localize_script( 'wca2-ajax', 'wca2', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wca2_ajax_enqueue' );

/**
 * AJAX Handler for realtime search suggestions.
 *
 * @since 0.1.0
 */
function wca2_ajax_search_response() {

	$search = isset( $_REQUEST['s'] ) ? sanitize_text_field( $_REQUEST['s'] ) : '';
	$results = wca2_get_suggested_results( $search );

	wp_send_json_success( array(
		'searchString' => $search,
		'results'      => $results,
	) );
}
add_action( 'wp_ajax_wca2-search', 'wca2_ajax_search_response' );
add_action( 'wp_ajax_nopriv_wca2-search', 'wca2_ajax_search_response' );

/**
 * Get the suggested search results.
 *
 * @since  0.1.0
 *
 * @param  string $search Search string.
 * @return array          WP Posts.
 */
function wca2_get_suggested_results( $search = '' ) {
	$results = get_posts( array(
		's' => $search,
		'posts_per_page' => 5,
	) );

	foreach ( $results as $result ) {
		$result->title = $result->post_title;
		$result->link = get_permalink( $result->ID );
	}

	return $results;
}
