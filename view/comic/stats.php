
        <script>
          google.load('visualization', '1', {'packages':['corechart']});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Readers');
            data.addColumn('number', 'Unique visitors');
            data.addColumn('number', 'Visitors which were readers');
            data.addRows([
                <?php
                $prevstat = null;
                foreach ($view['stats'] as $k => $stat) {
                    // If day has been missed out in log flatline until next reading
                    if ( ($prevstat) && ($stat->date('datetime')->diff($prevstat->date('datetime'))->d > 1) ) {
                        $prevday = $stat->date('datetime')->sub(new \DateInterval('P1D'));
                        echo '[new Date('.$prevday->format('Y').', '.($prevday->format('m')-1).', '.$prevday->format('d').'), '.$prevstat->readers('int').', '.$prevstat->dailyvisitors('int').', '.$prevstat->dailyreaders('int').'],';
                    }
                    $prevstat = $stat;

                    echo '[new Date('.$stat->date('Y').', '.($stat->date('m')-1).', '.$stat->date('d').'), '.$stat->readers('int').', '.$stat->dailyvisitors('int').', '.$stat->dailyreaders('int').']';
                    if ($k < count($view['stats'])-1) echo ',';
                }
                ?>
            ]);

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, {
                chartArea: {width: '100%'},
                hAxis: {format:'MMM d', viewWindowMode: 'maximized'},
                vAxis: {textPosition: 'in'},
                seriesType: "area",
                series: {
                    0: {type: "line", lineWidth: 2},
                    1: {lineWidth: 0},
                    2: {lineWidth: 0}
                }
            });
          }
        </script>

        <section class="sectionbox">
            <header>
                <h1>Stats: <?=$view['comic']->title('html')?></h1>
            </header>

            <div class="contentwrap">

                <div style="float: left; width: 33.33%; text-align: center; border-bottom: solid 5px #36c;">
                    <h2>Readers</h2>
                    <p style="font-size: 24px;"><?=$view['comic']->readers('int')?></p>
                    <p style="font-size: 12px; margin-top: -10px;">Unique people who regularly read your comic</p>
                </div>

                <div style="float: left; width: 33.33%; text-align: center; border-bottom: solid 5px #dc3912;">
                    <h2>Visitors today</h2>
                    <p style="font-size: 24px;"><?=$view['comic']->dailyvisitors('int')?></p>
                    <p style="font-size: 12px; margin-top: -10px;">Unique visitors over the past 24 hours</p>
                </div>

                <div style="float: left; width: 33.33%; text-align: center; border-bottom: solid 5px #f90;">
                    <h2>Readers today</h2>
                    <p style="font-size: 24px;"><?=$view['comic']->dailyreaders('int')?></p>
                    <p style="font-size: 12px; margin-top: -10px;">Readers who have visited over the past 24 hours</p>
                </div>

                <div id="chart_div" style="width: 100%; height: 300px; clear: left;">
                </div>

            </div>
        </section>
