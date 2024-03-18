<?php
session_start();
include "config.php";
if(isset($_POST['vhod'])){
$login = strip_tags($_POST['login']);
$password = strip_tags($_POST['password']);
}
if (!empty($_SESSION['id'])) {
    header("location: profile.php");
    exit();
}

if (!empty($login) && !empty($password)) {
    $select_sql = $sql->query("SELECT * FROM `users` WHERE `login`='$login' and `password`='$password'");
    $select_res = $select_sql->fetch_array();
    if (!empty($select_res['ID'])) {        

        $_SESSION['id']=$select_res['ID'];
        $_SESSION['login']=$select_res['login'];
        $_SESSION['fn']=$select_res['firstn'];
        $_SESSION['ln']=$select_res['lastn'];
        $_SESSION['mn']=$select_res['midlen'];
        $_SESSION['adm']=$select_res['status'];
        $_SESSION['mail']=$select_res['E-mail'];            
        header("location: profile.php");
        exit();
                
    }
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Городской портал | HappyCity</title>
        <link rel="shortcut icon" href="" type="image/x-icon">
        <link href="styles/style2.css" rel="stylesheet" type="text/css">
        <link href="styles/style3.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <form class="vhod" action="" method="POST">
            <div class="regheader"><h1 class="regtxt">Вход</h1></div>
            <div class="polya2">
                <div class="pole">
                    <p class="info" >Логин:</p>
                    <input id="login1" name="login">
                </div>
                <div class="pole">
                    <p class="info">Пароль:</p>
                    <input id="psw1" name="password">
                </div>
                <a href="#" class="par">Забыли пароль?</a>
                <div class="button" style="margin-top: 38px; display: flex; justify-content: center; margin-left: 50px;">
                    <input type="submit" class="buttonvhod" id="vhod" style="margin-top: 10px; margin-right: 0;" value="Войти" name="vhod">
                </div>
                <?
                    if (!empty($login) || !empty($password)){
                        if (empty($select_res['ID'])){
                            echo '
                            <p id="wrongpsw" style="margin-left: 76px;">Неверный логин или пароль</p>
                                ';

                            }
                        }

                ?>
                
            </div>
        </form>
    </body>
</html>