<?php
namespace ComicRank;
require_once(__DIR__.'/../core.php');

$page = new View\HTML;
$page->canonical = '/';
$page->title = 'Comic Rank';

$page->displayHeader();
?>

<div style="margin: 10px 0 20px; padding: 1px 80px 10px; color: #06a; font-size: 21px; line-height: 1.5em;">
	<p>Comic Rank provides a service which tracks the readers of webcomics and tells you how many real people frequently read your comic. No vote-begging required.</p>
</div>

<section>
	<header>
		<h1>Closed Beta</h1>
	</header>
	<p>Comic Rank is currently in a closed beta, and can be used by invitation only. If you'd like to be informed of updates, and get invitations as soon as possible, then please sign up here:</p>
	
	<form action="/mailing" method="post" class="big">
		<input type="email" name="email" placeholder="Your email address" required />
		<button type="submit">Add</button>
	</form>
	
	<p>Alternatively you can follow Comic Rank:</p>
	<ul class="sitelinks">
		<li><a href="https://twitter.com/comicrank"><img src="https://twitter.com/favicon.ico" alt="" /> @ComicRank</a></li>
		<li><a href="https://plus.google.com/u/0/108661948674027877061"><img src="http://plus.google.com/favicon.ico" alt="" /> +Comic Rank</a></li>
	</ul>
</section>

<?php $page->displayInnerLeaderboard(); ?>

<section>
	<header>
		<h1>Looking for comics?</h1>
	</header>
	<p>Due to an overwhelming amount of moderation activity required to keep up with demand Comic Rank's public leaderboards were disabled in September 2012.</p>
	<p>We're working on getting public comic listings back, and <a href="/about.php">many other things</a> too. In the meantime you might like to browse through free webcomics on these fine sites:</p>
	<ul class="sitelinks">
		<li><a href="http://www.comic-rocket.com/"><img src="https://www.comic-rocket.com/favicon.ico" alt="" /> Comic Rocket</a></li>
		<li><a href="http://inkoutbreak.com/"><img src="http://inkoutbreak.com/favicon.ico" alt="" /> inkOUTBREAK</a></li>
	</ul>
</section>

<?php
$page->displayFooter();
