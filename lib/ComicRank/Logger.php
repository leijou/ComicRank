<?php
namespace ComicRank;

/**
 * Static wrapper for the ComicRank logger
 */
class Logger
{
    private static $logger = null;


    public static function getLogger()
    {
        if (!self::$logger) {
            self::$logger = new Model\Logger;
        }

        return self::$logger;
    }

    public static function emergency($message, array $context = array())
    {
        return static::getLogger()->emergency($message, $context);
    }

    public static function alert($message, array $context = array())
    {
        return static::getLogger()->alert($message, $context);
    }

    public static function critical($message, array $context = array())
    {
        return static::getLogger()->critical($message, $context);
    }

    public static function error($message, array $context = array())
    {
        return static::getLogger()->error($message, $context);
    }

    public static function warning($message, array $context = array())
    {
        return static::getLogger()->warning($message, $context);
    }

    public static function notice($message, array $context = array())
    {
        return static::getLogger()->notice($message, $context);
    }

    public static function info($message, array $context = array())
    {
        return static::getLogger()->info($message, $context);
    }

    public static function debug($message, array $context = array())
    {
        return static::getLogger()->debug($message, $context);
    }

    public static function log($level, $message, array $context = array())
    {
        return static::getLogger()->log($level, $message, $context);
    }
}
