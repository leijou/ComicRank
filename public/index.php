<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;
$page->links['canonical'] = '/';
$page->title = 'Comic Rank';

$page->displayHeader();
if ($page->getSessionUser()) {
    $comics = Model\Comic::getFromUser($page->getSessionUser()->id);
    $page->display('index-user', array('user'=>$page->getSessionUser(), 'comics'=>$comics));
} else {
    $page->display('index-public');
}
$page->displayFooter();
