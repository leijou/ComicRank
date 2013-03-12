
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
                $prevstat = null;
                foreach ($view['stats'] as $k => $stat) {
                    // If day has been missed out in log flatline until next reading
                    if ( ($prevstat) && ($stat->date('datetime')->diff($prevstat->date('datetime'))->d > 1) ) {
                        $prevday = $stat->date('datetime')->sub(new \DateInterval('P1D'));
                        echo '[new Date('.$prevday->format('Y').', '.($prevday->format('m')-1).', '.$prevday->format('d').'), '.$prevstat->readers('int').', '.$prevstat->guests('int').'],';
                    }
                    $prevstat = $stat;

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

                <div style="float: left; width: 50%; text-align: center;">
                    <h2>Readers</h2>
                    <p style="font-size: 24px;"><?=$view['comic']->readers('int')?></p>
                </div>

                <div style="float: left; width: 50%; text-align: center;">
                    <h2>People today</h2>
                    <p style="font-size: 24px;"><?=$view['comic']->guests('int')?></p>
                    <p style="font-size: 12px; margin-top: -20px;">(Unique over the past 24 hours)</p>
                </div>

                <div id="chart_div" style="width: 100%; height: 300px; clear: left; padding-top: 20px;">
                </div>

            </div>
        </section>
