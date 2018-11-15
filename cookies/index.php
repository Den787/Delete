<?php

if (isset($_POST['name']) && (!empty($_POST['name']))) {
    $name = $_POST['name'];
    setcookie('name', $name);
    // echo $name;

}
elseif (isset($_COOKIE['name'])) {   //проверка куки
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
    <title>Страница index.php</title>
</head>
<body>
    <h1>Страница index.php</h1>
    <a href="page.php">Страница page.php</a>

    <br><br>
    <p>Привет, <?php echo $name ?></p>
    <form method="post">
        <input type="text" name="name" />
        <input type="submit" />


</body>
</html>
