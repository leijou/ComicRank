<?php
namespace ComicRank;
require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;

if (!isset($_GET['token'])) $page->exitNotFound();
$mailing = Model\Mailing::getFromToken($_GET['token']);
if (!$mailing) $page->exitNotFound();

$page->canonical = '/mailing/'.$mailing->token('url');
$page->title = 'Mailing options';

$page->displayHeader();
?>

<section>
	<header>
		<h1>Mailing options</h1>
	</header>
	
	<?php
	if (isset($_POST['unsubscribe'])) {
		$mailing->delete();
		?>
		<p>You have been unsubscribed from future updates to Comic Rank.</p>
		<?php
	} else {
		?>
		<p>To unsubscribe from future updates to Comic Rank click below.</p>
		
		<form method="post">
			<button type="submit" name="unsubscribe" value="1">Unsubscribe</button>
		</form>
		<?php
	}
	?>
</section>

<?php
$page->displayFooter();
