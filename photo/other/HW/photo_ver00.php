<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Загрузка картинок</title>
</head>
<body>

<?php

if (isset($_POST['submit']))  {
    $oldName = $_FILES['upload']['name'];
    $destination = $_SERVER['DOCUMENT_ROOT']. "/test1/photo/HW/big/".$oldName;  //место сохранения
    // файла на сервере + оставляет изначальное имя
    $uploadInfo = $_FILES['upload'];

    //Проверяем тип загруженного файла
    switch ($uploadInfo['type']) {
        case 'image/jpeg':
            echo 'Файл '.$oldName.' загружен';
            break;

        case 'image/png':
            echo 'Файл '.$oldName.' загружен';
            break;

        default:
            echo 'Файл неподдерживаемого типа';
            exit;
    }

    //Перемещаем файл из временной папки в указанную
    if (!move_uploaded_file($uploadInfo['tmp_name'], $destination)) {
        echo 'Не удалось осуществить сохранение файла';
    }
}
    ?>


    <form method="POST" enctype="multipart/form-data">
        <input name="upload" type="file">
        <br><br>
        <input type="submit" name="submit" value="Отправить">
    </form>

</body>
</html>
