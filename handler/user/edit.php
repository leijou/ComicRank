<?php
namespace ComicRank;

$page = new Serve\HTML;

if (!isset($_GET['id'])) $page->exitPageDisplay(404);
$user = Model\User::getFromId($_GET['id']);
if (!$user) {
    $page->exitPageDisplay(404, 'user/404');
}

$page->links['canonical'] = '/user/'.$user->id('url').'/edit';

// If not logged in or not logged in as correct user
if ( (!$page->getSessionUser()) || ( ($page->getSessionUser()->id != $user->id) && (!$page->getSessionUser()->admin)) ) {
    $page->exitPageDisplay(403);
}

$page->title = 'Edit user';

$errors = array();
$completions = array();
if (isset($_POST['name'])) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
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
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
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
$page->display('user/edit', array('user'=>$user, 'errors'=>$errors, 'completions'=>$completions));
$page->displayFooter();
