<?php
namespace ComicRank;

$page = new Serve\JSON;

if ( (!$page->getSessionUser()) || ( ($page->getSessionUser()->id != 'aaaa') && (!$page->getSessionUser()->admin)) ) {
    $page->exitDisplay(403, array('error'=>'Not Autorized'));
}

$page->outputHeaders();

echo '{';
$first = true;
$s = Database::query('SELECT * FROM comics WHERE inkid != ""');
while ($comic = Model\Comic::getNextFromStatement($s)) {
    if (!$first) echo ',';
    $first = false;
    echo json_encode($comic->id).':'.json_encode(['inkid'=>$comic->inkid, 'readers'=>$comic->readers('int')]);
}
echo '}';
