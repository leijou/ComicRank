<?php
namespace ComicRank;
require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;
$page->canonical = '/mailing';
$page->title = 'Comic Rank mailing list';

$page->displayHeader();
?>

<section>
	<header>
		<h1>Mailing list</h1>
	</header>
	
	<?php
	$added = false;
	if (isset($_POST['email'])) {
		try {
			$mailing = Model\Mailing::getFromEmail($_POST['email']);
			if (!$mailing) {
				$mailing = new Model\Mailing;
				$mailing->email = $_POST['email'];
				$mailing->insert();
			}
			
			mail($mailing->email, 'Comic Rank mailing', 
	"Thanks for supporting Comic Rank. We'll send an email to ".$mailing->email." again when there is something to say.

	- Steve H

	Twitter: @comicrank
	Google+: +Comic Rank


	Unsubscribe: ".URL_SITE."/mailing/".$mailing->token('url'), 'From: Steve H <steve@comicrank.com>');
			
			echo '<p>Thanks, a confirmation email has been sent to '.$mailing->email('html').'.</p>';
			$added = true;
		} catch (\Exception $e) {
			echo '<p>Failed to subscribe: '.fmt($e->getMessage(), 'html').'</p>';
		}
	}

	if (!$added) {
		?>
		<form action="/mailing" method="post" class="big">
			<input type="email" name="email" placeholder="Your email address" required />
			<button type="submit">Add</button>
		</form>
		<?php
	}
	?>
</section>

<?php
$page->displayFooter();
