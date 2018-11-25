<!--
1. возможность загрузки фотографии на сервер (при загрузке должен проверяться тип
файла)

2. при загрузке должна автоматически создаваться ее уменьшенная копия (не более
200 пикселей по наибольшей стороне)
-->



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Загрузка картинок</title>
</head>
<body>


<?php

if (isset($_POST['submit']))  {
    $uploadDirBig = 'img/big/';
    $uploadDirSmall = 'img/small/';
    //вопрос: а есть ли возможность хранить файлы в другом месте, отличающимся от проекта? скажем на диске C:
    // - у меня превьюшка не отображается если файлы не в проекте
    $filename = $_FILES['upload']['name'];
    $target = $uploadDirBig. $filename;
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
            $im = imagecreatefromjpeg($uploadDirBig . $filename);
            break;

        case 'image/png':
            $im = imagecreatefrompng($uploadDirBig . $filename);
            break;

        default:
            echo 'Файл неподдерживаемого типа <br>';
            exit;
    }

    $ox = imagesx($im);
    $oy = imagesy($im);
    $nx = $final_width_of_image;
    $ny = floor($oy * ($final_width_of_image / $ox));
    $nm = imagecreatetruecolor($nx, $ny);

    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

    if(!file_exists($uploadDirBig)) {
        if(!mkdir($uploadDirSmall)) {
            die("Возникли проблемы! попробуйте снова!");
        }
    }
    imagejpeg($nm, $uploadDirSmall . $filename);
    $tn = '<img src="' . $uploadDirSmall . $filename . '" alt="image" />';
    $tn .= '<br />Ваше изображение успешно загружено и его миниатюра удачно выполнена. Выше Вы можете просмотреть результат:';
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
