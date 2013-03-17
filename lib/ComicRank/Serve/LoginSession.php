<?php
namespace ComicRank\Serve;

/**
 * Store and retrieve login session details for a client
 *
 * Exhibiting classes are responsible for calling loadSessionFromKey
 * and getSessionKey for session persistence
 */
trait LoginSession
{
    /**
     * @var string
     */
    private $sessionkey = false;

    /**
     * @var \ComicRank\Model\Session
     */
    private $session = false;

    /**
     * @var \ComicRank\Model\User
     */
    private $sessionuser = false;

    /**
     * Recover a login session
     */
    private function loadSessionFromKey($key)
    {
        $this->sessionkey = $key;
        $this->session = \ComicRank\Model\Session::getFromKey($key);
        $this->sessionuser = null;
    }

    /**
     * Return session key that should be used to recover the session
     *
     * Depending on the state of the session this may be the same key used
     * to recover the current session, or be a newly generated one
     */
    private function getSessionKey()
    {
        if ( ($this->session) && ($this->session->shouldRegenerate()) ) {
            try {
                $this->sessionkey = $this->session->regenerate();
            } catch (\Exception $e) {
                // TODO: Log Exception without affecting client
            }
        }

        return $this->sessionkey;
    }

    /**
     * Fetches user data associated with the client's login session
     *
     * The same User object is returned on each call
     *
     * @return \ComicRank\Model\User|bool Associated User of false if not found
     */
    public function getSessionUser()
    {
        // User variable defaults to null, only try to fetch once
        if ($this->sessionuser === null) {
            $this->sessionuser = false;
            if ($this->session) {
                $this->sessionuser = \ComicRank\Model\User::getFromId($this->session->user);
            }
        }

        return $this->sessionuser;
    }

    /**
     * Create new login session for the client for a given user
     *
     * Must be called before outputHeaders to ensure client retains the session
     *
     * @param \ComicRank\Model\User $user User to authenticate client as
     */
    public function setSessionUser(\ComicRank\Model\User $user)
    {
        // Replace existing session if exists
        if ($this->session) $this->unsetSessionUser();

        $this->sessionuser = $user;
        $this->session = new \ComicRank\Model\Session;
        $this->session->user = $user->id;
    }

    /**
     * Remove login session for the client
     */
    public function unsetSessionUser()
    {
        if ($this->session) {
            try {
                $this->session->delete();
            } catch (\Exception $e) {
                // TODO: Log Exception without affecting client
            }

            $this->sessionkey = false;
            $this->session = false;
            $this->sessionuser = false;
        }
    }
}
