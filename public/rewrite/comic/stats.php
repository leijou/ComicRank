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
    data.addRows([
    	<?php
    	foreach ($stats as $k => $stat) {
    		echo '[new Date('.$stat->date('Y').', '.($stat->date('m')-1).', '.$stat->date('d').'), '.$stat->readers('int').']';
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
		</div>
	</div>
	
	<footer>
		<p>A maximum of 9 weeks history can be displayed here.</p>
	</footer>
</section>

<?php
$page->displayFooter();
