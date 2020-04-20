<?php

require_once('cleaner.php');
$clean = cleaner();

require_once('printer.php');

?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<base href="http://goodspeed.lib.uchicago.edu/view/"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" />
<title>The Goodspeed Manuscript Collection</title>
<script type="text/javascript">
// ASYNCHRONOUS GOOGLE ANALYTICS CODE.
// http://code.google.com/apis/analytics/docs/tracking/asyncTracking.html
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-12414285-1']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type =
'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' :
'http://www') + '.google-analytics.com/ga.js';
    (document.getElementsByTagName('head')[0] ||
document.getElementsByTagName('body')[0]).appendChild(ga);
})();
</script>
<style>
  body {
    bottom: 0;
    left: 0;
    margin: 0;
    outline: 1px solid red;
    position: absolute;
    right: 0;
    top: 0;
  }
  html {
    background-color: black;
  }
</style>
</head>
<body>

<!-- IFRAME FOR ZOOMIFY VIEWER -->
<iframe
src="<?php print_iiif_html(); ?>" width="100%" height="100%"
allowfullscreen frameborder="0" marginheight="0" marginwidth="0"
scrolling="auto" data-sequenceindex="2"></iframe>

</body>
</html>
