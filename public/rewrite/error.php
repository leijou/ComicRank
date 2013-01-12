<?php
namespace ComicRank;
require_once(__DIR__.'/../../core.php');

$page = new View\HTML;

if (isset($_GET['code'])) switch ($_GET['code']) {
	case 403: $page->exitForbidden(); break;
	case 404: $page->exitNotFound(); break;
	case 410: $page->exitGone(); break;
	case 500: $page->exitInternalError(); break;
	case 503: $page->exitUnavailable(); break;
}

$page->exitNotFound();
