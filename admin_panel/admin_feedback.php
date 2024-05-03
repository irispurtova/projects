<?php 
include 'admin_header.php';
require '../connect.php';
?>

    <div class="input">
    <?php
        
        $sql = "SELECT * FROM questions"; // количество всех
        $sql_done = "SELECT * FROM questions WHERE done = 1";

        $result = mysqli_query($connect, $sql);
        $result_done = mysqli_query($connect, $sql_done); //количество отвеченных
        $result_new = mysqli_num_rows($result)-mysqli_num_rows($result_done);

        if($result = mysqli_query($connect, $sql)) { ?>

            <div class="applications">
                <p>Всего заявок: <span id="totalApplications"><?=mysqli_num_rows($result)?></span></p>
                <p>Отвечено: <span id="Applications"><?=mysqli_num_rows($result_done)?></span></p>
                <p>Новых заявок: <span id="newApplications"><?=$result_new?></span></p>
            </div>

            <table class="table_feedback">
                <tr>
                    <td><strong>Имя</strong></td>
                    <td><strong>Проект</strong></td>
                    <td><strong>Телефон</strong></td>
                    <td><strong>Почта</strong></td>
                    <td><strong>Дата</strong></td>
                    <td><strong>Состояние</strong></td>
                </tr>

                <?php
                    if(mysqli_num_rows($result) > 0) {
                        $i=0;
                        foreach($result as $row) {
                            $i++;
                            $id = $row["id"];
                            $namepr = $row["namepr"];
                            $user_name = $row["user_name"];
                            $user_tel = $row["user_tel"];
                            $user_email = $row["user_email"];
                            $user_text = $row["user_text"];
                            $date = $row["date"]; 
                            $done = $row['done'];?>

                            <tr>
                                <td onclick="toggleBlock(<?=$id?>)"><?=$user_name?></td>
                                <td onclick="toggleBlock(<?=$id?>)"><?=$namepr?></td>
                                <td onclick="toggleBlock(<?=$id?>)"><?=$user_tel?></td>
                                <td onclick="toggleBlock(<?=$id?>)"><?=$user_email?></td>
                                <td onclick="toggleBlock(<?=$id?>)"><?=$date?></td>
                                <td>
                                <?php if ($done == 1) : ?>
                                    <span style="color: green;">Отвечено</span>
                                <?php else : ?>
                                    <form onsubmit="markAsDone(event, <?=$id?>)">
                                        <input type="submit" value="Отвечено">
                                    </form>
                                <?php endif; ?>
                                </td>
                            </tr>

                            <div id="block<?=$id?>" class="block">
                                <div class="block-content">
                                    <span class="close" onclick="closeFeedBack(<?=$id?>)">&times;</span>
                                    <h3 style="padding: 15px">Вопрос по проекту <strong>"<?=$namepr?>"</strong></h3>
                                    <strong><p><?=$user_name?>:</p></strong>
                                    <p><?=$user_text?></p><br>
                                    <p>Телефон: <strong><a href="#"><?=$user_tel?></a></strong></p>
                                    <p>E-mail: <strong><a href="#"><?=$user_email?></strong></a></p>
                                    <br>
                                </div>
                            </div>

                            <script>
                                function toggleBlock(id) {
                                    var block = document.getElementById("block"+id);
                                    block.style.display = "block";
                                }

                                function closeFeedBack(id) {
                                    var block = document.getElementById("block"+id);
                                    block.style.display = "none";
                                }

                                function markAsDone(event, questionId) {
                                    event.preventDefault();
                                    
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState == 4 && xhr.status == 200) {
                                            var doneElement = document.createElement('span');
                                            doneElement.style.color = 'green';
                                            doneElement.textContent = 'Отвечено';
                                            event.target.parentNode.replaceChild(doneElement, event.target);
                                        }
                                    };
                                    
                                    xhr.open("POST", "update/update_feedback.php", true);
                                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                    xhr.send("mark_as_done=1&question_id=" + questionId);

                                    updateApplicationsCount();
                                    updateNewApplicationsCount();
                                }

                                function updateApplicationsCount() {
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState == 4 && xhr.status == 200) {
                                            var doneApplicationsCount = parseInt(xhr.responseText);
                                            document.getElementById("Applications").innerText = doneApplicationsCount;
                                        }
                                    };

                                    // Отправка асинхронного GET-запроса на сервер
                                    xhr.open("GET", "update/update_count.php", true);
                                    xhr.send();

                                    location.reload();
                                }

                                function updateNewApplicationsCount() {
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState == 4 && xhr.status == 200) {
                                            var newApplicationsCount = parseInt(xhr.responseText);
                                            document.getElementById("newApplications").innerText = newApplicationsCount;
                                        }
                                    };

                                    // Отправка асинхронного GET-запроса на сервер
                                    xhr.open("GET", "update/update_new_count.php", true);
                                    xhr.send();

                                    location.reload();
                                }

                                // запрет на повторную отправку формы при перезагрузке
                                if ( window.history.replaceState ) {
                                    window.history.replaceState( null, null, window.location.href );
                                }
                            </script>

                            <?php                       
                        } 
                    } 
            ?></table>
            <?php
            
        } ?>
        
    </div>
</div>
</div>
</body>

</html>