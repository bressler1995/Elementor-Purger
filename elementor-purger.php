<?php
   /*
   Plugin Name: Elementor Purger
   Plugin URI: https://salazardigital.net
   Description: Periodically clear elementor files.
   Version: 1.0.0
   Author: Brian Ressler
   Author URI: https://briancressler.com
   License: GPL2
   */

// require_once plugin_dir_path( __FILE__ ) . '/eccent_ep_manager.php';

function eccent_purger_register() {  
  
   error_log( 'Elementor Purger Activated!' );

   $post_css = '_elementor_css';
   $global_css = '_elementor_global_css';
   $frontend = 'elementor-custom-breakpoints-files';
   $data_key = '_elementor_assets_data';

   $upload_dir = wp_upload_dir();
   $upload_path = $upload_dir['basedir'] . '/elementor/css/*';
   error_log( 'Upload Base Directory: ' . $upload_path);

   foreach ( glob( $upload_path ) as $file_path ) {
		 unlink( $file_path );
	 }

   delete_post_meta_by_key( $post_css );
	delete_option( $global_css );
	delete_option( $frontend );
   delete_option( $data_key );

   do_action( 'elementor/core/files/clear_cache' );

   if (function_exists('sg_cachepress_purge_cache')) {
      error_log( 'Purging Siteground Cache... ');
      sg_cachepress_purge_cache();
   }

   if (function_exists('rocket_clean_domain')) {
      error_log( 'Purging WP Rocket Cache... ');
      rocket_clean_domain();
   }

   if (function_exists('wpfc_clear_all_cache')) {
      error_log( 'Purging WP Fastest Cache... ');
      wpfc_clear_all_cache();
   }

   if (function_exists('w3tc_flush_all')) {
      error_log( 'Purging W3 Total Cache... ');
      w3tc_flush_all();
   }

    
}

register_activation_hook( __FILE__, 'eccent_purger_register' );

function eccent_purger_pluginsloaded() {
  // $path = Base::get_base_uploads_dir() . Base::DEFAULT_FILES_DIR . '*';
  
}

add_action('plugins_loaded', 'eccent_purger_pluginsloaded');

?>