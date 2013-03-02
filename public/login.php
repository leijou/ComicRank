<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new View\HTML;

$page->title = 'Log In';
$page->canonical = '/login.php';

if ( (isset($_POST['email'])) && (isset($_POST['password'])) ) {
    $user = Model\User::getFromEmail($_POST['email']);
    if ( ($user) && ($user->verifyPassword($_POST['password'])) ) {
        $page->setSessionUser($user);
        $page->exitRedirectTemporary('/');
    }
}

$page->displayHeader();
?>

<section class="sectionbox">
    <header>
        <h1>Log In</h1>
    </header>

    <form action="/login.php" method="post" class="big">
        <input type="email" name="email" placeholder="Your email address" required />
        <input type="password" name="password" placeholder="Your password" required />
        <button type="submit">Log In</button>
    </form>

    <footer>
        <p>If you're part of the current closed beta and are having trouble logging in please email Steve.</p>
    </footer>
</section>

<?php
$page->displayFooter();
