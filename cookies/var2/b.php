<?php
session_start();

setcookie('last_page',"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

echo "b";