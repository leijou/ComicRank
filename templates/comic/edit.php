
        <section class="sectionbox">
            <header>
                <h1>Edit Comic</h1>
            </header>

            <div class="sectionmain">
                <form method="post" class="big">
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
