
        <section class="sectionbox">
            <header>
                <h1>Invite user</h1>
            </header>

            <div class="sectionmain">
                <form method="post" class="big">
                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                    <?=(isset($view['errors']['email'])?'<p style="color: red">'.fmt($view['errors']['email'], 'html').'</p>':'')?>
                    <input type="email" name="email" placeholder="Email address" required /><br />
                    <button type="submit" name="invite">Send Invitation</button>
                </form>
            </div>
        </section>
