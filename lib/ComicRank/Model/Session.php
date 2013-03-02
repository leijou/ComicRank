<?php
namespace ComicRank\Model;

class Session extends StoredObject
{
    protected static $table = 'sessions';
    protected static $table_fields = array(
        'key'         => array('string', null),
        'expires'     => array('time',   null),
        'regenerates' => array('time',   null),
        'user'        => array('string', null),
    );
    protected static $table_primarykey = array('key');

    public static function getFromId($key)
    {
        if (!$key) return false;
        return static::getSingleFromSQL('SELECT * FROM sessions WHERE `key` = :key', array(':key'=>$key));
    }

    public static function getFromKey($key)
    {
        if (!$key) return false;
        return static::getSingleFromSQL('SELECT * FROM sessions WHERE `key` = :key AND `expires` > UTC_TIMESTAMP()', array(':key'=>sha1($key)));
    }

    public static function getFromUser($user)
    {
        if (!$user) return false;
        return static::getFromSQL('SELECT * FROM sessions WHERE user = :user AND `expires` > UTC_TIMESTAMP()', array(':user'=>$user));
    }

    public function shouldRegenerate()
    {
        if (!$this->key) return true;
        return (new \DateTime >= $this->regenerates('datetime'));
    }

    public function regenerate()
    {
        if ($this->key) {
            // Expire this key soon (allows synchronous requests to complete)
            $this->set('expires', new \DateTime('+1 minute'));
            $this->set('regenerates', new \DateTime('+5 minute'));
            $this->update();
        }

        // Insert as new row (creates new key and resets expiry/regenerate time)
        $this->insert($key);
        return $key;
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

    public function insert(&$k=null)
    {
        do {
            $key = $this->user.base_convert(mt_rand(1, 3656158440062975), 10, 36).base_convert(mt_rand(1, 3656158440062975), 10, 36);
            $existing = Session::getFromId(sha1($key));
        } while ($existing);
        $k = $key;

        $this->set('key', sha1($key));
        $this->set('expires', new \DateTime('+1 year'));
        $this->set('regenerates', new \DateTime('+1 hour'));
        return parent::insert();
    }
}
