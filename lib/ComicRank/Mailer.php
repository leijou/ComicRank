<?php
namespace ComicRank;

class Mailer
{
    public static $failures = array();

    protected static $mailer_noreply = null;
    protected static $mailer_steve = null;

    public static function sendAsNoReply(\Swift_Message $message)
    {
        if (static::$mailer_noreply === null) {
            $transport = \Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT, SMTP_TRANSPORT);
            $transport->setUsername(SMTP_NOREPLY_USER);
            $transport->setPassword(SMTP_NOREPLY_PASSWORD);

            static::$mailer_noreply = \Swift_Mailer::newInstance($transport);
        }

        $message->setFrom(array('noreply@comicrank.com'=>'Comic Rank'));

        return static::send(static::$mailer_noreply, $message);
    }

    public static function sendAsSteve(\Swift_Message $message)
    {
        if (static::$mailer_steve === null) {
            $transport = \Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT, SMTP_TRANSPORT);
            $transport->setUsername(SMTP_STEVE_USER);
            $transport->setPassword(SMTP_STEVE_PASSWORD);

            static::$mailer_steve = \Swift_Mailer::newInstance($transport);
        }

        $message->setFrom(array('steve@comicrank.com'=>'Steve H'));

        return static::send(static::$mailer_steve, $message);
    }

    private static function send(\Swift_Mailer $mailer, \Swift_Message $message)
    {
        var_dump($message->getTo());
        return 0;

        $failures = array();
        $r = $mailer->send($message, $failures);
        static::$failures = array_merge(static::$failures, $failures);

        return $r;
    }
}
