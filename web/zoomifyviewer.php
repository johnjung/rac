<?php

/*
 * FUNCTIONS
 */

/*
 * get link for page turning.
 * input: integer object offset (e.g. -1 = previous page, 1 = next page)
 * also uses global METADATA and clean.
 * output: either a blank string or a link to another page. 
 */

function get_pageturning_link($offset) {
	global $METADATA;
	global $clean;
	$i = (int)$clean['obj'];
	if ($i + $offset < 1 || $i + $offset > count($METADATA))
		return '';
	else
		return sprintf("http://roseandchess.lib.uchicago.edu/view.php?doc=%s&obj=%03s",$clean['doc'],$i+$offset);
}

/*
 * get flashvars.
 * input: none.
 * uses global METADATA and clean.
 * output: flashvars string.
 */

function get_flashvars() {
	global $METADATA;
	global $clean;
	
	$f = '';
	$f .= 'imagepath=' . urlencode($METADATA[$clean['obj']][0]) . '&amp;';
	$f .= 'prevlink=' . urlencode(get_pageturning_link(-1)) . '&amp;';
	$f .= 'nextlink=' . urlencode(get_pageturning_link(1)) . '&amp;';
	$f .= 'imagecount=' . urlencode((string)count($METADATA)) . '&amp;';
	$f .= 'metadata=' . urlencode($METADATA[$clean['obj']][1]) . '&amp;';
	if ($clean['nav'])
		$f .= 'nav=on';
	else
		$f .= 'nav=off';

	return $f;
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

$clean['nav'] = '';
if (isset($_GET['nav'])) {
	if ($_GET['nav'] == 'on')
		$clean['nav'] = 'on';
}

// build an associative array. each key is the object number.
// the array will be:
// 0: zoomify imagepath.
// 1: metadata.
$txt = file_get_contents('metadata/ucms.txt');
$METADATA = array();
$records = explode("\n", $txt);
foreach ($records as $record) {
	if (trim($record) == '')
		continue;
	$fields = explode("\t", $record);
	if ($fields[0] == $clean['doc']) {
		if (count($fields) > 2)
			$METADATA[$fields[1]] = array_slice($fields, 2);
		else
			$METADATA[$fields[1]] = '';
	}
}

// SANITY CHECK

if (count($METADATA) == 0)
	die();
if (!array_key_exists($clean['obj'], $METADATA))
	die();

?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" />
<title>Rose and Chess</title>
<link href="css/view.css" rel="stylesheet" type="text/css" />
</head>
<body onload="window.focus();">
<!-- ZOOMIFY VIEWER -->
<object
 classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
 codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
 width="100%"
 height="100%"
 id="zoomifyviewer"
 align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="movie" value="zoomifyviewer.swf" />
	<param name="flashVars" value="<?php echo get_flashvars(); ?>" />
	<param name="quality" value="high" />
	<param name="scale" value="noscale" />
	<param name="bgcolor" value="#ffffff" />
	<embed
	 src="zoomifyviewer.swf"
	 flashvars="<?php echo get_flashvars(); ?>"
	 quality="high"
	 scale="noscale"
	 bgcolor="#ffffff"
	 width="100%"
	 height="100%"
	 name="zoomifyviewer"
	 align="middle"
	 allowScriptAccess="sameDomain"
	 type="application/x-shockwave-flash"
	 pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</body>
</html>

