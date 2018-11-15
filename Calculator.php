<?php
include_once 'funcCalculator.php';

if  (isset($_POST['submit'])) {
    $a = $_POST['a'];
    $b = $_POST['b'];
    $znak = $_POST['znak'];


    if (!empty($a) && !empty($znak) && !empty($b)) {

        if (is_numeric($a) && is_numeric($b)) {

            $result = calc($a, $znak, $b);

            if ($result != false) {

               print_r($result);
               $x = $result;

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

<form action="Calculator.php" method="post">
    <p> Введите число 1: </p>
    <input type="text" name="a"><br>
    <p> Введите знак: </p>
    <input type="text" name="znak"><br>
    <p> Введите число 2: </p>
    <input type="text" name="b"><br><br>
    <input type="submit" value="Посчитать" name="submit">
    <p> Ответ: </p>
    <input type="text" disabled  value="<?php echo $x ?>">
    <input type="reset" value="Очистить форму">
</form>

</body>
</html>
