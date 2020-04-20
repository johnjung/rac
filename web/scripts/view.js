if (!ROSEANDCHESS) {
	var ROSEANDCHESS = {};
}

/*
 * avoid accidentally overwriting window.onloads
 */

function makeDoubleDelegate(f1, f2) {
	return function() {
		if (f1) {
			f1();
		}
		if (f2) {
			f2();
		}
	};
}

/*
 * add function to pad strings with character.
 */

String.prototype.pad = function(width, chr, right) {
	var str = this;
	while (str.length < width) {
		if (right) {
			str = chr + str;
		} else {
			str = str + chr;
		}
	}
	return str;
};

/*
 * 
 */

ROSEANDCHESS.jumpToImage = function() {
	var i = document.getElementById('obj');
	if (i.value) {
		var o = i.value.pad(3,'0',true);
		if (o.match(/^[0-9]{3}$/)) {
			var f = document.getElementById('zoomifycontroler');
			f.submit();
		}
	}
};

/*
 * script resizing of the inline frame containing our zoomify movie
 */

ROSEANDCHESS.resize = function() {
	var h = document.body.offsetHeight;
	h -= 106;
	
	var z = document.getElementById('zoomifyframe');
	if (z) {
		z.style.height = String(h) + 'px';
	}
	window.focus();
};

/*
 * include two different onloads, because IE fires a bit differently
 * than FF
 */

ROSEANDCHESS.loader = function() {
	document.body.onload = makeDoubleDelegate(document.body.onload, ROSEANDCHESS.resize);
	document.getElementById('obj').onchange = ROSEANDCHESS.jumpToImage;
};
window.onload = makeDoubleDelegate(window.onload, ROSEANDCHESS.resize);
window.onresize = ROSEANDCHESS.resize;

