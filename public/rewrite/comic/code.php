<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new Serve\HTML;

if (!isset($_GET['id'])) $page->exitNotFound();
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) {
    $page->exitPageDisplay(404, 'comic-not-found');
}

$page->links['canonical'] = '/comic/'.$comic->id('url').'/code';

if ( (!$page->getSessionUser()) || ( ($page->getSessionUser()->id != $comic->user) && (!$page->getSessionUser()->admin)) ) {
    $page->exitPageDisplay(403, 'comic-not-authorized');
}

$page->title = 'Code: '.$comic->title;

$page->displayHeader();
$page->display('comic-code', array('comic'=>$comic));
$page->displayFooter();
