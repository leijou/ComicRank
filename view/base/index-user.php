
    <?php
    if (count($view['comics'])) {
        ?>
        <section class="sectionbox">
            <header>
                <h1>My Comics</h1>
            </header>

            <div class="contentwrap">
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
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="/comic/<?=$comic->id('url')?>/code">Code</a>
                    <?php
                }
                ?>

                <h2>Add Comic</h2>
                <a href="/comic/add">Add Comic</a>
            </div>
        </section>
        <?php
    } else {
        ?>
        <section class="sectionbox">
            <header>
                <h1>You're in! Good job soldier</h1>
            </header>

            <div class="contentwrap">
                <p>Now that you've infiltrated the elusive Comic Rank it would be prudent of you to add your webcomic.</p>
                <p>Comic Rank's not much to look at the moment, but if you keep an eye out for the links you'll be able to get around. Steve's constantly developing the site and you can see what's going on in the <a href="/about.php">About page</a>.</p>

                <a href="/comic/add">Add Comic</a> &nbsp;&nbsp;&nbsp;&nbsp; &lt;-- There it is! Quick, click it!
            </div>
        </section>
        <?php
    }
    ?>

        <section class="sectionbox">
            <header>
                <h1>My Details</h1>
            </header>

            <div class="contentwrap">
                <dl>
                    <dt>Name</dt>
                    <dd><a href="/user/<?=$view['user']->id('url')?>/<?=$view['user']->name('url')?>"><?=$view['user']->name('html')?></a></dd>
                    <dt>Email</dt>
                    <dd><?=$view['user']->email('html')?></dd>
                </dl>
                <a href="/user/<?=$view['user']->id('url')?>/edit">Edit</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/logout.php">Logout</a>
            </div>
        </section>
