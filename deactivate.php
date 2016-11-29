<?php

/*
*
* ДЕАКТИВАЦИЯ ПЛАГИНА
*
*/

function rb_gallery_db_uninstall () {
    global $wpdb;
    
    $table_name = $wpdb->prefix . "rb_gallery";
    
    $sql = "DROP TABLE " . $table_name . ";";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $wpdb->query($sql);
}

register_deactivation_hook(RBGL_PLUGIN,'rb_gallery_db_uninstall');

/*
*
* КОНЕЦ ДЕАКТИВАЦИЯ ПЛАГИНА
*
*/


?>