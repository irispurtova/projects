<?php 
    require 'header.php'; 
    require 'connect.php';
    require 'values/send_var.php'; 
?>

<div class="menu">
        <div class="menu_size">
            <ul class="menu_mv">
                <li><a href="index.php"><img src="img/logo.png" alt=""></a></li>
                <li><a href="index.php" id="link1">Главная</a></li>
                <li><a href="projects.php" id="link1"  style="color: #f4c367;">Проекты и цены</a></li>
                <li><a href="feedback.php" id="link1">Отзывы</a></li>
                <li><a href="contacts.php" id="link1">Контакты</a></li>
            </ul>
        </div>
    </div>

<div class="inner">
    <div class="inner inner--1" style="padding-top: 30px; width: 60%">
        <h3><a class="card_pr" href="projects.php"> Проекты и цены</a> / <?= $card_name ?></h3>
        <h1><?= $card_name ?></h1><br>

        <div class="card-description">
            <div class="left-part">

<!-- галерея изображений -->
<?php 
$sql = "SELECT img_src FROM images WHERE id = $userid";
$result = $connect->query($sql); ?>

<div class="" id="gallery">    
    <?php
    // Вывод большого изображения и первого маленького изображения
    $firstImagePath = 'admin_panel/' . $result->fetch_assoc()["img_src"];
    echo '<img id="bigImage" src="' . $firstImagePath . '" class="big-image" alt="Big Image">';   
    ?>
    
    <div class="slides">
        <div class="arrow-left" id="prevButton" onclick="navigate(-1)"><img src="img/icons/arrow-slider2.svg" alt=""></div>
        <div class="arrow-right" id="nextButton" onclick="navigate(1)"><img src="img/icons/arrow-slider1.svg" alt=""></div>
        
        <div class="carousel" id="carousel"> 
            
                <?php    
                echo '<img src="' . $firstImagePath . '" class="small-image selected" alt="Small Image">';
                // Вывод остальных маленьких изображений
                while ($row = $result->fetch_assoc()) {
                    echo '<img src="admin_panel/' . $row["img_src"] . '" class="small-image" alt="Small Image">';
                }
                ?>
        </div>
    </div>
    
</div>

<script>
    // JavaScript для обработки кликов на маленькие изображения
    const smallImages = document.querySelectorAll('.small-image');
    const bigImage = document.getElementById('bigImage');

    const carousel = document.getElementById('carousel');

    let currentIndex = 0;

    // Функция для обновления изображений
    function updateImages(index, carouselWidth, currentMarginLeft, direction) {

        // Убираем opacity=1 у всех маленьких изображений
        smallImages.forEach((img) => img.classList.remove('selected'));
        
        // Устанавливаем opacity=1 для выбранного маленького изображения
        smallImages[index].classList.add('selected');

        // Заменяем большое изображение выбранным маленьким
        bigImage.src = smallImages[index].src;

        if ((index == 0) || (index == 1) || (index == 2) || (index == 3)) {
            currentMarginLeft = 0;
            carousel.style.marginLeft = currentMarginLeft + 'px';

        } else if ((index == (smallImages.length - 1)) || (index == (smallImages.length - 2)) || (index == (smallImages.length - 3)) || (index == (smallImages.length - 4))) {
            currentMarginLeft = - ((smallImages.length - 4) * 0.25 * carouselWidth);
            carousel.style.marginLeft = currentMarginLeft + 'px';

        } else if (direction == -1){
            // Увеличиваем значение marginLeft на 25% от ширины блока carousel
            currentMarginLeft += 0.25 * carouselWidth;
            // Устанавливаем новое значение marginLeft
            carousel.style.marginLeft = currentMarginLeft + 'px';

        } else if (direction == 1) {
            // Уменьшаем значение marginLeft на 25% от ширины блока carousel
            currentMarginLeft -= 0.25 * carouselWidth;
            // Устанавливаем новое значение marginLeft
            carousel.style.marginLeft = currentMarginLeft + 'px';
        }

    }

    // Функция для навигации (влево или вправо)
    function navigate(direction) {
        currentIndex = (currentIndex + direction + smallImages.length) % smallImages.length;

        // Получаем текущую ширину блока carousel
        var carouselWidth = carousel.offsetWidth;

        // Получаем текущее значение marginLeft и преобразуем его в число
        var currentMarginLeft = parseInt(carousel.style.marginLeft) || 0;

        updateImages(currentIndex, carouselWidth, currentMarginLeft, direction);
    }

    // Обработчики событий для кликов на маленькие изображения
    smallImages.forEach((smallImage, index) => {
        smallImage.addEventListener('click', () => {
            currentIndex = index;
            updateImages(currentIndex);
        });
    });

</script>
                
                <div class="description">
                    <h2>Описание проекта</h2>
                    <p><?= $descr ?></p>
                </div>

            </div>
            <div class="right-part">
                <div class="description-base">
                    <p class="bold" style="font-size: 20px; padding: 30px; border-bottom: 1px solid #e4e4e4; color: #454545"><?= $name ?></p>
                    <div class="desc-bottom">
                        <p><img src="img/square-gray.png" alt="#" width="9px"> ОБЩАЯ ПЛОЩАДЬ</p>
                        <p class="bold" style="font-size: 18px;"><?= $square ?> м<sup>2</sup></p>
                        <p><img src="img/ruble.png" alt="#" height="12px"> СТОИМОСТЬ СТРОИТЕЛЬСТВА</p>
                        <p class="bold" style="font-size: 14px"><?= $price ?></p>
                        <p><img src="img/technology-gray.png" alt="#" height="10px"> ТЕХНОЛОГИЯ</p>
                        <p class="bold" style="font-size: 14px"><?= $technology ?></p>
                    </div>
<!-- модальное окно -->
                    <a onclick=openModalQuestion(event) class="link-question">
                        <div class="q_h" style="">
                            ЗАДАТЬ ВОПРОС ПО ПРОЕКТУ
                        </div>
                    </a>
                    <?php include 'blocks/modal_question.php'; ?>

    <script>
        function openModalQuestion(event) {
            event.preventDefault();
            openModal('modalQuestion');
        }

        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        function closeModalQuestion(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
            document.getElementById("result").textContent = '';
        }

        function addFeedback(event, card_name) {
            console.log(card_name);
            // Отменяем стандартное действие формы (перезагрузку страницы)
            event.preventDefault();

            // Создаем объект XMLHttpRequest
            var request = new XMLHttpRequest();
            // Создаем объект FormData для отправки данных
            var formData = new FormData(document.getElementById("ques"));

            var projectName = card_name;
            var user_name = document.getElementById('user_name').value;
            var user_tel = document.getElementById('user_tel').value;
            var user_email = document.getElementById('user_email').value;
            var user_text = document.getElementById('user_text').value; 
            var project_name = document.getElementById('project_name').value; 

            console.log(user_name, user_tel, user_email);

            formData.append("namepr", projectName);
            formData.append("user_name", user_name);
            formData.append("user_tel", user_tel);
            formData.append("user_email", user_email);
            formData.append("user_text", user_text);
            formData.append("project_name", project_name);

            // Настраиваем запрос
            request.open('POST', 'server/add_user.php', true);

            // Устанавливаем обработчик события для отслеживания состояния запроса
            request.onreadystatechange = function () {
                if (request.readyState === 4 && request.status === 200) {
                    // Сбрасываем значения полей формы
                    resetModalQuestion();
                    // Закрываем модальное окно
                    //closeModal('modalQuestion');
                    // вывод об успешной операции
                    document.getElementById("result").textContent = 'Спасибо за обратную связь!';
                }
            };
                
            // Отправляем запрос
            request.send(formData);
        }

        function resetModalQuestion() {
            // Сбрасываем значения полей формы
            document.getElementById("ques").reset();
            document.getElementById("result").textContent = '';
        }
    </script>
                </div>


<!-- площади проекта -->
                <?php include 'blocks/squares.php'; ?>
            </div>
        </div>
    </div>

    <div class="other">
        
        <?php 
        $str = "SELECT * FROM projects WHERE NOT id = $userid";
        $res = mysqli_query($connect, $str);

        if (mysqli_num_rows($res) > 1) { ?>
            <h1>Другие проекты</h1>
                <div class="projects">
                    <?php include 'blocks/print_other_pr.php'; ?>
                </div>
        <?} 
        else if (mysqli_num_rows($res) == 1) { ?>
            <h1>Другие проекты</h1>
            <div class="projects" style="justify-content: center;">
                <?php include 'blocks/print_other_pr.php'; ?>
            </div>
        <?php } 
            else {?><h1>Это наш единственный проект!</h1><?php
            ;}
            ?>
        
    </div>
</div>
<?php include 'blocks/footer.php';?>