<?php
namespace ComicRank;

$page = new Serve\HTML;

if (!$page->getSessionUser()) $page->exitPageDisplay(403, 'forum/403'); // For now beta users only

if (!isset($_GET['id'])) $page->exitPageDisplay(404);
$firstpost = Model\Post::getFromId($_GET['id']);
if (!$firstpost) $page->exitPageDisplay(404, 'forum/404');

$thread = Model\Thread::getFromId($firstpost->thread);
if (!$thread) $page->exitPageDisplay(404, 'forum/404');

if ($firstpost->id != $thread->firstpost) {
    $page->exitRedirect('/forum/'.$thread->firstpost('url').'#p'.$firstpost->id('url'));
}

$errors = array();
$replybox = '';
if ( (isset($_POST['reply'])) && (isset($_POST['body'])) ) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $post = new Model\Post;
        $post->thread = $thread->id;
        $post->user = $page->getSessionUser()->id;
        $post->body = trim($_POST['body']);
        if ($post->validate()) {
            $post->insert();
            $page->exitRedirect('/forum/'.$firstpost->id('url').'#p'.$post->id('url'));
        } else {
            $errors = $post->validation_errors;
            $replybox = $_POST['body'];
        }
    }
}

$posts = Model\Post::getFromThreadId($thread->id);

$page->links['canonical'] = '/forum/'.$thread->firstpost('url');
$page->headers['X-Robots-Tag'] = 'noindex'; // For now avoid search engines

$page->title = $thread->title;

$page->displayHeader();
$page->display('forum/view', array('thread'=>$thread, 'posts'=>$posts, 'errors'=>$errors, 'replybox'=>$replybox));
$page->displayFooter();
