<link rel="stylesheet" type="text/css" href="demo.css" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-darkness/jquery-ui.css"
      type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.2.6.css">




<!-- Контейнер: -->
<div id="gallery">
    <?php
    /* Начало конфигурации */
    $thumb_directory = 'small';
    $orig_directory = 'big';
    $stage_width=600;
    $stage_height=400;
    /* Конец конфигурации */
    $allowed_types=array('jpg','jpeg','gif','png');
    $file_parts=array();
    $ext='';
    $title='';
    $i=0;

    /* Открываем папку с миниатюрами и пролистываем каждую из них */
    $dir_handle = @opendir($thumb_directory) or die("There is an error with your 
image directory!");
    $i=1;

    while ($file = readdir($dir_handle))
    {
        /* Пропускаем системные файлы: */
        if($file=='.' || $file == '..') continue;
        $file_parts = explode('.',$file);
        $ext = strtolower(array_pop($file_parts));

        /* Используем название файла (без расширения) в качестве названия изображения:
        */
        $title = implode('.',$file_parts);
        $title = htmlspecialchars($title);

        /* Если расширение разрешено: */
        if(in_array($ext,$allowed_types))
        {
            /* Генерируем случайные значения для позиционирования и поворота фото: */
            $left=rand(0,$stage_width);

            $top=rand(0,400);
            $rot = rand(-40,40);
            if($top>$stage_height-130 && $left > $stage_width-230)
            {
                /* Prevent the images from hiding the drop box */
                $top-=120+130;
                $left-=230;
            }
            /* Выдаем каждое фото: */
            echo '
<div id="pic-'.($i++).'" class="pic" style="top:'.$top.'px;left:'.$left.'px;background:url('.$thumb_directory.'/'.$file.') 
no-repeat 50% 50%; -moz-transform:rotate('.$rot.'deg); -webkit-transform:rotate('.$rot.'deg);">

<a class="fancybox" rel="fncbx" href="'.$orig_directory.'/'.$file.'" 
target="_blank">'.$title.'</a>
</div>';
        }
    }
    /* Закрываем папку */
    closedir($dir_handle);
    ?>
    <!-- Ячейка для распространения фото -->
    <div class="drop-box">
    </div>
</div>
<div class="clear"></div>
<!-- Это конвертируется в модальном окно с УРЛом изображения: -->
<div id="modal" title="Share this picture">
    <form>
        <fieldset>
            <label for="name">URL of the image</label>
            <input type="text" name="url" id="url" class="text ui-widget-content ui-corner-all"
                   onfocus="this.select()" />
        </fieldset>
    </form>
</div>


