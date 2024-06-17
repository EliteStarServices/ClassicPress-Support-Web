<?php


// HORIZONTAL TWO COLUMN DISPLAY SHORTCODE (Default)
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
							<div class="col-md-8 col-sm-8 col-xs-12" style="margin:0px;">
								<h3>
								<?php esc_html_e('Welcome to the ', 'cp-web'); ?>
								<?php echo '<a href="' . esc_url($cphome) . '"><strong>'; ?>
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
				$mylink = $post['mylink'];
				$myname = $post['myname'];

				if (empty($title)) {
					$title = __('Nothing Found', 'cp-web');
				}

				if ($post['mylogo'] != "") {
					$mylogo = $post['mylogo'];
				} else {
					$mylogo = "https://cp-web.elite-star-services.com/wp-content/uploads/logodemo.png";
				}

				$excerpt = esc_attr(wp_trim_words($post['mytext'], 100, '...'));

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
							<a href="<?php echo esc_html($mylink); ?>" target="_blank" style="text-decoration:none;">
								<h3 class="panel-title" style="color:#057f99;"><strong><?php echo esc_html($myname); ?></strong>
								</a>
								<div style="float:right;">
									<a href="https://cp-web.elite-star-services.com/report-content-form/?company=<?php echo esc_html($myname); ?>" title="Report This Company">
									<i class="fa fa-flag" style="color:tomato;"></i></a>
								</div>
								</h3>
						</div>

						<div class="" style="margin-top:8px; width:50%; float:left;">
							<a href="<?php echo esc_html($mylink); ?>">
							<img src="<?php echo esc_html($mylogo); ?>" style="max-width:95%; max-height:110px; height:auto; width:auto; margin:0 auto; display:block;"></a>
						</div>

						<div class="panel-body text-primary" style="margin-top: -10px; width:50%; float:right;">
							• <a href="<?php echo esc_html($link); ?>"><strong><?php echo esc_html($title); ?></strong></a><br>
							<?php echo esc_html($excerpt); ?>
						</div>

					</div>
				</div>
<?php
			$cnt++;
		}
	} else {
		echo wp_kses(
			sprintf('<li>%s</li>', esc_html($posts)),
			array('li' => array())
		);
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
	$content = str_replace('|br|', '<br>', $content);

	return $content; // Return the content.
}
add_shortcode('cp-web', 'display_cp_web');



// VERTICAL TWO COLUMN DISPLAY SHORTCODE
function display_cp_web_vtwo() {
	ob_start();
	$posts = get_cp_web();

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
							<div class="col-md-8 col-sm-8 col-xs-12" style="margin:0px;">
								<h3>
								<?php esc_html_e('Welcome to the ', 'cp-web'); ?>
								<?php echo '<a href="' . esc_url($cphome) . '"><strong>'; ?>
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
				$mylink = $post['mylink'];
				$myname = $post['myname'];

				if (empty($title)) {
					$title = __('Nothing Found', 'cp-web');
				}

				if ($post['mylogo'] != "") {
					$mylogo = $post['mylogo'];
				} else {
					$mylogo = "https://cp-web.elite-star-services.com/wp-content/uploads/logodemo.png";
				}

				$excerpt = esc_attr(wp_trim_words($post['mytext'], 100, '...'));

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
					<div class="panel panel-info ellipsis" style="height:285px; overflow:hidden; word-wrap:normal;">

						<div class="panel-heading">
							<a href="<?php echo esc_html($mylink); ?>" target="_blank" style="text-decoration:none;">
								<h3 class="panel-title" style="color:#057f99;"><strong><?php echo esc_html($myname); ?></strong>
								</a>
								<div style="float:right;">
									<a href="https://cp-web.elite-star-services.com/report-content-form/?company=<?php echo esc_html($myname); ?>" title="Report This Company">
									<i class="fa fa-flag" style="color:tomato;"></i></a>
								</div>
								</h3>
						</div>

						<div class="" style="margin-top:8px; _width:50%; _float:left;">
							<a href="<?php echo esc_html($mylink); ?>">
							<img src="<?php echo esc_html($mylogo); ?>" style="max-width:95%; max-height:110px; height:auto; width:auto; margin:0 auto; display:block;"></a>
						</div>

						<div class="panel-body text-primary" style="margin-top: -10px; _width:50%; _float:right;">
							• <a href="<?php echo esc_html($link); ?>"><strong><?php echo esc_html($title); ?></strong></a><br>
							<?php echo esc_html($excerpt); ?>
						</div>

					</div>
				</div>
<?php
			$cnt++;
		}
	} else {
		echo wp_kses(
			sprintf('<li>%s</li>', esc_html($posts)),
			array('li' => array())
		);
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
	$content = str_replace('|br|', '<br>', $content);

	return $content; // Return the content.
}
add_shortcode('cp-web-vtwo', 'display_cp_web_vtwo');
