<?php
require '../connect.php';

// Получаем значение $userid из POST-запроса
$userid = isset($_POST['userid']) ? $_POST['userid'] : 0;


if ($_FILES['image']) {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $stmt = $connect->prepare("INSERT INTO images (id, img_src) VALUES (?, ?)");
        $stmt->bind_param("ss", $userid, $targetFile);

        if ($stmt->execute()) {
            echo "Изображение успешно загружено в базу данных";
        } else {
            echo "Ошибка при загрузке в базу данных: " . $connect->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка при загрузке файла на сервер";
    }
}

$conn->close();
?>
