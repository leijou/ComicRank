<?php
namespace ComicRank\Model;

class Thread extends ActiveRecord
{
    protected static $table = 'threads';
    protected static $table_fields = array(
        'id'        => array('autoid', null),
        'added'     => array('time',   null),
        'updated'   => array('time',   null),
        'firstpost' => array('int', null),
        'postcount' => array('int', 0),
        'title'     => array('string', ''),
    );
    protected static $table_primarykey = array('id');

    public static function getFromId($id)
    {
        if (!$id) return false;
        return static::getSingleFromSQL('SELECT * FROM threads WHERE id = :id', array(':id'=>$id));
    }

    public function validate()
    {
        parent::validate();

        if (strlen($this->title) < 3) {
            $this->validation_errors['title'] = 'Title not long enough';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        $this->set('added', new \DateTime);
        $this->set('updated', new \DateTime);

        return parent::insert();
    }
}
