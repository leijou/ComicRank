<?php
namespace ComicRank\View;

class HTML extends HTTP
{
    public $title = 'Comic Rank';
    public $canonical = null;
    public $author = null;
    public $css = array();
    public $js = array();

    public function __construct()
    {
        parent::__construct();

        $this->css[] = URL_STATIC.'/style/base.css';

        $this->headers['Content-Type'] = 'text/html; charset=utf8';
    }

    public function displayHeader()
    {
        $this->outputHeaders();

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

    public function displayInnerLeaderboard()
    {
        include(PATH_BASE.'/view/innerleaderboard.php');
    }

    public function exitPageDisplay($statuscode, $id, array $view = array())
    {
        $this->statuscode = $statuscode;
        $this->displayHeader();
        $this->display($id, $view);
        $this->displayFooter();
        exit;
    }

    public function exitRedirectPermanent($url)
    {
        if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
        $this->headers['Location'] = $url;
        $this->exitPageDisplay(301, 'generic-redirect', array('url'=>$url));
    }

    public function exitRedirectTemporary($url)
    {
        if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
        $this->headers['Location'] = $url;
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
