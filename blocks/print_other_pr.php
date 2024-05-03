<?php 
    $sql = "SELECT
        p.id,
        p.namepr,
        p.price,
        p.square,
        p.technology, 
        (SELECT i.img_src FROM images i WHERE i.id = p.id LIMIT 1) 
        AS img_src 
        FROM projects p 
        WHERE NOT p.id = $userid 
        order by RAND() 
        LIMIT 3";  // проверка что в списке "другие дома" не будет дома, который уже открыт

    $q_run = $connect->query($sql);

    if ($q_run->num_rows > 0) {
        while ($row = $q_run->fetch_assoc()) {
            $imagePath = $row["img_src"];
            $id = $row["id"];
            $price = $row["price"];
            $technology = $row["technology"];
            $square = $row["square"];
            $namepr = $row["namepr"]; ?>
            
            <div class="project">
                <div class="img" style="background-image: url('admin_panel/<?= $imagePath; ?>'); background-repeat: no-repeat; background-size: 450px 300px">
                    <div class="pic_text" style="padding: 260px 20px 20px 20px;">
                        <span style="color: white; font-weight: bold"><?= $square; ?> м<sup>2</sup></span>
                        <a href="card_project.php?id=<?=$id;?>">
                            <div class="button">Подробнее</div>
                        </a>
                    </div>
                    <div class="text">
                        <p><strong><?php echo $namepr; ?></strong></p>
                        <p
                            style="border-top: solid #eeeeee 1px; border-bottom: solid #eeeeee 1px; padding-top: 10px; padding-bottom: 10px;">
                            <?= number_format($price, 0, '.', ' '); ?></p>
                        <p>Технология: <strong><?= $technology; ?></strong></p>
                    </div>
                </div>
            </div> <?php
        }
    } 
?>