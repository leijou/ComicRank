
        <section class="sectionbox">
            <header>
                <h1>Add a Comic</h1>
            </header>

            <div class="sectionmain">

                <form action="" method="post" class="big">
                    <input type="hidden" name="csrf" value="<?=$page->getRFPKey()?>" />
                    <?=(isset($view['errors']['csrf'])?'<p style="color: red">'.fmt($view['errors']['csrf'], 'html').'</p>':'')?>

                    <h2>Basic Info</h2>
                    <?=(isset($view['errors']['title'])?'<p style="color: red">'.fmt($view['errors']['title'], 'html').'</p>':'')?>
                    <input type="text" name="title" placeholder="Comic Title" required /><br />
                    <?=(isset($view['errors']['url'])?'<p style="color: red">'.fmt($view['errors']['url'], 'html').'</p>':'')?>
                    <input type="url" name="url" placeholder="Comic URL (http://example.com)" onblur="if (this.value && this.value.indexOf('://')<0) this.value='http://'+this.value;" required /><br />

                    <h2>I hereby swear</h2>
                    <p style="padding-left: 22px;"><input type="checkbox" style="float: left; margin-left: -22px;" required /> I want to track readers on a site (or one section of a bigger site) where the primary content is a single webcomic series.</p>
                    <p style="padding-left: 22px;"><input type="checkbox" style="float: left; margin-left: -22px;" required /> My comic updates at least once a week and my readers come to the site to see the latest updates.</p>
                    <p style="padding-left: 22px;"><input type="checkbox" style="float: left; margin-left: -22px;" required /> To track readers I will put a Comic Rank button on my site. It will look like this: <img src="http://stats.comicrank.com/v1/img.jpg" /> and will display in a visible section of my site without being obscured, cropped, or resized.</p>
                    <p style="padding-left: 22px;"><input type="checkbox" style="float: left; margin-left: -22px;" required /> And I think all the other <a href="/terms">terms of service</a> are just peachy as well.</p>

                    <button>Yep, yep, yep</button>
                </form>
            </div>
        </section>
