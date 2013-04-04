<?php
namespace ComicRank;

$page = new Serve\HTML;
$page->links['canonical'] = '/';
$page->title = 'Comic Rank';

$page->js[] = 'http://www.google.com/jsapi';

$page->displayHeader();
if ($page->getSessionUser()) {
    $comics = $page->getSessionUser()->getComics();

    $posts = array();
    $s = \ComicRank\Database::query('
        SELECT
            MAX(posts.id) AS id,
            firstpost,
            title,
            posts.added,
            (SELECT COUNT(*) FROM posts AS sp WHERE sp.thread = posts.thread AND sp.id > MAX(posts.id)) AS since
        FROM posts
        INNER JOIN threads ON threads.id = posts.thread
        WHERE user = :user
        GROUP BY thread
        ORDER BY posts.added DESC
        LIMIT 5
    ', array(':user'=>$page->getSessionUser()->id));
    while ($row = $s->fetch(\PDO::FETCH_ASSOC)) {
        $posts[] = $row;
    }

    $page->display('index-user', array('user'=>$page->getSessionUser(), 'comics'=>$comics, 'posts'=>$posts));

    foreach ($comics as $comic) {
        $stats = Model\ComicStats::getFromSQL('
            SELECT * FROM comicstats
            WHERE `comic` = :comic AND
                `date` >= (UTC_DATE() - INTERVAL 6 WEEK)
            ORDER BY `date` ASC', array(':comic'=>$comic->id));

        $page->display('comic/stats', array('comic'=>$comic, 'stats'=>$stats));
    }


} else {
    $page->display('index-public');
}
$page->displayFooter();
