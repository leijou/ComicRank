<?php
namespace ComicRank;

$page = new Serve\HTML;

if (!$page->getSessionUser()) $page->exitPageDisplay(403, 'forum/403'); // For now beta users only

$page->links['canonical'] = '/forum/about';
$page->headers['X-Robots-Tag'] = 'noindex'; // For now avoid search engines

$page->title = 'Forum Primer';

$page->displayHeader();
$page->display('forum/about');
$page->displayFooter();
