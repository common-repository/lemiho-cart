// ajax add to cart
function change_text(token) {
	jQuery(function($) {
		$("button#lemiho" + token).html("Add success");
	});	
}
function lemiho_add_to_cart(id,token) {
	 var xhttp = new XMLHttpRequest();
     xhttp.open("GET", "?s=&lemiho_type=product&add_to_cart=" + id, true);
	 xhttp.send();
	 jQuery(function($) {
	    change_text(token);
	 });
}