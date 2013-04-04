<?php
namespace ComicRank\Serve;

/**
 *
 */
trait RequestForgeryProtection
{
    /**
     * @var string
     */
    private $rfpkey = false;

    /**
     * Return the RFP key
     *
     * If none exists generate one and return
     *
     * @return string RFP key
     */
    public function getRFPKey()
    {
        if (!$this->rfpkey) $this->rfpkey = sha1(mt_rand());

        return $this->rfpkey;
    }
}
