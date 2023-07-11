<?php

namespace HP_SEO_ANALYZER\Crons;

use HP_SEO_ANALYZER\Sitemap\SitemapHandler;

class CrowlingHourlyCron
{
	public function __construct()
	{
		// check if the cron is already scheduled or not
		if (!wp_next_scheduled('hp_seo_analyzer_hourly_cron')) {
			// schedule the cron
			wp_schedule_event(time() , 'hourly', 'hp_seo_analyzer_hourly_cron');
		}
		// add the action for the cron
		add_action('hp_seo_analyzer_hourly_cron', [$this, 'generateSitemap']);
	}

	private function generateSitemap()
	{
		$site_map_handler = new SitemapHandler();
		$site_map_handler->generateSitemap();
	}
}
