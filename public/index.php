<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;
$page->links['canonical'] = '/';
$page->title = 'Comic Rank';

$page->displayHeader();
if ($page->getSessionUser()) {
    $comics = $page->getSessionUser()->getComics();
    $page->display('base/index-user', array('user'=>$page->getSessionUser(), 'comics'=>$comics));
} else {
    $page->display('base/index-public');
}
$page->displayFooter();
