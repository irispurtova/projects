<!-- добавление данных от пользователя в бд -->
<?php  
require "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
    $add_name = mysqli_real_escape_string($connect, $_POST['NAME']);
    $add_phone = mysqli_real_escape_string($connect, $_POST['PHONE']);
    $add_email = mysqli_real_escape_string($connect, $_POST['EMAIL']);
    $add_text = mysqli_real_escape_string($connect, $_POST['TEXT']);

    $name = mysqli_real_escape_string($connect, $_POST['project_name']);

    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO questions (namepr, user_name, user_tel, user_email, user_text, date) VALUES ('$name','$add_name','$add_phone','$add_email','$add_text', '$date')";   

    $result = mysqli_query($connect, $sql); 
} 
?>