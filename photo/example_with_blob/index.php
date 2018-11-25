<?php

$imgData = file_get_contents($filename);
$size = getimagesize($filename);
mysqli_connect("localhost", "$username", "$password");
mysqli_select_db ("$dbname");
// mysqli
// $link = mysqli_connect("localhost", $username, $password,$dbname);
$sql = sprintf("INSERT INTO testblob
    (image_type, image, image_size, image_name)
    VALUES
    ('%s', '%s', '%d', '%s')",

    mysqli_real_escape_string($size['mime']),
    mysqli_real_escape_string($imgData),
    $size[3],
    mysqli_real_escape_string($_FILES['userfile']['name'])
);
mysql_query($sql);