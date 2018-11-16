<?php
session_start();

$answer2 = $_POST['answer2'];

$_SESSION['answer2'] = $answer2;

?>


<p>Вопрос 3:</p>
<p>4 + 4 = ?</p>

<form action="result.php" method="post">
    <input type="text" name="answer3">
    <input type="submit">
</form>