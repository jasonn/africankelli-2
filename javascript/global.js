// jquery.lazy-1.2.2.js
(function($){var o={};$.lazy=function(g,h,j){var h=h;var k=g;var m={};var n,arg;function loadCSS(a,b,c,d,e){o[d]='loaded';var f=document.createElement('link');f.type='text/css';f.rel='stylesheet';f.href=a;f.media='screen';document.getElementsByTagName("head")[0].appendChild(f);if(b)b(c,d,e)}function loadJS(a,b,c,d,e){o[d]='loaded';$.getScript(a,function(){if(b)b(c,d,e)})}function loadPlugin(a,b,c){$.getScript(k,function(){o[b]='loaded';if(typeof a=='object'){a.each(function(){if(c.length>0)$(this)[b].apply(a,c);else{$(this)[b]()}})}else{$[b].apply(null,c)}})}m[h]=function(){var a=this;var b=arguments;if(o[h]=='loaded'){$.each(this,function(){$(this)[h].apply(a,b)})}else if(o[h]=='loading'){setTimeout(function(){m[h].apply(a,b)},5)}else{o[h]='loading';if(j){var c=j.css||[];var e=j.js||[];var d=c.concat(e);var f=c.length;var l=d.length;$.each(d,function(i){if(i+1<l&&!o[this]){if(i<f)loadCSS(this);else loadJS(this)}else if(!o[this]){if(i<f)loadCSS(this,loadPlugin,a,h,b);else loadJS(this,loadPlugin,a,h,b)}else{loadPlugin(a,h,b)}})}else{loadPlugin(a,h,b)}}return this};jQuery.fn.extend(m);jQuery.extend(m)}})(jQuery);

// Load some external js files
$.lazy('/wp-content/themes/africankelli-2/javascript/preloadCssImages.jQuery_v5.js','preloadCssImages');
$.lazy('/wp-content/themes/africankelli-2/javascript/captify.js','captify');
$.lazy('/wp-content/themes/africankelli-2/javascript/tools.tooltip-1.0.2.js','tooltip');

$(function () {

  $.preloadCssImages();
  
  jQuery.fn.extend({
  	modwidth: function() {
  	$(this).each(function() {
  		$(this).parent().width($(this).width() + 24);
  	});
    }
  });

  $('a.tt-flickr img').modwidth();

  $('a.tt-flickr img').captify({
  	speedOver: 'fast',
  	speedOut: 'normal',
  	hideDelay: 300,
  	opacity: '0.7',
  	position: 'bottom'
  });
  
  $('.title a').tooltip({position: ['bottom', 'center'],slideOffset: 50});

});







