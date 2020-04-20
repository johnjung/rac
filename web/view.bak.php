<?php

/*
 * FUNCTIONS
 */

function print_ms_number() {
	global $clean;
	print ltrim($clean['doc'], '0');
}

function print_image_number() {
	global $clean;
	print ltrim($clean['obj'], '0');
}

function print_reset_link() {
	print($_SERVER['REQUEST_URI']);
}

function print_toggle_link() {
	global $clean;
	if ($clean['nav'])
		printf("view.php?doc=%s&amp;obj=%s", $clean['doc'], $clean[ 'obj']);
	else
		printf("view.php?doc=%s&amp;obj=%s&amp;nav=on", $clean['doc'], $clean['obj']);
}

function print_zoomify_html() {
	global $clean;
	if ($clean['nav'])
		printf("zoomifyviewer.php?doc=%s&amp;obj=%s&amp;nav=on", $clean['doc'], $clean['obj']);
	else
		printf("zoomifyviewer.php?doc=%s&amp;obj=%s", $clean['doc'], $clean['obj']);
}

function print_metadata_line() {
	global $clean;
	global $METADATA;
	printf("%s : %s", $clean['obj'], $METADATA[$clean['obj']][1]);
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

?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" />
<title>Rose and Chess</title>
<?php include "includes/head.html"; ?>
<link href="css/view.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/view.js"></script>
</head>
<body>

<!-- NAMETAG -->
<div style="position: absolute; right: 0; top: 0; padding: 5px; background: #800000; z-index: 4;">
<a href="http://www.lib.uchicago.edu/e/"><img src="images/theuniversityofchicagolibrary.gif" alt="The University of Chicago Library"/></a>
</div>

<!-- HEADER (TOP HALF: BREADCRUMBS, RED STRIPE) -->
<div style="width: 100%; height: 46px; position: absolute; z-index: 3; background: #f5f1e9; border-top: 5px solid #800000;">
<div style="position: absolute; bottom: 0; border-bottom: 1px solid #ddd; width: 100%; padding-bottom: 4px;">
<p style="padding-left: 6px;">
<!--<a style="text-decoration: none; color: #800000;" href="http://roseandchess.lib.uchicago.edu/">Rose and Chess</a>-->
<a href="http://roseandchess.lib.uchicago.edu/"><img style="position: relative; top: 9px;" src="images/rose-and-chess-small.gif"/></a> |
Ms <?php print_ms_number(); ?> | 
image <?php print_image_number(); ?></p>
</div>
</div>

<!-- HEADER (BOTTOM HALF: LINKS TO CONTROL FLASH PLAYER) -->
<div style="width: 100%; height: 30px; position: absolute; top: 48px; height: 30px; z-index: 2; padding-top: 4px;">
<form id="zoomifycontroller" action="view.php">
<input type="hidden" name="doc" id="doc" value="<?php echo $clean['doc']; ?>"/>
<p style="padding-left: 6px;">
<a href="<?php print_reset_link(); ?>" style="text-decoration: none; color: #800000;" id="resetview">Reset View</a> |
<a href="<?php print_toggle_link(); ?>" style="text-decoration: none; color: #800000;" id="togglenavwindow">Toggle Navigation Window</a> | 
Jump to image
<input type="text" name="obj" id="obj" style="border: 1px solid #999; width: 40px;"/>
of 
<?php echo count($METADATA); ?>
</p>
</form>
</div>

<!-- IFRAME FOR ZOOMIFY VIEWER -->
<iframe frameborder="0" id="zoomifyframe" src="<?php print_zoomify_html(); ?>" scrolling="no" style="width: 100%; height: 100%; position: absolute; top: 76px; border=0;"></iframe>

<!-- FOOTER: METADATA VIEW -->
<div 
 style="width: 100%; height: 26px; position: absolute; bottom: 0; z-index: 10; border-top: 1px solid #ddd; background: #f5f1e9; padding-top: 4px;">
<p style="padding-left: 6px;"><?php print_metadata_line(); ?></p>
</div>

</body>
</html>
