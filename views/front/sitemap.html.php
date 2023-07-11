<?php

$sitemap_html = '<html lang="en"  xmlns:og="http://opengraphprotocol.org/schema/">'
. '<head>'
. '<meta charset="UTF-8">'
. '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
. '<meta http-equiv="X-UA-Compatible" content="ie=edge">'
. '<meta name="description" content="Sitemap">'
. '<meta name="robots" content="index, follow">'
. '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">'
. '<title>Sitemap for ' . get_bloginfo('name') . ' Homepage</title>'
. '</head>'
. '<body class="container  pt-5">'
. '<h1 class="py-5 text-center">'. get_bloginfo('name') . ' Homepage Sitemap.html</h1>'
. '<ul class="container">';
// get the internal links from the database

foreach ($internal_links as $link) {
	$url = $link['url'];
	$title = $link['title'];
	if (empty($title)) {
		$title = $url;
	}
	$sitemap_html .= '<li ><a href="' . $url . '">' . $title . '</a></li>';
}
$sitemap_html .= '</ul>'
. '</body>'
. '</html>';
echo $sitemap_html;
?>
