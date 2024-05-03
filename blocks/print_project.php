<div class="project">
    <div class="img" style='background-image: url("admin_panel/<?= $imagePath; ?>"); background-repeat: no-repeat; background-size:545px 364px;'>
        <div class="pic_text">
            <span style="color: white; font-weight: bold"><?= $square; ?> м<sup>2</sup></span>
            <a href="card_project.php?id=<?=$id;?>">
                <div class="button">Подробнее</div>
            </a>
        </div>
        <div class="text">
            <p><strong><?= $namepr; ?></strong></p>
            <p
                style="border-top: solid #eeeeee 1px; border-bottom: solid #eeeeee 1px; padding-top: 10px; padding-bottom: 10px;">
                <?= number_format($price, 0, '.', ' ') ?></p>
            <p>Технология: <strong><?= $technology; ?></strong></p>
        </div>
    </div>                                
</div>