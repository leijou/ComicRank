<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new View\HTML;
$page->canonical = '/';
$page->title = 'Comic Rank';

$page->displayHeader();
if ($page->getUser()) {
    $comics = Model\Comic::getFromUser($page->getUser()->id);
    $page->display('index-user', array('user'=>$page->getUser(), 'comics'=>$comics));
} else {
    $page->display('index-public');
}
$page->displayFooter();
