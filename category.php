<?php
session_start();
include "config.php";

// Добавление новой категории
if(isset($_POST['category_name'])) {
    $categoryName = $_POST['category_name'];
    
    $sql = "INSERT INTO categories (name) VALUES ('$categoryName')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Новая категория успешно добавлена";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}
?>

<html> 
<form method="post" action="">
    <label for="category_name">Название категории:</label>
    <input type="text" name="category_name" id="category_name">
    <button type="submit">Добавить категорию</button>
</form>
</html>