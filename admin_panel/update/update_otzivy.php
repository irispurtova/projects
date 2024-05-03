<?php
require '../../connect.php';

// Подключение к базе данных и другие необходимые настройки

$userid = mysqli_real_escape_string($connect, $_POST["id"]);
$name_upd = mysqli_real_escape_string($connect, $_POST["name"]);
$otziv_upd = mysqli_real_escape_string($connect, $_POST["fback"]);

$sql = "UPDATE feedback SET name = '$name_upd', fback = '$otziv_upd' WHERE id = $userid";

if (mysqli_query($connect, $sql)) {
    echo "Данные успешно обновлены";
} else {
    echo "Ошибка при обновлении данных: " . mysqli_error($connect);
}

mysqli_close($connect);
?>