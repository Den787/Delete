<?php
header("Content-type: text/html; charset=utf-8");
session_start();

//Запись в cookie адреса страницы, то же самое для страницы b.php с таким же именем
$lastPage = $_SERVER['REQUEST_URI'];
setcookie('lastPage', $lastPage);

//Если сессия создана, то поприветствовать пользователя и подключить файл logaut.php с кнопкой Выйти
if(!empty($_SESSION['auth'])){
    echo "Добро пожаловать, ". $_COOKIE['name'] .". Вы авторизованы. <br>";
    include_once("logaut.php");

    //Если нажата кнопка Выйти в файле logaut.php, то уничтожить сессии
    if(isset($_POST['submit'])){
        session_destroy();
    }
}
?>
<h3>Страница A.php</h3>

Перейти на страницу index.php <a href="index.php"><input type="submit" value="index.php"></a><br><br>
Перейти на страницу b.php <a href="b.php"><input type="submit" value="b.php"></a><br><br>
Вернутся в начало <a href="../../index.php"><input type="submit" value="В начало"></a><br><br>