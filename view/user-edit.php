
        <section class="sectionbox">
            <header>
                <h1>Edit Name</h1>
            </header>

            <form method="post" class="big">
                <?=(isset($view['completions']['name'])?'<p style="color: green">'.fmt($view['completions']['name'], 'html').'</p>':'')?>
                <?=(isset($view['errors']['name'])?'<p style="color: red">'.fmt($view['errors']['name'], 'html').'</p>':'')?>
                <input type="text" name="name" value="<?=$view['user']->name('html')?>" required />
                <button type="submit" name="edit">Save Changes</button>
            </form>
        </section>

        <section class="sectionbox">
            <header>
                <h1>Edit Password</h1>
            </header>

            <form method="post" class="big">
                <?=(isset($view['completions']['password'])?'<p style="color: green">'.fmt($view['completions']['password'], 'html').'</p>':'')?>
                <?=(isset($view['errors']['password'])?'<p style="color: red">'.fmt($view['errors']['password'], 'html').'</p>':'')?>
                <input type="password" name="password" placeholder="Current Password" required /><br />
                <?=(isset($view['errors']['newpassword'])?'<p style="color: red">'.fmt($view['errors']['newpassword'], 'html').'</p>':'')?>
                <input type="password" name="newpassword" placeholder="New Password" required /><br />
                <input type="password" name="verifypassword" placeholder="New Password (again)" required /><br />
                <button type="submit" name="edit">Save Changes</button>
            </form>
        </section>
