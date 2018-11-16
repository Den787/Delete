<?php
session_start();
if(!empty($_SESSION['auth']) and $_SESSION['auth']){
    //Если переменная $_SESSION['auth'] существует и значение ее true, то редирект на последнюю посещенную страницу: a.php или b.php, адрес которой в $_COOKIE['lastPage']
    header("Location: ". $_COOKIE['lastPage']);
}else {
    //Иначе нужен редирект на страницу авторизации
    header("Location: auth.php");
}
?>