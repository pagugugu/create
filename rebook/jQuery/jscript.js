// JavaScript Document
$(function(){
	$('header nav >ul').mouseenter(function(){
		$('ul.lv2, .headerBg').stop().slideDown()
	})
	$('header nav >ul').mouseleave(function(){
		$('ul.lv2, .headerBg').stop().slideUp()
	})
	
	var slideI=0;
	setInterval(function(){
		if(slideI<1){
			slideI++;
		}else{
			slideI=0;
		}
		$(".mainvisual ul").animate({left:(slideI*-1200)},500);
	},3000);
	
	$(".notice ul li").first().click(function(){
		$(".modal").fadeIn();
	});
	$(".modal button").click(function(){
		$(".modal").fadeOut();
	});
});