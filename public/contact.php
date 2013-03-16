<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;
$page->links['canonical'] = '/contact.php';
$page->title = 'Contact';

$page->displayHeader();
$page->display('base/contact');
$page->displayFooter();
