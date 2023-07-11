<?php
/**
 * Plugin Name: WP Media Homepage SEO Analyzer
 * Description: Analyze your homepage internal SEO
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.3
 * Author: Tachafine AIT TOUDA
 * Author URI: https://github.com/TachafineAITTouda/
 * Text Domain: hp-seo-analyzer
 * Domain Path: languages
 */

defined( 'ABSPATH' ) || exit;

// Define plugin constants

if ( ! defined( 'HP_SEO_ANALYZER_VERSION' ) ) {
	define( 'HP_SEO_ANALYZER_VERSION', '1.0.0' );
}

if ( ! defined( 'HP_SEO_ANALYZER_FILE' ) ) {
	define( 'HP_SEO_ANALYZER_FILE', __FILE__ );
}

if ( ! defined( 'HP_SEO_ANALYZER_PATH' ) ) {
	define( 'HP_SEO_ANALYZER_PATH', plugin_dir_path( HP_SEO_ANALYZER_FILE ) );
}

if ( ! defined( 'HP_SEO_ANALYZER_INCLUDES' ) ) {
	define( 'HP_SEO_ANALYZER_INCLUDES', HP_SEO_ANALYZER_PATH . 'inc' );
}

if ( ! defined( 'HP_SEO_ANALYZER_VIEWS' ) ) {
	define( 'HP_SEO_ANALYZER_VIEWS', HP_SEO_ANALYZER_PATH . 'views' );
}
// text domain
if ( ! defined( 'HP_SEO_ANALYZER_TEXT_DOMAIN' ) ) {
	define( 'HP_SEO_ANALYZER_TEXT_DOMAIN', 'hp-seo-analyzer' );
}


if($_SERVER['REQUEST_URI'] == '/sitemap.html')
{
	// get the internal links from the database
	// this is where we will render the sitemap.html file
	$internal_links = array();
	// get the internal links from the database transient

	$sitemap_html = get_transient('hp_seo_analyzer_internal_links');
	if (!$sitemap_html) {
		// get the last saved internal links from the database
		$sitemap_html = get_option('hp_seo_analyzer_internal_links');
	}
	if(!empty($sitemap_html)){
		$internal_links = $sitemap_html['links'];
		include HP_SEO_ANALYZER_VIEWS . '/front/sitemap.html.php';
		exit;
	}
}

if ( file_exists( HP_SEO_ANALYZER_PATH . 'vendor/autoload.php' ) ) {
	require_once HP_SEO_ANALYZER_PATH . 'vendor/autoload.php';
}

if ( class_exists( 'HP_SEO_ANALYZER\\PluginInit' ) ) {
	HP_SEO_ANALYZER\PluginInit::instance();
}
