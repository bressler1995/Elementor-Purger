<?php
/*
Plugin Name: Elementor Purger
Plugin URI: https://salazardigital.net
Description: Periodically clear elementor files and supported cache plugins to resolve broken header issues.
Version: 1.0.0
Author: Brian Ressler
Author URI: https://briancressler.com
License: GPL2
*/

function eccent_purger_custom_interval($schedules) {
   $schedules['eccent-purger-5minutes'] = array(
      'interval' => 5 * MINUTE_IN_SECONDS,
      'display'  => __( 'Every 5 minutes' )
  );
  return $schedules;
}

add_filter( 'cron_schedules', 'eccent_purger_custom_interval');

function eccent_purger_register() {  
   eccent_purger_clear();

   if ( ! wp_next_scheduled( 'eccent_purger_cron_action' ) ) {
      // wp_schedule_event( time(), 'eccent-purger-5minutes', 'eccent_purger_cron_action' );
      wp_schedule_event( time(), 'daily', 'eccent_purger_cron_action' );
   }
    
}

register_activation_hook( __FILE__, 'eccent_purger_register' );


function eccent_purger_deregister() {
   wp_clear_scheduled_hook("eccent_purger_cron_action");
}

register_deactivation_hook( __FILE__, 'eccent_purger_deregister' );

function eccent_purger_clear() {

   // error_log( 'Elementor Purger Triggered: ' . time());

   $post_css = '_elementor_css';
   $global_css = '_elementor_global_css';
   $frontend = 'elementor-custom-breakpoints-files';
   $data_key = '_elementor_assets_data';

   $upload_dir = wp_upload_dir();
   $upload_path = $upload_dir['basedir'] . '/elementor/css/*';
   // error_log( 'Upload Base Directory: ' . $upload_path);

   foreach ( glob( $upload_path ) as $file_path ) {
		 unlink( $file_path );
	 }

   delete_post_meta_by_key( $post_css );
	delete_option( $global_css );
	delete_option( $frontend );
   delete_option( $data_key );

   do_action( 'elementor/core/files/clear_cache' );

   if (function_exists('sg_cachepress_purge_cache')) {
      // error_log( 'Purging Siteground Cache... ');
      sg_cachepress_purge_cache();
   }

   if (function_exists('rocket_clean_domain')) {
      // error_log( 'Purging WP Rocket Cache... ');
      rocket_clean_domain();
   }

   if (function_exists('wpfc_clear_all_cache')) {
      // error_log( 'Purging WP Fastest Cache... ');
      wpfc_clear_all_cache();
   }

   if (function_exists('w3tc_flush_all')) {
      // error_log( 'Purging W3 Total Cache... ');
      w3tc_flush_all();
   }

}

add_action( 'eccent_purger_cron_action', 'eccent_purger_clear' );

?>