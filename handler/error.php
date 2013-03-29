<?php
namespace ComicRank;

$page = new Serve\HTML;

if (isset($_GET['code'])) switch ($_GET['code']) {
	case 403:
	case 404:
	case 410:
	case 500:
	case 503:
        $page->exitPageDisplay($_GET['code']);
        break;
}

$page->exitPageDisplay(404);
