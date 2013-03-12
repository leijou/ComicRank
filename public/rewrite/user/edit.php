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

// If not logged in or not logged in as correct user
if ( (!$page->getUser()) || ( ($page->getUser()->id != $user->id) && (!$page->getUser()->admin)) ) {
    $page->exitForbidden();
}

$page->canonical = '/user/'.$user->id('url').'/edit';

$page->title = 'Edit user';

$errors = array();
$completions = array();
if (isset($_POST['name'])) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getCSRF()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $user->name = $_POST['name'];
        if ($user->validate()) {
            $user->update();
            $completions['name'] = 'Name has been updated';
        } else {
            $errors = $user->validation_errors();
        }
    }
} elseif (isset($_POST['password'])) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getCSRF()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        if (!$user->verifyPassword($_POST['password'])) {
            $errors['password'] = 'Incorrect current password';
        } elseif ($_POST['newpassword'] != $_POST['verifypassword']) {
            $errors['newpassword'] = 'New passwords do not match';
        } else {
            $user->password = $_POST['newpassword'];
            if ($user->validate()) {
                $user->update();
                $completions['password'] = 'Password has been updated';
            } else {
                $errors = $user->validation_errors();
            }
        }
    }
}

$page->displayHeader();
$page->display('user-edit', array('user'=>$user, 'errors'=>$errors, 'completions'=>$completions));
$page->displayFooter();
