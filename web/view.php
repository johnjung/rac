<?php

/*
 * FUNCTIONS
 */

function print_iiif_html() {
    global $clean;
    $cv = (int)$clean['obj'] - 1;
    printf("https://iiif-viewer.lib.uchicago.edu/uv/./uv.html#?cv=%s&manifest=https://iiif-manifest.lib.uchicago.edu/rac/%s/%s.json", $cv, $clean['doc'], $clean['doc']);
}

/*
 * GET URL PARAMS
 */

$clean = array();

$clean['doc'] = '';
if (isset($_GET['doc'])) {
	if (ctype_digit($_GET['doc']) && strlen($_GET['doc']) <= 4)
		$clean['doc'] = sprintf("%04d", $_GET['doc']);
}

$clean['obj'] = '';
if (isset($_GET['obj'])) {
	if (ctype_digit($_GET['obj']) && strlen($_GET['obj']) <= 3)
		$clean['obj'] = sprintf("%03d", $_GET['obj']);
}
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<base href="http://goodspeed.lib.uchicago.edu/view/"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" />
<title>Rose and Chess</title>
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
