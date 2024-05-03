<?php
require '../../connect.php';

if (isset($_POST['mark_as_done'])) {
    $question_id = $_POST['question_id'];
    $update_sql = "UPDATE questions SET done = 1 WHERE id = $question_id";
    mysqli_query($connect, $update_sql);
}        

$result = $connect->query($query);

// Отправка ответа в зависимости от результата
if ($result) {
    echo "success";
} else {
    echo "error";
}

// Закрытие соединения с базой данных
$connect->close();
?>
