<?php
namespace ComicRank\Model;

class Session extends StoredObject
{
    protected static $table = 'sessions';
    protected static $table_fields = array(
        'key'        => array('string', null),
        'expires'    => array('time',   null),
        'regenerate' => array('time',   null),
        'user'       => array('int',    null),
    );
    protected static $table_primarykey = array('key');

    public static function getFromKey($key)
    {
        if (!$key) return false;
        return static::getSingleFromSQL('SELECT * FROM sessions WHERE `key` = :key AND expires > NOW()', array(':key'=>sha1($key)));
    }

    public static function getFromUser($user)
    {
        if (!$user) return false;
        return static::getFromSQL('SELECT * FROM sessions WHERE user = :user AND expires > NOW()', array(':user'=>$user));
    }

    public function shouldRegenerate()
    {
        return (new \DateTime <= $this->regenerate('datetime'));
    }

    public function regenerate()
    {
        // Expire this key soon (allows synchronous requests to complete)
        $this->set('expires', new \DateTime('+1 minute'));
        $this->set('regenerate', new \DateTime('+5 minute'));
        $this->update();

        // Insert as new row (creates new key and resets expiry/regenerate time)
        $this->insert();
    }

    public function validate() {
        parent::validate();

        if (!$this->user) {
            $this->validation_errors['user'] = 'No user given';
        } elseif (!User::getFromId($this->user)) {
            $this->validation_errors['user'] = 'Invalid user given';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        do {
            $key = $this->user.'|'.base_convert(mt_rand(1, 3656158440062975), 10, 36).base_convert(mt_rand(1, 3656158440062975), 10, 36);
            $existing = Session::getFromKey(sha1($key));
        } while ($existing);

        $this->set('key', sha1($key));
        $this->set('expires', new \DateTime('+1 year'));
        $this->set('regenerate', new \DateTime('+1 hour'));
        $r = parent::insert();

        // Set local key to be plaintext for this request
        $this->set('key', $key);

        return $r;
    }
}
