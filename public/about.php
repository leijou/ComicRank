<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;
$page->links['canonical'] = '/about.php';
$page->title = 'Comic Rank Roadmap';

$page->displayHeader();
$page->display('base/about');
$page->displayFooter();
