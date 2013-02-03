<?php
namespace ComicRank\Model;

class Comic extends ORM {
	protected static $_table = 'comics';
	protected static $_primarykey = array('id');
	protected static $_fields = array(
		'id'=>array('readonly','string',null),
		'added'=>array('readonly','time',null),
		'url'=>array('public','string',''),
		'title'=>array('public','string',''),
		'nsfw'=>array('public','bool',0),
		'public'=>array('public','bool',1),
		'email'=>array('public','string',''),
		'accesscode'=>array('protected','string',null),
		'readers'=>array('protected','int',0),
		'guests'=>array('protected','int',0),
	);
	
	
	public static function getFromId($id) {
		if (strlen($id) != 4) return false;
		return static::getSingleFromSQL('SELECT * FROM comics WHERE id = :id', array(':id'=>$id));
	}
	
	protected function set($field, $value) {
		switch ($field) {
			case 'url':
				if (!strpos($value, '://')) $value = 'http://'.$value;
				break;
			
			case 'email':
				if (preg_match('/^[^@]*[^\.]*$/', $value)) throw new \UnexpectedValueException('Invalid format for email address');
				break;
		}
		
		return parent::set($field, $value);
	}
	
	public function generateFullCode($format='raw') {
		$r = '<!--Begin ComicRank button-->'."\n"
		    .'<a href="http://www.comicrank.com/comic/'.$this->id('html').'/in" id="comicrank_button"><noscript><img src="http://stats.comicrank.com/v1/img/'.$this->id('html').'" alt="Visit Comic Rank" /></noscript></a>'."\n"
		    .'<script>(function(){'."\n"
		    .'var w=window,d=document,c,s;'."\n"
		    .'function crl(){if(c)return;'."\n"
		    .'c=d.getElementById("comicrank_button");'."\n"
		    .'s=d.createElement("script");'."\n"
		    .'s.async=true; s.src="http://stats.comicrank.com/v1/js/'.$this->id('url').'";'."\n"
		    .'c.appendChild(s);}'."\n"
		    .'if (w.attachEvent){'."\n"
		    .'w.attachEvent("DOMContentLoaded",crl);'."\n"
		    .'w.attachEvent("onload",crl);'."\n"
		    .'}else{'."\n"
		    .'w.addEventListener("DOMContentLoaded",crl,false);'."\n"
		    .'w.addEventListener("load",crl,false);'."\n"
		    .'}})();</script>'."\n"
		    .'<!--End ComicRank button-->'."\n";
		return \ComicRank\fmt($r, $format);
	}
	
	public function generateBasicCode($format='raw') {
		$r = '<a href="http://www.comicrank.com/comic/'.$this->id('html').'/in"><img src="http://stats.comicrank.com/v1/img/'.$this->id('html').'" alt="Visit Comic Rank" /></a>'."\n";
		return \ComicRank\fmt($r, $format);
	}
	
	public function insert() {
		do {
			$id = strtolower(base_convert(mt_rand(46656, 1679615), 10, 36));
			$existing = Comic::getFromId($id);
		} while ($existing);
		
		$this->set('id', $id);
		$this->set('added', time());
		$this->set('accesscode', str_replace(range(0,9), range('Q','Z'), strtoupper(base_convert(mt_rand(1, 9999999999999), 10, 26))));
		return parent::insert();
	}
	
}
