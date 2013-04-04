<?php
namespace ComicRank\Model;

class Email extends ActiveRecord
{
    protected static $table = 'emails';
    protected static $table_fields = array(
        'id'          => array('autoid', null),
        'added'       => array('time',   null),
        'processed'   => array('time',   null),
        'success'     => array('bool',   0),
        'fromaccount' => array('string', 'noreply'),
        'toaddress'   => array('string', null),
        'subject'     => array('string', ''),
        'body'        => array('string', ''),
    );
    protected static $table_primarykey = array('id');

    const ACCOUNT_NOREPLY = 'noreply';
    const ACCOUNT_STEVE = 'steve';

    public static function getFromId($id)
    {
        if (!$id) return false;
        return static::getSingleFromSQL('SELECT * FROM emails WHERE id = :id', array(':id'=>$id));
    }

    public function send()
    {
        $message = new \Swift_Message($this->subject);
        $message->setTo($this->toaddress);
        $message->setBody($this->body);

        switch ($this->fromaccount) {
            case self::ACCOUNT_NOREPLY:
                $this->success = \ComicRank\Mailer::sendAsNoReply($message);
                break;

            case self::ACCOUNT_STEVE:
                $this->success = \ComicRank\Mailer::sendAsSteve($message);
                break;

            default:
                throw new \RuntimeException('Invalid from account');
        }

        $this->processed = new \DateTime;
    }

    public function validate()
    {
        parent::validate();

        if (!$this->toaddress) {
            $this->validation_errors['toaddress'] = 'No to address defined';
        } elseif (!filter_var($this->toaddress, FILTER_VALIDATE_EMAIL)) {
            $this->validation_errors['toaddress'] = 'Invalid to address';
        }

        switch ($this->fromaccount) {
            case self::ACCOUNT_NOREPLY:
            case self::ACCOUNT_STEVE:
                // Good
                break;

            default:
                $this->validation_errors['fromaccount'] = 'Invalid from account';
        }

        return !count($this->validation_errors);
    }

    public function insert()
    {
        $this->set('added', new \DateTime);

        return parent::insert();
    }
}
