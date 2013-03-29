
        <p style="color: #06a; font-size: 19px; line-height: 1.8em; margin: 60px 40px 40px; text-align: center;">Comic Rank tracks the readers of webcomics and tells you how many real people frequently read your comic. No vote-begging required.</p>

        <section class="sectionbox">
            <header>
                <h1>Closed Beta</h1>
            </header>

            <div class="sectionmain">
                <p>Comic Rank is currently in a closed beta, and can be used by invitation only. If you'd like to be informed of updates, and get invitations as soon as possible, then please sign up here:</p>

                <form action="/mailing/add" method="post" class="big">
                    <input type="email" name="email" placeholder="Your email address" required />
                    <button type="submit">Add</button>
                </form>
            </div>

            <div class="sectionside">
                <h2>Log In:</h2>
                <form action="/user/login" method="post">
                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <input type="email" name="email" placeholder="Email" required /><br />
                    <input type="password" name="password" placeholder="Password" required /><br />
                    <button type="submit">Log in</button>
                </form>
            </div>

        </section>

        <section class="sectionbox">
            <header>
                <h1>What happened?</h1>
            </header>

            <div class="sectionmain">
                <p>Due to an overwhelming amount of moderation activity required to keep up with demand Comic Rank's public leaderboards were disabled in September 2012.</p>
                <p>We're working on getting public comic listings back, and many other things too.</p>
            </div>

            <div class="sectionside">
                <h2>Follow Comic Rank:</h2>
                <ul class="nostyle">
                    <li><a href="https://twitter.com/comicrank"><img src="<?=URL_STATIC?>/images/twitter.com.ico" alt="" style="width: 16px; height: 16px;" /> @ComicRank</a></li>
                    <li><a href="https://plus.google.com/u/0/108661948674027877061" rel="publisher"><img src="<?=URL_STATIC?>/images/plus.google.com.ico" alt="" style="width: 16px; height: 16px;" /> +Comic Rank</a></li>
                </ul>
            </div>

        </section>


        <section class="sectionbox">
            <header>
                <h1>What we do</h1>
            </header>

            <div class="sectionmain">
                <p>Comic Rank tracks people who visit Webcomic sites, analyzes their page views and works out whether they frequently read the comic. In other words Comic Rank totals up the number of regular readers of Webcomics, rather than just pageviews.</p>
                <p>This is a great way to boost ad revenue, track campaigns, and stay motivated to keep making comics! A lot of webcomic readers are silent most of the time but we're still there loving your work and supporting your comic.</p>

                <h2 style="position: absolute; z-index: 99;">TL;DR: We make graphs that look like this:</h2>
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
                        [new Date(2013, 1, 04), 2, 77, 2],[new Date(2013, 1, 05), 2, 61, 1],[new Date(2013, 1, 06), 3, 61, 2],[new Date(2013, 1, 07), 4, 67, 3],[new Date(2013, 1, 08), 6, 82, 4],[new Date(2013, 1, 09), 6, 74, 5],[new Date(2013, 1, 10), 7, 57, 5],[new Date(2013, 1, 11), 9, 80, 3],[new Date(2013, 1, 12), 9, 58, 6],[new Date(2013, 1, 13), 12, 61, 10],[new Date(2013, 1, 14), 11, 43, 8],[new Date(2013, 1, 15), 13, 46, 10],[new Date(2013, 1, 16), 15, 50, 6],[new Date(2013, 1, 17), 15, 52, 6],[new Date(2013, 1, 18), 16, 54, 7],[new Date(2013, 1, 19), 18, 57, 12],[new Date(2013, 1, 20), 20, 49, 14],[new Date(2013, 1, 21), 22, 53, 15],[new Date(2013, 1, 22), 22, 56, 17],[new Date(2013, 1, 23), 23, 47, 13],[new Date(2013, 1, 24), 24, 43, 16],[new Date(2013, 1, 25), 27, 50, 20],[new Date(2013, 1, 26), 30, 36, 11],[new Date(2013, 1, 27), 30, 52, 14],[new Date(2013, 1, 28), 31, 41, 15],[new Date(2013, 2, 01), 30, 36, 14],[new Date(2013, 2, 02), 30, 43, 15],[new Date(2013, 2, 03), 30, 52, 18],[new Date(2013, 2, 04), 31, 58, 19],[new Date(2013, 2, 05), 35, 40, 10],[new Date(2013, 2, 06), 35, 59, 20]            ]);

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
                <div id="chart_div" style="width: 100%; height: 300px;"></div>
            </div>

            <div class="sectionside" style="height: 500px; background: url(<?=URL_STATIC?>/images/marvinsellsit.png) top left no-repeat">
            </div>

        </section>

        <section class="sectionbox">
            <header>
                <h1>What will happen</h1>
            </header>

            <div class="sectionmain">
                <p>We'll always have more ideas than time, so the new site was launched with minimal features so it can evolve over time. Most importantly we want to get back to a stage where we can offer the service free to everyone!</p>

                <h2>Plans &amp; Ideas</h2>
                <ul>
                    <li><del>Open source ComicRank.com so anyone can contribute</del> <a href="https://github.com/leijou/ComicRank">Done</a>!</li>
                    <li>Small, centralized forum for discussing Comic Rank</li>
                    <li>Free access for all reasonably sized webcomics</li>
                    <li>Stats history browse / download</li>
                    <li>Public leaderboards (community moderated)</li>
                    <li>Reader-supplied tagging of comics</li>
                    <li>More customization and promotion tools</li>
                </ul>
            </div>

            <div class="sectionside" style="height: 300px; background: url(<?=URL_STATIC?>/images/marvinchills.png) bottom right no-repeat">
            </div>

        </section>

        <section class="sectionbox">
            <header>
                <h1>Get in touch</h1>
            </header>

            <div class="sectionfull" style="text-align: center; font-size: 40px;">
                <p style="margin-bottom: 70px;"><a href="https://twitter.com/comicrank">@ComicRank</a></p>
                <p style="margin-bottom: 70px;"><a href="mailto:steve@comicrank.com">steve@comicrank.com</a></p>
            </div>
        </section>
