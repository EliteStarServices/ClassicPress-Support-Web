<?php
/*
Plugin Name: ClassicPress Support Network
Plugin URI: https://elite-star-services.com/plugins/
Description: ClassicPress Support Network Client Plugin
Version: 0.9.6
Requires at least: 4.9
Requires CP: 1.7
Requires PHP: 7.4
Author: Elite Star Services
Author URI: https://elite-star-services.com
*/


function display_cp_web() {
	ob_start();
	$posts = get_cp_web();
	//print_r($posts);
	//print_r($invites);

	if (is_array($posts)) {
		$cnt = 0;
		foreach (array_reverse($posts) as $post) {

			if ($cnt == 0) {

				$gethome = explode("?", $post['cplink']);
				$cphome = substr($gethome[0], 0, -1);
?>
				<div class="bsbody bshtml">

					<div class="alert alert-success" style="background:#C1DFE6;">
						<div class="row" style="margin-top:-15px;">
							<div class="col-md-8 col-sm-8 col-xs-12" style="margin:0px;"><h3>
								<?php esc_html_e('Welcome to the ', 'cp-web'); ?>
								<?php echo '<a href="' . esc_url( $cphome ) . '"><strong>'; ?>
								<?php esc_html_e('ClassicPress Support Network!', 'cp-web'); ?>
								</a></h3>
								<?php esc_html_e('A place for developers to showcase their services and users to find professionals.', 'cp-web'); ?>
								</strong>
							</div>

							<div class="col-md-4 col-sm-4 col-xs-12" style="margin-top:12px;">
								<p><?php esc_html_e('Are You a ClassicPress Service Provider?', 'cp-web'); ?></p>
								<a href="https://cp-web.elite-star-services.com/cp-web-app/" class="btn btn-primary" style="color:#d3f4a9;">
								<?php esc_html_e('List Your Services!', 'cp-web'); ?></a>
							</div>
						</div>
					</div>
					<div style="clear: both;"></div>
					<div style="margin: 0px -15px 0; padding: 0px 0px 0;">

					<?php

				}


				// ASSEMBLE VARIABLES
				$link = $post['link'];
				while (stristr($link, 'http') !== $link) {
					$link = substr($link, 1);
				}

				$link  = esc_url(strip_tags($link));
				$title = esc_html(trim(strip_tags($post['title'])));

				if (empty($title)) {
					$title = __('Nothing Found', 'cp-web');
				}

				if ($post['mylogo'] != "") {
					$memberlogo = '<a href="' . $post['mylink'] . '"><img src="' . $post['mylogo'] . '" style="max-width:95%; max-height:110px; height:auto; width:auto; margin:0 auto; display:block;"></a>';
				} else {
					$memberlogo = '<a href="' . $post['mylink'] . '">
					<img src="https://cp-web.elite-star-services.com/wp-content/uploads/logodemo.png" style="_max-width:95%; max-height:110px; height:autopx; width:auto; margin:0 auto; display:block;"></a>';
				}

				$excerpt = esc_attr(wp_trim_words($post['mytext'], 100, '...'));
				$excerpt = str_replace('|br|', '<br>', $excerpt);

				if (strlen($excerpt) > 165) {
					$new_excerpt = substr($excerpt, 0, strpos($excerpt, ' ', 165));
					$excerpt = $new_excerpt . '...';
				}


				//$summary = '<p class="rssSummary">• ' . $excerpt . '</p>';
				$date = $post['date'];
				if ($date) {
					$date = '<span class="rss-date"><small>' . date_i18n(get_option('date_format'), $date) . '</small></span><br>';
				}


					?>

					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="panel panel-info ellipsis" style="height:183px; overflow:hidden; word-wrap:normal;">

							<div class="panel-heading">
								<a href="<?php esc_html_e( $post['mylink'] ); ?>" target="_blank" style="text-decoration:none;">
								<h3 class="panel-title" style="color:#057f99;"><strong><?php esc_html_e( $post['myname'] ); ?></strong>
								</a>
								<div style="float:right;">
									<a href="https://cp-web.elite-star-services.com/report-content-form/?company=<?php esc_html_e( $post['myname'] ); ?>" title="Report This Company">
										<i class="fa fa-flag" style="color:tomato;"></i></a>
								</div>
								</h3>
							</div>

							<div class="" style="margin-top:8px; width:50%; float:left;">
								<?php echo $memberlogo; ?>
							</div>

							<div class="panel-body text-primary" style="margin-top: -10px; width:50%; float:right;">
								<?php echo '• <a href="' . $link . '"><strong>' . $title . '</strong></a><br>'; ?>
								<?php echo $excerpt; ?>
							</div>

						</div>
					</div>

			<?php


			//printf(__('<li><strong><a href="%1$s">%2$s</a></strong><br>%3$s%4$s%5$s</li>', 'cp-web'), $link, $title, $date, $memberlink, $summary);


			$cnt++;
		}
	} else {
		printf(__('<li>%s</li>', 'cp-web'), $posts);
	}

			?>

				</div>
					<div class="col-md-12" style="display: flex; justify-content: space-between;align-items: center;margin: 5px -12px 0;padding: 10px 10px 0; border-top: 1px solid #eee; margin-left:0px;">
						<?php esc_html_e('ClassicPress Support Provider?', 'cp-web'); ?>
						<?php echo '<a href="https://cp-web.elite-star-services.com/cp-web-app/"><strong>'; ?>
						<?php esc_html_e('Include Your Services on the list of Approved Providers', 'cp-web'); ?>
						</strong></a>
					</div>
				</div>

			<?php


			$content = ob_get_clean(); // store buffered output content.

			return $content; // Return the content.
		}
		add_shortcode('cp-web', 'display_cp_web');


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


		function cpm_assets() {
			$plugin_url = plugin_dir_url(__FILE__);

			wp_enqueue_style('style',  $plugin_url . "assets/css/style.css");

			//wp_enqueue_style('bootstrap-style-cpw', 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@3.4.1/dist/css/bootstrap.min.css', array(), '3.4.1');
			wp_enqueue_style('bootstrap-theme-cpw', 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css', array(), '3.4.1');

			wp_enqueue_script('ellipsis',  $plugin_url . "assets/js/smartEllipsis.js", array( 'jquery' ), true );

			// js loaded for old browsers - may not actually be needed
			wp_register_script('respond-script', 'https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js', array(), '1.4.2', true);
			wp_enqueue_script('respond-script');
			wp_register_script('html5-shiv-script', 'https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js', array(), '3.7.3', true);
			wp_enqueue_script('html5-shiv-script');
		}
		add_action('wp_enqueue_scripts', 'cpm_assets');


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

		require 'vendor/bh-update/plugin-update-checker.php';

		use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

		$MyUpdateChecker = PucFactory::buildUpdateChecker(
			'https://cs.elite-star-services.com/wp-repo/?action=get_metadata&slug=cp-web', //Metadata URL.
			__FILE__, //Full path to the main plugin file.
			'cp-web' //Plugin slug. Usually it's the same as the name of the directory.
		);