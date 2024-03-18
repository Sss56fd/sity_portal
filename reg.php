<?php
header('content-type: text/html; charset=utf-8');
session_start();
for($i=0;$i<7;$i++){
    $check[$i]=0;
}
include "config.php";

if(!empty($_SESSION['id'])){
    header("location: profile.php");
    exit();
}
if(isset($_POST['btn'])){
$reg[0]=strip_tags($_POST['f']);
$reg[1]=strip_tags($_POST['i']);
$reg[2]=strip_tags($_POST['o']);
$reg[3]=strip_tags($_POST['login']);
$reg[4]=strip_tags($_POST['mail']);
$reg[5]=strip_tags($_POST['password_1']);
$reg[6]=strip_tags($_POST['password_2']);
}
function rus($text){
    
    if (!preg_match("/[^А-ЯЁа-яё]/iu", $text)) {
        return 0;
    }
    else return 1;
}

if (isset($_POST['btn'])) {
    for ($i=0; $i < count($reg); $i++) { 
        if(empty($reg[$i])){$check[$i] = 1; continue;}

        else $check[$i]=0;

        if ($i==0 || $i==1 || $i==2){
            $check[$i]=rus($reg[$i]);
        }
        else if($i==3) {
            $check_login_sql=$sql->query("SELECT `login` FROM `users` WHERE `login`='$reg[$i]'");
            $check_login_res=$check_login_sql->fetch_array();
            if (!empty($check_login_res['login'])) {
                $check[$i]=1;
            }
        }
        else if ($i==4) {
            $check_dog=0;
            $check_at=0;
            for ($j=0; $j < strlen($reg[$i]); $j++) { 
                if ($reg[$i][$j]=='@'){$check_dog=1; $j+=2;}
                if($check_dog==1 && $reg[$i][$j]=='.')$check_at=1;
            }
            if ($check_dog==1 && $check_at==1) {
                $check_login_sql=$sql->query("SELECT `E-mail` FROM `users` WHERE `E-mail`='$reg[$i]'");
                $check_login_res=$check_login_sql->fetch_array();
                if (!empty($check_login_res['E-mail']))$check[$i]=1;
            }
            else{
                $check[$i]=1;
            }
        }
        else if ($i==5 && $reg[$i]!=$reg[6]){
            $check[$i]=1;
        }
    }
    $check_i=0;
    for ($i=0; $i < count($check); $i++) { 
        if ($check[$i]==0)$check_i++;
    }
    if ($check_i==count($check)) {
        $sql->query("INSERT INTO `users` (`login`,`password`,`lastn`,`firstn`,`midlen`,`E-mail`) VALUES ('$reg[3]','$reg[6]','$reg[0]','$reg[1]','$reg[2]','$reg[4]')");

        $select_sql = $sql->query("SELECT * FROM `users` WHERE `login`='$reg[3]' and `password`='$reg[5]'");
        $select_res = $select_sql->fetch_array();       
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
        <form class="reg" action="" method="POST">
            <div class="regheader"><h1 class="regtxt">Регистрация</h1></div>
            <div class="polya">
                <div class="pole"><p class="info">Фамилия:</p>
                <?
                if ($check[0]==1) {
                    echo'<input id="fio" name="f" placeholder="Только Кириллица">';
                }
                else {
                    echo '<input id="fio" name="f">';
                }
                ?>
                </div>

                <div class="pole"><p class="info">Имя:</p>
                <?
                if ($check[1]==1) {
                    echo'<input id="fio" name="i" placeholder="Только Кириллица">';
                }
                else {
                    echo '<input id="fio" name="i">';
                }
                ?>
                </div>
                <div class="pole"><p class="info">Отчество:</p>
                <?
                if ($check[2]==1) {
                    echo'<input id="fio" name="o" placeholder="Только Кириллица">';
                }
                else {
                    echo '<input id="fio" name="o">';
                }
                ?>

                </div>

                <div class="pole"><p class="info">Логин:</p>
                <?
                if ($check[3]==1) {
                    echo'<input id="login" name="login" placeholder="Занято или пусто">';
                }
                else {
                    echo '<input id="login" name="login">';
                }
                ?>
                </div>
                <div class="pole"><p class="info">Email:</p>
                <?
                if ($check[4]==1) {
                    echo'<input id="email" name="mail" placeholder="Занято или почты нет">';
                }
                else {
                    echo '<input id="email" name="mail">';
                }
                ?>
                </div>
                <div class="pole"><p class="info">Пароль:</p>
                <?
                if ($check[5]==1) {
                    echo'<input id="password" name="password_1" placeholder="Пароли не совпадают">';
                }
                else {
                    echo '<input id="password" name="password_1">';
                }
                ?>
                </div>
                <div class="pole"><p class="info" style="padding-top: 5px;">Повторите<br>пароль:</p>
                    <input type="password" id="confirm-password" style="margin-top: -56px;" name="password_2">

                </div>
                <div class="pole" style="display: flex;"><input class="sogl" type="checkbox"><a href="#" class="info" style="font-size: 18px; margin-left: -9px; margin-top: -10px;">Согласие на обработку данных</a></div>
                <input type="submit" name="btn" style="cursor: pointer; margin-right: 45px; " value="Зарегистрироваться" class="button">
            </div>
        </form>
    </body>
</html>