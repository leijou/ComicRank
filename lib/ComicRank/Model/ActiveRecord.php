<?php
namespace ComicRank\Model;

/**
 *
 */
abstract class ActiveRecord
{
    protected static $table = '';
    protected static $table_primarykey = array();
    protected static $table_fields = array();

    private $field_container = array();
    private $field_changes = array();

    protected $validation_errors = null;

    const FIELD_FORMAT = 0;
    const FIELD_DEFAULT = 1;

    /**
     * Execute and fetch all rows
     * @param  string        $sql
     * @param  mixed[string] $bind
     * @return static[]
     */
    public static function getFromSQL($sql, array $bind = null)
    {
        return static::getFromStatement(\ComicRank\Database::query($sql, $bind));
    }

    /**
     * Execute and fetch one row
     * @param  string        $sql
     * @param  mixed[string] $bind
     * @return static|bool
     */
    public static function getSingleFromSQL($sql, array $bind = null)
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
        foreach (static::$table_fields as $field => $details) {
            if (array_key_exists($field, $row)) {
                $this->field_container[$field] = $row[$field];
            } else {
                $this->field_container[$field] = $details[self::FIELD_DEFAULT];
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
        if ($field == 'validation_errors') return $this->validation_errors;

        if (!array_key_exists($field, $this->field_container)) {
            throw new \OutOfRangeException('Field or attribute '.$field.' does not exists');
        }

        return $this->field_container[$field];
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
        if (!array_key_exists($field, $this->field_container)) {
            throw new \BadMethodCallException('Method or field '.$field.' does not exists');
        }
        array_unshift($args, $this->__get($field));

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
        if (!array_key_exists($field, static::$table_fields)) {
            throw new \OutOfRangeException('Field or attribute '.$field.' does not exists');
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
        if (!array_key_exists($field, $this->field_changes)) {
            $this->field_changes[$field] = $this->field_container[$field];
        }

        // Format the value as a storable value
        if ($value !== null) switch (static::$table_fields[$field][self::FIELD_FORMAT]) {
            case 'bool':
                $value = ($value?1:0);
                break;

            case 'time':
                if (!$value instanceof \DateTime) throw new \InvalidArgumentException('Value for time must be a DateTime instance');
                $value = $value->format('Y-m-d H:i:s');
                break;

            case 'date':
                if (!$value instanceof \DateTime) throw new \InvalidArgumentException('Value for date must be a DateTime instance');
                $value = $value->format('Y-m-d');
                break;
        }

        $this->field_container[$field] = $value;
    }

    /**
     *
     */
    public function validate() {
        $this->validation_errors = array();

        return true;
    }

    /**
     *
     */
    public function insert()
    {
        if ($this->validation_errors === null) $this->validate();
        if (count($this->validation_errors)) {
            throw new \RuntimeException('Unresolved validation errors on insert');
        }

        $bind = array();

        // Fetch all fields
        $set = array();
        foreach (static::$table_fields as $field => $details) {
            $set[] = '`'.$field.'`=?';
            $bind[] = $this->field_container[$field];
        }
        if (!count($set)) return;

        $sql = 'INSERT INTO `'.static::$table.'` SET '.implode($set,', ');
        \ComicRank\Database::query($sql, $bind);

        // Populate autoID field if there is one
        foreach (static::$table_fields as $field => $details) {
            if ($details[self::FIELD_FORMAT] == 'autoid') {
                $this->field_container[$field] = \ComicRank\Database::lastInsertId();
                break;
            }
        }
    }

    /**
     *
     */
    public function update()
    {
        if ($this->validation_errors === null) $this->validate();
        if (count($this->validation_errors)) {
            throw new \RuntimeException('Unresolved validation errors on update');
        }

        $bind = array();

        // Fetch updated fields
        $set = array();
        foreach ($this->field_changes as $field => $oldvalue) {
            if ($this->field_container[$field] !== $oldvalue) {
                $set[] = '`'.$field.'`=?';
                $bind[] = $this->field_container[$field];
            }
        }
        if (!count($set)) return;

        // Construct primary key where statement
        $where = array();
        foreach (static::$table_primarykey as $field) {
            $where[] = '`'.$field.'`=?';
            if (array_key_exists($field, $this->field_changes)) {
                $bind[] = $this->field_changes[$field];
            } else {
                $bind[] = $this->field_container[$field];
            }
        }

        $sql = 'UPDATE `'.static::$table.'` SET '.implode($set,', ').' WHERE '.implode($where, ' AND ');
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
        foreach (static::$table_primarykey as $field) {
            $where[] = '`'.$field.'`=?';
            if (array_key_exists($field, $this->field_changes)) {
                $bind[] = $this->field_changes[$field];
            } else {
                $bind[] = $this->field_container[$field];
            }
        }

        $sql = 'DELETE FROM `'.static::$table.'` WHERE '.implode($where, ' AND ');
        \ComicRank\Database::query($sql, $bind);
    }
}
