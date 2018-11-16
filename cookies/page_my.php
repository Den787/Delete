<?php

if (isset($_COOKIE['name'])) {   //проверка куки
    $name = $_COOKIE['name'];
}

else {
    $name = 'Гость';  //если нет значений(по-умолчанию ставится)
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Страница page.php</title>
</head>
<body>
    <h1>Страница page.php</h1>
    <p>Привет, <?php echo $name ?></p>
    <a href="index_my.php">Страница index.php</a>

</form>


</body>
</html>
