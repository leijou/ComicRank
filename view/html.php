<?php
namespace ComicRank\View;

class HTML extends HTTP {
	public $canonical = null;
	public $title = 'Comic Rank';
	public $css = array();
	
	/**
	 * 
	 */
	public function __construct() {
		parent::__construct();
		
		$this->css[] = URL_STATIC.'/style/base.css';
		
		$this->headers['Content-Type'] = 'text/html; charset=utf8';
	}
	
	/**
	 * 
	 */
	public function displayHeader() {
		$this->outputHeaders();
		
		echo '<!doctype html>
		<html>
		<head><title>'.htmlspecialchars($this->title).'</title>';
		foreach ($this->css as $css) echo '<link rel="stylesheet" href="'.htmlspecialchars($css).'" />';
		if ($this->canonical) echo '<link rel="canonical" value="'.URL_SITE.htmlspecialchars($this->canonical).'" />';
		?>
			<script>
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-367286-6']);
			_gaq.push(['_trackPageview']);

			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			</script>
		</head>
		<body>
			<header id="headband">
				<div>
					<a href="/"><img src="<?=URL_STATIC?>/images/heading.png" alt=""></a>
					<nav>
						<ul>
							<li><a href="/">Home</a></li>
							<li><a href="/about.php">About</a></li>
							<li><a href="/contact.php">Contact</a></li>
						</ul>
					</nav>
				</div>
			</header>
			<div id="wrap">
				<h1>Comic Rank</h1>
		<?php
	}
	
	/**
	 * 
	 */
	public function displayFooter() {
		echo '
				<div style="height: 20px;"></div>
			</div>
		</body>
		</html>';
	}
	
	
	public function displayInnerLeaderboard() {
		include(__DIR__.'/html_section/innerleaderboard.php');
	}
	
	
	
	public function exitRedirectPermanent($url) {
		$this->statuscode = 301;
		if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
		$this->headers['Location'] = $url;
		$this->displayHeader();
		echo '<section>
			<header>
				<h1>Over here</h1>
			</header>
			<p>You\'re lagging behind! The page you want is here: '.htmlspecialchars($url).'</p>
		</section>';
		$this->displayFooter();
		exit;
	}
	
	public function exitRedirectTemporary($url) {
		$this->statuscode = 302;
		if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
		$this->headers['Location'] = $url;
		$this->displayHeader();
		echo '<section>
			<header>
				<h1>Over here</h1>
			</header>
			<p>You\'re lagging behind! The page you want is here: '.htmlspecialchars($url).'</p>
		</section>';
		$this->displayFooter();
		exit;
	}
	
	public function exitForbidden() {
		$this->statuscode = 403;
		$this->displayHeader();
		echo '<section>
			<header>
				<h1>Forbidden</h1>
			</header>
		</section>';
		$this->displayFooter();
		exit;
	}
	
	public function exitNotFound() {
		$this->statuscode = 404;
		$this->displayHeader();
		echo '<section>
			<header>
				<h1>Page not found</h1>
			</header>
		</section>';
		$this->displayFooter();
		exit;
	}
	
	public function exitGone() {
		$this->statuscode = 410;
		$this->displayHeader();
		echo '<section>
			<header>
				<h1>Page no longer exists</h1>
			</header>
		</section>';
		$this->displayFooter();
		exit;
	}
	
	public function exitInternalError() {
		$this->statuscode = 500;
		$this->displayHeader();
		echo '<section>
			<header>
				<h1>Internal error</h1>
			</header>
			<p>Something went wrong, it\'s probably our fault ☹</p>
		</section>';
		$this->displayFooter();
		exit;
	}
	
	public function exitUnavailable() {
		$this->statuscode = 503;
		$this->displayHeader();
		echo '<section>
			<header>
				<h1>Service unavailable</h1>
			</header>
		</section>';
		$this->displayFooter();
		exit;
	}
	
	
}