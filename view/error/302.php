
        <section class="sectionbox">
            <header>
                <h1>Over here</h1>
            </header>

            <div class="contentwrap">
                <p>You're lagging behind! The page you want is here: <a href="<?=fmt($page->headers['Location'], 'html')?>"><?=fmt($page->headers['Location'], 'html')?></a></p>
            </div>
        </section>
