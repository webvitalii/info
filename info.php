<?php
/*
Plugin Name: info
Plugin URI: http://wordpress.org/plugins/info/
Description: Plugin shows in the admin bar the number of SQL queries, the amount of time in seconds and memory load.
Version: 2.3
Author: webvitaly
Author URI: http://web-profile.com.ua/wordpress/plugins/
License: GPLv3
*/


if ( !function_exists( 'info_unqprfx_admin_bar' ) ) {

	function info_unqprfx_admin_bar() { // add info to admin bar
		global $wp_admin_bar, $wpdb;
		if ( !is_super_admin() || !is_admin_bar_showing() )
			return;
		//$useful_info = get_num_queries().' sql q.; '.timer_stop().' sec.;';
		$useful_info = sprintf( '%d q; %.2f sec; %.2f MB;',
			get_num_queries(),
			timer_stop( 0, 3 ),
			memory_get_peak_usage() / 1024 / 1024
		);
		/* Add the main siteadmin menu item */
		$wp_admin_bar->add_menu( array( 'id' => 'useful_info', 'title' => $useful_info, 'href' => FALSE ) );
		//$wp_admin_bar->add_menu( array( 'parent' => 'useful_info', 'title' => $useful_info, 'href' => FALSE ) );
	}
	add_action( 'admin_bar_menu', 'info_unqprfx_admin_bar', 1000 );


	function info_unqprfx_code($atts, $content = null) { // add info to source code
		$useful_info = sprintf( '%d q; %.2f sec; %.2f MB;',
			get_num_queries(),
			timer_stop( 0, 3 ),
			memory_get_peak_usage() / 1024 / 1024
		);
		echo "\n".'<!-- info plugin v.2.3 wordpress.org/plugins/info/ -->'."\n";
		echo '<!-- ========== '.$useful_info.' ========== -->'."\n";
	}
	add_action('wp_footer', 'info_unqprfx_code');


	function info_unqprfx_plugin_meta( $links, $file ) { // add 'Support' and 'Donate' links to plugin meta row
		if ( strpos( $file, 'info.php' ) !== false ) {
			$links = array_merge( $links, array( '<a href="http://web-profile.com.ua/wordpress/plugins/info/" title="Plugin page">info</a>' ) );
			$links = array_merge( $links, array( '<a href="http://web-profile.com.ua/donate/" title="Support the development">donate</a>' ) );
		}
		return $links;
	}
	add_filter( 'plugin_row_meta', 'info_unqprfx_plugin_meta', 10, 2 );

}