<?php
namespace ComicRank\Model;

class Comic extends ActiveRecord
{
    protected static $table = 'comics';
    protected static $table_fields = array(
        'id'            => array('string', null),
        'added'         => array('time',   null),
        'user'          => array('string', null),
        'url'           => array('string', '',),
        'title'         => array('string', '',),
        'nsfw'          => array('bool',   0),
        'public'        => array('bool',   1),
        'readers'       => array('int',    0),
        'dailyvisitors' => array('int',    0),
        'dailyreaders'  => array('int',    0),
    );
    protected static $table_primarykey = array('id');

    public static function getFromId($id)
    {
        if (strlen($id) != 4) return false;
        return static::getSingleFromSQL('SELECT * FROM comics WHERE id = :id', array(':id'=>$id));
    }

    public static function getFromUser($user)
    {
        if (!$user) return false;
        return static::getFromSQL('SELECT * FROM comics WHERE user = :user', array(':user'=>$user));
    }

    public function generateFullCode($format='raw')
    {
        $r = '<!--Begin ComicRank button-->'."\n"
            .'<a href="http://www.comicrank.com/comic/'.$this->id('html').'/in" id="comicrank_button"><noscript><img src="http://stats.comicrank.com/v1/img/'.$this->id('html').'" alt="Visit Comic Rank" /></noscript></a>'."\n"
            .'<script>(function(){'."\n"
            .'var w=window,d=document,c,s;'."\n"
            .'function crl(){if(c)return;'."\n"
            .'c=d.getElementById("comicrank_button");'."\n"
            .'s=d.createElement("script");'."\n"
            .'s.async=true; s.src="http://stats.comicrank.com/v1/js/'.$this->id('url').'";'."\n"
            .'c.appendChild(s);}'."\n"
            .'if (w.attachEvent) {'."\n"
            .'w.attachEvent("DOMContentLoaded",crl);'."\n"
            .'w.attachEvent("onload",crl);'."\n"
            .'} else {'."\n"
            .'w.addEventListener("DOMContentLoaded",crl,false);'."\n"
            .'w.addEventListener("load",crl,false);'."\n"
            .'}})();</script>'."\n"
            .'<!--End ComicRank button-->'."\n";

        return fmt($r, $format);
    }

    public function generateBasicCode($format='raw')
    {
        $r = '<a href="http://www.comicrank.com/comic/'.$this->id('html').'/in"><img src="http://stats.comicrank.com/v1/img/'.$this->id('html').'" alt="Visit Comic Rank" /></a>'."\n";

        return fmt($r, $format);
    }

    public function validate() {
        parent::validate();

        if (!$this->url) {
            $this->validation_errors['url'] = 'No URL defined';
        } else {
            if (!strpos($this->url, '://')) $this->url = 'http://'.$this->url;
            if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
                $this->validation_errors['url'] = 'Invalid URL';
            } elseif (!in_array(substr($this->url, 0, 7), array('http://','https:/'))) {
                $this->validation_errors['url'] = 'URL must be HTTP or HTTPS';
            }
        }

        if (!$this->title) {
            $this->validation_errors['title'] = 'No title defined';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        do {
            $id = strtolower(base_convert(mt_rand(46656, 1679615), 10, 36));
            $existing = Comic::getFromId($id);
        } while ($existing);

        $this->set('id', $id);
        $this->set('added', new \DateTime);

        return parent::insert();
    }
}
