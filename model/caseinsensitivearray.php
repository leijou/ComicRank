<?php
namespace ComicRank\Model;

/**
 * Case insensitive array object used like a PHP array
 * 
 * Key access is case insensitive. When accessing the array's keys they will
 * be returned as the original case that defined them.
 * 
 * If an existing key is overwritten with a different case the new case will be
 * used when returning key names.
 * 
 * @author Stephen Hawkes
 * @link https://github.com/leijou
 */
class CaseInsensitiveArray implements \ArrayAccess, \Iterator, \Countable {
    
    /**
     * @var mixed[mixed] Contained array with original keys
     */
    private $container;
    
    /**
     * @var mixed[string] Map custom hash key to original key on container
     */
    private $map;
    
    /**
     * Returns lowercased version of the given key
     * 
     * Want to change this? Try the CustomHashArray class instead:
     * @link https://github.com/leijou/CustomHashArray
     * 
     * @param $key mixed
     * @return string
     */
    protected function hash($key) {
        return strtolower($key);
    }
    
    /**
     * Create new blank array or convert from existing standard array
     * 
     * @param mixed[mixed] Optional array to instantiate as
     */
    public function __construct(Array $array=array()) {
        $this->container = $array;
        
        $this->map = array();
        foreach (array_keys($array) as $key) {
            $this->map[$this->hash($key)] = $key;
        }
    }
    
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
            end($this->container);
            $offset = key($this->container);
        } else {
            if ($this->offsetExists($offset)) {
                $this->offsetUnset($offset);
            }
            $this->container[$offset] = $value;
        }
        
        $this->map[$this->hash($offset)] = $offset;
    }
    
    public function offsetExists($offset) {
        return isset($this->map[$this->hash($offset)]);
    }
    
    public function offsetUnset($offset) {
        $key = $this->map[$this->hash($offset)];
        unset($this->container[$key]);
        unset($this->map[$this->hash($offset)]);
    }
    
    public function offsetGet($offset) {
        $key = $this->map[$this->hash($offset)];
        return $this->container[$key];
    }
    
    public function rewind() {
        return reset($this->container);
    }
    
    public function current() {
        return current($this->container);
    }
    
    public function key() {
        return key($this->container);
    }
    
    public function next() {
        return next($this->container);
    }
    
    public function valid() {
        return !is_null(key($this->container));
    }
    
    public function count() {
        return count($this->container);
    }
    
}
