<?php
namespace ComicRank\Serve;

class HTML extends HTTP
{
    public $title = 'Comic Rank';
    public $css = array();
    public $js = array();

    /**
     * @var \Leijou\CaseInsensitiveArray
     */
    public $links;

    public function __construct()
    {
        parent::__construct();
        $this->headers['Content-Type'] = 'text/html; charset=utf8';

        $this->links = new \Leijou\CaseInsensitiveArray;

        $this->css[] = URL_STATIC.'/style/base.css';
    }

    public function displayHeader()
    {
        $this->outputHeaders();

        // Make canonical links absolute
        if ( (isset($this->links['canonical'])) && (substr($this->links['canonical'], 0, 1) == '/') ) {
            $this->links['canonical'] = URL_SITE.$this->links['canonical'];
        }

        $this->display('header');
    }

    public function displayFooter()
    {
        $this->display('footer');
    }

    public function display($id, array $view = array())
    {
        $page = $this;
        include(PATH_BASE.'/view/'.$id.'.php');
    }

    public function exitPageDisplay($statuscode, $displayid, array $view = array())
    {
        $this->statuscode = $statuscode;
        $this->displayHeader();
        $this->display($displayid, $view);
        $this->displayFooter();
        exit;
    }

    public function exitRedirectPermanent($url)
    {
        $url = $this->redirect($url);
        $this->exitPageDisplay(301, 'generic-redirect', array('url'=>$url));
    }

    public function exitRedirectTemporary($url)
    {
        $url = $this->redirect($url);
        $this->exitPageDisplay(302, 'generic-redirect', array('url'=>$url));
    }

    public function exitForbidden()
    {
        $this->exitPageDisplay(403, 'generic-forbidden');
    }

    public function exitNotFound()
    {
        $this->exitPageDisplay(404, 'generic-filenotfound');
    }

    public function exitGone()
    {
        $this->exitPageDisplay(410, 'generic-gone');
    }

    public function exitInternalError()
    {
        $this->exitPageDisplay(500, 'generic-internalerror');
    }

    public function exitUnavailable()
    {
        $this->exitPageDisplay(503, 'generic-unavailable');
    }
}
