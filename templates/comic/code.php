
    <?php
    if ( ($view['comic']->readers == 0) && ($view['comic']->dailyvisitors == 0) ) {
        ?>
        <section class="sectionbox">
            <header>
                <h1>Your comic has been added!</h1>
            </header>

            <div class="sectionfull">
                <p>Please follow the instructions below to add the Comic Rank button to your site so that we can start tracking your readers. Within a few hours of putting on your site your first visitors will start showing up on your user panel.</p>
            </div>
        </section>
        <?php
    }
    ?>

        <section class="sectionbox">
            <header>
                <h1>Code: <?=$view['comic']->title('html')?></h1>
            </header>

            <div class="sectionfull">
                <p>To track readers you need to place the Comic Rank button on your site. If installed properly it will look like this: <img src="http://stats.comicrank.com/v1/img.jpg" /></p>

                <h2>For your site</h2>
                <p>To track your readers you will need to put the following code in to your site's HTML:</p>
                <textarea style="width: 100%; padding: 10px; margin: 0 -10px; border: none; overflow: auto; height: 330px; color: #060; background: #eee;" readonly><?=$view['comic']->generateFullCode('html')?></textarea>
                <p>Generally you should put the button code on every page of your site in the header, footer, or sidebar templates.</p>
                <p>There are a few rules about how the button can be placed. The button:</p>
                <ul>
                    <li>MUST be placed in a prominent, visible place on your site, but without implication that Comic Rank endorces your website.</li>
                    <li>MUST NOT be cropped, resized, obscured, or otherwise deformed on the page.</li>
                </ul>

                <h2>For your RSS feed</h2>
                <p>If you have an RSS feed and want to track your readers there as well then you can put the following code in it:</p>
                <textarea style="width: 100%; padding: 10px; margin: 0 -10px;  border: none; overflow: auto; height: 60px; color: #060; background: #eee;" readonly><?=$view['comic']->generateBasicCode('html')?></textarea>
                <p>The code must go in every &lt;description&gt; block in the feed, and needs to be within the CDATA scope. If it's not visible within the RSS viewer then it wont be tracking anyone.</p>
            </div>
        </section>
