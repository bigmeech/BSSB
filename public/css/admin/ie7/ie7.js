/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-remove': '&#xe600;',
		'icon-users': '&#xe601;',
		'icon-sad': '&#xe602;',
		'icon-grin': '&#xe603;',
		'icon-download': '&#xe604;',
		'icon-thumbs-up': '&#xe605;',
		'icon-thumbs-up2': '&#xe606;',
		'icon-home': '&#xe607;',
		'icon-user': '&#xe608;',
		'icon-cog': '&#xe609;',
		'icon-eye': '&#xe60a;',
		'icon-notification': '&#xe60b;',
		'icon-warning': '&#xe60c;',
		'icon-checkmark': '&#xe60d;',
		'icon-checkmark2': '&#xe60e;',
		'icon-close': '&#xe60f;',
		'icon-plus': '&#xe610;',
		'icon-minus': '&#xe611;',
		'icon-exit': '&#xe612;',
		'icon-spam': '&#xe613;',
		'icon-spell-check': '&#xe614;',
		'icon-pencil': '&#xe615;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
