<?php
if (isset($_POST['submit'])) {

    echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>';
}


$directory = 'big';	//название папки с изображениями
$allowed_types=array('jpg','jpeg','gif','png');	//разрешеные типы изображений
$file_parts=array();
$ext='';
$title='';
$i=0;
//пробуем открыть папку
$dir_handle = @opendir($directory) or die("There is an error with your image directory!");
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
  <div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
  <a href="'.$directory.'/'.$file.'" title="'.$title.'" target="_blank">'.$title.'</a>
  </div>';
        $i++;
    }
}
closedir($dir_handle);	//закрыть папку
