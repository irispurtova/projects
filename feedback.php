<?php 
include 'header.php';
require 'connect.php'; 

$q = "SELECT * FROM feedback";
$q_run = mysqli_query($connect, $q);
?>

    <div class="menu">
        <div class="menu_size">
            <ul class="menu_mv">
                <li><a href="index.php"><img src="img/logo.png" alt=""></a></li>
                <li><a href="index.php" id="link1">Главная</a></li>
                <li><a href="projects.php" id="link1">Проекты и цены</a></li>
                <li><a href="feedback.php" id="link1" style="color: #f4c367;">Отзывы</a></li>
                <li><a href="contacts.php" id="link1">Контакты</a></li>
            </ul>
        </div>
    </div>

    <div class="inner">
        <div class="inner inner--1">
            <h1>Истории заказчиков</h1>

            <div class="reviews">
            <?php 
                if($q_run) {
                    if(mysqli_num_rows($q_run) > 0) {
                        foreach($q_run as $row) {
                            $id = $row["id"];
                            $user = $row["name"];
                            $text = $row["fback"];
            ?> 
            <div class="feedback feedback--1">
                <img src="img/feedback/user_noimg.png" alt="">
                <h3><?= $user ?></h3>
                <p class="rep"><?= $text ?></p>
                <a class="fbck feedback-link" data-id="<?= $id ?>">Читать полностью <img src="img/feedback/link-strelka.png" alt=""></a>
            </div>
            <?php 
                        } 
                    }
                } 
                ?>                    
                <div id="openFeedback" class="modal_feedback">
                    <div class="modal_feedback-dialog">
                        <span class="close" onclick="closeFB('openFeedback')">&times;</span>
                        <div class="modal_feedback-content">
                            <div class="okno_feedback" id="feedbackContent">
                                <!-- Содержимое модального окна будет добавлено с помощью JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
// JavaScript код для обработки клика на ссылку
document.addEventListener('DOMContentLoaded', function () {
    var feedbackLinks = document.getElementsByClassName('feedback-link');

    for (var i = 0; i < feedbackLinks.length; i++) {
        feedbackLinks[i].addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            openFeedbackModal(id);
        });
    }
});

function openFeedbackModal(id) {
    // AJAX запрос для получения данных от сервера
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Заполнение модального окна данными
            document.getElementById('feedbackContent').innerHTML = this.responseText;

            // Открытие модального окна
            document.getElementById('openFeedback').style.display = 'block';
        }
    };

    xhr.open('GET', 'server/feedback_in.php?id=' + id, true);
    xhr.send();
}

function closeFB(modalId) {
    // Закрытие модального окна
    document.getElementById(modalId).style.display = 'none';
}
</script>

<?php include 'blocks/footer.php';?>