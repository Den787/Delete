<?php

$connect = mysqli_connect('localhost','root', '','gallery');

mysqli_set_charset($connect, 'utf8');

//check connection
if (mysqli_connect_errno()) {

    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();

}