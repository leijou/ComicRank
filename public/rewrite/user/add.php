<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new Serve\HTML;

$page->title = 'Register';
$page->link['canonical'] = '/user/add';

if (!isset($_GET['email'])) $page->exitPageDisplay(404, 'user/register-bad');
if (!isset($_GET['key'])) $page->exitPageDisplay(404, 'user/register-bad');
$invitation = Model\Invitation::getFromEmail($_GET['email']);
if (!$invitation) $page->exitPageDisplay(404, 'user/register-bad');
if ($invitation->key != $_GET['key']) $page->exitPageDisplay(404, 'user/register-bad');
if ($invitation->expires('datetime') < new \DateTime) $page->exitPageDisplay(404, 'user/register-bad');

$errors = array();
if (isset($_POST['register'])) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        if (!$_POST['newpassword']) {
            $errors['newpassword'] = 'Password not given';
        } elseif ($_POST['newpassword'] != $_POST['verifypassword']) {
            $errors['newpassword'] = 'New passwords do not match';
        } else {
            $user = new Model\User;
            $user->name = $_POST['name'];
            $user->email = $invitation->email;
            $user->password = $_POST['newpassword'];

            if ($user->validate()) {
                $user->insert();

                $invitation->receiver = $user->id;
                $invitation->expires = new \DateTime;
                $invitation->update();

                $page->setSessionUser($user);
                $page->exitRedirect('/');
            } else {
                $errors = $user->validation_errors;
            }
        }
    }
}

$page->displayHeader();
$page->display('user/register', array('invitation'=>$invitation, 'errors'=>$errors));
$page->displayFooter();
