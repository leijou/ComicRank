<?php
namespace ComicRank;

$page = new Serve\HTML;

$page->title = 'Terms & Conditions';
$page->links['canonical'] = '/terms.php';
$page->displayHeader();
$page->display('terms');
$page->displayFooter();
