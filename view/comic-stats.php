
        <script>
          google.load('visualization', '1', {'packages':['corechart']});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Readers');
            data.addColumn('number', 'Unique Visitors');
            data.addRows([
                <?php
                foreach ($view['stats'] as $k => $stat) {
                    echo '[new Date('.$stat->date('Y').', '.($stat->date('m')-1).', '.$stat->date('d').'), '.$stat->readers('int').', '.$stat->guests('int').']';
                    if ($k < count($view['stats'])-1) echo ',';
                }
                ?>
            ]);

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, {legend: {position: 'top', alignment: 'end'}, chartArea: {width: '100%'}, hAxis: {format:'MMM d', viewWindowMode: 'maximized'}, vAxis: {textPosition: 'in'}});
          }
        </script>

        <section class="sectionbox">
            <header>
                <h1>Stats: <?=$view['comic']->title('html')?></h1>
            </header>

            <div class="contentwrap">
                <div id="chart_div" style="width: 100%; height: 300px;">
                </div>

                <div style="float: left; width: 50%; text-align: center;">
                    <h2>Readers</h2>
                    <p style="font-size: 24px;"><?=$view['comic']->readers('int')?></p>
                </div>

                <div style="float: left; width: 50%; text-align: center;">
                    <h2>Guests</h2>
                    <p style="font-size: 24px;"><?=$view['comic']->guests('int')?></p>
                    <p style="font-size: 12px; margin-top: -20px;">(Unique visitors over the past 24 hours)</p>
                </div>

            </div>
        </section>
