<?php
/*
Plugin Name: ClassicPress Support Network
Plugin URI: https://github.com/EliteStarServices/ClassicPress-Support-Web
Description: ClassicPress Support Network Client Plugin
Version: 0.9.7
Requires at least: 4.9
Requires CP: 1.7
Requires PHP: 7.4
Author: Elite Star Services
Author URI: https://elite-star-services.com
*/


// GET CP WEB FEED DATA
function get_cp_web() {

	$posts = get_transient('cp_web_feed');

	if (false === $posts) {

		$response = wp_remote_get('https://cp-web.elite-star-services.com/wp-json/wp/v2/cp-web?per_page=100');
		if (is_wp_error($response) || !isset($response['body'])) {
			return 'An error has occurred, which probably means the feed is down. Please try again later';
		}

		$posts_array = json_decode(wp_remote_retrieve_body($response), true);

		if (!is_array($posts_array)) {
			return 'An error has occurred, which probably means the feed is down. Please try again later';
		}

		$posts = array();

		foreach ($posts_array as $post) {
			$posts[] = array(
				'link'    => $post['link'],
				'title'   => $post['title']['rendered'],
				'date'    => strtotime($post['date'], time()),
				'cplink'  => $post['guid']['rendered'],
				'mylink'  => $post['acf']['mylink'],
				'myname'  => $post['acf']['myname'],
				'mytext'  => $post['acf']['mytext'],
				'mylogo'  => $post['acf']['mylogo'],
			);
		}

		set_transient('cp_web_feed', $posts, DAY_IN_SECONDS);
		//set_transient('cp_web_feed', $posts, 10);
	}

	return $posts;
}


// LOAD REQUIRED ASSETS
function cp_assets() {
	$plugin_url = plugin_dir_url(__FILE__);

	wp_enqueue_style('style',  $plugin_url . "assets/css/style.css");

	//wp_enqueue_style('bootstrap-style-cpw', 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@3.4.1/dist/css/bootstrap.min.css', array(), '3.4.1');
	wp_enqueue_style('bootstrap-theme-cpw', 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css', array(), '3.4.1');

	wp_enqueue_script('ellipsis',  $plugin_url . "assets/js/smartEllipsis.js", array('jquery'), true);

	// js loaded for old browsers - may not actually be needed
	wp_register_script('respond-script', 'https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js', array(), '1.4.2', true);
	wp_enqueue_script('respond-script');
	wp_register_script('html5-shiv-script', 'https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js', array(), '3.7.3', true);
	wp_enqueue_script('html5-shiv-script');
}
add_action('wp_enqueue_scripts', 'cp_assets');


// CREATE SHORTCODES
require('includes/shortcodes.php');


/* DISABLED UNTIL ADDED TO CLASSICPRESS DIRECTORY
// Plugin Update Checker if not using ClassicPress Directory Integration plugin
if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if (
	   version_compare(function_exists('classicpress_version') ? classicpress_version() : '0', '2', '>=') &&
	   is_plugin_active('classicpress-directory-integration/classicpress-directory-integration.php')
   ) {
   return;
}
*/


// ESS UPDATE SERVER (Checks for Updates)
require 'vendor/bh-update/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$MyUpdateChecker = PucFactory::buildUpdateChecker(
	'https://cs.elite-star-services.com/wp-repo/?action=get_metadata&slug=cp-web', //Metadata URL.
	__FILE__, //Full path to the main plugin file.
	'cp-web' //Plugin slug. Usually it's the same as the name of the directory.
);
