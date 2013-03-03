
        <div style="margin: 10px 0; padding: 1px 80px; color: #06a; font-size: 21px; line-height: 1.5em;">
            <p>Comic Rank provides a service which tracks the readers of webcomics and tells you how many real people frequently read your comic. No vote-begging required.</p>
        </div>

        <section class="sectionbox">
            <header>
                <h1>Closed Beta</h1>
            </header>

            <div class="section_grid">
                <div class="twothirds">
                    <p>Comic Rank is currently in a closed beta, and can be used by invitation only. If you'd like to be informed of updates, and get invitations as soon as possible, then please sign up here:</p>

                    <form action="/mailing" method="post" class="big">
                        <input type="email" name="email" placeholder="Your email address" required />
                        <button type="submit">Add</button>
                    </form>
                </div>
                <div class="third">
                    <h2 class="small">Follow Comic Rank:</h2>
                    <ul class="transparent">
                        <li><a href="https://twitter.com/comicrank"><img src="<?=URL_STATIC?>/images/twitter.com.ico" alt="" style="width: 16px; height: 16px;" /> @ComicRank</a></li>
                        <li><a href="https://plus.google.com/u/0/108661948674027877061"><img src="<?=URL_STATIC?>/images/plus.google.com.ico" alt="" style="width: 16px; height: 16px;" /> +Comic Rank</a></li>
                    </ul>

                </div>
            </div>

            <footer>
                <p>Already in on the action? <a href="/login.php">Log In</a></p>
            </footer>
        </section>

        <?php $page->display('innerleaderboard'); ?>

        <section class="sectionbox">
            <header>
                <h1>Looking for comics?</h1>
            </header>

            <div class="section_grid">
                <div class="twothirds">
                    <p>Due to an overwhelming amount of moderation activity required to keep up with demand Comic Rank's public leaderboards were disabled in September 2012.</p>
                    <p>We're working on getting public comic listings back, and <a href="/about.php">many other things</a> too.</p>
                </div>
                <div class="third">
                    <p>In the meantime you might like to browse through free webcomics on these fine sites:</p>
                    <ul class="transparent">
                        <li><a href="http://www.comic-rocket.com/"><img src="<?=URL_STATIC?>/images/comic-rocket.com.ico" alt="" style="width: 16px; height: 16px;" /> Comic Rocket</a></li>
                        <li><a href="http://inkoutbreak.com/"><img src="<?=URL_STATIC?>/images/inkoutbreak.com.ico" alt="" style="width: 16px; height: 16px;" /> inkOUTBREAK</a></li>
                    </ul>
                </div>
            </div>
        </section>
