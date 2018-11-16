<?php
session_start();

$answer1 = $_SESSION['answer1'];
$answer2 = $_SESSION['answer2'];

$answer3 = $_POST['answer3'];

if (($answer1 == 4) && ($answer2 == 6) && ($answer3 == 8)) {
    echo "Все ок";
}
else {
    echo "Где то ошибка";
}

echo session_id(); //идентификатор, хранится локально на компе
echo session_name() //название сессии

?>



<p>Ваш результат</p>


