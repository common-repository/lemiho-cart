function lemiho_order_open(id) {
        jQuery(document).ready(function($) {
            $("#lemiho-table-product" + id).show();
            $("#group-user" + id).show();
        }); 
}
function lemiho_order_close(id) {
        jQuery(document).ready(function($) {
            $("#lemiho-table-product" + id).hide();
            $("#group-user" + id).hide();
        }); 
}