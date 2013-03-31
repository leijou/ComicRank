
        <?php
        $anonhashes = array();

        $firstpost = array_shift($view['posts']);
        ?>
        <article>
            <div class="sectionbox">
                <header>
                    <h1><?=$view['thread']->title('html')?></h1>
                </header>

                <div class="sectionmain">
                    <img src="http://www.gravatar.com/avatar/<?=$firstpost->anonhash('url')?>?s=80&amp;d=identicon&amp;f=y" style="float: left;" />
                    <div style="margin-left: 100px;">
                        <p><?=nl2br($firstpost->body('html|postlink'))?></p>
                    </div>
                </div>

                <div class="sectionside">
                    <p>ID: <?=$firstpost->id?> [<a href="#addreply">reply</a>]</p>
                    <p><?=$firstpost->added('datetime')->format('H:i d M')?></p>
                </div>
            </div>

            <?php
            foreach ($view['posts'] as $post) {
                ?>
                <article class="sectionbox" id="p<?=$post->id?>">

                    <div class="sectionmain">
                        <img src="http://www.gravatar.com/avatar/<?=$post->anonhash('url')?>?s=80&amp;d=identicon&amp;f=y" style="float: left;" />
                        <div style="margin-left: 100px;">
                            <p><?=nl2br($post->body('html|postlink'))?></p>
                        </div>
                    </div>

                    <div class="sectionside">
                        <p>ID: <?=$post->id?> [<a href="#addreply" onclick="document.getElementById('replybox').value = document.getElementById('replybox').value + '\n&gt;&gt;<?=$post->id?>\n';">reply</a>]</p>
                        <p><?=$post->added('datetime')->format('H:i d M')?></p>
                    </div>

                </article>
                <?php
            }
            ?>
        </article>

        <section class="sectionbox" id="addreply">
            <header>
                <h1>Reply</h1>
            </header>

            <div class="sectionmain">
                <form action="/forum/<?=$firstpost->id('url')?>" method="post">
                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                    <?=(isset($view['errors']['body'])?'<p style="color: red">'.fmt($view['errors']['body'], 'html').'</p>':'')?>
                    <textarea name="body" rows="10" id="replybox" required><?=fmt($view['replybox'], 'html')?></textarea>
                    <button type="submit" name="reply">Reply</button>
                </form>
            </div>

            <div class="sectionside">
                <h2>Replying to this thread</h2>
                <div style="font-size: 12px;">
                    <p>You are replying to the current thread. All posts on the Comic Rank forum are made anonymously but within this thread all your posts will have the same avatar.</p>

                    <ul>
                        <li>There is no formatting, please use plain text.</li>
                    </ul>

                    <p><a href="/forum/about">About the Comic Rank forum</a></p>
                </div>
            </div>
        </section>
