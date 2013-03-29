<?php
namespace ComicRank;

$page = new Serve\HTML;

$user = $page->getSessionUser();
if (!$user) $page->exitPageDisplay(403);

$page->title = 'Add a Webcomic';

$errors = array();
if (isset($_POST['title'])) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $comic = new Model\Comic;
        $comic->title = $_POST['title'];
        $comic->url = $_POST['url'];
        $comic->user = $user->id;

        if ($comic->validate()) {
            $comic->insert();

            $page->exitRedirect('/comic/'.$comic->id('url').'/code');
        } else {
            $errors = $comic->validation_errors;
        }
    }
}

$page->displayHeader();
$page->display('comic/add', array('errors'=>$errors));
$page->displayFooter();
