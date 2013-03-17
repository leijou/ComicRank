
        <section class="sectionbox">
            <header>
                <h1><?=$view['comic']->title('html')?></h1>
            </header>

            <h2>Visit</h2>
            <p>You can view the comic here: <a href="<?=$view['comic']->url('html')?>" rel="nofollow"><?=$view['comic']->title('html')?></a><?=($view['comic']->nsfw?' [Warning: NSFW]':'')?></p>

            <?php
            if ($view['comic']->public) {
                ?>
                <h2>Readers</h2>
                <p><?=$view['comic']->title('html')?> has <?=$view['comic']->readers('int')?> readers.</p>
                <?php
            }
            ?>
        </section>
