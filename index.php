<?php 
    require 'header.php';
    require 'connect.php';
?>

    <div class="menu">
        <div class="menu_size">
            <ul class="menu_mv">
                <li><a href="index.php"><img src="img/logo.png" alt=""></a></li>
                <li><a href="index.php" id="link1" style="color: #f4c367;">Главная</a></li>
                <li><a href="projects.php" id="link1">Проекты и цены</a></li>
                <li><a href="feedback.php" id="link1">Отзывы</a></li>
                <li><a href="contacts.php" id="link1">Контакты</a></li>
            </ul>
        </div>
    </div>
<!-- слайдер -->
    <?php require 'blocks/slider.php'; ?>

    <div class="logo">
        <h1>Мы - специалисты Строительной Компании "Медный Всадник" - занимаемся строительством загородных домов и
            коттеджей уже более 20 лет.</h1>
    </div>

<!-- блоки "наши преимущества" -->
    <?php require 'blocks/advantages.php'; ?>

<!-- наши проекты - 4 случайных из базы данных -->
    <div class="our_projects">
        <h1>НАШИ ПРОЕКТЫ</h1>
        <div class="projects">
            <?php
                $sql = "SELECT
                    p.id,
                    p.namepr,
                    p.price,
                    p.square,
                    p.technology,
                    (SELECT i.img_src FROM images i WHERE i.id = p.id LIMIT 1) AS img_src 
                FROM
                    projects p
                ORDER BY
                    RAND()
                LIMIT 4";

                $result = $connect->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["img_src"];
                        $id = $row["id"];
                        $price = $row["price"];
                        $technology = $row["technology"];
                        $square = $row["square"];
                        $namepr = $row["namepr"];
                        
                        // Отображение на веб-странице
                        include 'blocks/print_project.php';
                    }
                }?>
        </div>
    </div>    

    <?php require 'blocks/footer.php';?>