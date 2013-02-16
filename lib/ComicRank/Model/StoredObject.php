<?php
namespace ComicRank\Model;

/**
 *
 */
abstract class StoredObject
{
    protected static $_table = '';
    protected static $_primarykey = array();
    protected static $_fields = array();

    private $_container = array();
    private $_changes = array();

    const FIELD_SCOPE = 0;
    const FIELD_TYPE = 1;
    const FIELD_DEFAULT = 2;

    /**
     * Execute and fetch all rows
     * @param  string        $sql
     * @param  mixed[string] $bind
     * @return static[]
     */
    public static function getFromSQL($sql, array $bind=null)
    {
        return static::getFromStatement(\ComicRank\Database::query($sql, $bind));
    }

    /**
     * Execute and fetch one row
     * @param  string        $sql
     * @param  mixed[string] $bind
     * @return static|bool
     */
    public static function getSingleFromSQL($sql, array $bind=null)
    {
        return static::getNextFromStatement(\ComicRank\Database::query($sql, $bind));
    }

    /**
     * Fetch and return an array of all remaining rows in a statement
     * @param  \PDOStatement $s
     * @return static[]
     */
    public static function getFromStatement(\PDOStatement $s)
    {
        $array = array();
        while ($row = $s->fetch(\PDO::FETCH_ASSOC)) {
            $array[] = new static($row);
        }

        return $array;
    }

    /**
     * Fetch and return the next row of a statement or false if none left
     * @param  \PDOStatement $s
     * @return static|bool
     */
    public static function getNextFromStatement(\PDOStatement $s)
    {
        $row = $s->fetch(\PDO::FETCH_ASSOC);
        if (!$row) return false;
        return new static($row);
    }

    /**
     * Construct an object with a new state
     * @param mixed[string] $row Associative array of field=>value
     */
    public function __construct(array $row = array())
    {
        foreach (static::$_fields as $field => $details) {
            if (array_key_exists($field, $row)) {
                $this->_container[$field] = $row[$field];
            } else {
                $this->_container[$field] = $details[self::FIELD_DEFAULT];
            }
        }
    }

    /**
     * Allow read-only access to fields
     * @throws \OutOfRangeException
     * @param  string               $field
     * @return mixed
     */
    public function __get($field)
    {
        if (!array_key_exists($field, $this->_container)) {
            throw new \OutOfRangeException('Field or attribute '.$field.' does not exists');
        }

        return $this->_container[$field];
    }

    /**
     * Allow reading of fields with format argument
     * @throws \BadMethodCallException
     * @param  string                  $field
     * @param  string[]                $args
     * @return mixed
     */
    public function __call($field, $args)
    {
        if (!array_key_exists($field, $this->_container)) {
            throw new \BadMethodCallException('Method or field '.$field.' does not exists');
        }
        array_unshift($args, $this->_container[$field]);

        return call_user_func_array('fmt', $args);
    }

    /**
     * Allow setting of non-readonly fields
     * @uses  static::set
     * @throws \BadMethodCallException
     * @param  string                  $field
     * @param  mixed                   $value
     */
    public function __set($field, $value)
    {
        if (!array_key_exists($field, static::$_fields)) {
            throw new \OutOfRangeException('Field or attribute '.$field.' does not exists');
        }
        if (static::$_fields[$field][self::FIELD_SCOPE] == 'readonly') {
            throw new \OutOfRangeException('Field '.$field.' is read only');
        }
        $this->set($field, $value);
    }
    /**
     * Allow setting of any fields (only available in class scope)
     * Handles the formatting of input depedant on field type
     * @param string $field
     * @param mixed  $value
     */
    protected function set($field, $value)
    {
        // Mark the field as changed and note the original value
        if (!array_key_exists($field, $this->_changes)) {
            $this->_changes[$field] = $this->_container[$field];
        }

        // Format the value as a storable value
        if ($value !== null) switch (static::$_fields[$field][self::FIELD_TYPE]) {
            case 'bool': $value = ($value?1:0); break;
            case 'password': $value = $value->getHash(); break;
            case 'time': $value = $value->format('Y-m-d H:i:s'); break;
            case 'date': $value = $value->format('Y-m-d'); break;
        }

        $this->_container[$field] = $value;
    }

    /**
     * Attempt to set all fields that are publicly editable
     * Silently fail to set any uneditable fields
     * @param mixed[string] $values
     */
    public function setPublic($values)
    {
        foreach ($values as $field => $value) {
            if (
                (array_key_exists($field, static::$_fields)) &&
                (static::$_fields[$field][self::FIELD_SCOPE] == 'public')
            ) {
                $this->set($field, $value);
            }
        }
    }

    /**
     *
     */
    public function insert()
    {
        $bind = array();

        // Fetch all fields
        $set = array();
        foreach (static::$_fields as $field => $details) {
            $set[] = '`'.$field.'`=?';
            $bind[] = $this->_container[$field];
        }
        if (!count($set)) return;

        $sql = 'INSERT INTO `'.static::$_table.'` SET '.implode($set,', ');
        \ComicRank\Database::query($sql, $bind);

        // Populate autoID field if there is one
        foreach (static::$_fields as $field => $details) {
            if ($details[self::FIELD_TYPE] == 'autoid') {
                $this->_container[$field] = \ComicRank\Database::lastInsertId();
                break;
            }
        }
    }

    /**
     *
     */
    public function update()
    {
        $bind = array();

        // Fetch updated fields
        $set = array();
        foreach ($this->_changes as $field => $oldvalue) {
            if ($this->_container[$field] !== $oldvalue) {
                $set[] = '`'.$field.'`=?';
                $bind[] = $this->_container[$field];
            }
        }
        if (!count($set)) return;

        // Construct primary key where statement
        $where = array();
        foreach (static::$_primarykey as $field) {
            $where[] = '`'.$field.'`=?';
            if (array_key_exists($field, $this->_changes)) {
                $bind[] = $this->_changes[$field];
            } else {
                $bind[] = $this->_container[$field];
            }
        }

        $sql = 'UPDATE `'.static::$_table.'` SET '.implode($set,', ').' WHERE '.implode($where, ' AND ');
        \ComicRank\Database::query($sql, $bind);
    }

    /**
     *
     */
    public function delete()
    {
        $bind = array();

        // Construct primary key where statement
        $where = array();
        foreach (static::$_primarykey as $field) {
            $where[] = '`'.$field.'`=?';
            if (array_key_exists($field, $this->_changes)) {
                $bind[] = $this->_changes[$field];
            } else {
                $bind[] = $this->_container[$field];
            }
        }

        $sql = 'DELETE FROM `'.static::$_table.'` WHERE '.implode($where, ' AND ');
        \ComicRank\Database::query($sql, $bind);
    }
}
