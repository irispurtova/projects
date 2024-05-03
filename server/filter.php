<?php
require "../connect.php";

// для сортировки по цене
$sortDirection = isset($_POST['sortDirection']) ? intval($_POST['sortDirection']) : 0;

// для сортировки по площади
$areaSortDirection = isset($_POST['areaSortDirection']) ? intval($_POST['areaSortDirection']) : 0;

// Проверка наличия данных и их валидности
$minPrice = isset($_POST['minPrice']) ? intval($_POST['minPrice']) : $minPrice;
$maxPrice = isset($_POST['maxPrice']) ? intval($_POST['maxPrice']) : $maxPrice; // Используем максимальное значение из базы данных
$minSquare = isset($_POST['minSquare']) ? intval($_POST['minSquare']) : $minSquare;
$maxSquare = isset($_POST['maxSquare']) ? intval($_POST['maxSquare']) : $maxSquare; // Используем максимальное значение из базы данных

// Дополнительная проверка на корректность диапазона значений
if ($minPrice < 0 || $maxPrice < 0 || $minSquare < 0 || $maxSquare < 0 || $minPrice > $maxPrice || $minSquare > $maxSquare) {
    die("Некорректные значения фильтра.");
}

if (isset($_POST['minPrice'])||isset($_POST['maxPrice'])||isset($_POST['minSquare'])||isset($_POST['maxSquare'])) {
    $sql = "SELECT 
    p.id, p.namepr, p.price, p.square, p.technology, 
    (SELECT i.img_src FROM images i WHERE i.id = p.id LIMIT 1) 
    AS img_src 
    FROM projects p 
    WHERE price BETWEEN $minPrice AND $maxPrice 
    AND square BETWEEN $minSquare AND $maxSquare";
}
else {
    $sql = "SELECT p.* (SELECT i.img_src FROM images i WHERE i.id = p.id LIMIT 1) AS img_src FROM projects p";
}

// сортировка по цене добавляет order by
if ($sortDirection == 1) {
    $sql .= " ORDER BY price ASC";
} elseif ($sortDirection == 2) {
    $sql .= " ORDER BY price DESC";
}

// сортировка по площади добавляет order by
if ($areaSortDirection == 1) {
    $sql .= " ORDER BY square ASC";
} elseif ($areaSortDirection == 2) {
    $sql .= " ORDER BY square DESC";
}

$result = $connect->query($sql);

// печать проекта
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="project">
                <div class="img" style='background-image: url("admin_panel/<?= $row['img_src']; ?>"); background-repeat: no-repeat; background-size:545px 364px;'>
                    <div class="pic_text">
                        <span style="color: white; font-weight: bold; margin-left: 0px"><?= $row['square']; ?> м<sup>2</sup></span>
                        <a href="card_project.php?id=<?= $row['id']; ?>" style="margin-right: 0px">
                            <div class="button">Подробнее</div>
                        </a>
                        
                    </div>
                    <div class="text">
                        <p><strong><?= $row['namepr']; ?></strong></p>
                        <p
                            style="border-top: solid #eeeeee 1px; border-bottom: solid #eeeeee 1px;">
                            <?= number_format($row['price'], 0, '.', ' ') ?></p>
                        <p>Технология: <strong><?= $row['technology']; ?></strong></p>
                    </div>
                </div>                                
            </div>
            <?php
        }
    } 
?>