<?php
namespace ComicRank;
require_once(__DIR__.'/../../../core.php');

$page = new View\HTML;

if (!isset($_GET['id'])) $page->exitNotFound();
$comic = Model\Comic::getFromId($_GET['id']);
if (!$comic) $page->exitNotFound();

$page->canonical = '/comic/'.$comic->id('url').'/stats';

$page->title = 'Stats: '.$comic->title;

if ( (!isset($_POST['accesscode'])) || (trim(strtoupper($_POST['accesscode'])) !== $comic->accesscode) ) {
	$page->statuscode = 403;
	$page->displayHeader();
	?>
	
	<section class="sectionbox">
		<header>
			<h1>Access Code</h1>
		</header>
		
		<form action="<?=$page->canonical?>" method="post" class="big">
			<input type="text" name="accesscode" placeholder="Access Code" required />
			<button type="submit">Login</button>
		</form>
	</section>
	
	<?php
	$page->displayFooter();
	exit;
}

$page->displayHeader();

$stats = Model\ComicStats::getFromSQL('
	SELECT * FROM comicstats
	WHERE `comic` = :comic AND
		`date` >= (UTC_DATE() - INTERVAL 9 WEEK)
	ORDER BY `date` ASC', array(':comic'=>$comic->id));
?>

<script type='text/javascript' src='http://www.google.com/jsapi'></script>
<script type='text/javascript'>
  google.load('visualization', '1', {'packages':['corechart']});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Date');
    data.addColumn('number', 'Readers');
    data.addColumn('number', 'Unique Visitors');
    data.addRows([
    	<?php
    	foreach ($stats as $k => $stat) {
    		echo '[new Date('.$stat->date('Y').', '.($stat->date('m')-1).', '.$stat->date('d').'), '.$stat->readers('int').', '.$stat->guests('int').']';
    		if ($k < count($stats)-1) echo ',';
    	}
    	?>
    ]);

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, {legend: {position: 'top', alignment: 'end'}, chartArea: {width: '100%'}, hAxis: {format:'MMM d', viewWindowMode: 'maximized'}, vAxis: {textPosition: 'in'}});
  }
</script>

<section class="sectionbox">
	<header>
		<h1>Stats: <?=$comic->title('html')?></h1>
	</header>
	
	<div class="section_grid">
		<div class="twothirds">
			<div id="chart_div" style="width: 100%; height: 300px;">
			</div>
		</div>
		<div class="third">
			<h2 style="text-align: center;">Readers</h2>
			<p style="font-size: 24px; text-align: center;"><?=$comic->readers('int')?></p>
			
			<h2 style="text-align: center;">Guests</h2>
			<p style="font-size: 24px; text-align: center;"><?=$comic->guests('int')?></p>
			<p style="font-size: 12px; text-align: center; margin-top: -20px;">(Unique visitors over the past 24 hours)</p>
		</div>
	</div>
	
	<footer>
		<p>A maximum of 9 weeks history can be displayed here.</p>
	</footer>
</section>

<section class="sectionbox">
	<header>
		<h1>Code</h1>
	</header>
	
	<p>To track readers you need to place the Comic Rank button on your site. If installed properly it will look like this: <img src="http://stats.comicrank.com/v1/img.jpg" /></p>
	
	<h2>For your site</h2>
	<p>To track your readers you will need to put the following code in to your site's HTML:</p>
	<textarea style="width: 100%; padding: 10px; margin: 0 -10px; border: none; overflow: auto; height: 330px; color: #060; background: #eee;" readonly><?=$comic->generateFullCode('html')?></textarea>
	<p>Generally you should put the button code on every page of your site in the header, footer, or sidebar templates.</p>
	<p>There are a few rules about how the button can be placed. The button:</p>
	<ul>
		<li>MUST be placed in a prominent, visible place on your site, but without implication that Comic Rank endorces your website.</li>
		<li>MUST NOT be cropped, resized, obscured, or otherwise deformed on the page.</li>
	</ul>
	
	<h2>For your RSS feed</h2>
	<p>If you have an RSS feed and want to track your readers there as well then you can put the following code in it:</p>
	<textarea style="width: 100%; padding: 10px; margin: 0 -10px;  border: none; overflow: auto; height: 60px; color: #060; background: #eee;" readonly><?=$comic->generateBasicCode('html')?></textarea>
	<p>The code must go in every &lt;description&gt; block in the feed, and needs to be within the CDATA scope. If it's not visible within the RSS viewer then it wont be tracking anyone.</p>
</section>

<?php
$page->displayFooter();
