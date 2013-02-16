<?php
namespace ComicRank;

/**
 *
 */
class Database
{
    private static $dbhandle = null;

    /**
     * Lazy-connect to the database and return handle
     * @return PDO Handle to the MySQL database
     */
    public static function getHandle()
    {
        if (!self::$dbhandle) {
            self::$dbhandle = new \PDO(
                'mysql:dbname='.MYSQL_DATABASE.';host='.MYSQL_HOST,
                MYSQL_USER,
                MYSQL_PASSWORD,
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
            );
            self::$dbhandle->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$dbhandle;
    }

    /**
     * Prepare and execute an SQL statement on the database
     * @param  string       $sql  SQL to run
     * @param  mixed[mixed] $bind Input parameters to bind to the SQL
     * @return PDOStatement       Pre-executed PDO statement
     */
    public static function query($sql, array $bind = null)
    {
        $h = self::getHandle();
        $s = $h->prepare($sql);
        $s->execute($bind);

        return $s;
    }

    /**
     * @return int
     */
    public static function lastInsertId()
    {
        $h = self::getHandle();

        return $h->lastInsertId();
    }
}
