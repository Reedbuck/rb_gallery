$(document).ready(function() { // Ждём загрузки страницы
    $(".rb_gallery-image").click(function(){	// Событие клика на маленькое изображение
        var img_url = $(this).attr("src"); // Достаем из этого изображения путь до картинки
        $(".rb_gallery-popupImg").attr("src", img_url);
        $(".rb_gallery-popup").fadeIn(500); // Медленно выводим изображение
        $(".rb_gallery-popupBg").click(function(){	// Событие клика на затемненный фон	   
            $(".rb_gallery-popup").fadeOut(500);	// Медленно убираем всплывающее окно
        });
    });	
});