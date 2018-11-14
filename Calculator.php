<?php
include_once 'funcCalculator.php';

if  (isset($_GET['submit'])) {
    $a = $_GET['a'];
    $b = $_GET['b'];
    $znak = $_GET['znak'];

    if (!empty($a) && !empty($znak) && !empty($b)) {

        if (is_numeric($a) && is_numeric($b)) {

            $result = calc($a, $znak, $b);

            if ($result != false) {

                print_r($result);

            }


        }
        else {
            echo "Введены не числа";
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

<form action="Calculator.php" method="get">
    Число 1: <input type="text" name="a"><br>
    Знак:    <input type="text" name="znak"><br>
    Число 2: <input type="text" name="b"><br>
    <input type="submit" value="Submit" name="submit">
</form>

</body>
</html>
