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
//если пользователь нажал на выйти
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: main.php");
    exit();
}

$i=0;
$id = $_SESSION['id'];
$select_zaya_sql=$sql->query("SELECT * FROM `quests` WHERE `id пользователя` = '$id'");
while ($select_zaya_res[$i]=$select_zaya_sql->fetch_array()) {
    $_SESSION[$i]['id_zaya']=$select_zaya_res[$i]['id заявки'];
    $_SESSION[$i]['stat_zaya']=$select_zaya_res[$i]['статус'];
    $_SESSION[$i]['kat']=$select_zaya_res[$i]['тема'];
    $_SESSION[$i]['title']=$select_zaya_res[$i]['название'];
    $_SESSION[$i]['describe']=$select_zaya_res[$i]['текст'];
    $_SESSION[$i]['date']=date('d.m.Y',strtotime($select_zaya_res[$i]['дата и время отправления']));
    $i++;
}

//удаление
for($j=0;$j<=$i;$j++){
    if(isset($_POST[$j])){
        $id_zaya = $_SESSION[$j]['id_zaya'];
        $sql->query("DELETE FROM `quests` WHERE `id заявки` = '$id_zaya'");
        header("location: profile.php");
        exit();
    }
}

///Создание заявки
//выбор темы
$select_theme_sql=$sql->query("SELECT * FROM `Темы`");

if(isset($_POST['btn-zaya'])){
    //оформление заявки
    $name_zaya=strip_tags($_POST['name_zaya']);
    $kateg_zaya=strip_tags($_POST['categ-zayavka']);
    $text_zaya=strip_tags($_POST['text_zaya']);
    $date = date('Y-m-d H:i:s');
    if (!empty($name_zaya) && !empty($kateg_zaya) && !empty($text_zaya)) {
        $sql->query("INSERT INTO `quests` (`id пользователя`, `тема`,`название`,`текст`,`статус`,`дата и время отправления`) values('$id','$kateg_zaya','$name_zaya','$text_zaya','Новая','$date')");
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
        <link href="styles/style1.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        
        <header>
            <a href="main.php"><img src="img\logotip.jpeg" alt="logo" class="logo"></a>
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
        
        <main><div class="prpole"><p class="infop"><?=$_SESSION['ln']?> <?=$_SESSION['fn']?> <?=$_SESSION['mn']?></p></div></h2>
        
            <?

                if($_SESSION['adm']=="admin"){
                echo '

                <div class="yprav">
                    <a href="category.php" style="display: flex; margin-top: 2px; margin-left: 13px;">Управление категориями</a>
                </div>
                <div class="yprav">
                    <a href="quests.php" style="display: flex; margin-top: 2px; margin-left: 27px;">Управление заявками</a>
                </div>

                ';
            
                }
            ?>


            <h2 style="text-align: center;">Есть варианты, как сделать город лучше? <br> Создайте заявку!</h2>
            <form class="zayavka" action="" method="POST">
                <div class="polez" style="margin-top: 30px;"><p class="infoz">Введите название:</p><input class="inputz" name="name_zaya"></div>
                <div class="polez"><p class="infoz">Категория:</p>

                    <select class="category" name="categ-zayavka">

                    <?while ( $select_theme_res=$select_theme_sql->fetch_array() ) {
                        echo '<option>'.$select_theme_res['темы'].'</option>';
                    }?>
                    </select>
                </div>
                <div class="polez" style="height: 97px;"><p class="infoz">Добавьте описание:</p><input class="inputz" style="height: 87px;" name="text_zaya"></div>
                <div class="polez" style="margin-top: 30px;">
                    <p class="infoz">Выберите фото:</p>
                    <input class="inputz" type="file" name="photo">
                </div>
                <div class="buttonz"><input type="submit" style="display: flex; border:0px; background: none; padding-left: 52px; justify-content: center; margin-top: 7px; font-size: 20px;" value="Создать заявку" name="btn-zaya"></div>
                
            </form>

            <?
                if($i-1==0){
                    echo '<section class="myzay"><h1>Мои заявки</h1></section>';
                }
            ?>
            
            <?
            for($k=$i-1;$k>=0;$k--){
                echo '
                <div class="zayavka2">
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
                        <input type="submit" style="display: flex; border:0px; background: none; padding-left: 52px; justify-content: center; margin-top: 7px; font-size: 20px;" value="Удалить заявку" name="'.$k.'">
                    </form>

                </div>

                ';
            }
            ?>
        </main>
    </body>
</html>