// jquery.lazy-1.2.2.js
(function($){var o={};$.lazy=function(g,h,j){var h=h;var k=g;var m={};var n,arg;function loadCSS(a,b,c,d,e){o[d]='loaded';var f=document.createElement('link');f.type='text/css';f.rel='stylesheet';f.href=a;f.media='screen';document.getElementsByTagName("head")[0].appendChild(f);if(b)b(c,d,e)}function loadJS(a,b,c,d,e){o[d]='loaded';$.getScript(a,function(){if(b)b(c,d,e)})}function loadPlugin(a,b,c){$.getScript(k,function(){o[b]='loaded';if(typeof a=='object'){a.each(function(){if(c.length>0)$(this)[b].apply(a,c);else{$(this)[b]()}})}else{$[b].apply(null,c)}})}m[h]=function(){var a=this;var b=arguments;if(o[h]=='loaded'){$.each(this,function(){$(this)[h].apply(a,b)})}else if(o[h]=='loading'){setTimeout(function(){m[h].apply(a,b)},5)}else{o[h]='loading';if(j){var c=j.css||[];var e=j.js||[];var d=c.concat(e);var f=c.length;var l=d.length;$.each(d,function(i){if(i+1<l&&!o[this]){if(i<f)loadCSS(this);else loadJS(this)}else if(!o[this]){if(i<f)loadCSS(this,loadPlugin,a,h,b);else loadJS(this,loadPlugin,a,h,b)}else{loadPlugin(a,h,b)}})}else{loadPlugin(a,h,b)}}return this};jQuery.fn.extend(m);jQuery.extend(m)}})(jQuery);

// lazyload for images - http://www.appelsiini.net/projects/lazyload - jquery.lazyload.mini.js
(function($){$.fn.lazyload=function(options){var settings={threshold:0,failurelimit:0,event:"scroll",effect:"show",container:window};if(options){$.extend(settings,options);}
var elements=this;if("scroll"==settings.event){$(settings.container).bind("scroll",function(event){var counter=0;elements.each(function(){if(!$.belowthefold(this,settings)&&!$.rightoffold(this,settings)){$(this).trigger("appear");}else{if(counter++>settings.failurelimit){return false;}}});var temp=$.grep(elements,function(element){return!element.loaded;});elements=$(temp);});}
return this.each(function(){var self=this;$(self).attr("original",$(self).attr("src"));if("scroll"!=settings.event||$.belowthefold(self,settings)||$.rightoffold(self,settings)){if(settings.placeholder){$(self).attr("src",settings.placeholder);}else{$(self).removeAttr("src");}
self.loaded=false;}else{self.loaded=true;}
$(self).one("appear",function(){if(!this.loaded){$("<img />").bind("load",function(){$(self).hide().attr("src",$(self).attr("original"))
[settings.effect](settings.effectspeed);self.loaded=true;}).attr("src",$(self).attr("original"));};});if("scroll"!=settings.event){$(self).bind(settings.event,function(event){if(!self.loaded){$(self).trigger("appear");}});}});};$.belowthefold=function(element,settings){if(settings.container===undefined||settings.container===window){var fold=$(window).height()+$(window).scrollTop();}
else{var fold=$(settings.container).offset().top+$(settings.container).height();}
return fold<=$(element).offset().top-settings.threshold;};$.rightoffold=function(element,settings){if(settings.container===undefined||settings.container===window){var fold=$(window).width()+$(window).scrollLeft();}
else{var fold=$(settings.container).offset().left+$(settings.container).width();}
return fold<=$(element).offset().left-settings.threshold;};$.extend($.expr[':'],{"below-the-fold":"$.belowthefold(a, {threshold : 0, container: window})","above-the-fold":"!$.belowthefold(a, {threshold : 0, container: window})","right-of-fold":"$.rightoffold(a, {threshold : 0, container: window})","left-of-fold":"!$.rightoffold(a, {threshold : 0, container: window})"});})(jQuery);


// Load some external js files
$.lazy('/wp-content/themes/africankelli-2/javascript/captify.js','captify');
$.lazy('/wp-content/themes/africankelli-2/javascript/tools.tooltip-1.0.2.js','tooltip');

$(function () {

  
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
  
  $('a.tt-flickr img:below-the-fold').lazyload({
      effect : "fadeIn", 
      event : "flickr" 
    });
});

$(window).bind("load", function() { 
    var timeout = setTimeout(function() {$("a.tt-flickr img").trigger("flickr")}, 2000);
});







