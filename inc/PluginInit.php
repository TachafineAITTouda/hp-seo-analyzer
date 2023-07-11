<?php

namespace HP_SEO_ANALYZER;
use HP_SEO_ANALYZER\Admin\AdminInit;



class PluginInit
{
	public static function instance()
	{
		new PluginInit();
	}

	private function __construct()
	{
		AdminInit::instance();
	}
}


