<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Multisites Sites List
 * GitHub Plugin URI: https://github.com/bahia0019/multisite-sites-list
 * Description:       Replaces My Sites list with a scrollable/searchable list of Sites.
 * Version:           1.1.0
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
}
add_action( 'admin_enqueue_scripts', 'msl_scripts' );


function msl_remove_nodes( $wp_admin_bar ) {
	$sites = get_sites();
	foreach ( $sites as $site ) {
		$wp_admin_bar->remove_node( 'blog-' . $site->blog_id . '-n' );
		$wp_admin_bar->remove_node( 'blog-' . $site->blog_id . '-c' );
	}
}
add_action( 'admin_bar_menu', 'msl_remove_nodes', 999 );
