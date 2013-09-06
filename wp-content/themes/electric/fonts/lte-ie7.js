/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'electric\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-menu' : '&#xe024;',
			'icon-user' : '&#xe023;',
			'icon-search' : '&#xe022;',
			'icon-bubble' : '&#xe021;',
			'icon-bubbles' : '&#xe018;',
			'icon-tag' : '&#xe010;',
			'icon-pencil' : '&#xe013;',
			'icon-calendar' : '&#xe004;',
			'icon-glasses' : '&#x263a;',
			'icon-plus' : '&#xe01f;',
			'icon-minus' : '&#xe01d;',
			'icon-download' : '&#xe01c;',
			'icon-mail' : '&#xe019;',
			'icon-drawer' : '&#xe017;',
			'icon-github' : '&#xe016;',
			'icon-tumblr' : '&#xe015;',
			'icon-dribbble' : '&#x26e2;',
			'icon-flickr' : '&#x2689;',
			'icon-mail-2' : '&#xe012;',
			'icon-reddit' : '&#xe001;',
			'icon-pinterest' : '&#x2667;',
			'icon-twitter' : '&#xe01e;',
			'icon-quote' : '&#x275e;',
			'icon-file-zip' : '&#xe01b;',
			'icon-file-powerpoint' : '&#xe01a;',
			'icon-meter-fast' : '&#x2b1c;',
			'icon-meter-medium' : '&#x2b1b;',
			'icon-meter-slow' : '&#x2b1a;',
			'icon-new-tab' : '&#x27b2;',
			'icon-redo' : '&#x27b6;',
			'icon-help' : '&#xe020;',
			'icon-cancel' : '&#x2612;',
			'icon-checkmark' : '&#xe007;',
			'icon-star' : '&#x2605;',
			'icon-enter' : '&#xe00f;',
			'icon-file-pdf' : '&#xe00e;',
			'icon-file-word' : '&#xe00d;',
			'icon-css3' : '&#xe00c;',
			'icon-html5' : '&#xe00b;',
			'icon-feed' : '&#xe00a;',
			'icon-gplus' : '&#xe009;',
			'icon-stumbleupon' : '&#xe008;',
			'icon-linkedin' : '&#x2300;',
			'icon-tux' : '&#xe006;',
			'icon-wordpress' : '&#xe005;',
			'icon-facebook' : '&#xe003;',
			'icon-twitter-2' : '&#xe000;',
			'icon-zoom-in' : '&#xe002;',
			'icon-home' : '&#x27f0;',
			'icon-arrow-right-alt1' : '&#xe025;',
			'icon-arrow-left-alt1' : '&#xe011;',
			'icon-pushpin' : '&#xe014;',
			'icon-clock' : '&#xe026;',
			'icon-equalizer' : '&#xe027;',
			'icon-attachment' : '&#xe028;',
			'icon-thumbs-up' : '&#xe029;',
			'icon-thumbs-up-2' : '&#xe02a;',
			'icon-embed' : '&#xe02b;',
			'icon-code' : '&#xe02c;',
			'icon-right' : '&#xe02d;',
			'icon-heart' : '&#xe02e;',
			'icon-caret-down' : '&#xe02f;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};