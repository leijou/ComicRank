
        <section class="sectionbox">
            <header>
                <h1>My Comics</h1>
            </header>

            <?php
            foreach ($view['comics'] as $comic) {
                ?>
                <h2><a href="/comic/<?=$comic->id('url')?>/<?=$comic->title('url')?>"><?=$comic->title('html')?></a></h2>
                <dl>
                    <dt>Readers</dt>
                    <dd><?=$comic->readers('int')?></dd>
                    <dt>Unique viewers</dt>
                    <dd><?=$comic->guests('int')?> in the last 24 hours</dd>
                </dl>
                <a href="/comic/<?=$comic->id('url')?>/stats">Stats</a>
                <?php
            }
            ?>
        </section>

        <section class="sectionbox">
            <header>
                <h1>My Details</h1>
            </header>

            <dl>
                <dt>Name</dt>
                <dd><a href="/user/<?=$view['user']->id('url')?>/<?=$view['user']->name('url')?>"><?=$view['user']->name('html')?></a></dd>
                <dt>Email</dt>
                <dd><?=$view['user']->email('html')?></dd>
            </dl>
            <a href="/user/<?=$view['user']->id('url')?>/edit">Edit</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/logout.php">Logout</a>
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
