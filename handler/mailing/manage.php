<?php
namespace ComicRank;

$page = new Serve\HTML;

// Find mailing entry for this token
if (!isset($_GET['token'])) $page->exitPageDisplay(404);
$mailing = Model\Mailing::getFromToken($_GET['token']);
if (!$mailing) {
    $page->exitPageDisplay(404, 'mailing/404');
    exit;
}

$page->links['canonical'] = '/mailing/'.$mailing->token('url');
$page->title = 'Mailing options';
$page->headers['X-Robots-Tag'] = 'noindex';

if (isset($_POST['unsubscribe'])) {
    $mailing->delete();
    $mailing = false;
}

$page->displayHeader();
$page->display('mailing/manage', array('mailing'=>$mailing));
$page->displayFooter();
