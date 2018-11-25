<?php
echo"<a href='add_images_form.php' class='add_images'>
<div class='add_images_text'>ДОБАВИТЬ КАРТИНКУ</div>
</a><br><br>";

include ("bd.php"); //подключение к базе данных



$sql = mysqli_query($db,"SELECT id, img FROM 3_images");

// Выбор из базы данных полей id и img
if (!$sql) {
exit();
}

if (mysqli_num_rows($sql) > 0) {
@$row=mysqli_fetch_array($sql);
$i=1;

do {
echo "<table><tr><td valign='top'>";
echo $i++;
echo "<td>";
echo "<img src='img/$row[img]' class='img'/>";
echo "</td></tr></table><br>";
}

while (@$row = mysqli_fetch_array($sql));
}

else {
echo "<label class='label'>В базе данных нет 
добавленных картинок!</label>";
exit();

}


