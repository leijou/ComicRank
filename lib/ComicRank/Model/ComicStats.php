<?php
namespace ComicRank\Model;

/**
 * Comic Stats are read-only snapshots of a comic's reader/visitor count on
 * a given day. They are generated automatically by database triggers
 */
class ComicStats extends ActiveRecord
{
    protected static $table = 'comicstats';
    protected static $table_fields = array(
        'comic'         => array('string', null),
        'date'          => array('date',   null),
        'readers'       => array('int',    0),
        'dailyvisitors' => array('int',    0),
        'dailyreaders'  => array('int',    0),
    );
    protected static $table_primarykey = array('comic','date');

    public function insert()
    {
        throw new \BadMethodCallException('ComicStats are read-only');
    }

    public function update()
    {
        throw new \BadMethodCallException('ComicStats are read-only');
    }

    public function delete()
    {
        throw new \BadMethodCallException('ComicStats are read-only');
    }
}
