<?php

if (isset($_POST['submit'])) {

    echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>';
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

