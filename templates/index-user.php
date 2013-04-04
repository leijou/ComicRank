    <?php
    if (!count($view['comics'])) {
        ?>
        <section class="sectionbox">
            <header>
                <h1>You're in! Good job soldier</h1>
            </header>

            <div class="sectionfull">
                <p>Now that you've infiltrated Comic Rank it would be prudent of you to add your webcomic.</p>
                <p>Comic Rank's not much to look at the moment, but if you keep an eye out for the links you'll be able to get around. Steve's constantly developing the site and you should hopefully see things improving over the coming months.</p>
            </div>

        </section>
        <?php
    }
    ?>

        <section class="sectionbox">
            <header>
                <h1>My Details</h1>
            </header>

            <div class="sectionmain">
                <p>
                    <a href="/user/<?=$view['user']->id('url')?>/<?=$view['user']->name('url')?>"><?=$view['user']->name('html')?></a>
                    &lt;<?=$view['user']->email('html')?>&gt;
                </p>
            </div>

            <div class="sectionside">
                <h2>Check Yo Self</h2>
                <nav>
                    <ul class="nostyle">
                        <li><a href="/comic/add">Add Comic</a></li>
                        <li><a href="/user/<?=$view['user']->id('url')?>/edit">Edit Account</a></li>
                        <li><a href="/user/logout">Logout</a></li>
                    </ul>
                </nav>
            </div>

        </section>

        <section class="sectionbox">
            <header>
                <h1>My Posts</h1>
            </header>

            <div class="sectionmain">
                <ol class="nostyle">
                <?php
                foreach ($view['posts'] as $post) {
                    ?>
                    <li>
                        <a href="/forum/<?=fmt($post['firstpost'], 'url')?>#p<?=fmt($post['id'], 'url')?>"><?=fmt($post['title'], 'html')?></a><br />
                        <?=fmt($post['since'], 'html')?> repl<?=($post['since']==1?'y':'ies')?> since
                    </li>
                    <?php
                }
                ?>
                </ol>
            </div>

            <div class="sectionside">
                <h2>The Forum</h2>
                <nav>
                    <ul class="nostyle">
                        <li><a href="/forum">Visit the forum</a></li>
                        <li><a href="/forum/about">Understand the forum</a></li>
                    </ul>
                </nav>
            </div>

        </section>
