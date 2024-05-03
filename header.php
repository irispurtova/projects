<?php 

include 'connect.php';

session_start();

if (isset($_SESSION["auth"]) && $_SESSION["auth"] == 'admin') {
    header("location: admin_panel/admin_main.php");
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Медный всадник</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- главная страница -->
    <link rel="stylesheet" href="css/styles_index.css">
    <!-- контакты -->
    <link rel="stylesheet" href="css/styles_contacts.css">
    <!-- все проекты -->
    <link rel="stylesheet" href="css/styles_projects.css">
    <!-- отзывы -->
    <link rel="stylesheet" href="css/styles_feedback.css">
    <!-- карточка проекта -->
    <link rel="stylesheet" href="css/styles_card_projects.css">
    <!-- окно задать вопрос -->
    <link rel="stylesheet" href="css/styles_modal_question.css">
    <!-- слайдер на главной странице -->
    <link rel="stylesheet" href="css/styles_slider.css">
    <!-- блок наши преимущества -->
    <link rel="stylesheet" href="css/styles_advantages.css">
    <!-- 1 проект стили -->
    <link rel="stylesheet" href="css/styles_project.css">
    <!-- фильтр -->
    <link rel="stylesheet" href="css/styles_filter.css">
    <!-- подвал -->
    <link rel="stylesheet" href="css/styles_footer.css">

    <!-- иконка -->
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="header">
        <div class="header_size">
            <ul class="text">
                <li> Санкт-Петербург </li>
                <li> +7 (812) 748 91 88 </li>
            </ul>

            <a class="auth" onclick="showModal()">
                Войти как администратор
            </a>

<!-- модальное окно входа для администратора -->
    <div id="login_body" class="modal">
        <div class="modal-content">
            <div id="login_box">
                <p class="title_log">
                    Вход администратора
                </p>
                <span class="close" onclick="closeModal()">&times;</span>
                <form id="login_account">
                    <table>
                        <tr>
                            <td>Логин:</td>
                            <td><input class="input_log" type="text" name="login" id="login"></td>
                        </tr>
                        <tr>
                            <td>Пароль:</td>
                            <td><input class="input_log" type="password" name="password" id="password"> </td>
                        </tr>
                        <tr>
                            <td><input class="btn_log" type="button" value="Войти" onclick="loginAccount()"></td>    
                        </tr>
                    </table>
                </form> 
            </div>
        </div>
    </div>

            <script>
                function showModal() {
                    document.getElementById('login_body').style.display = 'block';
                }

                function closeModal() {
                    document.getElementById('login_body').style.display = 'none';
                }

                function loginAccount() {
                    let form = document.getElementById('login_account');

                    let formData = new FormData(form);
                    
                    var url = 'admin_panel/auth/login.php';
                    
                    let xhr = new XMLHttpRequest();

                    // xhr.responseType = 'document';
                    
                    xhr.open('POST', url);

                    xhr.send(formData);
                    xhr.onload = () => {
                        if (xhr.response == '') {
                            window.location.replace("index.php");
                        } else {
                            alert(xhr.response);
                        }
                        
                    }
                    
                }
            </script>
        </div>
    </div>