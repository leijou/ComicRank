<?php
namespace ComicRank;
require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;

if (!isset($_GET['id'])) $page->exitNotFound();
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) $page->exitNotFound();

$page->canonical = '/comic/'.$comic->id('url').'/'.$comic->title('url');

// Redirect incorrect / out of date comic title links to canonical URL
if ( (!isset($_GET['title'])) || ($_GET['title'] != $comic->title) ) {
	$page->exitRedirectTemporary($page->canonical);
}

$page->title = $comic->title;

$page->displayHeader();
?>

<section class="sectionbox">
	<header>
		<h1><?=$comic->title('html')?></h1>
	</header>
	<p><?=$comic->title('html')?> uses Comic Rank to find out how many people read it. It's a great way to boost ad revenue and stay motivated to keep making comics!</p>
	
	<h2>Visit</h2>
	<p>You can view the comic here: <a href="<?=$comic->url('html')?>" rel="nofollow"><?=$comic->title('html')?></a><?=($comic->nsfw?' [Warning: NSFW]':'')?></p>
	
	<?php
	if ($comic->public) {
		?>
		<h2>Readers</h2>
		<p><?=$comic->title('html')?> has <?=$comic->readers('int')?> readers, and <?=$comic->guests('int')?> other people have visited the site recently.</p>
		<?php
	}
	?>
</section>

<?php
$page->displayInnerLeaderboard();

$page->displayFooter();
