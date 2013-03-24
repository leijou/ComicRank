<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;
$page->links['canonical'] = '/';
$page->title = 'Comic Rank';

$page->js[] = 'http://www.google.com/jsapi';

$page->displayHeader();
if ($page->getSessionUser()) {
    $comics = $page->getSessionUser()->getComics();

    $page->display('base/index-user', array('user'=>$page->getSessionUser(), 'comics'=>$comics));

    foreach ($comics as $comic) {
        $stats = \ComicRank\Model\ComicStats::getFromSQL('
            SELECT * FROM comicstats
            WHERE `comic` = :comic AND
                `date` >= (UTC_DATE() - INTERVAL 6 WEEK)
            ORDER BY `date` ASC', array(':comic'=>$comic->id));

        $page->display('comic/stats', array('comic'=>$comic, 'stats'=>$stats));
    }


} else {
    $page->display('base/index-public');
}
$page->displayFooter();
