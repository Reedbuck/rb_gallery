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

/*
*
* ГЛАВНАЯ
*
*/

function rb_gallery_Home(){
    if(!$_GET["dop"]){
        
        global $wpdb;
        $table_name = $wpdb->prefix . "rb_gallery";

        $GMId = $wpdb->get_col(
            "
            SELECT id 
            FROM $table_name
            "
        );
        
?>
    <h2>Главная страница</h2>
<?php
        if($GMId) {
            for($i = 0; $i < count($GMId); ++$i){ 
                
                $gallery = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE `id` = %d LIMIT 1;", $GMId[$i] ));
                
                $image_MSrc = explode(",", $gallery->foto);
                $image_attributes = wp_get_attachment_image_src( $image_MSrc[1], array($w, $h) );
                $image_Src = $image_attributes[0];
?>
                    <form method="get" action="<?php plugins_url('rb_gallery/rb_gallery.php'); ?>">
                        <div class="rb_gallery-ImgDbLoad">
                            <img data-src="<?php echo $image_Src; ?>" src="<?php echo $image_Src ?>" width="150px" />
                        </div>
                        <input type="hidden" name="page" value="rb_gallery" />
                        <input type="hidden" name="dop" value="gallery<?php echo $GMId[$i]; ?>" />
                        <p class="submit">
                            <input type="submit" class="button-primary" value="перейти в галерею" />
                        </p>
                    </form>
                <?php
            }
        }
?>

    <form method="get" action="<?php plugins_url('rb_gallery/rb_gallery.php'); ?>">
        
        <input type="hidden" name="page" value="rb_gallery" />
        <input type="hidden" name="dop" value="gallery" />
        
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
        
            global $wpdb;
            $table_name = $wpdb->prefix . "rb_gallery";

            $gallery = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE `id` = %d LIMIT 1;", 1 ));
            
        
        
?>

    <h2>Дополнительная страница</h2>
    <div>
        <div class="rb_gallery-innerBox">
            <div id="rb_gallery-inner">
                <?php 
        
                    $massImgId = explode(",", $gallery->foto);
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
        <input type="hidden" name="dop" value="gallery" />
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