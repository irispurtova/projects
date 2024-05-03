<!-- задание значений переменным -->

<?php

$userid = mysqli_real_escape_string($connect, $_GET["id"]);

$sql = "SELECT projects.*, images.img_src
        FROM projects
        LEFT JOIN images ON projects.id = images.id
        WHERE projects.id = $userid";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $row["id"];
        $name = $row["namepr"];
        $card_name = $row["card_name"];
        $square = $row["square"];
        $square_terrace = $row["square_terrace"];
        $bedroom = $row["bedroom"];
        $bathroom = $row["bathroom"];        
        $price = number_format($row['price'], 0, '.', ' ');
        $technology = $row["technology"];
        $descr = $row["description"]; 
    }
}?>