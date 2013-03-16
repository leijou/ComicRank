<?php
namespace ComicRank\Serve;

/**
 * Base class for communicating with client over HTTP
 *
 */
abstract class HTTP
{
    use LoginSession;
    use RequestForgeryProtection;

    const AUTH_COOKIE = 'crauth';
    const RFP_COOKIE = 'rfp';

    /**
     * @var int HTTP status code to use when sending headers
     */
    public $statuscode = 200;

    /**
     * @var \Leijou\CaseInsensitiveArray Set of custom HTTP headers to send
     */
    public $headers;

    /**
     * Setup HTML header defaults and recover states from cookies
     */
    public function __construct()
    {
        $this->headers = new \Leijou\CaseInsensitiveArray;
        $this->headers['Cache-Control'] = 'private';

        if (isset($_COOKIE[self::AUTH_COOKIE])) {
            $this->loadSessionFromKey($_COOKIE[self::AUTH_COOKIE]);
        }
        if (isset($_COOKIE[self::RFP_COOKIE])) {
            $this->rfpkey = $_COOKIE[self::RFP_COOKIE];
        }
    }

    /**
     * Output HTTP headers including cookies to the client
     *
     * Will return immediately if output has already begun
     *
     * @return bool Whether headers could be sent
     */
    public function outputHeaders()
    {
        if (headers_sent()) return false;

        // Output HTTP headers
        header(':', true, $this->statuscode);
        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }

        // Add/Update/Remove session cookie
        if ($this->session) {
            $_COOKIE[self::AUTH_COOKIE] = $this->getSessionKey();
            setcookie(self::AUTH_COOKIE, $_COOKIE[self::AUTH_COOKIE], time()+31449600, '/', null, false, true);
        } elseif (isset($_COOKIE[self::AUTH_COOKIE])) {
            unset($_COOKIE[self::AUTH_COOKIE]);
            setcookie(self::AUTH_COOKIE, '', time()-31449600, '/');
        }

        // Add Request Forgery Protection cookie
        setcookie(self::RFP_COOKIE, $this->getRFPKey(), time()+31449600, '/');

        return true;
    }

    /**
     * Set headers related to a HTTP redirect
     *
     * URLs starting with a / will have the site's base URL prepended
     *
     * @param string $url     URL to redirect to
     * @param bool $permanent Whether to flag as a permanent redirect
     * @return string         Full URL used for the redirect
     */
    public function redirect($url, $permanent=false)
    {
        $this->statuscode = ($permanent?301:302);
        if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
        $this->headers['Location'] = $url;

        return $url;
    }
}
