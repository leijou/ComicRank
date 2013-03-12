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

$page->canonical = '/comic/'.$comic->id('url').'/stats';

$page->title = 'Stats: '.$comic->title;

if ( (!$page->getUser()) || ( ($page->getUser()->id != $comic->user) && (!$page->getUser()->admin)) ) {
    $page->statuscode = 403;
    $page->displayHeader();
    $page->display('comic-not-authorized');
    $page->displayFooter();
    exit;
}

$page->js[] = 'http://www.google.com/jsapi';

$page->displayHeader();

$stats = Model\ComicStats::getFromSQL('
    SELECT * FROM comicstats
    WHERE `comic` = :comic AND
        `date` >= (UTC_DATE() - INTERVAL 9 WEEK)
    ORDER BY `date` ASC', array(':comic'=>$comic->id));

$page->display('comic-stats', array('comic'=>$comic, 'stats'=>$stats));
$page->displayFooter();
