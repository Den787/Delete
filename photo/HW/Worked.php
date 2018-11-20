<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Загрузка картинок</title>
</head>
<body>

<?php

if (isset($_POST['submit']))  {
    $path_to_image_directory = 'C:/img/big/';
    $path_to_thumbs_directory = 'C:/img/small/';
    $final_width_of_image = 200; //Размер изображения которые Вы хотели бы получить (И ШИРИНА И ВЫСОТА)

    if(isset($_FILES['fupload'])) {

        if(preg_match('/[.](jpg)|(gif)|(png)$/', //Ставим допустимые форматы изображений для загрузки
            $_FILES['fupload']['name'])) {

            $filename = $_FILES['fupload']['name'];
            $source = $_FILES['fupload']['tmp_name'];
            $target = $path_to_image_directory . $filename;

            move_uploaded_file($source, $target);

        //    createThumbnail($filename);
        }
    }





if(preg_match('/[.](jpg)$/', $filename)) {
  $im = imagecreatefromjpeg($path_to_image_directory . $filename);
  } else if (preg_match('/[.](gif)$/', $filename)) {
  $im = imagecreatefromgif($path_to_image_directory . $filename);
  } else if (preg_match('/[.](png)$/', $filename)) {
  $im = imagecreatefrompng($path_to_image_directory . $filename);
  } //Определяем формат изображения

  $ox = imagesx($im);
  $oy = imagesy($im);

  $nx = $final_width_of_image;
  $ny = floor($oy * ($final_width_of_image / $ox));

  $nm = imagecreatetruecolor($nx, $ny);

  imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

  if(!file_exists($path_to_thumbs_directory)) {
  if(!mkdir($path_to_thumbs_directory)) {
  die("Возникли проблемы! попробуйте снова!");
  }
  }
 imagejpeg($nm, $path_to_thumbs_directory . $filename);
  $tn = '<img src="' . $path_to_thumbs_directory . $filename . '" alt="image" />';
  $tn .= '<br />Поздравляем! Ваше изображение успешно загружено и его миниатюра удачно выполнена. Выше Вы можете просмотреть результат:';
  echo $tn;
  //Сжимаем изображение, если есть оишибки, то говорим о них, если их нет, то выводим получившуюся миниатюру


}

    ?>


    <!-- форма загрузки картинки -->
    <form method="POST" enctype="multipart/form-data">
        <input name="fupload" type="file">
        <br><br>
        <input type="submit" name="submit" value="Отправить">
    </form>







</body>
</html>
