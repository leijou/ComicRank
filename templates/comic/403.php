
        <section class="sectionbox">
            <header>
                <h1>Not Authorized</h1>
            </header>

            <div class="sectionmain">
                <?php if ($page->getSessionUser()) { ?>
                    <p>Sorry, only the comic owner can see this page.</p>
                <?php } else { ?>
                    <p>Sorry, but I can't let you see that. Please try <a href="/login.php">logging in</a>.</p>
                <?php } ?>
            </div>

            <div class="sectionside" style="height: 350px; background: url(<?=URL_STATIC?>/images/marvinfixesit.png) top left no-repeat">
            </div>

        </section>

