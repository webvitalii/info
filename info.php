<?php
/*
Plugin Name: info
Plugin URI: http://wordpress.org/plugins/info/
Description: Plugin shows in the admin bar the number of SQL queries, the amount of time in seconds and memory load.
Version: 2.4
Author: webvitaly
Author URI: http://web-profile.com.ua/wordpress/plugins/
License: GPLv3
*/


if ( !function_exists( 'info_plugin_admin_bar' ) ) {

	function info_plugin_admin_bar() {
		global $wp_admin_bar;
		if ( !is_super_admin() || !is_admin_bar_showing() ) {
			return;
		}
		$useful_info = sprintf(
			'%d q; %.2f sec; %.2f MB;',
			get_num_queries(),
			timer_stop( 0, 3 ),
			memory_get_peak_usage() / 1024 / 1024
		);
		$wp_admin_bar->add_menu( array( 'id' => 'useful_info', 'title' => $useful_info, 'href' => FALSE ) );
		//$wp_admin_bar->add_menu( array( 'parent' => 'useful_info', 'title' => $useful_info, 'href' => FALSE ) );
	}
	add_action( 'admin_bar_menu', 'info_plugin_admin_bar', 1000 );


	function info_plugin_code($atts, $content = null) {
		$useful_info = sprintf(
			'%d q; %.2f sec; %.2f MB;',
			get_num_queries(),
			timer_stop( 0, 3 ),
			memory_get_peak_usage() / 1024 / 1024
		);
		echo "\n".'<!-- Debug info: '.$useful_info.' -->'."\n";
		echo '<!-- info plugin v.2.3 wordpress.org/plugins/info/ -->'."\n";
	}
	add_action('wp_footer', 'info_plugin_code');


	function info_plugin_plugin_meta( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$row_meta = array(
				'support' => '<a href="http://web-profile.com.ua/wordpress/plugins/info/" target="_blank"><span class="dashicons dashicons-editor-help"></span> ' . __( 'info', 'info' ) . '</a>',
				'donate' => '<a href="http://web-profile.com.ua/donate/" target="_blank"><span class="dashicons dashicons-heart"></span> ' . __( 'Donate', 'info' ) . '</a>',
				'pro' => '<a href="http://codecanyon.net/item/silver-bullet-pro/15171769?ref=webvitalii" target="_blank" title="Speedup and protect WordPress in a smart way"><span class="dashicons dashicons-star-filled"></span> ' . __( 'Silver Bullet Pro', 'info' ) . '</a>'
			);
			$links = array_merge( $links, $row_meta );
		}
		return (array) $links;
		
	}
	add_filter( 'plugin_row_meta', 'info_plugin_plugin_meta', 10, 2 );

}
