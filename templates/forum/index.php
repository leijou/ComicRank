
        <p style="color: #06a; font-size: 19px; line-height: 1.8em; margin: 60px 40px 40px; text-align: center;"><a href="/forum/about"><strong>STOP! Spiel time:</strong> This forum is rather different from the norm, please read!</a></p>

        <section class="sectionbox">
            <header>
                <h1>Current Threads</h1>
            </header>

            <div class="sectionfull">
                <?php
                foreach ($view['threads'] as $thread) {
                    $post = \ComicRank\Model\Post::getFromId($thread->firstpost);
                    ?>
                        <a href="/forum/<?=$thread->firstpost?>">
                            <div style="float: left; width: 46%; margin: 10px 1%; padding: 1px 1%; height: 160px; overflow: hidden; background: #E4EDFC; position: relative;">
                                <div style="float: right; width: 25%; text-align: center;">
                                    <h3>Posts</h3>
                                    <span style="font-size: 30px;"><?=$thread->postcount?></span><br />
                                    <br />
                                    Last post<br />
                                    <span style="font-size: 12px;"><?=$thread->updated('datetime')->format('H:i d M')?></span>
                                </div>
                                <div style="width: 70%;">
                                    <h2 style="margin: 10px 0;"><?=$thread->title('html')?></h2>
                                    <p style="font-size: 12px; line-height: 14px; color: #668;"><?=nl2br(($post?$post->body('html'):''))?></p>
                                </div>
                                <div style="position: absolute; left: 0; bottom: 0; right: 30%; height: 25px; background: -webkit-linear-gradient(top, rgba(228, 237, 252 ,0) 0%,rgba(228, 237, 252, 1) 90%);"></div>
                            </div>
                        </a>
                    <?php
                }
                ?>
            </div>
        </section>

        <section class="sectionbox">
            <header>
                <h1>New Thread</h1>
            </header>

            <div class="sectionmain">
                <form action="/forum" method="post">
                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                    <?=(isset($view['errors']['title'])?'<p style="color: red">'.fmt($view['errors']['title'], 'html').'</p>':'')?>
                    <input type="text" name="title" placeholder="Thread title" maxlength="100" required />
                    <?=(isset($view['errors']['body'])?'<p style="color: red">'.fmt($view['errors']['body'], 'html').'</p>':'')?>
                    <textarea name="body" placeholder="Message" rows="15" required><?=fmt($view['postbox'], 'html')?></textarea>
                    <button type="submit" name="addthread">Post new thread</button>
                </form>
            </div>

            <div class="sectionside">
                <h2>Creating a new thread</h2>
                <div style="font-size: 12px;">
                    <p>You are creating a new thread for people to reply to. All posts on the Comic Rank forum are made anonymously.</p>

                    <ul>
                        <li>Include a descriptive title that people will remember.</li>
                        <li>There is no formatting, please use plain text.</li>
                        <li><strong>Don't be shy!</strong> Got a quick question? Make a thread. We don't mind lots of threads.</li>
                    </ul>

                    <p><a href="/forum/about">About the Comic Rank forum</a></p>
                </div>
            </div>
        </section>
