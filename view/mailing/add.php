
        <section class="sectionbox">
            <header>
                <h1>Mailing list</h1>
            </header>

            <div class="contentwrap">
                <?php
                if ($view['mailing']) {
                    ?>
                    <p>Thanks, a confirmation email has been sent to <?=$view['mailing']->email('html')?>.</p>
                    <p>If you can't find it within a few minutes please check your spam folder, we'll send the mail from noreply@comicrank.com.</p>
                    <?php
                } else {
                    ?>
                    <form action="/mailing" method="post" class="big">
                        <?=($view['mailadderror']?'<p style="color: red">'.fmt($view['mailadderror'], 'html').'</p>':'')?>
                        <input type="email" name="email" placeholder="Your email address"<?=(isset($_POST['email'])?' value="'.fmt($_POST['email'], 'html').'"':'')?> required />
                        <button type="submit">Add</button>
                    </form>
                    <?php
                }
                ?>
            </div>
        </section>
