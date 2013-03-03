<?php
namespace ComicRank;

require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;
$page->canonical = '/mailing';
$page->title = 'Comic Rank mailing list';

$mailing = null;
$mailadderror = false;
if (isset($_POST['email'])) {
    // Insert in to DB if not already known
    $mailing = Model\Mailing::getFromEmail($_POST['email']);
    if (!$mailing) {
        $mailing = new Model\Mailing;
        $mailing->email = $_POST['email'];
        if ($mailing->validate()) {
            $mailing->insert();
        } else {
            $mailadderror = implode($mailing->validation_errors);
            $mailing = false;
        }
    }

    // Send confirmation email
    if ($mailing) {
        $message = new \Swift_Message('Comic Rank mailing list');
        $message->setTo($mailing->email);
        $message->setBody(
            'Thanks for supporting Comic Rank. We\'ll send an email to '.$mailing->email.' again when there is something to say.'."\n"
            ."\n"
            .'- Steve H'."\n"
            ."\n"
            .'Twitter: @comicrank'."\n"
            .'Google: +Comic Rank'."\n"
            ."\n"
            .'Unsubscribe: '.URL_SITE.'/mailing/'.$mailing->token('url')
        );
        \ComicRank\Mailer::sendAsNoReply($message);
    }
}

$page->displayHeader();
$page->display('mailing-add', array('mailing'=>$mailing,'mailadderror'=>$mailadderror));
$page->displayFooter();
