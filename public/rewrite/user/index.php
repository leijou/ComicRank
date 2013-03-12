<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;

if (!isset($_GET['id'])) $page->exitNotFound();
$user = Model\User::getFromId($_GET['id']);
if (!$user) {
    $page->exitPageDisplay(404, 'user-not-found');
}

$page->canonical = '/user/'.$user->id('url').'/'.$user->name('url');

// Redirect incorrect / out of date user name links to canonical URL
if ( (!isset($_GET['name'])) || ($_GET['name'] != $user->name) ) {
    $page->exitRedirectTemporary($page->canonical);
}

$page->title = 'User: '.$user->name;

$page->displayHeader();
$page->display('user-view', array('user'=>$user));
$page->displayFooter();
