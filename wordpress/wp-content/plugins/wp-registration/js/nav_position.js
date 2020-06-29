"use strict";
jQuery(function($){

	var $item = $("[href='edit.php?post_type=wpr&page=wpr_dashboard_id']");
       var m = $item.closest('li');
     // var  $before = m.prev();
       m.insertBefore('#menu-posts-wpr .wp-submenu-head');

});