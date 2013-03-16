<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new Serve\HTML;

if (!isset($_GET['id'])) $page->exitPageDisplay(404);
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) {
    $page->exitPageDisplay(404, 'comic/404');
}

$page->links['canonical'] = '/comic/'.$comic->id('url').'/code';

if ( (!$page->getSessionUser()) || ( ($page->getSessionUser()->id != $comic->user) && (!$page->getSessionUser()->admin)) ) {
    $page->exitPageDisplay(403, 'comic/403');
}

$page->title = 'Code: '.$comic->title;

$page->displayHeader();
$page->display('comic/code', array('comic'=>$comic));
$page->displayFooter();
