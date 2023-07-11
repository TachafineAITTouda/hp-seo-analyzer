<?php

namespace HP_SEO_ANALYZER\Sitemap;

use DateTime;
use HP_SEO_ANALYZER\Sitemap\Link;
use HP_SEO_ANALYZER\Sitemap\Sitemap;
use HP_SEO_ANALYZER\Helpers\Crawler;
use HP_SEO_ANALYZER\Crons\CrowlingHourlyCron;

use function WPML\FP\Strings\remove;

class SitemapHandler
{


	function __construct()
	{
	}

	public function generateSitemap()
	{
		$home_url = get_home_url();
		$home_url = 'https://www.melty.fr';
		// celar the error log option
		delete_option('hp_seo_analyzer_crawler_error_log');
		// replace all home_b_url with home_url in html
		$sitemap = Crawler::getSitemap($home_url);
		$sitemap_array = $sitemap->toArray();
		// save internal links in database transient for 7 dayss
		set_transient(
			'hp_seo_analyzer_internal_links',
			$sitemap_array,
			7 * DAY_IN_SECONDS,
			false
		);
		update_option('hp_seo_analyzer_internal_links', $sitemap_array);
	}


}
