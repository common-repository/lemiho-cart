<?php class lemiho_sidebar extends lemiho {
	    function register_lemiho_sidebar() {
	    	     register_sidebar(array(
	    	     		'name'    =>  __('Lemiho sidebar product','lemiho_bsn'),
	    	     		'id'       =>  'lemiho-sidebar-product',
	    	     		'description' => __('Lemiho sidebar show on page of plugin lemiho cart','lemiho_bsn'),
	    	     		'before_title' =>  '<h3 class="lemiho-text-title-widget">',
	    	     		'after_title'  =>  '</h3>',
	    	     		'before_widget' => '<div class="lemiho-widget">',
	    	     		'after_widget' =>  '</div>'
	    	     	));
	    }
}
add_action('widgets_init',array('lemiho_sidebar','register_lemiho_sidebar'));