<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'gor_portal';

// Пытаемся соединиться
$sql = new mysqli ($db_host, $db_user, $db_password, $db_name);
$sql -> query("SET NAMES 'utf8'");

// Проверяем, удалось ли соединение
if ($sql -> connect_errno){
    echo "Не удалось подключиться к MySQL: " . $sql -> connect_error;
}
?>