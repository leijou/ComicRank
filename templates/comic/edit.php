
        <section class="sectionbox">
            <header>
                <h1>Edit Comic</h1>
            </header>

            <div class="sectionmain">
                <form method="post" class="big">
                    <?=(isset($view['completions']['comic'])?'<p style="color: green">'.fmt($view['completions']['comic'], 'html').'</p>':'')?>

                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                    <?=(isset($view['errors']['title'])?'<p style="color: red">'.fmt($view['errors']['title'], 'html').'</p>':'')?>
                    <input type="text" name="title" value="<?=$view['comic']->title('html')?>" placeholder="Comic Title" required /><br />

                    <?=(isset($view['errors']['url'])?'<p style="color: red">'.fmt($view['errors']['url'], 'html').'</p>':'')?>
                    <input type="url" name="url" value="<?=$view['comic']->url('html')?>" placeholder="Comic URL (http://example.com)" onblur="if (this.value && this.value.indexOf('://')<0) this.value='http://'+this.value;" required /><br />

                    <button type="submit" name="edit">Save Changes</button>
                </form>
            </div>
        </section>

        <section class="sectionbox">
            <header>
                <h1>Link to inkOUTBREAK</h1>
            </header>

            <div class="sectionmain">
                <form method="post" class="big">
                    <?=(isset($view['completions']['inkid'])?'<p style="color: green">'.fmt($view['completions']['inkid'], 'html').'</p>':'')?>

                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                    <?=(isset($view['errors']['inkid'])?'<p style="color: red">'.fmt($view['errors']['inkid'], 'html').'</p>':'')?>
                    <input type="text" name="inkid" value="<?=$view['comic']->inkid('html')?>" placeholder="InkOUTBREAK ID" /><br />
                    <p>by providing your inkOUTBREAK ID you agree to share your reader count publicly on inkOUTBREAK.com</p>

                    <button type="submit" name="edit">Save Changes</button>
                </form>
            </div>

            <div class="sectionside" style="background: transparent url(http://s.gravatar.com/avatar/1ed243cf25ffe995d128e89e358582dd?s=150&amp;r=g) top center no-repeat;">
            </div>

        </section>
