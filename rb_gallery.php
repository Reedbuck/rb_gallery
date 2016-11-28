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
add_action( 'admin_init', 'true_plugin_init');

global $rb_gallery_db_version;
$rb_gallery_db_version = "1.0";

function rb_gallery_db_install () {
   global $wpdb;
   global $rb_gallery_db_version;

   $table_name = $wpdb->prefix . "rb_gallery";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id smallint unsigned NOT NULL AUTO_INCREMENT,
      name text NOT NULL,
	  foto text NOT NULL,
	  type text NOT NULL,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );
 
      add_option("rb_gallery_db_version", $rb_gallery_db_version);

   }
$welcome_name = "Mr. Wordpress";
  $welcome_text = "Поздравляю, установка прошла успешно!";

  $rows_affected = $wpdb->insert( $table_name, array( 'name' => $welcome_name, 'type' => $welcome_text ) );

}

register_activation_hook(__FILE__,'rb_gallery_db_install');

function rb_gallery_db_uninstall () {
    global $wpdb;
    $table_name = $wpdb->prefix . "rb_gallery";
    
    $sql = "DROP TABLE " . $table_name . ";";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $wpdb->query($sql);
}

register_deactivation_hook(__FILE__,'rb_gallery_db_uninstall');



function true_plugin_init() {
    if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
    wp_enqueue_script('uploadgalleryjs', plugins_url('assets/js/upload_gallery.js', __FILE__), array('jquery'), null, false);
    wp_enqueue_style('uploadgallerystyle', plugins_url('assets/css/uploadgallerystyle.css', __FILE__));
}

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
* ГЛАВНАЯ
*
*/

function rb_gallery_Home(){
    if(!$_GET["dop"]){
?>
    <h2>Главная страница</h2>

    <form method="get" action="<?php plugins_url('rb_gallery/rb_gallery.php'); ?>">
        
        <input type="hidden" name="page" value="rb_gallery" />
        <input type="hidden" name="dop" value="newdop" />
        
        <p class="submit">
            <input type="submit" class="button-primary" value="Добавить новую галерею" />
        </p>
    </form>

<?php  
                      
                      
/*
*
* КОНЕЦ ГЛАВНОЙ
*
*/
    } else { 
/*
*
* Регистрация опцый в БД
*
*/
if($_GET['rb_gallery-name']){
    echo "Есть контакт";
    
    $galleryName = $_GET['rb_gallery-name'];
    $galleryImgId = $_GET['rb_gallery-massImgId'];
    add_action( 'create_new_gallery', 'rb_gallery_register_settings', 10, 3 );
    
    
    function rb_gallery_register_settings($galleryName, $galleryImgId) {
        echo "контакт 2";
        global $wpdb;
     // подготавливаем данные
     $galleryName = esc_sql($galleryName);
     $galleryImgId = esc_sql($galleryImgId);
        
     $table_name = $wpdb->prefix . "rb_gallery";
    // вставляем строку в таблицу
     $wpdb->insert( $table_name, array( 'name' => $galleryName, 'foto' => $galleryImgId ));
    }
    
    
    do_action( 'create_new_gallery', $galleryName, $galleryImgId );
}

/*
*
* КОНЕЦ Регистрация опцый в БД
*
*/


        $default = plugins_url('rb_gallery/assets/img/no-image.png');
        
?>

    <h2>Дополнительная страница</h2>
    <div>
        <div class="rb_gallery-innerBox">
            <div id="rb_gallery-inner">
                <?php 
                    $massImgId = explode(",", get_option('rb_gallery-massImgId'));
                    if($massImgId){
                        for($i = 1; $i < count($massImgId); ++$i){ 
                        $image_attributes = wp_get_attachment_image_src( $massImgId[$i], array($w, $h) );
                        $image_src = $image_attributes[0];
                ?>
                            <div class="rb_gallery-ImgDbLoad"><img data-src="<?php echo $image_src; ?>" src="<?php echo $image_src; ?>" width="150px" /></div>
                <?php
                        }
                    } 
                ?>
            </div>
            <div class="rb_gallery-no-image">
                <img data-src="<?php echo $default ?>" src="<?php echo $default ?>" width="100%" />
            </div>
        </div>
		<div>
			<button type="submit" class="upload_image_button button">Загрузить</button>
			<button type="submit" class="remove_image_button button">&times;</button>
		</div>
	</div>
    
    <form method="get" action="<?php plugins_url('rb_gallery/rb_gallery.php'); ?>">
        <input type="hidden" name="page" value="rb_gallery" />
        <input type="hidden" name="dop" value="newdop" />
        <label>Название галлереи
            <input type="text" name="rb_gallery-name" value="" />
        </label>
        <input type="text" name="rb_gallery-massImgId" value="" /> 
        <input type="text" name="rb_gallery-type" value="slider" /> 
        <p class="submit">
            <input type="submit" class="button-primary" value="Сохранить" />
        </p>
    </form>

<?php  
    }
}



function rb_gallery_Setting(){
    echo '<h2>Настройки галереи</h2>';
} 

/* settings link in plugin management screen */
 
function rb_gallery_settings_link($actions, $file) {
    
    $actions['settings'] = '<a href="admin.php?page=rb_gallery_setting">Settings</a>';
    
    return $actions;
}
 
add_filter('plugin_action_links', 'rb_gallery_settings_link', 2, 2);

?>