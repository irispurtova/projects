<?php require '../connect.php'; 
session_start();?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Административная панель</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/styles_admin_main.css">
    <link rel="stylesheet" href="css/styles_admin_bd.css">
    <link rel="stylesheet" href="css/styles_admin_feedback.css">
    <link rel="stylesheet" href="css/styles_admin_upd.css">
    <link rel="stylesheet" href="css/styles_admin_add.css">

    <!-- иконка -->
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

</head>

<body>
    <div class="admin_general">
        <div class="admin_header_title">
            <div class="logo"><img src="../img/logo.png" alt="" width="200px"></div>
            <div class="title">Административная панель</div>
            <div class="hello">Здравствуйте, Ирина! <a href="auth/unlogin.php">выйти</a></div>
        </div>

        <?php
            if (isset($_GET['do']) && $_GET['do']=='exit') {
                unset($_SESSION['auth']); // удаляем сессионную переменную
                header('Location: ../index.php'); // делаем редирект
                die; // и завершаем выполнение скрипта
            }
        ?>

        <div class="inner">
            <div class="sidebox">
                <!-- <div class="box"><a href="admin_main.php"><p>Главная</p></a></div> -->
                <div class="box"><a href="admin_feedback.php"><p>Обратная связь</p></a></div>
                <div class="box"><a href="admin_bd.php"><p>База проектов</p></a></div>
                <div class="box"><a href="admin_otzivy.php"><p>Отзывы</p></a></div>
            </div>