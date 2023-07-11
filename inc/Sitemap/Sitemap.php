<?php

namespace HP_SEO_ANALYZER\Sitemap;
use HP_SEO_ANALYZER\Sitemap\Link;
use DateTime;
class Sitemap
{
	private $links = [];
	private $lastModifiedDate;
	private $username;
	public function __construct()
	{
		$this->lastModifiedDate = new DateTime();
		$this->links = [];
		if(is_admin()){
			$this->username = wp_get_current_user()->user_login;
		}
	}

	public function addLink(Link $link)
	{
		$this->links[] = $link;
	}

	public function getLinks()
	{
		return $this->links;
	}

	public function setLinks(array $links)
	{
		$this->links = $links;
	}

	public function getLastModifiedDate()
	{
		return $this->lastModifiedDate;
	}

	public function setLastModifiedDate(DateTime $lastModifiedDate)
	{
		$this->lastModifiedDate = $lastModifiedDate;
	}

	public function toArray()
	{
		$links = [];
		foreach ($this->links as $link)
		{
			$links[] = $link->toArray();
		}
		return [
			'username' => $this->username,
			'links' => $links,
			'time' => $this->lastModifiedDate->format('Y-m-d H:i:s')
		];
	}
}
