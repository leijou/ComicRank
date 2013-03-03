<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;

if (!isset($_GET['id'])) $page->exitNotFound();
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) {
    $page->title = 'Comic not found';
    $page->statuscode = 404;
    $page->displayHeader();
    $page->display('comic-not-found');
    $page->displayFooter();
    exit;
}

$page->canonical = '/comic/'.$comic->id('url').'/code';

$page->title = 'Code: '.$comic->title;

if ( (!$page->getUser()) || ($page->getUser()->id != $comic->user) ) {
    $page->statuscode = 403;
    $page->displayHeader();
    $page->display('comic-not-authorized');
    $page->displayFooter();
    exit;
}

$page->displayHeader();
$page->display('comic-code', array('comic'=>$comic));
$page->displayFooter();
