<?php class lemiho_model extends lemiho {
                 function lemiho_create_order_table() {
                 	   $output = '';
                 	   $create = "CREATE TABLE lemiho_or(ID int NOT NULL AUTO_INCREMENT,
					   id_order varchar(255),
					   price varchar(50),
					   day varchar(50),
					   fullname varchar(150),
					   email varchar(150),
					   address varchar(500),
					   message varchar(500),
					   payment_method varchar(100),
					   coupon varchar(50),
					   postcode varchar(50),
					   number_fone varchar(50),
					   CONSTRAINT PK_lemiho_or PRIMARY KEY (ID))";
					   mysql_query($create);
                 	   return $output;
                 }
                 function lemiho_create_order_item_table() {
                 	   $output = '';
	                 	   $create = "CREATE TABLE lemiho_item(ID int NOT NULL AUTO_INCREMENT,
						   id_order varchar(255), 
						   qty varchar(50),
						   id_product varchar(255),
					   		CONSTRAINT PK_lemiho_item PRIMARY KEY (ID))";
						   mysql_query($create);
                 	   return $output;
                 }
				 function lemiho_create_coupon_table() {
					   $output = '';
	                 	   $create = "CREATE TABLE lemiho_coupon(ID int NOT NULL AUTO_INCREMENT,
						   code varchar(255), 
						   down varchar(50),
					   		CONSTRAINT PK_lemiho_coupon PRIMARY KEY (ID))";
						   mysql_query($create);
                 	   return $output;
				 }
}
add_action("after_setup_theme",array("lemiho_model","lemiho_create_order_table"));
add_action("after_setup_theme",array("lemiho_model","lemiho_create_order_item_table"));
add_action("after_setup_theme",array("lemiho_model","lemiho_create_coupon_table"));
