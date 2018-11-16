
<?php

session_start();

$username = $_SESSION['username'];

if($username == NULL){
header("Location: login.php");
exit();
}

if(isset($_COOKIE['username'])) {
header("Location: ".$_SERVER['PHP_SELF']);
}

?>




<html>
<head>
<title>A</title>
</head>
<body>
<a href="var1/b.php">Go to B PAGE</a>
<p>Welcome to A PAGE</p>
<p>Your enter for <?echo $username;?><a href="login.php">Logout</a></p>
<body>
</html>