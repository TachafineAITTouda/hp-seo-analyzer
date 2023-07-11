<?php

namespace HP_SEO_ANALYZER\Admin;
use HP_SEO_ANALYZER\Admin\Options\HpSeoAnalyzerSettingPage;

class AdminInit
{
	public static function instance()
	{
		if (is_admin() && !defined('DOING_AJAX'))
		{
			new AdminInit();
		}
	}

	private function __construct()
	{
		new HpSeoAnalyzerSettingPage();
	}

}


