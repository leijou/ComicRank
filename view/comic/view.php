
        <section class="sectionbox">
            <header>
                <h1><?=$view['comic']->title('html')?></h1>
            </header>
            <p><?=$view['comic']->title('html')?> uses Comic Rank to find out how many people read it. It's a great way to boost ad revenue and stay motivated to keep making comics!</p>

            <h2>Visit</h2>
            <p>You can view the comic here: <a href="<?=$view['comic']->url('html')?>" rel="nofollow"><?=$view['comic']->title('html')?></a><?=($view['comic']->nsfw?' [Warning: NSFW]':'')?></p>

            <?php
            if ($view['comic']->public) {
                ?>
                <h2>Readers</h2>
                <p><?=$view['comic']->title('html')?> has <?=$view['comic']->readers('int')?> readers, and <?=$view['comic']->guests('int')?> uniques int he last 24 hours.</p>
                <?php
            }
            ?>
        </section>
