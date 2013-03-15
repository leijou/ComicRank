
        <section class="sectionbox">
            <header>
                <h1>Not Authorized</h1>
            </header>

            <div class="contentwrap">
                <?php if ($page->getUser()) { ?>
                    <p>Sorry, only the comic owner can see this page.</p>
                <?php } else { ?>
                    <p>Sorry, but I can't let you see that. Please try <a href="/login.php">logging in</a>.</p>
                <?php } ?>
            </div>
        </section>

