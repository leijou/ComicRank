<?php
namespace ComicRank\Model;

class User extends StoredObject
{
    protected static $table = 'users';
    protected static $table_fields = array(
        'id'       => array('string', null),
        'added'    => array('time',   null),
        'email'    => array('email',  ''),
        'password' => array('string', ''),
        'name'     => array('string', ''),
        'admin'    => array('bool', 0),
    );
    protected static $table_primarykey = array('id');

    public static function getFromId($id)
    {
        if (!$id) return false;
        return static::getSingleFromSQL('SELECT * FROM users WHERE id = :id', array(':id'=>$id));
    }

    public static function getFromEmail($email)
    {
        if (!$email) return false;
        return static::getSingleFromSQL('SELECT * FROM users WHERE email = :email', array(':email'=>$email));
    }

    protected function set($field, $value)
    {
        if ($field == 'password') {
            $value = password_hash($value, PASSWORD_BCRYPT);
            if (!$value) throw new \RuntimeException('Password could not be hashed');
        }

        return parent::set($field, $value);
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function validate() {
        parent::validate();

        if (!$this->email) {
            $this->validation_errors['email'] = 'No email address defined';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->validation_errors['email'] = 'Invalid email address';
        }

        if (!$this->password) {
            $this->validation_errors['password'] = 'No password defined';
        }

        if (!$this->name) {
            $this->validation_errors['name'] = 'No name defined';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        do {
            $id = strtolower(base_convert(mt_rand(46656, 1679615), 10, 36));
            $existing = User::getFromId($id);
        } while ($existing);

        $this->set('id', $id);
        $this->set('added', new \DateTime);

        return parent::insert();
    }
}
