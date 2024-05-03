<?php 

    session_start();
    require_once('../../connect.php');

    $login = $_POST['login'];
    $password = $_POST['password'];
    
    if($login == "admin" && $password == "admin"){
        $_SESSION['auth'] = 'admin';
    } else {
        echo "Данные для входа не верны!";
    }

?>