<?php
namespace ComicRank;

$page = new Serve\HTML;

if (!isset($_GET['id'])) $page->exitPageDisplay(404);
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) {
    $page->exitPageDisplay(404, 'comic/404');
}

$page->links['canonical'] = '/comic/'.$comic->id('url').'/edit';

if ( (!$page->getSessionUser()) || ( ($page->getSessionUser()->id != $comic->user) && (!$page->getSessionUser()->admin)) ) {
    $page->exitPageDisplay(403, 'comic/403');
}

$page->title = 'Code: '.$comic->title;

$errors = array();
$completions = array();
if (isset($_POST['title'])) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $comic->title = $_POST['title'];
        $comic->url = $_POST['url'];

        if ($comic->validate()) {
            $comic->update();

            $page->exitRedirect('/comic/'.$comic->id('url').'/'.$comic->title('url'));
        } else {
            $errors = $comic->validation_errors;
        }
    }
}

$page->displayHeader();
$page->display('comic/edit', array('comic'=>$comic, 'errors'=>$errors, 'completions'=>$completions));
$page->displayFooter();
