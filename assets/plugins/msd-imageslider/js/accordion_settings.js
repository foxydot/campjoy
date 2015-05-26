// initialize slider
$(document).ready(function(){
	$('.kwicks').kwicks({
	max : 650,
	sticky : 0,
	duration:300
	});
});


// Slider Headlines
$(document).ready(function(){

if(jQuery.browser.msie) {
$(".kwicks li#kwick1").hover(function(){
$("li#kwick1 div.title_active").fadeTo(350, 0.8);
$("li#kwick1 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick1 div.title_active").fadeTo(350, 0.0);
$("li#kwick1 div.title").fadeTo(350, 0.8);
});

$(".kwicks li#kwick2").hover(function(){
$("li#kwick2 div.title_active").fadeTo(350, 0.8);
$("li#kwick2 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick2 div.title_active").fadeTo(350, 0.0);
$("li#kwick2 div.title").fadeTo(350, 0.8);
});

$(".kwicks li#kwick3").hover(function(){
$("li#kwick3 div.title_active").fadeTo(350, 0.8);
$("li#kwick3 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick3 div.title_active").fadeTo(350, 0.0);
$("li#kwick3 div.title").fadeTo(350, 0.8);
});

$(".kwicks li#kwick4").hover(function(){
$("li#kwick4 div.title_active").fadeTo(350, 0.8);
$("li#kwick4 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick4 div.title_active").fadeTo(350, 0.0);
$("li#kwick4 div.title").fadeTo(350, 0.8);
});
}
else {
$(".kwicks li#kwick1").hover(function(){
$("li#kwick1 div.title_active").fadeTo(350, 1.0);
$("li#kwick1 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick1 div.title_active").fadeTo(350, 0.0);
$("li#kwick1 div.title").fadeTo(350, 1.0);
});

$(".kwicks li#kwick2").hover(function(){
$("li#kwick2 div.title_active").fadeTo(350, 1.0);
$("li#kwick2 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick2 div.title_active").fadeTo(350, 0.0);
$("li#kwick2 div.title").fadeTo(350, 1.0);
});

$(".kwicks li#kwick3").hover(function(){
$("li#kwick3 div.title_active").fadeTo(350, 1.0);
$("li#kwick3 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick3 div.title_active").fadeTo(350, 0.0);
$("li#kwick3 div.title").fadeTo(350, 1.0);
});

$(".kwicks li#kwick4").hover(function(){
$("li#kwick4 div.title_active").fadeTo(350, 1.0);
$("li#kwick4 div.title").fadeTo(350, 0.0);
},function(){
$("li#kwick4 div.title_active").fadeTo(350, 0.0);
$("li#kwick4 div.title").fadeTo(350, 1.0);
});
}

});