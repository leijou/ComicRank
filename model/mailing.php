<?php
namespace ComicRank\Model;

class Mailing extends ORM {
	protected static $_table = 'mailing';
	protected static $_primarykey = array('email');
	protected static $_fields = array(
		'email'=>array('public','string',null),
		'added'=>array('readonly','time',null),
		'token'=>array('readonly','string',null),
	);
	
	
	public static function getFromEmail($email) {
		if (!$email) return false;
		return static::getSingleFromSQL('SELECT * FROM mailing WHERE email = :email', array(':email'=>$email));
	}
	
	public static function getFromToken($token) {
		if (!$token) return false;
		return static::getSingleFromSQL('SELECT * FROM mailing WHERE token = :token', array(':token'=>$token));
	}
	
	protected function set($field, $value) {
		switch ($field) {
			case 'email':
				if (preg_match('/^[^@]*[^\.]*$/', $value)) throw new \UnexpectedValueException('Invalid format for email address');
				break;
		}
		
		return parent::set($field, $value);
	}
	
	public function insert() {
		do {
			$token = base_convert(mt_rand(1, 9999999999999), 10, 32);
			$existing = Mailing::getFromToken($token);
		} while ($existing);
		
		$this->set('added', time());
		$this->set('token', $token);
		
		return parent::insert();
	}
	
}
