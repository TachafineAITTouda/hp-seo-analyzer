<?php

namespace HP_SEO_ANALYZER\Sitemap;

use Exception;


/**
 * Class Link
 * @package HP_SEO_ANALYZER\Sitemap
 *
 * @property string $url
 * @property string $title
 * @property string $description
 */
class Link
{
	private $url;
	private $title;
	private $description;

	public function __construct($url, $title = null, $description = null)
	{
		$this->url = $url;
		$this->title = $title;
		$this->description = $description;
	}

	function getUrl()
	{
		return $this->url;
	}

	function getTitle()
	{
		return $this->title;
	}

	function getDescription()
	{
		return $this->description;
	}

	function setUrl($url)
	{
		$this->url = $url;
	}

	function setTitle($title)
	{
		$this->title = $title;
	}

	function setDescription($description)
	{
		$this->description = $description;
	}


	public function toArray()
	{
		return [
			'url' => $this->url,
			'title' => $this->title,
			'description' => $this->description
		];
	}
}

