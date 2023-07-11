<?php

namespace HP_SEO_ANALYZER\Admin\Options;

use HP_SEO_ANALYZER\Admin\Options\SettingsMenuPageBase;
use HP_SEO_ANALYZER\Admin\Options\IOptionPageSaveInterface;
use HP_SEO_ANALYZER\Helpers\Crawler;
use HP_SEO_ANALYZER\Sitemap\SitemapHandler;
use HP_SEO_ANALYZER\Crons\CrowlingHourlyCron;

class HpSeoAnalyzerOptionPageSave implements IOptionPageSaveInterface
{
	public function save()
	{
		// set limit time for execution
		set_time_limit(0);
		$site_map_handler = new SitemapHandler();
		$site_map_handler->generateSitemap();
		// run wp task in background to generate sitemap every hour
		new CrowlingHourlyCron();
	}
}


class HpSeoAnalyzerSettingPage extends SettingsMenuPageBase
{
	public function __construct()
	{
		parent::__construct(
			'HP SEO Analyzer Settings',
			'HP SEO Analyzer',
			'manage_options',
			'hp-seo-analyzer-settings',
			'admin/option_page.php',
			['manage_options'],
			new HpSeoAnalyzerOptionPageSave()
		);
	}
}
