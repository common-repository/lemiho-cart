jQuery(document).ready(function($){
 		// slider 1
	   $("ul.list-image-slider-small li#slider1").click(function(){
	   		$("ul.list-image-slider-big li:first-child").show();
	   		$("ul.list-image-slider-big li:nth-child(2)").hide();
	   		$("ul.list-image-slider-big li:nth-child(3)").hide();
	   		$("ul.list-image-slider-big li:nth-child(4)").hide();
	   		$("ul.list-image-slider-big li:nth-child(5)").hide();
	   });
	   // slider 2
	   $("ul.list-image-slider-small li#slider2").click(function(){
	   		$("ul.list-image-slider-big li:first-child").hide();
	   		$("ul.list-image-slider-big li:nth-child(2)").show();
	   		$("ul.list-image-slider-big li:nth-child(3)").hide();
	   		$("ul.list-image-slider-big li:nth-child(4)").hide();
	   		$("ul.list-image-slider-big li:nth-child(5)").hide();
	   });
	   // slider 3
	   $("ul.list-image-slider-small li#slider3").click(function(){
	   		$("ul.list-image-slider-big li:first-child").hide();
	   		$("ul.list-image-slider-big li:nth-child(2)").hide();
	   		$("ul.list-image-slider-big li:nth-child(3)").show();
	   		$("ul.list-image-slider-big li:nth-child(4)").hide();
	   		$("ul.list-image-slider-big li:nth-child(5)").hide();
	   });
	   // slider 4
	   $("ul.list-image-slider-small li#slider4").click(function(){
	   		$("ul.list-image-slider-big li:first-child").hide();
	   		$("ul.list-image-slider-big li:nth-child(2)").hide();
	   		$("ul.list-image-slider-big li:nth-child(3)").hide();
	   		$("ul.list-image-slider-big li:nth-child(4)").show();
	   		$("ul.list-image-slider-big li:nth-child(5)").hide();
	   });
	   // slider 5
	   $("ul.list-image-slider-small li#slider5").click(function(){
	   		$("ul.list-image-slider-big li:first-child").hide();
	   		$("ul.list-image-slider-big li:nth-child(2)").hide();
	   		$("ul.list-image-slider-big li:nth-child(3)").hide();
	   		$("ul.list-image-slider-big li:nth-child(4)").hide();
	   		$("ul.list-image-slider-big li:nth-child(5)").show();
	   });
});
	  
