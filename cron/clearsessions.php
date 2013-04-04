<?php
/**
 * This script removes user sessions which have expired
 */
namespace ComicRank;

require_once(__DIR__.'/../core.php');

try {
    $s = Database::query('DELETE FROM sessions WHERE expires < UTC_TIMESTAMP()');
    Logger::info('Cleared {num} expired user sessions', array('num'=>$s->rowCount()));
} catch (\Exception $e) {
    Logger::error('Database exception when clearing user sessions');
}
