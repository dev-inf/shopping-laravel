$(function(){
	heightAdjust();
	$(window).resize(function(){
		heightAdjust();
	});
	$("li.css3aw-has-submenu").each(function(){
		$(this).html("<i class='fa fa-play submenu-trigger'></i>" + $(this).html());
	});

	//main menu hover functions
	$("div#css3aw-menu-trigger-icon").on("mouseenter", function(){
		$(this).addClass("hover");
		$("div#css3aw-main-menu-container").addClass("hover");
	});

	$("ul#css3aw-menu").on ("mouseenter", function(){
		$("div#css3aw-main-menu-container").addClass("hover-extended");
	});

	$("ul#css3aw-menu").on ("mouseleave", function(){
		$(this).children("li").children("ul").slideUp();
		$("div#css3aw-menu-trigger-icon").removeClass("hover");
		$("li.css3aw-has-submenu").children("span.submenu-trigger").removeClass("clicked");
		$("div#css3aw-main-menu-container").removeClass("hover-extended");
		$("div#css3aw-main-menu-container").removeClass("hover");
	});


	//main menu click functions
	$("div#css3aw-menu-trigger-icon").on("click", function(){
		$("div#css3aw-menu-trigger-icon").toggleClass("clicked");
		$("div#css3aw-menu-trigger-icon").removeClass("hover");
		$("div#css3aw-main-menu-container").toggleClass("clicked");
		$("div#css3aw-main-menu-container").removeClass("hover");
	});

	//submenu menu trigering functions
	$("li.css3aw-has-submenu").click(function(){
		$(this).children("span.submenu-trigger").toggleClass("clicked");
		$(this).children("ul").animate({
			height: "toggle",
			opacity: "toggle"
		});
	});

	$("body").not("header").click(function(){
		$("header").find(".clicked").removeClass("clicked");
		$("header").find(".hover").removeClass("hover");
	});

	$("header").bind('click', function (event) {
	  event.stopPropagation();
	});

});

function heightAdjust () {
	var windowWidth = $(window).width();
	if (windowWidth < 1025) {
		$("div#css3aw-main-menu-container").height($(window).height()-46);
	}
	if (windowWidth > 1024) {
		$("div#css3aw-main-menu-container").height($(window).height()-60);
	}
}
