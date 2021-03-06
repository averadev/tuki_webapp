/*
 showMessage - jQuery plugin
 Simple Twitter like notification method

 Examples and documentation can be found at http://showMessage.dingobytes.com/

 Copyright (c) 2009 - 2012 Andrew Alba (http://albawebstudio.com)

 Version: 3.0
 Requires jQuery v1.7+

 Dual licensed under the MIT  and GPL licenses:
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html

 Date: Tue Apr 04 18:00:00 2010 -0500
*/
(function(a){var c,d,h,g,i;_autoClose=function(e){typeof c!="undefined"&&clearTimeout(c);c=setTimeout(function(){a("#showMessage",window.parent.document).fadeOut()},e)};_useEsc=function(){a(window).keydown(function(e){if((e===null?event.keyCode:e.which)==27)a("#showMessage",window.parent.document).fadeOut(),typeof c!="undefined"&&clearTimeout(c)})};_navigation=function(e,b,d){var f=a("<span></span>").addClass("messageNav");e&&a(f).html(b+" ");d=a("<a></a>").attr({href:"",title:option.closeText}).css("text-decoration",
"underline").click(function(){a("#showMessage",window.parent.document).fadeOut();clearTimeout(c);return!1}).text(d);a(f).append(d);return f};_abandon=function(){a(window).click(function(){if(a("#showMessage",window.parent.document).length)return a("#showMessage",window.parent.document).fadeOut(),a(window).unbind("click"),typeof c!="undefined"&&clearTimeout(c),!1})};_show=function(e,b){try{a("#showMessage",window.parent.document).length&&a("#showMessage",window.parent.document).remove();d=a("<div></div>").css({position:b.position,
"z-index":b.zIndex,filter:"Alpha(Opacity="+b.opacity*100+")",opacity:b.opacity}).attr("id","showMessage").addClass(b.className);b.location=="top"?a(d).css("top",0):a(d).css("bottom",0);b.useEsc?_useEsc():a(window).unbind("keydown");b.displayNavigation?(i=_navigation(b.useEsc,b.escText,b.closeText),a(d).append(i)):_abandon();g=a("<ul></ul>");for(var c=0;c<b.thisMessage.length;c++){var f=a("<li></li>").html(b.thisMessage[c]);a(g).append(f)}h=a("<div></div>").addClass("stateHolder").append(g);a(d).append(h);
b.location=="top"?a(e,window.parent.document).prepend(d):a(e,window.parent.document).append(d);a(d).fadeIn();b.autoClose&&_autoClose(b.delayTime)}catch(j){console.log("error message:",j.message)}};a.fn.showMessage=function(c){if(!a(this).length)return this;option=a.extend(a.fn.showMessage.defaults,c);_show(this,option)};a.showMessage=function(c){option=a.extend(a.fn.showMessage.defaults,c);_show(jQuery("body",window.parent.document),option)};a.showMessage.close=function(){a("#showMessage",window.parent.document).length&&
(typeof c!="undefined"&&clearTimeout(showmessage_t),a("#showMessage",window.parent.document).fadeOut());return!1};a.showMessage.init=function(){a("#showMessage")};a.fn.showMessage.defaults={thisMessage:[""],className:"notification",position:"fixed",zIndex:1001,opacity:0.9,location:"top",useEsc:!0,displayNavigation:!0,closeText:"cerrar",escText:"",autoClose:!1,delayTime:5E3,onStart:function(){},onCancel:function(){},onComplete:function(){},onCleanup:function(){},onClosed:function(){},onError:function(){}};
a(document).ready(function(){a.showMessage.init()})})(jQuery);