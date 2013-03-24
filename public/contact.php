<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;
$page->exitRedirect('/');
