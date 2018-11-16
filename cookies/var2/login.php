<?php session_start();
if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    if (isset($_POST['remember'])) {
        setcookie('remember','1');
    }
    header('location: a.php');
    exit;
}
?>
<form action="" method="post">
    <input type="text" name="username" value="" />
    <input type="submit" name="submit" value="submit" />
    <input type="checkbox" name="remember">
</form>