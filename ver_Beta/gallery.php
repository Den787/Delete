<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="gallery.css" />

<div id="container">
<div id="heading"> <!-- Заголовок -->
  <h1>Фотогалерея</h1>
  </div>
  <div id="gallery"> <!-- это блок для изображений -->
<?php
include ("bd.php");


$directorySmall = 'img/small/';	//название папки с изображениями
$directoryBig = 'img/big/';
$nomargin = '';


$j=0;

$sql = mysqli_query($db,"SELECT id, image_id, ext, click FROM image ORDER BY click DESC");

if (!$sql) {
exit();
}

if (mysqli_num_rows($sql) > 0) {
$row=mysqli_fetch_array($sql);


    $i=1;

do {
    if(($j+1)%4==0) {
        $nomargin='nomargin';
    } 	//последнему изображению в ряде присваевается CSS класс "nomargin"
    echo '
  <div class="pic  '.$nomargin.'" style="background:url('.$directorySmall.$row["image_id"].'.'.$row["ext"].') no-repeat 50% 50%;">
  <a href="image.php?imageName='.$row["image_id"].'.'.$row["ext"].'"  target="_blank"> </a>
<!-- <a href="image.php"  target="_blank"><img src="'.$directoryBig.$row["image_id"].'.'.$row["ext"].'"> </a>  -->
<!-- .$sql2 = mysqli_query($db,"UPDATE image SET click = click + 1;"). -->
<!--<a href="image.php?imageName='.$row["image_id"].'.'.$row["ext"].'"  target="_blank"><img src="'.$directoryBig.$row["image_id"].'.'.$row["ext"].'"> </a> -->
  <!--  <a href="'.$directoryBig.$row["image_id"].'.'.$row["ext"].'"  target="_blank"> $info = mysqli_query($con,$query); </a>  -->
 <p>Количество просмотров = '.$count = $row["click"].'</p>  

  </div>';

    $j++;
$i++;
}


while (@$row = mysqli_fetch_array($sql));

}

else

{

echo "<label class='label'>В базе данных нет
    
    добавленных картинок!</label>";

exit();

}



  ?>
<div class="clear"></div> <!-- using clearfix -->
  </div>
<div id="footer"> <!-- футер -->
  </div>
</div> <!-- закрывающий div -->


<!--  есть минус, автоматически не обновляет галерею, f5 нужно нажимать. технология AJAX Нужна -->

