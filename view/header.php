<!doctype html>
<html>
<head>
    <title><?=htmlspecialchars($page->title)?></title>
    <link rel="publisher" href="https://plus.google.com/108661948674027877061" />

    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1" />
    <?php
    if ($page->author) echo '<link rel="author" href="'.htmlspecialchars($page->author).'" />'."\n    ";
    if ($page->canonical) echo '<link rel="canonical" href="'.URL_SITE.htmlspecialchars($page->canonical).'" />'."\n    ";
    foreach ($page->css as $css) echo '<link rel="stylesheet" href="'.htmlspecialchars($css).'" />'."\n    ";
    foreach ($page->js as $js) echo '<script src="'.htmlspecialchars($js).'"></script>'."\n    ";
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
    <header id="siteheader">
        <div class="contentwrap">
            <a href="/" id="siteheaderlink"><img src="<?=URL_STATIC?>/images/heading.png" alt=""></a>

            <p style="color: #06a; font-size: 19px; line-height: 1.5em;">Comic Rank provides a service which tracks the readers of webcomics and tells you how many real people frequently read your comic. No vote-begging required.</p>
        </div>
    </header>

    <div id="sitecontent">
