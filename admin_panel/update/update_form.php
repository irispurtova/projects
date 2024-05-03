<?php
require '../../connect.php';

// Подключение к базе данных и другие необходимые настройки

$userid = mysqli_real_escape_string($connect, $_POST["id"]);
$name_upd = mysqli_real_escape_string($connect, $_POST["namepr"]);
$card_name_upd = mysqli_real_escape_string($connect, $_POST["card_name"]);
$price_upd = mysqli_real_escape_string($connect, $_POST["price"]);
$square_upd = mysqli_real_escape_string($connect, $_POST["square"]);
$square_terrace_upd = mysqli_real_escape_string($connect, $_POST["square_terrace"]);
$bedroom_upd = mysqli_real_escape_string($connect, $_POST["bedroom"]);
$bathroom_upd = mysqli_real_escape_string($connect, $_POST["bathroom"]);
$technology_upd = mysqli_real_escape_string($connect, ($_POST['technologies']) ? implode(", ", $_POST['technologies']) : "");
$description_upd = mysqli_real_escape_string($connect, $_POST["description"]);

$sql = "UPDATE projects SET 
    namepr = '$name_upd', 
    card_name = '$card_name_upd', 
    price = '$price_upd', 
    square = '$square_upd', 
    square_terrace = '$square_terrace_upd', 
    bedroom = '$bedroom_upd', 
    bathroom = '$bathroom_upd', 
    technology = '$technology_upd', 
    description = '$description_upd' 
    WHERE id = $userid";

if (mysqli_query($connect, $sql)) {
    echo "Данные успешно обновлены";
} else {
    echo "Ошибка при обновлении данных: " . mysqli_error($connect);
}

mysqli_close($connect);
?>