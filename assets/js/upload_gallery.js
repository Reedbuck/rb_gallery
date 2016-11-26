jQuery(function($){
   
	$('.upload_image_button').click(function(e) {  
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
            var fotomasId;
            var massive;
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(button).parent().prev().attr('src', attachment.url);
            
            $(button).prev().val(attachment.id);
            var zapis = '0';
            var cast = $.each(fotomas, function(key, value){
                fotomasId = fotomas[key].url;
                zapis += ',' + fotomasId ;
                alert(key + ': ' + value);
                alert(fotomasId);
                alert(zapis);
                $("input[name='option1']").val(zapis);
                massive = zapis.split(',');
                
            });
            for (var i = 1; i < massive.length; i++) {
                var massiveInner = '<img data-src="' + massive[i] + '" src="' + massive[i] + '" width="150px" />';
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
