<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Multisites Sites List
 * GitHub Plugin URI: https://github.com/bahia0019/multisite-sites-list
 * Description:       Replaces My Sites list with a scrollable/searchable list of Sites.
 * Version:           1.0.0
 * Author:            William Bay | Flaunt Your Site
 * Author URI:        http://flauntyoursite.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       multisite-sites-list
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$user = get_current_user_id();

function msl_scripts() {
	wp_enqueue_style( 'msl-styles', plugin_dir_url( __FILE__ ) . 'multisite-sites-list.css', null, date( 'Ymd' ) );
	wp_enqueue_script( 'msl-js', plugin_dir_url( __FILE__ ) . 'multisite-sites-list.js', array(), date( 'Ymd' ), true );

	wp_localize_script( 'msl-js', 'msl_localize_scripts', array(
		'networkUrl' => network_home_url( '', 'https' ),
	));

}
add_action( 'admin_enqueue_scripts', 'msl_scripts' );


function my_api_custom_route_sites( $user ) {

	$sites = get_blogs_of_user( $user );
	return $sites;
}

add_action('rest_api_init', function() {
	register_rest_route('msl/v1', '/sites', [
		'methods'  => 'GET',
		'callback' => 'my_api_custom_route_sites',
	]);
});
