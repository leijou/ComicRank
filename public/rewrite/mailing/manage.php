<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new Serve\HTML;

// Find mailing entry for this token
if (!isset($_GET['token'])) $page->exitNotFound();
$mailing = Model\Mailing::getFromToken($_GET['token']);
if (!$mailing) {
    $page->title = 'Mailing options';
    $page->statuscode = 404;
    $page->displayHeader();
    $page->display('mailing-not-found');
    $page->displayFooter();
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
$page->display('mailing-manage', array('mailing'=>$mailing));
$page->displayFooter();
