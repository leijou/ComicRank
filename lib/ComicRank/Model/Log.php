<?php
namespace ComicRank\Model;

class Log extends ActiveRecord
{
    protected static $table = 'logs';
    protected static $table_fields = array(
        'id'      => array('autoid', null),
        'added'   => array('time',   null),
        'level'   => array('string', null),
        'message' => array('string', null),
    );
    protected static $table_primarykey = array('id');

    public static function getFromId($id)
    {
        if (!$id) return false;
        return static::getSingleFromSQL('SELECT * FROM logs WHERE id = :id', array(':id'=>$id));
    }

    public function insert()
    {
        $this->set('added', new \DateTime);

        return parent::insert();
    }
}
