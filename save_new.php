<?php 
    // Подключение к базе данных: 
    include('config.php');
    
    // Подготовка данных для запроса
    $FIO = mysqli_real_escape_string($connection, $_GET['FIO']);
    $Login = mysqli_real_escape_string($connection, $_GET['Login']);
    $Password = mysqli_real_escape_string($connection, $_GET['Password']);
    $Email = mysqli_real_escape_string($connection, $_GET['Email']);

    
    // Строка запроса на добавление записи в таблицу
    $sql_add = "INSERT INTO users (users_FIO, users_Login, users_Password, users_Email) VALUES ('$FIO', '$Login', '$Password', '$Email')"; 
    
    // Выполнение запроса 
    mysqli_query($connection, $sql_add); 
?>
