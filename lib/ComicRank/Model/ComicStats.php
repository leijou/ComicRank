<?php
namespace ComicRank\Model;

/**
 * Comic Stats are read-only snapshots of a comic's reader/guest count on
 * a given day. They are generated automatically by database triggers
 */
class ComicStats extends StoredObject
{
    protected static $_table = 'comicstats';
    protected static $_primarykey = array('comic','date');
    protected static $_fields = array(
        'comic'=>array('readonly','string',null),
        'date'=>array('readonly','date',null),
        'readers'=>array('readonly','int',0),
        'guests'=>array('readonly','int',0),
    );
}
