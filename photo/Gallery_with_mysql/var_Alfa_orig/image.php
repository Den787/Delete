<?php
$filename = $_POST['img'];
?>
<html>
<head>
    <title>Просмотр фотографии</title>
    <meta http-equiv="imagetoolbar" content="no">
</head>
<body marginheight="0" marginwidth="0" rightmargin="0" bottommargin="0" leftmargin="0" topmargin="0" bgcolor="white">
<img src="<? echo $filename;?>" border="0">
</body>
</html>


<!--
и в основном коде другого файла, стоит вывод этого изображения
PHPВыделить код /*<?php echo '<img src="image.php?text='.$text.'&font='.$_POST['font'].'" alt="" title="" />' ; ?>
-->