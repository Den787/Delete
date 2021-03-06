<?php
session_start();

include_once("configs.php");

/****/
if (!defined("included"))
    printAuthForm();

/****/

function isAuth() {
    return $_SESSION['is_wery_auth'] === true;
}

function logout() {
    $_SESSION['is_wery_auth'] = false;
    session_destroy();
    //header("location: index.php");
    header("location: " . $_SERVER['HTTP_REFERER']); //перенаправить туда, откуда пришёл пользователль.
}

function printAuthForm() {
    global $good_pass;

    if (isset($_POST['act']) and $_POST['act'] == 'auth') {
        if (ADMIN_PASS == $_POST['passw0rd']) {
            $_SESSION['is_wery_auth'] = true;
            header("location: index.php");
            die();
        } else {
            $error = "Не правильный пароль...";
        }
    }    
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
    <style>
 @charset "utf-8";
body {
	background: url(img/bg.png) repeat;
	color: #999;
	font: 100%/1.5em sans-serif;
	margin: 0;
}

h1 { margin: 0; }

a {
	color: #999;
	text-decoration: none;
}

a:hover { color: #1dabb8; }

fieldset {
	border: none;
	margin: 0;
}

input {
	border: none;
	font-family: inherit;
	font-size: inherit;
	margin: 0;
	outline: none;
	-webkit-appearance: none;
}

input[type="submit"] { cursor: pointer; }

.clearfix { *zoom: 1; }
.clearfix:before, .clearfix:after {
	content: "";
	display: table;	
}
.clearfix:after { clear: both; }

#login-form {
	margin: 150px auto;
	width: 300px;
}

#login-form h1 {
	background-color: #282830;
	border-radius: 5px 5px 0 0;
	color: #fff;
	font-size: 14px;
	padding: 20px;
	text-align: center;
	text-transform: uppercase;
}

#login-form fieldset {
	background: #fff;
	border-radius: 0 0 5px 5px;
	padding: 20px;
	position: relative;
}

#login-form fieldset:before {
	background-color: #fff;
	content: "";
	height: 8px;
	left: 50%;
	margin: -4px 0 0 -4px;
	position: absolute;
	top: 0;
	-webkit-transform: rotate(45deg);
	-moz-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	-o-transform: rotate(45deg);
	transform: rotate(45deg);
	width: 8px;
}

#login-form input {
	font-size: 14px;
}

#login-form input[type="email"],
#login-form input[type="password"] {
	border: 1px solid #dcdcdc;
	padding: 12px 10px;
	width: 238px;
}

#login-form input[type="email"] {
	border-radius: 3px 3px 0 0;
}

#login-form input[type="password"] {
	border-radius: 0px 0px 3px 3px;
}

#login-form input[type="submit"] {
	background: #1dabb8;
	border-radius: 3px;
	color: #fff;
	float: right;
	font-weight: bold;
	margin-top: 20px;
	padding: 12px 20px;
}

#login-form input[type="submit"]:hover { background: #198d98; }

#login-form footer {
	font-size: 12px;
	margin-top: 16px;
}

.info {
	background: #e5e5e5;
	border-radius: 50%;
	display: inline-block;
	height: 20px;
	line-height: 20px;
	margin: 0 10px 0 0;
	text-align: center;
	width: 20px;
}
    </style>
</head>
<body>

    <div id="login-form">
        <h1>Авторизация</h1>
        <fieldset>
            <form action="" method="POST">
                <input type="password" name="passw0rd" value="<?php if (isset($_POST['passw0rd'])) echo $_POST['passw0rd']; ?>" />
                <input type="hidden" name="act" value="auth" />
                <?php if (isset($error)) echo "<font color=red>$error</font>"; ?>
                <input type="submit" value="Войти" />
            </form>
        </fieldset>

    </div>
</body>
</html>

</body>
</html>
    
    <?php
}
