<?php
header("Content-type: text/html; charset=utf-8");

//Если нажата кнопка Войти ...
if(isset($_POST['submit'])){

    //Проверить, не пустая ли переменная $_POST['name']
    if(!empty($_POST['name'])){

        //Если логин введен, то записать имя в cookie и открыть сессию со знчением true. Редирект на последнюю посещенную страницу, адрес которой в $_COOKIE['lastPage']
        session_start();
        $name = $_POST['name'];
        setcookie('name', $name);
        $_SESSION['auth'] = true;
        header("Location: ". $_COOKIE['lastPage']);

    }else{
        //Иначе, если нажата кнопка Войти, но форма, то есть переменная $_POST['name'] пустая, то вывести предупреждение
        echo "Вы не ввели логин. Заполните форму <br>";
    }
}
?>
<h3>Cтраница авторизации</h3>
<form action="" method="post">
    Ваше логин: <input type="text" name="name"><br>
    <input type="submit" name="submit" value="Войти"><br>
</form>
