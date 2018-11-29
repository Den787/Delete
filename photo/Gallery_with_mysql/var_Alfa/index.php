
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Загрузка картинок</title>
</head>
<body>

<?php
include_once 'gallery.php';

if (isset($_POST['submit']))  {

    $filenameOld = $_FILES['upload']['name'];
    $ext = substr($filenameOld, strrpos($filenameOld, '.')+1); //расширение файла
    /*    $file_parts = explode('.',$filename);
        $naim = $file_parts;
        $ext = array_pop($file_parts);  такой тоже вариант норм */
    $prename = uniqid();
    $filename = $prename. '.'. $ext;
    
    $target = $directoryBig. $filename;
    $source = $_FILES['upload']['tmp_name'];
    $uploadInfo = $_FILES['upload'];
    $final_width_of_image = 200; // (И ШИРИНА И ВЫСОТА)

    //Проверяем тип загружаемого файла
    switch ($uploadInfo['type']) {
        case 'image/jpeg':
            echo 'Файл '.$filename.' загружен <br>';
            break;

        case 'image/png':
            echo 'Файл '.$filename.' загружен <br>';
            break;

        case 'image/gif':
            echo 'Файл '.$filename.' загружен <br>';
            break;

        default:
            echo 'Файл неподдерживаемого типа <br>';
            exit;
    }

    //<Безопасно перемещаем файл из временной папки в указанную
          if (!move_uploaded_file($source, $target)) {
              echo 'Не удалось осуществить сохранение файла';
          }

    //Делаем превьюшки
    switch ($uploadInfo['type']) {
        case 'image/jpeg':
            $im = imagecreatefromjpeg($directoryBig . $filename);


            break;

        case 'image/png':
            $im = imagecreatefrompng($directoryBig . $filename);
            break;

        case 'image/gif':
            $im = imagecreatefrompng($directoryBig . $filename);
            break;

        default:
            echo 'Файл неподдерживаемого типа <br>';
            exit;
    }

    if (isset($im)) {
        echo $prename;
        $q = "INSERT INTO image (image_id, ext, click) VALUES ('$prename', '$ext' , '0') ";
        $query = mysqli_query($db,$q);
    }
    else {
        echo 'Ошибка добавления в базу 1';
        }

  $ox = imagesx($im);
  $oy = imagesy($im);
  $nx = $final_width_of_image;
  $ny = floor($oy * ($final_width_of_image / $ox));
  $nm = imagecreatetruecolor($nx, $ny);

  imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

  if(!file_exists($directoryBig)) {
  if(!mkdir($directorySmall)) {
  die("Возникли проблемы! попробуйте снова!");
  }
  }
 imagejpeg($nm, $directorySmall . $filename);
  $tn = '<img src="' . $directorySmall . $filename . '" alt="image" />';
  $tn .= '<br />Картинка успешно загружена и ее миниатюра удачно выполнена. Выше Вы можете просмотреть результат:';
  echo $tn;


}
    ?>

    <!-- форма загрузки картинки -->
    <form method="POST" enctype="multipart/form-data">
        <input name="upload" type="file">
        <br><br>
        <input type="submit" name="submit" value="Отправить">
    </form>




</body>
</html>
