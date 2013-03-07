<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;

if (!isset($_GET['id'])) $page->exitNotFound();
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) {
    $page->exitPageDisplay(404, 'comic-not-found');
}

$page->canonical = '/comic/'.$comic->id('url').'/'.$comic->title('url');

// Redirect incorrect / out of date comic title links to canonical URL
if ( (!isset($_GET['title'])) || ($_GET['title'] != $comic->title) ) {
    $page->exitRedirectTemporary($page->canonical);
}

$page->title = $comic->title;

$page->displayHeader();
$page->display('comic-view', array('comic'=>$comic));
$page->display('innerleaderboard');
$page->displayFooter();
