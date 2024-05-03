<?php
require '../connect.php';

// Получение данных из базы данных
$id = $_GET['id'];
$sql = "SELECT name, fback FROM feedback WHERE id = $id";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user = $row['name'];
    $text = $row['fback'];

    // Отправка данных в формате HTML
    echo '<form>' .
        '<img src="img/feedback/user_noimg.png" alt="">' .
        '<h3>' . $user . '</h3>' .
        '<p class="rep">' . $text . '</p>' .
        '</form>';
} else {
    echo "No data found";
}

$connect->close();
?>
