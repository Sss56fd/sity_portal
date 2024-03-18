<?php
include 'config.php';
session_start();
$select_four_sql=$sql->query("SELECT * FROM `quests` WHERE `статус`='Решена'");
$i=0;
$n=0;
while($select_four_res[$i]=$select_four_sql->fetch_array()){$i++; $n++;}
 ?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Городской портал | HappyCity</title>
        <link rel="shortcut icon" href="" type="image/x-icon">
        <link href="css\main.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" defer></script>
        <script type="text/javascript" defer>
            function check(){
            $.ajax({
                    url: 'chetchik.php',
                    datatype: "json",
                    success: function (result){

                            $("#good").html(result.chK);
                            
                            if(localStorage.getItem('good')<result.chK){
                                var audio = new Audio();
                                audio.src="sound.mp3";
                                audio.autoplay = true;
                                
                            }
                            localStorage.setItem('good',$("#good").html());
                            return false;
                    }
                });
            }
        setInterval(check,100);
    </script>
    </head>
    <body>
        <header>
            <a href="main.php"><img src="img\logotip.jpeg" alt="logo" class="logo"></a>

            <?
            if (empty($_SESSION['id'])) {
                echo'
                    <a href="vhod.php" class="li_1">Вход</a>
                    <a href="reg.php" class="li_1_1">Регистрация</a>
                ';
            }
            else{
                echo '
                    <a href = "profile.php" class="vhod">'.$_SESSION['login'].'</a>

                ';
            }
            ?>
            <a class="a_0">+01234567891</a>



        </header>
        <main>
        <h1 class="h1">Последние решенные проблемы</h1>
        <div class="textcols">
            <div class="textcols-item">
                <a class="a_1"><p>15.12.2022</p>
                <p>Уборка снега</p>
                <p>Очистка от снега</p></a>
                <img src="img\problema_1.jpg" alt="photo1" class="task_img">
            </div>
            <div class="textcols-item">
                <a class="a_2"><p>10.01.2023</p>
                <p>Уборка снега</p>
                <p>Вывоз снега</p></a>
                <img src="img\problema_2.jpg" alt="photo2"  class="task_img">
            </div>
            <div class="textcols-item">
                <a class="a_3"><p>01.05.2023</p>
                <p>Дороги</p>
                <p>Ремонт дорог</p></a>
                <img src="img\problema_3.jpg" alt="photo3"  class="task_img">
            </div>
        </div>
            <div class="counter">
                <span style="margin-left: 625px;">Всего заявок выполнено: </span><span class="count" id="good">0</span>
            
        </main>
    </body>
</html>