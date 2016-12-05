<?php

/*
*
* ПОДКЛЮЧЕНИЕ СКРИПОВ И СТИЛЕЙ
*
*/

add_action( 'admin_init', 'true_plugin_init');   //Регистрирует хук-событие выполняемый системой. Обьявлять не нужно

function true_plugin_init() {
    
    if ( !did_action( 'wp_enqueue_media' ) ) {   //если не подключена библиотека media_editor, подключаем
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media');
	}
    // подключение скрипта открытия медиатеки
    wp_enqueue_script('uploadgalleryjs', plugins_url('assets/js/upload_gallery.js', __FILE__), array('jquery'), null, false); 
    // подключение стилей
    wp_enqueue_style('uploadgallerystyle', plugins_url('assets/css/uploadgallerystyle.css', __FILE__));
    
}

/*
*
* КОНЕЦ ПОДКЛЮЧЕНИЕ СКРИПОВ И СТИЛЕЙ
*
*/

/*
*
* АКТИВАЦИЯ ПЛАГИНА
*
*/



function rb_gallery_db_install () { // функция выполняющеяся при активации
    global $wpdb;                   // подключение системы управления бд wordpress в функцию

    $table_name = $wpdb->prefix . "rb_gallery"; // постоянный адресс плагина
    if($wpdb->get_var("show tables like '$table_name'") != $table_name) { // sql запрос на создание таблицы для плагина
      
        $sql = "CREATE TABLE " . $table_name . " (
        id smallint unsigned NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
	    foto text NOT NULL,
	    type text NOT NULL,
	    UNIQUE KEY id (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql); 
    }
}

register_activation_hook(RBGL_PLUGIN,'rb_gallery_db_install'); //вызов функции при активации


/*
*
* КОНЕЦ АКТИВАЦИИ ПЛАГИНА
*
*/
/*
*
* РЕГИСТРАЦИЯ МЕНЮ В АДМИНКЕ
*
*/


add_action('admin_menu', 'rb_gallery_MenuCreate');

function rb_gallery_MenuCreate(){
    if (function_exists('add_menu_page')){
        
        $pl_url = plugins_url('rb_gallery/assets/img/icon.png');
        
        add_menu_page( 'RB gallery', 'RB gallery', 'manage_options', 'rb_gallery', 'rb_gallery_Home', $pl_url , '20' );
        
        add_submenu_page( 'rb_gallery', 'RB gallery 1', 'Настройка', 'manage_options', 'rb_gallery_setting', 'rb_gallery_Setting' );
        
    }
}

/*
*
* КОНЕЦ РЕГИСТРАЦИЯ МЕНЮ В АДМИНКЕ
*
*/
?>