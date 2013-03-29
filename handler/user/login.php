<?php
namespace ComicRank;

$page = new Serve\HTML;

$page->title = 'Log In';
$page->links['canonical'] = '/user/login';

$errors = array();
if ( (isset($_POST['email'])) && (isset($_POST['password'])) ) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $user = Model\User::getFromEmail($_POST['email']);
        if ( ($user) && ($user->verifyPassword($_POST['password'])) ) {
            $page->setSessionUser($user);
            $page->exitRedirect('/');
        }
        $errors['auth'] = 'Incorrect email or password.';
    }
}

$page->displayHeader();
$page->display('user/login', array('errors'=>$errors));
$page->displayFooter();
