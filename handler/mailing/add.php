<?php
namespace ComicRank;

$page = new Serve\HTML;
$page->links['canonical'] = '/mailing/add';
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
        $email = new Model\Email;
        $email->subject = 'Comic Rank mailing list';
        $email->fromaccount = 'noreply';
        $email->toaddress = $mailing->email;
        $email->body =  'Thanks for supporting Comic Rank. We\'ll send an email to '.$mailing->email.' again when there is something to say.'."\n"
                        ."\n"
                        .'- Steve H'."\n"
                        ."\n"
                        .'Twitter: @comicrank'."\n"
                        .'Google: +Comic Rank'."\n"
                        ."\n"
                        .'Unsubscribe: '.URL_SITE.'/mailing/'.$mailing->token('url');
        $email->send();
        $email->insert();
    }
}

$page->displayHeader();
$page->display('mailing/add', array('mailing'=>$mailing,'mailadderror'=>$mailadderror));
$page->displayFooter();
