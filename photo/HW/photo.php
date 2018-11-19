<?php

if (isset($_POST['submit'])) {

    echo '<pre>';
    print_r($_POST);
    print_r(basename($_FILES));
    echo '</pre>';

    if (empty($_FILES['file']['size'])) die('Вы не выбрали файл');
    if ($_FILES['file']['size'] > (5 * 1024 * 1024)) die('Размер файла не должен превышать 5Мб');
    $imageinfo = getimagesize($_FILES['file']['tmp_name']);
    $arr = array('image/jpeg', 'image/gif', 'image/png');
    if (!array_search($imageinfo['mime'], $arr)) echo('Картинка должна быть формата JPG, GIF или PNG');
    else {
        $uploaddir = '../i/'; //Обработчик кнопки "Обзор
        $picture = $uploaddir . md5(time());// для записи имени товара в базу
        $uploadfile = $picture . ".jpg";//для записи картинки в папку

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            echo "File is valid, and was successfully uploaded.\n";
        } else {
            echo "File uploading failed.\n";
        }
    }


}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form action="Photo.php" method="post" enctype="multipart/form-data">
    <p> Загрузка фотографий </p>
    <input type="file" name="file"><br>
    <input type="reset" value="Очистить форму">
    <input type="submit" value="Отправить" name="submit">

</form>

</body>
</html>

