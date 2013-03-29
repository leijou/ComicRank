<!doctype html>
<html>
<head>
    <title><?=htmlspecialchars($page->title)?></title>
    <link rel="publisher" href="https://plus.google.com/108661948674027877061" />

    <?php
    foreach ($page->links as $rel => $href) echo '<link rel="'.htmlspecialchars($rel).'" href="'.htmlspecialchars($href).'" />'."\n    ";
    foreach ($page->css as $css) echo '<link rel="stylesheet" href="'.htmlspecialchars($css).'" />'."\n    ";
    foreach ($page->js as $js) echo '<script src="'.htmlspecialchars($js).'"></script>'."\n    ";
    ?>

</head>
<body>
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


    <header id="siteheader">
        <a href="/" id="siteheaderlink"><img src="<?=URL_STATIC?>/images/heading.png" alt="Comic Rank"></a>
    </header>

    <div id="sitecontent">

