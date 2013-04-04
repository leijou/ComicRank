<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

$s = Database::query('SELECT * FROM emails WHERE processed IS NULL ORDER BY added ASC LIMIT 5');
while ($emailout = Model\Email::getNextFromStatement($s)) {
    try {
        try {
            $emailout->send();
        } catch (\Exception $e) {
            Logger::error('Email out triggered unexpected swiftmailer exception #{id}: {msg}', array('id'=>$emailout->id,'msg'=>$e->getMessage()));

            // Unexpected error in Swift mail = mark as send failed
            $emailout->success = 0;
            $emailout->processed = new \DateTime;
        }

        $emailout->update();
    } catch (\Exception $e) {
        Logger::critical('Email out triggered unexpected exception #{id}: {msg}', array('id'=>$emailout->id,'msg'=>$e->getMessage()));

        // Best effort mark email to not try sending again if classes fail
        Database::query('UPDATE emails SET processed = UTC_TIMESTAMP() WHERE id = :id', array(':id'=>$emailout->id));
        $emailout->success = 0;
    }

    if ($emailout->success) {
        Logger::info('Email auto-sent #{id} to {to}', array('id'=>$emailout->id,'to'=>$emailout->toaddress));
    } else {
        Logger::notice('Email failed to send #{id} to {to}', array('id'=>$emailout->id,'to'=>$emailout->toaddress));
    }
}
