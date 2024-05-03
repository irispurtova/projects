<div class="slider">
    <?php 
    require 'connect.php'; 
    
    
    $sql = "SELECT
        p.id,
        p.namepr,
        p.card_name,
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
            $square = $row["square"];
            $namepr = $row["namepr"]; 
            $card_name = $row['card_name']; ?>
            
            <div class="slide" style="background-image: url('admin_panel/<?= $imagePath; ?>'); background-repeat: no-repeat; background-size: cover;">
                <p class="text-slider"><?=$card_name;?></p>
                <table class="area-text">
                    <tr>
                        <td class="area-left" style="font-size: 20px"><strong><?=$square?> м<sup>2</sup></strong></td>
                        <td class="area-right" style="font-size: 14px"><?=$namepr?></td>
                    </tr>
                </table>
            </div> 
            <?php
        }
    } ?>
    
</div>

<script>

    document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const slideCount = slides.length;
    let currentIndex = 0;

    function showSlide(index) {
        if (index < 0) {
            index = slideCount - 1;
        } else if (index >= slideCount) {
            index = 0;
        }

        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        currentIndex = index;
    }

    function nextSlide() {
        showSlide(currentIndex + 1);
    }

    function preloadImages() {
        return new Promise((resolve) => {
            const images = [];

            slides.forEach((slide, index) => {
                const img = new Image();
                img.src = `admin_panel/<?= $imagePath; ?>`; 
                img.onload = () => {
                    images.push(img);

                    if (images.length === slideCount) {
                        resolve(images);
                    }
                };
            });
        });
    }

    preloadImages().then(() => {
        // Показываем первый слайд после загрузки изображений
        showSlide(currentIndex);

        // Запускаем автоматическую смену слайдов
        setInterval(() => {
            showSlide(currentIndex + 1);
        }, 4000);
    });
});

    
</script>