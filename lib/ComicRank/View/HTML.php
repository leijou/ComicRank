<?php
namespace ComicRank\View;

class HTML extends HTTP
{
    public $title = 'Comic Rank';
    public $canonical = null;
    public $author = null;
    public $css = array();

    public function __construct()
    {
        parent::__construct();

        $this->css[] = URL_STATIC.'/style/base.css';

        $this->headers['Content-Type'] = 'text/html; charset=utf8';
    }

    public function displayHeader()
    {
        $this->outputHeaders();

        include(PATH_BASE.'/view/header.php');
    }

    public function displayFooter()
    {
        echo '
                <div style="height: 20px;"></div>
            </div>
        </body>
        </html>';
    }

    public function displayInnerLeaderboard()
    {
        include(PATH_BASE.'/view/innerleaderboard.php');
    }

    public function exitRedirectPermanent($url)
    {
        $this->statuscode = 301;
        if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
        $this->headers['Location'] = $url;
        $this->displayHeader();
        echo '<section class="sectionbox">
            <header>
                <h1>Over here</h1>
            </header>
            <p>You\'re lagging behind! The page you want is here: '.htmlspecialchars($url).'</p>
        </section>';
        $this->displayFooter();
        exit;
    }

    public function exitRedirectTemporary($url)
    {
        $this->statuscode = 302;
        if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
        $this->headers['Location'] = $url;
        $this->displayHeader();
        echo '<section class="sectionbox">
            <header>
                <h1>Over here</h1>
            </header>
            <p>You\'re lagging behind! The page you want is here: '.htmlspecialchars($url).'</p>
        </section>';
        $this->displayFooter();
        exit;
    }

    public function exitForbidden()
    {
        $this->statuscode = 403;
        $this->displayHeader();
        echo '<section class="sectionbox">
            <header>
                <h1>Forbidden</h1>
            </header>
        </section>';
        $this->displayFooter();
        exit;
    }

    public function exitNotFound()
    {
        $this->statuscode = 404;
        $this->displayHeader();
        echo '<section class="sectionbox">
            <header>
                <h1>Page not found</h1>
            </header>
        </section>';
        $this->displayFooter();
        exit;
    }

    public function exitGone()
    {
        $this->statuscode = 410;
        $this->displayHeader();
        echo '<section class="sectionbox">
            <header>
                <h1>Page no longer exists</h1>
            </header>
        </section>';
        $this->displayFooter();
        exit;
    }

    public function exitInternalError()
    {
        $this->statuscode = 500;
        $this->displayHeader();
        echo '<section class="sectionbox">
            <header>
                <h1>Internal error</h1>
            </header>
            <p>Something went wrong, it\'s probably our fault ☹</p>
        </section>';
        $this->displayFooter();
        exit;
    }

    public function exitUnavailable()
    {
        $this->statuscode = 503;
        $this->displayHeader();
        echo '<section class="sectionbox">
            <header>
                <h1>Service unavailable</h1>
            </header>
        </section>';
        $this->displayFooter();
        exit;
    }
}
