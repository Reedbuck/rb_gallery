<?php
class foobar_shortcode {
    
    static function init () {
      add_shortcode('rb_gallery', array(__CLASS__, 'rb_gallery_shortcode'));
    }

    function rb_gallery_shortcode($atts) {

        extract(shortcode_atts(array(
        'id' => '1',
        'type' => 'slider'
        ), $atts));

        wp_enqueue_script('frontpopapgalleryjs', plugins_url('assets/js/frontpopapgalleryjs.js', __FILE__), array('jquery'), null, false); 
        wp_enqueue_style('frontpopapgallerystyle', plugins_url('assets/css/frontpopapgallerystyle.css', __FILE__));

        global $wpdb;
        $table_name = $wpdb->prefix . "rb_gallery";

        $gallery = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE `id` = %d LIMIT 1;", $id ));


        $massImgId = explode(",", $gallery->foto);
        echo '<div class="rb_gallery">';
                        if($massImgId){
                            for($i = 1; $i < count($massImgId); ++$i){ 
                            $image_attributes = wp_get_attachment_image_src( $massImgId[$i], full );
                            $image_src = $image_attributes[0];
                            echo '<div class="rb_gallery-imgBox"><img src="'. $image_src .'" class="rb_gallery-image"></div>';


                            }
                        } 

        echo '</div>';

        echo '<div class="rb_gallery-popup">
                  <div class="rb_gallery-popupBg">
                      <img src="" class="rb_gallery-popupImg" />
                  </div>
              </div>';


    }
}
foobar_shortcode::init();
?>