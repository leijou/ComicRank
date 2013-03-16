<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new Serve\HTML;

if (!isset($_GET['id'])) $page->exitPageDisplay(404);
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) {
    $page->exitPageDisplay(404, 'comic/404');
}

$page->links['canonical'] = '/comic/'.$comic->id('url').'/stats';

if ( (!$page->getSessionUser()) || ( ($page->getSessionUser()->id != $comic->user) && (!$page->getSessionUser()->admin)) ) {
    $page->exitPageDisplay(403, 'comic/403');
}

$page->title = 'Stats: '.$comic->title;

$page->js[] = 'http://www.google.com/jsapi';

$page->displayHeader();

$stats = Model\ComicStats::getFromSQL('
    SELECT * FROM comicstats
    WHERE `comic` = :comic AND
        `date` >= (UTC_DATE() - INTERVAL 9 WEEK)
    ORDER BY `date` ASC', array(':comic'=>$comic->id));

$page->display('comic/stats', array('comic'=>$comic, 'stats'=>$stats));
$page->displayFooter();
