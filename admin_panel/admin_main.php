<?php 
session_start();

require "admin_header.php"; 
require "../connect.php";


if ($_SESSION['auth'] = 'admin') {

    //$_SESSION['auth'] = $login;
    ?>
    <!-- начать писать код для этой страницы -->

    <div class="input">
        <div class="welcome">
            Добро пожаловать! Ваше рабочее меню находится слева.
        </div>       

    </div>


        <?php
}
else {
    
    header('Location: ../index.php');
}
?>


</body>

</html>