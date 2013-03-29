<?php
namespace ComicRank;

$page = new Serve\HTML;

if (!isset($_GET['id'])) $page->exitPageDisplay(404);
$user = Model\User::getFromId($_GET['id']);
if (!$user) {
    $page->exitPageDisplay(404, 'user/404');
}

$page->links['canonical'] = '/user/'.$user->id('url').'/'.$user->name('url');

// Redirect incorrect / out of date user name links to canonical URL
if ( (!isset($_GET['name'])) || ($_GET['name'] != $user->name) ) {
    $page->exitRedirectTemporary($page->links['canonical']);
}

$page->title = 'User: '.$user->name;

$page->displayHeader();
$page->display('user/view', array('user'=>$user));
$page->displayFooter();
