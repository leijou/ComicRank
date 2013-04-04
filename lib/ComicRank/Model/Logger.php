<?php
namespace ComicRank\Model;

class Logger extends \Psr\Log\AbstractLogger
{
    public function log($level, $message, array $context = array())
    {
        if (!defined('\\Psr\\Log\\LogLevel::'.strtoupper($level))) {
            throw new \Psr\Log\InvalidArgumentException('Unknown log level: '.$level);
        }

        // Replace {key} with val from context
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{'.$key.'}'] = $val;
        }
        $message = strtr($message, $replace);

        // Log in DB, fallback to file if unavailable
        try {
            $log = new Log;
            $log->level = $level;
            $log->message = $message;
            $log->insert();
        } catch(\Exception $e) {
            file_put_contents(PATH_BASE.'/emerg_log', $level."\t".$message."\n", FILE_APPEND);
        }
    }
}
