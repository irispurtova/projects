<?php require 'admin_header.php'; 
require '../connect.php';

if(isset($_GET["id"])) {

    $userid = mysqli_real_escape_string($connect, $_GET["id"]);

    $sql = "SELECT * FROM feedback WHERE id = '$userid'";

    if($result = mysqli_query($connect, $sql)) {
        if(mysqli_num_rows($result) > 0) {
            foreach($result as $row) {
                $name = $row["name"];
                $text = $row["fback"];
            } 
        }
    }
    
    ?>
            
    <div class="input">
        <div class="upd_form">
            <h2>Форма изменения отзыва</h2>
            <!-- форма для обновления вводимых текстовых данных -->
            <form id="upd" method="post" onsubmit="submitForm(event)">
                <input type='hidden' name='id' value='<?=$userid?>' />
                <table class="tbl">
                    <tr>
                        <td>Имя:</td>
                        <td><input type='text' name='name' value='<?=$name?>' /></td>
                    </tr>
                    <tr>
                        <td>Отзыв:</td>
                        <td><textarea name='fback' rows="6"><?=$text?></textarea></td>
                    </tr>
                </table>

                    <input type='submit' form="upd" value='Сохранить изменения' style="margin-top: 20px" onclick="submitForm(event)"><br><br>
            </form> 

            <a class="back" href="admin_otzivy.php">Вернуться</a>
            <div id="result"></div>

            <script>
                function submitForm(event) {
                    event.preventDefault();
                    var form = document.getElementById("upd");
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            console.log(xhr.responseText);
                            document.getElementById("result").innerHTML = 'Данные успешно обновлены!'
                        }
                    };

                    xhr.open("POST", "update/update_otzivy.php", true);
                    xhr.send(formData);
                }
            </script>

        </div> 
<?php 
}?>

</div>

<!-- запрет на повторную отправку формы при перезагрузке -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
