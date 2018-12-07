<?php
include "bd.php";
$filename = $_GET['imageName'];
$directoryBig = 'img/big/';
$result = $directoryBig.$filename;

//сюда надо добавить счетчик кликов +1
$file_parts = explode('.',$filename);
$name = array_shift($file_parts);
$ext = array_pop($file_parts);



$sql = mysqli_query($db,"SELECT id, image_id, ext, click FROM image WHERE image_id = '{$name}';");
$row = mysqli_fetch_array($sql);
$count = $row["click"];


?>
<html>
<head>
    <title>Просмотр фотографии</title>
    <meta http-equiv="imagetoolbar" content="no">
</head>
<body marginheight="0" marginwidth="0" rightmargin="0" bottommargin="0" leftmargin="0" topmargin="0" bgcolor="white">
<p>Количество просмотров = <?php echo $count ?></p>
<img src="<?php echo $result ?>"  border="0">
</body>
</html>

<?php  //почему данный скрипт если в начале кода установить то картинка не отображается???
$update = "UPDATE image SET click = click + 1 WHERE image_id = '{$name}';"; //счетчик кликов +1
$result = mysqli_query($db, $update);



?>

<!--
 $update = "UPDATE image SET click = click + 1 WHERE image_id = {$row["image_id"]};"; //счетчик кликов +1
$result = mysqli_query($db, $update);
-->