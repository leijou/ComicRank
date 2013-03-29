
        <section class="sectionbox">
            <header>
                <h1>Register</h1>
            </header>

            <div class="sectionmain">
                <form method="post" class="big" autocomplete="off">
                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                    <?=(isset($view['errors']['name'])?'<p style="color: red">'.fmt($view['errors']['name'], 'html').'</p>':'')?>
                    <input type="text" name="name" value="" placeholder="Full Name" required /><br />

                    <input type="email" name="email" value="<?=$view['invitation']->email('html')?>" disabled /><br />

                    <?=(isset($view['errors']['newpassword'])?'<p style="color: red">'.fmt($view['errors']['newpassword'], 'html').'</p>':'')?>
                    <input type="password" name="newpassword" placeholder="Password" required /><br />
                    <input type="password" name="verifypassword" placeholder="Password (again)" required /><br />

                    <button type="submit" name="register">Register</button>
                </form>
            </div>
        </section>
