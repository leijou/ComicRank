<!doctype html>
<html>
<head>
    <title><?=htmlspecialchars($page->title)?></title>
    <link rel="publisher" href="https://plus.google.com/108661948674027877061" />
    <?php
        if ($page->author) echo '<link rel="author" href="'.htmlspecialchars($page->author).'" />';
        if ($page->canonical) echo '<link rel="canonical" href="'.URL_SITE.htmlspecialchars($page->canonical).'" />';
        foreach ($page->css as $css) echo '<link rel="stylesheet" href="'.htmlspecialchars($css).'" />';
    ?>

    <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-367286-6']);
        _gaq.push(['_trackPageview']);
        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
</head>
<body>
    <header id="headband">
        <div>
            <a href="/"><img src="<?=URL_STATIC?>/images/heading.png" alt=""></a>
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about.php">About</a></li>
                    <li><a href="/contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="wrap">
        <h1>Comic Rank</h1>
