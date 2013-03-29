<?php
namespace ComicRank;

$page = new Serve\HTML;

if (!isset($_GET['id'])) $page->exitPageDisplay(404);
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) {
    $page->exitPageDisplay(404, 'comic/404');
}

$page->links['canonical'] = '/comic/'.$comic->id('url').'/'.$comic->title('url');
$page->headers['X-Robots-Tag'] = 'noindex'; // For now avoid search engines

// Redirect incorrect / out of date comic title links to canonical URL
if ( (!isset($_GET['title'])) || ($_GET['title'] != $comic->title) ) {
    $page->exitRedirect($page->links['canonical']);
}

$page->title = $comic->title;

$page->displayHeader();
$page->display('comic/view', array('comic'=>$comic));
$page->displayFooter();
