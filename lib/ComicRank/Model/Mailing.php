<?php
namespace ComicRank\Model;

class Mailing extends ActiveRecord
{
    protected static $table = 'mailing';
    protected static $table_fields = array(
        'email'     => array('string', null),
        'added'     => array('time',   null),
        'token'     => array('string', null),
        'requester' => array('string', null),
    );
    protected static $table_primarykey = array('email');

    public static function getFromEmail($email)
    {
        if (!$email) return false;
        return static::getSingleFromSQL('SELECT * FROM mailing WHERE email = :email', array(':email'=>$email));
    }

    public static function getFromToken($token)
    {
        if (!$token) return false;
        return static::getSingleFromSQL('SELECT * FROM mailing WHERE token = :token', array(':token'=>$token));
    }

    public function validate() {
        parent::validate();

        if (!$this->email) {
            $this->validation_errors['email'] = 'No email address defined';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->validation_errors['email'] = 'Invalid email address';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        do {
            $token = base_convert(mt_rand(1, 9999999999999), 10, 32);
            $existing = Mailing::getFromToken($token);
        } while ($existing);

        $this->set('added', new \DateTime);
        $this->set('token', $token);
        if (!$this->requester) $this->set('requester', $_SERVER['REMOTE_ADDR']);

        return parent::insert();
    }
}
