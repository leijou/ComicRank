<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;

$page->title = 'Log In';
$page->links['canonical'] = '/login.php';

$errors = array();
if ( (isset($_POST['email'])) && (isset($_POST['password'])) ) {
    if ( (!isset($_POST['csrf'])) || ($_POST['csrf'] != $page->getRFPKey()) ) {
        $errors['csrf'] = 'Missing or invalid security token. Please try again.';
    } else {
        $user = Model\User::getFromEmail($_POST['email']);
        if ( ($user) && ($user->verifyPassword($_POST['password'])) ) {
            $page->setSessionUser($user);
            $page->exitRedirectTemporary('/');
        }
        $errors['auth'] = 'Incorrect email or password.';
    }
}

$page->displayHeader();
?>

<section class="sectionbox">
    <header>
        <h1>Log In</h1>
    </header>

    <form action="/login.php" method="post" class="big">
        <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
        <?=(isset($errors['csrf'])?'<p style="color: red">'.fmt($errors['csrf'], 'html').'</p>':'')?>

        <?=(isset($errors['auth'])?'<p style="color: red">'.fmt($errors['auth'], 'html').'</p>':'')?>
        <input type="email" name="email" placeholder="Your email address" required /><br />
        <input type="password" name="password" placeholder="Your password" required /><br />
        <button type="submit">Log In</button>
    </form>

    <footer>
        <p>If you're part of the current closed beta and are having trouble logging in please email Steve.</p>
    </footer>
</section>

<?php
$page->displayFooter();
