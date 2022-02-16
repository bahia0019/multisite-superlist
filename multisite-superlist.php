<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Multisites SuperList
 * GitHub Plugin URI: https://github.com/bahia0019/multisite-superlist
 * Description:       Replaces My Sites list with a scrollable/searchable list of Sites.
 * Version:           2.1.0
 * Author:            William Bay | Flaunt Your Site
 * Author URI:        http://flauntyoursite.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       multisite-superlist
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$version = '2.1.0';

/**
 * Checks user to determine if plugin should run.
 */
function check_user() {

	if ( ! is_user_logged_in() || ! is_multisite() ) {
		return;
	}

	// If user doesn't have more than 1 site, or can't manage network, don't display the Multisite List.
	if ( ! current_user_can( 'manage_network' ) ) {
		return;
	} else {

		/**
		 * Enqueues React static file for the App.
		 */
		function msl_scripts() {

			// Build files.
			$react_app_js  = plugin_dir_url( __FILE__ ) . 'msl/build/static/js/all_in_one_file.js';
			$react_app_css = plugin_dir_url( __FILE__ ) . 'msl/build/static/css/all_in_one_file.css';

			wp_enqueue_style( 'msl-styles', $react_app_css, array(), $version );
			wp_enqueue_script( 'msl-js', $react_app_js, array(), $version, true );

			wp_localize_script(
				'msl-js',
				'msl_site_info',
				array(
					'site_url' => site_url(),
				)
			);
		}
		add_action( 'admin_enqueue_scripts', 'msl_scripts' );

		// /**
		// * Removes items from the site list items.
		// */
		// function msl_remove_nodes( $wp_admin_bar ) {

		// $sites = get_sites();
		// foreach ( $sites as $site ) {
		// $wp_admin_bar->remove_node( 'blog-' . $site->blog_id . '-n' );
		// $wp_admin_bar->remove_node( 'blog-' . $site->blog_id . '-c' );
		// }

		// }
		// add_action( 'admin_bar_menu', 'msl_remove_nodes', 999 );

		/**
		 * Remove the default WP Admin Bar My Sites menu.
		 *
		 * @return void
		 */
		function action_add_admin_bar_menus() {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_my_sites_menu', 20 );
		}

		/**
		 * Define the REST routes.
		 */
		function my_api_custom_route_sites() {

			$args = array(
				'number' => 100,
			// TODO Pagination
			);

			$sites              = get_sites( $args );
			$data               = array();
			$i                  = 0;
			$main_favicon       = get_site_icon_url();
			$site_mapped_domain = get_option( 'wu_custom-domain' );
			// TODO Determine WP Ultimo Mapped Domain.

			foreach ( $sites as $site ) {

					$data[ $i ]['site_id'] = $site->blog_id;
					$data[ $i ]['name']    = $site->blogname;
					$data[ $i ]['url']     = $site->siteurl;
					$data[ $i ]['domain']  = $site->domain;
					// TODO $data[ $i ]['mapped_domain'] = $site->$site_mapped_domain;
					$data[ $i ]['favicon'] = get_site_icon_url( 270, $main_favicon, $site->blog_id );
					$i++;
			}
			return $data;
		}

		/**
		 * Register the site routes.
		 */
		function register_sites() {
			register_rest_route(
				'msl/v1',
				'sites/',
				// TODO 'sites/(?P<page>[1-9]{1,2})',
				array(
					'methods'  => 'GET',
					'callback' => 'my_api_custom_route_sites',
				)
			);
		}
		add_action( 'rest_api_init', 'register_sites' );

	}
}
add_action( 'init', 'check_user' );
