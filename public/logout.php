<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new View\HTML;

$page->unsetSession();
$page->exitRedirectTemporary('/');
