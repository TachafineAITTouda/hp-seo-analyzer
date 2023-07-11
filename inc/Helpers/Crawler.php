<?php

namespace HP_SEO_ANALYZER\Helpers;
use DOMDocument;
use Exception;
use HP_SEO_ANALYZER\Sitemap\Link;
use HP_SEO_ANALYZER\Sitemap\Sitemap;

class Crawler
{
	/**
	 * Fetch html from url using wp_remote_get() function and return html
	 * @param $url
	 * @return string
	 * @throws Exception
	 */
	public static function getHtml($url)
	{
		// use wp_remote_get() to get html
		$response = wp_remote_get($url);
		if (is_wp_error($response))
		{
			// add error to log in option
			$error = [
				'code' => $response->get_error_code(),
				'message' => $response->get_error_message(),
			];
			$option = get_option('hp_seo_analyzer_crawler_error_log', []);
			$option[$url] = $error;
			update_option('hp_seo_analyzer_crawler_error_log',$option,false);
			throw new Exception($response->get_error_message());
		}
		return $response['body'];
	}

	/**
	 * Extract all links from html and return array of links
	 * @param $html
	 * @return array
	 */
	public static function getLinks($html)
	{
		$links = [];
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$tags = $dom->getElementsByTagName('a');
		foreach ($tags as $tag)
		{
			$link = $tag->getAttribute('href');
			// validate link to be a valid url
			if (filter_var($link, FILTER_VALIDATE_URL))
			{
				$links[] = $link;
			}
		}
		return $links;
	}

	/**
	 * Extract all images from html and return array of images
	 * @param $html
	 * @return array
	 */
	public static function getImages($html)
	{
		$images = [];
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$tags = $dom->getElementsByTagName('img');
		foreach ($tags as $tag)
		{
			$images[] = $tag->getAttribute('src');
		}
		return $images;
	}

	/**
	 * extract all non image links from html and return array of links
	 * @param $html
	 * @return array
	*/

	public static function getNonImageLinks($html)
	{
		$links = [];
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$tags = $dom->getElementsByTagName('a');
		foreach ($tags as $tag)
		{
			$links[] = $tag->getAttribute('href');
		}
		return $links;
	}

	/**
	 * extract links that belongs to same domain and return array of links
	 * @param $links
	 * @return array
	 */
	public static function getInternalLinks($html)
	{
		$links = self::getLinks($html);
		$internalLinks = [];
		$homeUrl = get_home_url();

		$homeUrl = 'https://www.melty.fr';
		// get only the domain name
		$homedomain = parse_url($homeUrl, PHP_URL_HOST);
		foreach ($links as $link)
		{
			if (strpos($link, $homedomain) !== false)
			{
				$internalLinks[] = $link;
			}
			// if link starts with / then it is internal link
			if (strpos($link, '/') === 0 && strpos($link, '//') !== 0)
			{
				$link = $homeUrl . $link;
				$internalLinks[] = $link;
			}
		}
		return $internalLinks;
	}

	/**
	 * Get Title of url and return title
	 * @param $url
	 * @return string
	 */
	public static function getTitle($html)
	{
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$title = $dom->getElementsByTagName('title');
		$title = $title->item(0)->nodeValue;
		return $title;
	}

	/**
	 * Get Description of url and return description
	 * @param $url
	 * @return string
	 */
	public static function getDescription($html)
	{
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$description = $dom->getElementsByTagName('meta');
		foreach ($description as $tag)
		{
			if ($tag->getAttribute('name') == 'description')
			{
				$description = $tag->getAttribute('content');
				return $description;
			}
		}
		return '';
	}

	/**
	 * Get all links from html and return array of Link objects
	 * @param $html
	 * @return array[Link]
	 */
	public static function getLinkObjects($url)
	{
		$html = self::getHtml($url);
		$links = self::getLinks($html);
		$internalLinks = self::getInternalLinks($links);
		$linkObjects = [];
		foreach ($internalLinks as $link)
		{
			$title = self::getTitle($link);
			$description = self::getDescription($link);
			$linkObjects[] = new Link($link, $title, $description);
		}
		return $linkObjects;
	}

	/**
	 * Get Sitemap object from url and return Sitemap object
	 * @param $url
	 * @return Sitemap
	 */
	public static function getSitemap($url)
	{
		$sitemap = new Sitemap();
		try{
			$html = self::getHtml($url);
			$links = self::getInternalLinks($html);
			foreach ($links as $link)
			{
				$linkObject = new Link($link);
				try{
					$html = self::getHtml($link);
					$title = self::getTitle($html);
					$description = self::getDescription($html);
					$linkObject->setTitle($title);
					$linkObject->setDescription($description);
				}catch ( Exception $e ){
				}
				$sitemap->addLink($linkObject);
			}
		}catch ( Exception $e ){
		}
		return $sitemap;
	}
}
