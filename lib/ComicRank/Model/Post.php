<?php
namespace ComicRank\Model;

class Post extends ActiveRecord
{
    protected static $table = 'posts';
    protected static $table_fields = array(
        'id'       => array('autoid', null),
        'added'    => array('time',   null),
        'thread'   => array('int',    null),
        'user'     => array('string', null),
        'anonhash' => array('string', null),
        'body'     => array('string', ''),
    );
    protected static $table_primarykey = array('id');

    public static function getFromId($id)
    {
        if (!$id) return false;
        return static::getSingleFromSQL('SELECT * FROM posts WHERE id = :id', array(':id'=>$id));
    }

    public static function getFromThreadId($thread)
    {
        if (!$thread) return array();
        return static::getFromSQL('SELECT * FROM posts WHERE thread = :thread ORDER BY added ASC', array(':thread'=>$thread));
    }

    public function validate()
    {
        parent::validate();

        if (!$this->user) {
            $this->validation_errors['user'] = 'No user defined';
        } elseif (!User::getFromId($this->user)) {
            $this->validation_errors['user'] = 'Invalid user given';
        }

        if (!$this->thread) {
            $this->validation_errors['thread'] = 'No thread defined';
        } elseif (!Thread::getFromId($this->thread)) {
            $this->validation_errors['thread'] = 'Invalid thread given';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        $this->set('added', new \DateTime);

        $threadpost = Post::getSingleFromSQL('SELECT * FROM posts WHERE thread = :thread AND user = :user ORDER BY added ASC LIMIT 1', array(':thread'=>$this->thread,':user'=>$this->user));
        if ($threadpost) {
            $this->anonhash = $threadpost->anonhash;
        } else {
            $this->anonhash = str_pad(dechex(mt_rand(0, 0xFFFFFFFF)), 8, '0', STR_PAD_LEFT).str_pad(dechex(mt_rand(0, 0xFFFFFFFF)), 8, '0', STR_PAD_LEFT).str_pad(dechex(mt_rand(0, 0xFFFFFFFF)), 8, '0', STR_PAD_LEFT).str_pad(dechex(mt_rand(0, 0xFFFFFFFF)), 8, '0', STR_PAD_LEFT);
        }

        return parent::insert();
    }
}
