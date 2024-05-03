<?php
require '../../connect.php';

$sql = "SELECT COUNT(*) FROM questions"; // все
$sql_done = "SELECT COUNT(*) FROM questions WHERE done = 1"; // количество отвеченных
$sql_new = $sql-$sql_done;

$result_new = mysqli_query($connect, $sql_new);

if ($result_new) {
    $newApplicationsCount = mysqli_fetch_row($result_new)[0];
    echo $newApplicationsCount;
} else {
    echo "Error";
}

// Закрытие соединения с базой данных
$connect->close();
?>
