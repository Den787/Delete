<?php

$db = mysqli_connect('localhost','root', '','example');
mysqli_set_charset($db, 'utf8');

//check connection
if (mysqli_connect_errno()) {

    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();

}

