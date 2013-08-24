$(document).ready(function(){
 
	$(".file-name a").hover(function() {
	$(this).next("em").stop(true, true).animate({opacity: "show", top: "-24"}, "slow");
	}, function() {
	$(this).next("em").animate({opacity: "hide", top: "-14"}, "fast");
	});
 
});