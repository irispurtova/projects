<?php
require '../../connect.php';

$sql_done = "SELECT COUNT(*) FROM questions WHERE done = 1"; // количество отвеченных

$result_done = mysqli_query($connect, $sql_done);

if ($result_done) {
    $doneApplicationsCount = mysqli_fetch_row($result_done)[0];
    echo $doneApplicationsCount;
} else {
    echo "Error";
}

// Закрытие соединения с базой данных
$connect->close();
?>
