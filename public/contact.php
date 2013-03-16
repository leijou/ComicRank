<?php
namespace ComicRank;
require_once(__DIR__.'/../core.php');

$page = new Serve\HTML;
$page->links['canonical'] = '/contact.php';
$page->title = 'Contact';

$page->displayHeader();
?>

<section class="sectionbox">
	<header>
		<h1>Get in touch</h1>
	</header>
	<p>We're on Twitter: <a href="https://twitter.com/comicrank">@ComicRank</a> and Google Plus: <a href="https://plus.google.com/u/0/108661948674027877061">+Comic Rank</a>.</p>
	<p>Or, you can email me at <a href="mailto:steve@comicrank.com">steve@comicrank.com</a></p>
</section>

<section class="sectionbox">
	<header>
		<h1>Want to contribute?</h1>
	</header>

	<div class="contentwrap">
		<p>Comic Rank has plans to be big again, but can only do it with your support. If you'd like to give it a go and help out with any of these kind of things we'd love to hear from you:</p>
		<ul>
			<li>Site design / drawings</li>
			<li>Text content for the site (because I rarely make sense)</li>
			<li>Web development</li>
			<li>Comic moderation</li>
			<li>or, of course, money for hosting costs</li>
		</ul>
		<p>We're working on getting a small forum for discussing Comic Rank but until then please contact me via the methods above, or clever developers can fork us on <a href="https://github.com/leijou/ComicRank">GitHub</a> directly.</p>
	</div>
</section>

<?php
$page->displayFooter();
