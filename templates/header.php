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

        <a href="http://www.comicrank.com/comic/c0a4/in" id="comicrank_button" style="display: none;"><noscript><img src="http://stats.comicrank.com/v1/img/c0a4" alt="Visit Comic Rank" /></noscript></a>
        <script>(function(){
        var w=window,d=document,c,s;
        function crl(){if(c)return;
        c=d.getElementById("comicrank_button");
        s=d.createElement("script");
        s.async=true; s.src="http://stats.comicrank.com/v1/js/c0a4";
        c.appendChild(s);}
        if (w.attachEvent){
        w.attachEvent("DOMContentLoaded",crl);
        w.attachEvent("onload",crl);
        }else{
        w.addEventListener("DOMContentLoaded",crl,false);
        w.addEventListener("load",crl,false);
        }})();</script>
    </header>

    <div id="sitecontent">

