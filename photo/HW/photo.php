<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Загрузка картинок</title>
</head>
<body>

<?php

if (isset($_POST['submit']))  {
    $uploadDir = 'C:/img/big/';
    $uploadDirSmall = 'C:/img/small/';
    $oldName = $_FILES['upload']['name'];
    $uploadFile = $uploadDir.basename($oldName);
    $uploadInfo = $_FILES['upload'];

    //Проверяем тип загружаемого файла
    switch ($uploadInfo['type']) {
        case 'image/jpeg':
            echo 'Файл '.$oldName.' загружен <br>';
            break;

            case 'image/png':
            echo 'Файл '.$oldName.' загружен <br>';
            break;

        default:
            echo 'Файл неподдерживаемого типа <br>';
            exit;
    }



    //<Безопасно перемещаем файл из временной папки в указанную
          if (!move_uploaded_file($uploadInfo['tmp_name'], $uploadFile)) {
              echo 'Не удалось осуществить сохранение файла';
          }


/*    //теперь делаем копию и уменьшаем или сначала уменьшаем пока не знаю, пробую

    //Уменьшаем картинку... типа лучше ImageMagick(надо посмотреть)
    $old = imageCreateFromJpeg($uploadFile);  //обращаемся к самой картинке в big
// Размеры старой картинки
    $old_w = imageSX($old);
    $old_h = imageSY($old);  //ОТрабатывает


// Новый размер должен быть в пределах 200х200
// Y X нужно просчитать
    if ($old_w > 200 || $old_h > 200) {
        header('Content-type: image/jpeg');
        $new = imageCreateTrueColor( 200, 200);
        imageCopyResampled($new, $old, 0, 0, 0, 0, $image_x, Y, X, $old_h);
        imagejpeg($new, $uploadDirSmall, 75);
        imagedestroy($new);
    }
*/

// задание максимальной ширины и высоты
    $width = 200;
    $height = 200;

    // тип содержимого
    header('Content-Type: image/jpeg');

// получение новых размеров
    list($width_orig, $height_orig) = getimagesize($uploadFile);

    $ratio_orig = $width_orig/$height_orig;

    if ($width/$height > $ratio_orig) {
        $width = $height*$ratio_orig;
    } else {
        $height = $width/$ratio_orig;
    }

// ресэмплирование
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($uploadFile);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

// вывод
    imagejpeg($image_p, $uploadDirSmall, 100);



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
