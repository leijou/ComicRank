<?php
namespace ComicRank\View;

abstract class HTTP
{
    public $statuscode = 200;
    public $headers;

    const AUTH_COOKIE = 'crauth';
    private $session = false;
    private $user = null;

    public function __construct()
    {
        $this->headers = new \Leijou\CaseInsensitiveArray;

        if (isset($_COOKIE[self::AUTH_COOKIE])) {
            $this->session = \ComicRank\Model\Session::getFromKey($_COOKIE[self::AUTH_COOKIE]);
        }
    }

    public function outputHeaders()
    {
        // Output HTTP headers
        header(':', true, $this->statuscode);
        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }

        // Add session cookie
        if ($this->session) {
            if ($this->session->shouldRegenerate()) {
                try {
                    $_COOKIE[self::AUTH_COOKIE] = $this->session->regenerate();
                } catch (\Exception $e) {
                }
            }
            setcookie(self::AUTH_COOKIE, $_COOKIE[self::AUTH_COOKIE], time()+31449600, '/', null, false, true);
        }
    }

    public function setSessionUser(\ComicRank\Model\User $user)
    {
        if ($this->session) {
            try {
                $this->session->delete();
            } catch (\Exception $e) {
            }
            $this->session = false;
            $this->user = false;
        }

        $this->user = $user;
        $this->session = new \ComicRank\Model\Session;
        $this->session->user = $user->id;
    }

    public function unsetSession()
    {
        if ($this->session) {
            try {
                $this->session->delete();
            } catch (\Exception $e) {
            }
            $this->session = false;
            $this->user = false;
        }
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getUser()
    {
        if ($this->user === null) {
            $this->user = false;
            if ($this->session) {
                $this->user = \ComicRank\Model\User::getFromId($this->session->user);
            }
        }
        return $this->user;
    }

    public function exitRedirectPermanent($url)
    {
        $this->statuscode = 301;
        if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
        $this->headers['Location'] = $url;
        $this->outputHeaders();
        exit;
    }

    public function exitRedirectTemporary($url)
    {
        $this->statuscode = 302;
        if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
        $this->headers['Location'] = $url;
        $this->outputHeaders();
        exit;
    }

    public function exitForbidden()
    {
        $this->statuscode = 403;
        $this->outputHeaders();
        exit;
    }

    public function exitNotFound()
    {
        $this->statuscode = 404;
        $this->outputHeaders();
        exit;
    }

    public function exitGone()
    {
        $this->statuscode = 410;
        $this->outputHeaders();
        exit;
    }

    public function exitInternalError()
    {
        $this->statuscode = 500;
        $this->outputHeaders();
        exit;
    }

    public function exitUnavailable()
    {
        $this->statuscode = 503;
        $this->outputHeaders();
        exit;
    }
}
