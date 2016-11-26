jQuery(function($){
   
	$('.rb_gallery-no-image').click(function(e) {  
        e.preventDefault();                  
        var button = $(this);               
        var custom_uploader = wp.media({ 
            title: 'Выберите или загрузите фото || для выбора нескольких фотографий - зажмите ctrl',          
            button: {       
                text: 'Добавить'           
            },
            multiple: true              
        }).on('select', function() {
            var fotomas = custom_uploader.state().get('selection').toJSON();
            var fotoUrl;
            var fotoId;
            var massive;
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(button).parent().prev().attr('src', attachment.url);
            
            $(button).prev().val(attachment.id);
            var fotoMassUrl = '0';
            var fotoMassId = '0';
            var cast = $.each(fotomas, function(key, value){
                fotoUrl = fotomas[key].url;
                fotoId = fotomas[key].id;
                fotoMassUrl += ',' + fotoUrl ;
                fotoMassId += ',' + fotoId ;
                alert(key + ': ' + value);
                alert(fotoUrl);
                alert(fotoMassUrl);
                $("input[name='rb_gallery-massImgId']").val(fotoMassId);
                massive = fotoMassUrl.split(',');
                
            });
            for (var i = 1; i < massive.length; i++) {
                var massiveInner = '<div class="rb_gallery-ImgCash"><img data-src="' + massive[i] + '" src="' + massive[i] + '" width="200px" /></div>';
                document.getElementById('rb_gallery-inner').innerHTML += massiveInner;
            }
            
            
            
        }).open();
        
    });
	
	$('.remove_image_button').click(function(){
		var r = confirm("Уверены?");
		if (r == true) {
			var src = $(this).parent().prev().attr('data-src');
			$(this).parent().prev().attr('src', src);
			$(this).prev().prev().val('');
		}
		return false;
	});
});
