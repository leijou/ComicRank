<?php
namespace ComicRank\Serve;

/**
 * Represents an HTML page generated for client
 */
class HTML extends HTTP
{
    /**
     * @var string Page title to include in HTML head
     */
    public $title = 'Comic Rank';

    /**
     * @var array List of CSS files to include in HTML head
     */
    public $css = array();

    /**
     * @var array List of Javascript files to include in HTML head
     */
    public $js = array();

    /**
     * @var \Leijou\CaseInsensitiveArray rel => href pairs to include in HTML head
     */
    public $links;

    /**
     * Initiate HTTP headers and HTML page options
     */
    public function __construct()
    {
        parent::__construct();
        $this->headers['Content-Type'] = 'text/html; charset=utf8';

        $this->links = new \Leijou\CaseInsensitiveArray;

        $this->css[] = URL_STATIC.'/style/base.css';
    }

    /**
     * Start HTTP output, output site header template
     */
    public function displayHeader()
    {
        $this->outputHeaders();

        // Make canonical links absolute
        if ( (isset($this->links['canonical'])) && (substr($this->links['canonical'], 0, 1) == '/') ) {
            $this->links['canonical'] = URL_SITE.$this->links['canonical'];
        }

        $this->display('header');
    }

    /**
     * Output site footer template
     */
    public function displayFooter()
    {
        $this->display('footer');
    }

    /**
     * Output a view template
     *
     * @param string $id  ID of template to output
     * @param array $view View scope
     */
    public function display($id, array $view = array())
    {
        $page = $this;
        include(PATH_BASE.'/templates/'.$id.'.php');
    }

    /**
     * Set HTTP status code, display full HTML page, and stop script execution
     *
     * Must only be called before anything has been output
     *
     * @param int $statuscode   HTTP statuscode to apply
     * @param string $displayid View template to display, defaults to statuscode's error template
     * @param array $view       View scope
     */
    public function exitPageDisplay($statuscode, $displayid=null, array $view = array())
    {
        if (!$displayid) $displayid = 'error/'.$statuscode;

        $this->statuscode = $statuscode;
        $this->displayHeader();
        $this->display($displayid, $view);
        $this->displayFooter();
        exit;
    }

    /**
     * Send redirect instructions and stop script execution
     *
     * @param string $url     URL to redirect to
     * @param bool $permanent Whether to flag as a permanent redirect
     */
    public function exitRedirect($url, $permanent=false)
    {
        $this->redirect($url, $permanent);
        $this->exitPageDisplay($this->statuscode);
    }
}
