<?php

/*
*
* НАЧАЛО ШОРТКОДА
*
*/

function rb_gallery_shortcode($atts) {
    
    extract(shortcode_atts(array(
    'id' => '1',
    'type' => 'slider'
    ), $atts));
    
    global $wpdb;
    $table_name = $wpdb->prefix . "rb_gallery";

    $gallery = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE `id` = %d LIMIT 1;", $id ));

    
    $massImgId = explode(",", $gallery->foto);
                    if($massImgId){
                        for($i = 1; $i < count($massImgId); ++$i){ 
                        $image_attributes = wp_get_attachment_image_src( $massImgId[$i], array($w, $h) );
                        $image_src = $image_attributes[0];
                        echo '<div class="rb_gallery-slider"><img src='. $image_src .'></div>';
                            
                
                        }
                    } 
    
    
    
}
add_shortcode('rb_gallery', 'rb_gallery_shortcode');

/*
*
* КОНЕЦ ШОРТКОДА
*
*/


?>