jQuery(document).ready(function($){$("*:first-child").addClass("first-child"),$("*:last-child").addClass("last-child"),$("*:nth-child(even)").addClass("even"),$("*:nth-child(odd)").addClass("odd");var s=$("#footer-widgets div.widget").length;$("#footer-widgets").addClass("cols-"+s),$.each(["show","hide"],function(s,t){var e=$.fn[t];$.fn[t]=function(){return this.trigger(t),e.apply(this,arguments)}}),$(".nav-footer ul.menu>li").after(function(){return!$(this).hasClass("last-child")&&$(this).hasClass("menu-item")&&"none"!=$(this).css("display")?'<li class="separator">|</li>':void 0}),$(".mega-stack").removeClass("mega-menu-columns-2-of-8").wrapAll('<div class="stacked"></div>'),$(".mega-menu-item-type-widget").height(function(){return $(this).parent().height()})});