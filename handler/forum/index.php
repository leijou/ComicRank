<?php
namespace ComicRank;

$page = new Serve\HTML;

if (!$page->getSessionUser()) $page->exitPageDisplay(403, 'forum/403'); // For now beta users only


$errors = array();
$postbox = '';
if ( (isset($_POST['addthread'])) && (isset($_POST['title'])) ) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $h = Database::getHandle();
        $h->beginTransaction();

        $thread = new Model\Thread;
        $thread->title = $_POST['title'];

        if ($thread->validate()) {
            $thread->insert();

            $post = new Model\Post;
            $post->thread = $thread->id;
            $post->user = $page->getSessionUser()->id;
            $post->body = trim($_POST['body']);

            if ($post->validate()) {
                $post->insert();

                $h->commit();

                $page->exitRedirect('/forum/'.$post->id('url'));
            } else {
                $h->rollBack();

                $errors = $post->validation_errors;
                $replybox = $_POST['body'];
            }
        } else {
            $errors = $thread->validation_errors;
            $postbox = $_POST['body'];
        }
    }
}


$page->links['canonical'] = '/forum';
$page->headers['X-Robots-Tag'] = 'noindex'; // For now avoid search engines

$page->title = 'Comic Rank Forum';

$page->displayHeader();
$page->display('forum/index', array('threads'=>Model\Thread::getFromSQL('SELECT * FROM threads ORDER BY updated DESC LIMIT 20'), 'errors'=>$errors, 'postbox'=>$postbox));
$page->displayFooter();
