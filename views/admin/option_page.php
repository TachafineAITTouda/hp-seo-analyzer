<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// get home url
$home_url = home_url();


$current_uri = $_SERVER['REQUEST_URI'];
$hp_seo_analyzer_transient = get_transient( 'hp_seo_analyzer_internal_links' );
$links_error_log = get_option( 'hp_seo_analyzer_crawler_error_log', [] );
?>

<div class="wrap">
	<p>
		<?php
			_e(
				'This plugin is used to analyze your homepage internal SEO,
				 if you launch a crawl Task for your homepage,
				 you will get a report about your homepage internal SEO.'
				, HP_SEO_ANALYZER_TEXT_DOMAIN
			);
		?>
	</p>
	<input type="submit"
	name="hp_seo_analyzer_run_task"
	class="button button-primary"
	value="<?php
		_e( 'Run a new Task for homepage SEO analysis', HP_SEO_ANALYZER_TEXT_DOMAIN );
	?>">
	<hr style="margin-top: 20px; margin-bottom: 20px;">
	<?php if (!empty($links_error_log)) : ?>
		<h2>
			<?php
				_e(
					'Homepage SEO analysis error log'
					, HP_SEO_ANALYZER_TEXT_DOMAIN
				);
			?>
		</h2>
		<table class="wp-list-table widefat fixed striped" style="font-weight: bold;color:red;">
			<thead>
				<tr>
					<th>
						<?php
							_e(
								'URL'
								, HP_SEO_ANALYZER_TEXT_DOMAIN
							);
						?>
					</th>
					<th>
						<?php
							_e(
								'Error message'
								, HP_SEO_ANALYZER_TEXT_DOMAIN
							);
						?>
					</th>
					<th>
						<?php
							_e(
								'Error code'
								, HP_SEO_ANALYZER_TEXT_DOMAIN
							);
						?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($links_error_log as $url=> $error_log) : ?>
					<tr>
						<td>
							<?php echo $url; ?>
						</td>
						<td>
							<?php echo $error_log['message']; ?>
						</td>
						<td>
							<?php echo $error_log['code']; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<hr style="margin-top: 20px; margin-bottom: 20px;">
	<?php endif; ?>
	<?php if ( !empty( $hp_seo_analyzer_transient ) ) :

		$last_crawl_time = $hp_seo_analyzer_transient['time'];
		$internal_links = $hp_seo_analyzer_transient['links'];
		$username = $hp_seo_analyzer_transient['username'];

		?>
		<div class="wrap">
			<h2>
				<?php
					_e(
						'Homepage SEO analysis report'
						, HP_SEO_ANALYZER_TEXT_DOMAIN
					);
				?>
			</h2>
			<p>
				<?php
					_e(
						'Your homepage SEO analysis is done, you can see the report directly on sitemap.html page.'
						, HP_SEO_ANALYZER_TEXT_DOMAIN
					);
				?>
				<a href="<?php
					echo esc_url( "https://www.melty.fr" . '/sitemap.html' );
				?>" >
					<?php
						echo esc_url( "https://www.melty.fr" . '/sitemap.html' );
					?>
				</a>
				<br>
				<p>
					<?php
						_e(
							'Last crawl time: '
							, HP_SEO_ANALYZER_TEXT_DOMAIN
						);
						echo esc_html( $last_crawl_time );
						_e(
							' by '
							, HP_SEO_ANALYZER_TEXT_DOMAIN
						);
						echo esc_html( $username );

					?>

			</p>


			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr >
						<th scope="col" id="title" class="manage-column column-title column-primary sortable desc" style="padding: 20px; font-weight: bold; width:5%;">
							<span>
								<?php
									_e(
										'No.'
										, HP_SEO_ANALYZER_TEXT_DOMAIN
									);
								?>
							</span>
						</th>
						<th scope="col" id="title" class="manage-column column-title column-primary sortable desc" style="padding: 20px; font-weight: bold;">
							<span>
								<?php
									_e(
										'Internal Links'
										, HP_SEO_ANALYZER_TEXT_DOMAIN
									);
								?>
							</span>
						</th>
						<th scope="col" id="title" class="manage-column column-title column-primary sortable desc" style="padding: 20px; font-weight: bold;">
							<span>
								<?php
									_e(
										'Title'
										, HP_SEO_ANALYZER_TEXT_DOMAIN
									);
								?>
							</span>
						</th>
					</tr>
				</thead>
				<tbody id="the-list">
					<?php
						foreach ( $internal_links as $i => $link ) {
							$title = $link['title'];
							$link = $link['url'];
							?>
							<tr>
								<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
									<strong>
										<?php
											echo $i + 1;
										?>
									</strong>
								</td>
								<td class="title column-title has-row-actions  page-title" data-colname="Title">
									<strong>
										<a href="<?php
											echo esc_url( $link );
										?>" target="_blank">
											<?php
												echo esc_url( $link );
											?>
										</a>
									</strong>
								</td>
								<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
									<strong>
										<?php
											echo $title;
										?>
									</strong>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
	<input type="hidden"
		name="hp_seo_analyzer_post"
		value="1">

</div>
