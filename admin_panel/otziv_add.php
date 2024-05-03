<?php include 'admin_header.php';
require '../connect.php';
?>

<div class="input">
    <div class="add_form">
        <h2>Форма добавления отзыва</h2>
        <form method="post">
            <table class="tbl">
                <tr>
                    <td style="width: 266px;">Имя:</td>
                    <td><input type='text' name='name' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Отзыв:</td>
                    <td><textarea name='otziv' rows="6" required></textarea></td>
                </tr>
            </table>

            <input type='submit' value='Добавить отзыв'><br><br>
            <a class="back" href="admin_otzivy.php">Вернуться</a>
        </form>

        <?php   
        // Проверяем, была ли отправлена форма
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Получение данных из формы
            $user = $_POST['name'];
            $otziv = $_POST['otziv'];

            echo $user;
            echo $otziv;

            $sql = "INSERT INTO feedback (name, fback) VALUES ('$user', '$otziv')";

            if ($connect->query($sql) !== TRUE) {
                echo "ошибка";
            }          
        }  
        ?>
            
    </div>

    <!-- запрет на повторную отправку формы при перезагрузке -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

    </div>
</div>
</div>
</body>

</html>