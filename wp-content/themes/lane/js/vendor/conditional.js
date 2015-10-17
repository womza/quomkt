// document.documentElement.className += 'ontouchstart' in document.documentElement ? ' wt_mobile ' : ' wt_desktop ';

var isMobile = { 
	Android    : function() { return navigator.userAgent.match(/Android/i); }, 
	BlackBerry : function() { return navigator.userAgent.match(/BlackBerry/i); }, 
	iOS        : function() { return navigator.userAgent.match(/iPhone|iPad|iPod/i); },
	webOS      : function() { return navigator.userAgent.match(/webOS/i); },  
	Opera      : function() { return navigator.userAgent.match(/Opera Mini/i); }, 
	Windows    : function() { return navigator.userAgent.match(/IEMobile/i); }, 
	any        : function() { return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.webOS() || isMobile.Opera() || isMobile.Windows());} 
};

if ( isMobile.any() ) { 
	document.documentElement.className += " wt_is_mobile"; } 
else {
	document.documentElement.className += " wt_is_desktop"; }

Modernizr.load([
  {
    test: Modernizr.mq('only all'),
    nope: theme_uri + '/js/vendor/respond.min.js'
  }
]);