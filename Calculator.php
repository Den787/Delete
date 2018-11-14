<?php
include_once 'funcCalculator.php';

    $a = $_GET['a'];
    $b = $_GET['b'];
    $znak = $_GET['znak'];


        $result = calc($a,$znak,$b);
        print_r($result);

    echo "Форма отправлена a = $a, znak = $znak, b = $b; <br/>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form action="funcCalculator.php" method="get">
    A: <input type="text" name="a"><br>
    B: <input type="text" name="znak"><br>
    C: <input type="text" name="b"><br>
    <input type="submit" value="Submit" name="submit">
</form>

</body>
</html>
