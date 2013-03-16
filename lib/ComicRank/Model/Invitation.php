<?php
namespace ComicRank\Model;

class Invitation extends ActiveRecord
{
    protected static $table = 'invitations';
    protected static $table_fields = array(
        'email'    => array('email',  null),
        'key'      => array('string',  null),
        'expires'  => array('time',   null),
        'sender'   => array('string', null),
        'receiver' => array('string', null),
    );
    protected static $table_primarykey = array('email');

    public static function getFromEmail($email)
    {
        if (!$email) return false;
        return static::getSingleFromSQL('SELECT * FROM invitations WHERE `email` = :email', array(':email'=>$email));
    }

    public function validate()
    {
        parent::validate();

        if (!$this->email) {
            $this->validation_errors['email'] = 'No email address defined';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->validation_errors['email'] = 'Invalid email address';
        }

        if (!$this->sender) {
            $this->validation_errors['sender'] = 'No sender given';
        } elseif (!User::getFromId($this->sender)) {
            $this->validation_errors['sender'] = 'Invalid sender given';
        }

        if ( ($this->receiver) && (!User::getFromId($this->receiver)) ) {
            $this->validation_errors['receiver'] = 'Invalid receiver given';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        $this->set('key', strtoupper(base_convert(mt_rand(46656, 1679615), 10, 36).base_convert(mt_rand(46656, 1679615), 10, 36)));
        $this->set('expires', new \DateTime('+1 week'));

        return parent::insert();
    }
}
