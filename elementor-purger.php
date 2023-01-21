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

function eccent_purger_register() {   

    error_log( 'Activated' );

    
}

register_activation_hook( __FILE__, 'eccent_purger_register' );

add_action('plugins_loaded', 'eccent_purger_pluginsloaded');
function eccent_purger_pluginsloaded() {
  do_action('elementor/core/files/clear_cache');

}

function eccent_purger_clear_cache() {
  
}

?>