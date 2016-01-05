<?php
if(!defined('WP_UNINSTALL_PLUGIN')) 
	exit();

// --edit--
$opt1='page_scroll_to_id_instances';
$opt2='page_scroll_to_id_version';

if(!is_multisite()){
	// Single site --edit--
	delete_option($opt1);
	delete_option($opt2);
}else{
	// Multisite
	global $wpdb;
	$blog_ids=$wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
	$original_blog_id=get_current_blog_id();
	foreach($blog_ids as $blog_id){
		switch_to_blog($blog_id);
		// --edit--
		delete_site_option($opt1);
		delete_site_option($opt2);
	}
	switch_to_blog($original_blog_id);
}
?>