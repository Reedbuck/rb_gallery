<?php
/*
Plugin Name: rb_gallery
Plugin URI: http://reedbuck.ru
Description: Плагин добавляет настраиваемую галерею
Version: 1.0
Author: Vpan
Author URI: http://omelchuck.ru
License: GPL2
*/
?>
<?php 

define( 'RBGL_VERSION', '1.0' );

define( 'RBGL_REQUIRED_WP_VERSION', '4.4' );

define( 'RBGL_PLUGIN', __FILE__ );

define( 'RBGL_PLUGIN_BASENAME', plugin_basename( RBGL_PLUGIN ) );

define( 'RBGL_PLUGIN_NAME', trim( dirname( RBGL_PLUGIN_BASENAME ), '/' ) );

define( 'RBGL_PLUGIN_DIR', untrailingslashit( dirname( RBGL_PLUGIN ) ) );

define( 'RBGL_PLUGIN_MODULES_DIR', RBGL_PLUGIN_DIR . '/modules' );

require_once RBGL_PLUGIN_DIR . '/setting.php';


function rb_gallery_Setting(){
    echo '<h2>Настройки галереи</h2>';
} 
 
function rb_gallery_settings_link($actions, $file) {
    
    $actions['settings'] = '<a href="admin.php?page=rb_gallery_setting">Settings</a>';
    
    return $actions;
}
 
add_filter('plugin_action_links', 'rb_gallery_settings_link', 2, 2);

?>