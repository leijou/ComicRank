
        <section class="sectionbox">
            <header>
                <h1>Log In</h1>
            </header>

            <form action="/login.php" method="post" class="big">
                <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                <?=(isset($view['errors']['auth'])?'<p style="color: red">'.fmt($view['errors']['auth'], 'html').'</p>':'')?>
                <input type="email" name="email" placeholder="Your email address" required /><br />
                <input type="password" name="password" placeholder="Your password" required /><br />
                <button type="submit">Log In</button>
            </form>

            <footer>
                <p>If you're part of the current closed beta and are having trouble logging in please email Steve.</p>
            </footer>
        </section>
