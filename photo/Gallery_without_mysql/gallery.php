<link rel="stylesheet" type="text/css" href="gallery.css" />

<div id="container">
<div id="heading"> <!-- Заголовок -->
  <h1>Фотогалерея</h1>
  </div>
  <div id="gallery"> <!-- это блок для изображений -->
<?php

$directorySmall = 'img/small/';	//название папки с изображениями
$directoryBig = 'img/big/';
$allowed_types=array('jpg','jpeg','gif','png');	//разрешеные типы изображений
$file_parts=array();
$ext='';
$title='';
$i=0;
//пробуем открыть папку
$dir_handle = @opendir($directorySmall) or die("There is an error with your image directory!");
while ($file = readdir($dir_handle))	//поиск по файлам
{
    if($file=='.' || $file == '..') continue;	//пропустить ссылки на другие папки
    $file_parts = explode('.',$file);	//разделить имя файла и поместить его в массив
    $ext = strtolower(array_pop($file_parts));	//последний элеменет - это расширение
    $title = implode('.',$file_parts);
    $title = htmlspecialchars($title);
    $nomargin='';
    if(in_array($ext,$allowed_types))
    {

        if(($i+1)%4==0) $nomargin='nomargin';	//последнему изображению в ряде присваевается CSS класс "nomargin"
        echo '
  <div class="pic '.$nomargin.'" style="background:url('.$directorySmall.'/'.$file.') no-repeat 50% 50%;">
  <a href="'.$directoryBig.'/'.$file.'" title="'.$title.'" target="_blank">'.$title.'</a>
  </div>';
        $i++;
    }
}
closedir($dir_handle);	//закрыть папку

  ?>
<div class="clear"></div> <!-- using clearfix -->
  </div>
<div id="footer"> <!-- футер -->
  </div>
</div> <!-- закрывающий div -->


<!--  есть минус, автоматически не обновляет галерею, f5 нужно нажимать. технология AJAX Нужна -->

