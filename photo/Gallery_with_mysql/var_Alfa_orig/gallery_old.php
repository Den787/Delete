<?php

include ("bd.php"); //подключение к базе данных

$directorySmall = 'img/small/';	//название папки с изображениями
$directoryBig = 'img/big/';

$sql = mysqli_query($db,"SELECT id, img_id, ext FROM image");
// Выбор из базы данных полей id и dir_small

if (!$sql)
{
exit();
}

if (mysqli_num_rows($sql) > 0)
{
@$row=mysqli_fetch_array($sql);
$i=1;
do
{
echo "<table><tr><td valign='top'>";
            echo $i++;
            echo "<td>";
            echo "<img src=' {$directorySmall}.$row[img_id].$row[ext]' class='img'/>";
            echo "</td></tr></table><br>";

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















 <!-- тут есть сортировка!!!! -->

<!--
<script type="text/javascript">
    $(document).ready(function() {
        $("a.gallery").fancybox({
            'transitionIn'	:	'elastic',
            'transitionOut'	:	'elastic',
            'speedIn'		:	600,
            'speedOut'		:	200,
            'overlayShow'	:	true
        });
    });
</script>  -->

<?php /*
include 'bd.php';

 $directorySmall = 'img/small/';	//название папки с изображениями
$directoryBig = 'img/big/';


      $gp=mysqli_query("select * from image  order by click");
      $i=1;
      while($pho = mysqli_fetch_array($gp)){
          if ($i==1){ echo "<table><tr>"; $allcl=false; }
          echo "<td><a class=\"gallery\" rel=\"group\" title='{$pho['comment']}' href=\"upload/{$pho['big']}\">
<img src=\"upload/{$pho['small']}\"></a></td>";

          if ($i%3==0){ echo "</tr><tr>"; }
          $i++;
      }
      echo "</table>"; */




  ?>



<!--  есть минус, автоматически не обновляет галерею, f5 нужно нажимать. технология AJAX Нужна -->

