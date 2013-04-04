<?php
namespace ComicRank;

$page = new Serve\HTML;

$page->links['canonical'] = '/user/invite';

// If not logged in or not admin
if ( (!$page->getSessionUser()) || (!$page->getSessionUser()->admin) ) {
    $page->exitPageDisplay(403);
}

$page->title = 'Invite user';

$errors = array();
if (isset($_POST['invite'])) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $invitation = new Model\Invitation;
        $invitation->email = $_POST['email'];
        $invitation->sender = $page->getSessionUser()->id;

        if ($invitation->validate()) {
            $invitation->insert();

            $page->exitRedirect('/user/add/'.$invitation->key('url'));
        } else {
            $errors = $invitation->validation_errors;
        }
    }
}

$page->displayHeader();
$page->display('user/invite', array('errors'=>$errors));
$page->displayFooter();
