<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../../connect.php';

$userid = mysqli_real_escape_string($connect, $_POST["userId"]);
$imgSrc = mysqli_real_escape_string($connect, $_POST["imgSrc"]);

$sql = "DELETE FROM images WHERE id = $userid AND img_src = '$imgSrc'";

if ($connect->query($sql) === TRUE) {
    //echo "Image deleted successfully";
} else {
    //echo "Error deleting image: " . $connect->error;
}

// Закрытие соединения с базой данных
$connect->close();
?>
