<?php
session_start();
include "config.php";

//если пользователь не авторизован и хочет попавть в профиль, то его выгонят
if(empty($_SESSION['id'])){
    session_unset();
    session_destroy();
    header("location: vhod.php");
    exit();
}
if($_SESSION['adm']!='admin'){
    header("location: profile.php");
    exit();
}
//если пользователь нажал на выйти
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: main.php");
    exit();
}

$i=0;
$id = $_SESSION['id'];
$select_zaya_sql=$sql->query("SELECT * FROM `quests`");
while ($select_zaya_res[$i]=$select_zaya_sql->fetch_array()) {
    $login = $select_zaya_res[$i]['id пользователя'];
    $select_name_sql=$sql->query("SELECT `login` FROM `users` WHERE `ID` = '$login'");
    $select_name_res=$select_name_sql->fetch_array();
    $_SESSION[$i]['login']=$select_name_res['login'];
    $_SESSION[$i]['id_zaya']=$select_zaya_res[$i]['id заявки'];
    $_SESSION[$i]['stat_zaya']=$select_zaya_res[$i]['статус'];
    $_SESSION[$i]['kat']=$select_zaya_res[$i]['тема'];
    $_SESSION[$i]['title']=$select_zaya_res[$i]['название'];
    $_SESSION[$i]['describe']=$select_zaya_res[$i]['текст'];
    $_SESSION[$i]['date']=date('d.m.Y',strtotime($select_zaya_res[$i]['дата и время отправления']));
    $i++;
}

for ($j=0; $j < $i; $j++) { 
    if (isset($_POST['complete'.$j])) {
        $idza=$_SESSION[$j]['id_zaya'];
        $sql->query("UPDATE `quests` SET `статус`='Решена' WHERE `id заявки`='$idza'");
        header("location: quests.php");
        exit();
    }
    if(isset($_POST['cancel'.$j])){
        $idza=$_SESSION[$j]['id_zaya'];
        $sql->query("UPDATE `quests` SET `статус`='Отклонена' WHERE `id заявки`='$idza'");
        header("location: quests.php");
        exit();
    }

}




?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Городской портал | HappyCity</title>
        <link rel="shortcut icon" href="" type="image/x-icon">
        <link href="styles/style1.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        
        <header>
            <a href="main.php"><img src="images/logotip.png" alt="logo" class="logo"></a>
            <p class="logotxt">HappyCity</p>
            <h1 class="slogan">СДЕЛАЕМ ЛУЧШЕ ВМЕСТЕ!</h1>
            <form action="" method="POST">
                <input type="submit" class="profout" value="Выход" name="logout">
            </form>
            <?

            if($_SESSION['adm']=="admin"){
               echo '<h5 class="adm">Выполнен вход: администратор</h5>';
            }

            ?>
        </header>
        
        <main>
            <?

                if($_SESSION['adm']=="admin"){
                echo '

                <div class="yprav">
                    <a href="#" style="display: flex; margin-top: 2px; margin-left: 13px;">Управление категориями</a>
                </div>
                <div class="yprav">
                    <a href="quests.php" style="display: flex; margin-top: 2px; margin-left: 27px;">Управление заявками</a>
                </div>
                <div class="yprav">
                    <a href="profile.php" style="display: flex; margin-top: 2px; margin-left: 27px;">Назад</a>
                </div>

                ';
            
                }
            ?>

            <?
                if($i-1==0){
                    echo '<section class="myzay"><h1>Мои заявки</h1>
                <div class="filtr"><a href="#" style="display: flex; margin-top: 2px; margin-left: 18px;">Сортировать по статусу</a></div>
            </section>';
                }
            ?>
            



            <?
            for($k=$i-1;$k>=0;$k--){
                echo '
                <div class="zayavka2" style="height:auto">
                    <div class="polez" style="margin-top: 30px;">
                        <p class="infoz">Пользователь: '.$_SESSION[$k]['login'].'</p>
                    </div>
                    <div class="polez" style="margin-top: 30px;">
                        <p class="infoz">Временная метка: '.$_SESSION[$k]['date'].'</p>
                    </div>
                    <div class="polez">
                        <p class="infoz">Название заявки: '.$_SESSION[$k]['title'].'</p>
                    </div>
                    <div class="polez" style="height: 97px;">
                        <p class="infoz">Описание заявки: '.$_SESSION[$k]['describe'].'</p>
                    </div>
                    <div class="polez">
                        <p class="infoz">Категория заявки: '.$_SESSION[$k]['kat'].'</p>
                    </div>
                    <div class="polez">
                        <p class="infoz">Статус заявки:'.$_SESSION[$k]['stat_zaya'].'</p>
                    </div>
                    <form class="buttonz" action="" method="POST">
                        <input type="submit" style="display: flex; border:0px; background: none; padding-left: 45px; justify-content: center; margin-top: 7px; font-size: 20px;" value="Отклонить заявку" name="cancel'.$k.'">
                    </form>
                    <form class="buttonz" action="" method="POST">
                        <input type="submit" style="display: flex; border:0px; background: none; padding-left: 45px; justify-content: center; margin-top: 7px; font-size: 20px;" value="Проблема решена" name="complete'.$k.'">
                    </form>
                </div>

                ';
            }


            ?>




        </main>
        <p></p>
        <p></p>
    </body>
    <footer></footer>
</html>