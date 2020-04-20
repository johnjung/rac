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
 * get an associative array of url parameters.
 * 
 * input: none
 * output: associative array of url parameters. 
 * e.g. parseUrlParams()['doc']
 */

function parseUrlParams() {
	var tmp = window.location.href.split('?');
	if (tmp.length < 2) {
		return '';
	}

	var params = new Array();
	var parampairs = tmp[1].split('&');
	var p = 0;
	while (p < parampairs.length) {
		var keyvalue = parampairs[p].split('=');
		if (keyvalue.length < 2) {
			params[keyvalue[0]] = '';
		} else {
			params[keyvalue[0]] = keyvalue[1];
		}
		p++;
	}
	return params;
}

/*
 * load metadata via XMLHttpRequest.
 */

ROSEANDCHESS.loadMetadata = function() {
	if (window.ActiveXObject) {
		ROSEANDCHESS.req = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		ROSEANDCHESS.req = new XMLHttpRequest();
	}
	ROSEANDCHESS.req.open('GET', 'scripts/ucms-0392.txt', true);
	ROSEANDCHESS.req.onreadystatechange = ROSEANDCHESS.metadataHandler;
	ROSEANDCHESS.req.send(null);
};

ROSEANDCHESS.metadataHandler = function() {
	if (ROSEANDCHESS.req.readyState != 4) {
		return;
	}
	var data = ROSEANDCHESS.req.responseText;
	ROSEANDCHESS.metadata = new Array();
	var records = data.split("\n");
	var r = 0;
	while (r < records.length) {
		var fields = records[r].split("\t");
		if (fields.length > 0) {
			ROSEANDCHESS.metadata[fields[1]] = '';
		}
		if (fields.length > 2) {
			ROSEANDCHESS.metadata[fields[1]] = fields[3];
		}
		r++;
	}
	document.getElementById('resetview').setAttribute('href', location.href);
};

/* 
 * update breadcrumbs
 */

ROSEANDCHESS.updateBreadcrumbs = function() {
	var b = document.getElementById('breadcrumbsobj');
	var o = parseUrlParams().obj.pad(3,'0',true);
	b.innerHTML = o;
};
	
/*
 * create the jump to image feature.
 */

ROSEANDCHESS.createJumpToImage = function() {
	// jump to object n of N
	var s = document.getElementById('displayobjectcount');
	if (s == null) {
		setTimeout(ROSEANDCHESS.createJumpToImage, 1000);
		return;
	}
	s.innerHTML = String(ROSEANDCHESS.metadata.length - 1);	

	// add hidden input value
	var i = document.getElementById('doc');
	if (i == null) {
		setTimeout(ROSEANDCHESS.createJumpToImage, 1000);
		return;
	}
	i.setAttribute('value', parseUrlParams().doc);
	
	var o = document.getElementById('obj');	
	if (o == null) {
		setTimeout(ROSEANDCHESS.createJumpToImage, 1000);
		return;
	}
	o.onchange = function () {
		o.value = o.value.pad(3,'0',true);
		var f = document.getElementById('zoomifycontroller');
		f.submit();
	};
};

/*
 * update metadata view
 */

ROSEANDCHESS.updateMetadataView = function() {
	var m = document.getElementById('metadataview');
	if (m == null) {
		setTimeout(ROSEANDCHESS.updateMetadataView, 1000);
		return;
	} else {
	var p = parseUrlParams();
	var o = p.obj.pad(3,'0',true);
	var t = o + ' : ' + ROSEANDCHESS.metadata[o];
	m.appendChild(document.createTextNode(t));
	}
};

/*
 * update all views.
 */

ROSEANDCHESS.updatePageContent = function() {
	if (!ROSEANDCHESS.metadata) {
		setTimeout(ROSEANDCHESS.updatePageContent, 1000);
	} else {
		ROSEANDCHESS.updateBreadcrumbs();
		ROSEANDCHESS.createJumpToImage();
		ROSEANDCHESS.updateMetadataView();
		ROSEANDCHESS.resize();
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
 * IE and FF work differently when it comes to onload events. FF seems
 * to want everything in window.onload. However, in IE, when
 * window.onload fires, there won't be much of a document to work with. 
 * because of that, I duplicate a lot of my loaders here. 
 */

ROSEANDCHESS.loader = function() {
	//document.body.onload = makeDoubleDelegate(document.body.onload, ROSEANDCHESS.loadMetadata);
	//document.body.onload = makeDoubleDelegate(document.body.onload, ROSEANDCHESS.updatePageContent);
	document.body.onload = makeDoubleDelegate(document.body.onload, ROSEANDCHESS.resize);
};
//window.onload = makeDoubleDelegate(window.onload, ROSEANDCHESS.loader);
//window.onload = makeDoubleDelegate(window.onload, ROSEANDCHESS.loadMetadata);
//window.onload = makeDoubleDelegate(window.onload, ROSEANDCHESS.updatePageContent);
window.onload = makeDoubleDelegate(window.onload, ROSEANDCHESS.resize);
window.onresize = ROSEANDCHESS.resize;

