
        <section class="sectionbox">
            <header>
                <h1>Mailing options</h1>
            </header>

            <div class="sectionmain">
                <?php
                if ($view['mailing']) {
                    ?>
                    <p>To unsubscribe from future updates to Comic Rank click below.</p>

                    <form method="post" action="<?=fmt($page->links['canonical'], 'html')?>">
                        <button type="submit" name="unsubscribe">Unsubscribe</button>
                    </form>
                    <?php
                } else {
                    ?>
                    <p>You have been unsubscribed from future emails about updates to Comic Rank.</p>
                    <?php
                }
                ?>
            </div>

            <div class="sectionside" style="height: 350px; background: url(<?=URL_STATIC?>/images/marvinfixesit.png) top left no-repeat">
            </div>

        </section>
