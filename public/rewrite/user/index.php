<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;

if (!isset($_GET['id'])) $page->exitNotFound();
$user = Model\User::getFromId($_GET['id']);
if (!$user) {
    $page->title = 'User not found';
    $page->statuscode = 404;
    $page->displayHeader();
    $page->display('user-not-found');
    $page->displayFooter();
    exit;
}

$page->canonical = '/user/'.$user->id('url').'/'.$user->name('url');

// Redirect incorrect / out of date user name links to canonical URL
if ( (!isset($_GET['name'])) || ($_GET['name'] != $user->name) ) {
    $page->exitRedirectTemporary($page->canonical);
}

$page->title = 'User: '.$user->name;

$page->displayHeader();
$page->display('user-view', array('user'=>$user));
$page->display('innerleaderboard');
$page->displayFooter();
