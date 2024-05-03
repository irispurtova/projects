<?php require 'admin_header.php'; 
require '../connect.php';

if(isset($_GET["id"])) {

    $userid = mysqli_real_escape_string($connect, $_GET["id"]);

    $sql = "SELECT * FROM projects WHERE id = '$userid'";

    if($result = mysqli_query($connect, $sql)) {
        if(mysqli_num_rows($result) > 0) {
            foreach($result as $row) {
                $userid = $row["id"];
                $name = $row["namepr"];
                $card_name = $row["card_name"];
                $square = $row["square"];
                $square_terrace = $row["square_terrace"];
                $bedroom = $row["bedroom"];
                $bathroom = $row["bathroom"];
                $price = $row["price"];
                $technologies = explode(', ', $row['technology']);
                $descr = $row["description"]; 
            } 
        }
    }

    // Запрос для получения путей к изображениям
    $sql_img = "SELECT img_src FROM images WHERE id = '$userid'";
    $result_img = $connect->query($sql_img);

    if ($result->num_rows > 0) {
        while($row = $result_img->fetch_assoc()) {
            $imagePath = $row["img_src"];
            $imagePaths[] = $imagePath;
        }
    } else {
        echo "Нет данных";
    }

    $Photos = mysqli_query($connect, "SELECT * FROM `images` WHERE `id`='$userid'");    
    $Photos = mysqli_fetch_all($Photos, MYSQLI_ASSOC);
    
    ?>
            
    <div class="input">
        <div class="upd_form">
            <h2>Форма изменения проекта "<?= $card_name ?>"</h2>
            <!-- форма для обновления вводимых текстовых данных -->
            <form id="upd" method="post" enctype="multipart/form-data" onsubmit="submitForm(event)">
                <input type='hidden' name='id' value='<?=$userid?>' />
                <table class="tbl">
                    <tr>
                        <td>Проект:</td>
                        <td><input type='text' name='namepr' value='<?=$name?>' /></td>
                    </tr>
                    <tr>
                        <td>Наименование проекта:</td>
                        <td><input type='text' name='card_name' value='<?=$card_name?>' /></td>
                    </tr>
                    <tr>
                        <td>Цена проекта:</td>
                        <td><input type='number' name='price' value='<?=$price?>' /></td>
                    </tr>
                    <tr>
                        <td>Площадь проекта:</td>
                        <td><input type='number' name='square' value='<?=$square?>' /></p></td>
                    </tr>
                    <tr>
                        <td>Площадь террасы:</td>
                        <td><input type='number' name='square_terrace' value='<?=$square_terrace?>' /></p></td>
                    </tr>
                    <tr>
                        <td>Количество спален:</td>
                        <td><input type='number' name='bedroom' value='<?=$bedroom?>' /></td>
                    </tr>
                    <tr>
                        <td>Количество с/у:</td>
                        <td><input type='number' name='bathroom' value='<?=$bathroom?>' /></td>
                    </tr>
                    <tr>
                        <td style="width: 266px;">Технология проекта:</td>
                        <td>
                            <?php 
                            foreach (['кирпич', 'газобетон', 'каркас'] as $technology) {
                                $checked = in_array($technology, $technologies) ? 'checked' : '';
                                echo '<input type="checkbox" name="technologies[]" value="' . $technology . '" ' . $checked . '>' . $technology . ' ';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Описание проекта:</td>
                        <td><textarea name='description' rows="6"><?=$descr?></textarea></td>
                    </tr>

                    <!-- сабмит для формы -->
                    <!-- <input type='submit' form="upd" value='Сохранить изменения' onclick="submitForm(event)"><br><br> -->
            </form> 

            <!-- конец формы -->            
                    <tr>
                        <td style="width: 266px;">Фото:</td>
                        <td>
                            <!-- вставка новых изображений -->
                            <input type="file" id="photos" name="photos[]" accept="image/*" multiple>

                            <div id="imageContainer" style="padding-top: 20px">
                            <?php
                            // Отображение изображений, которые уже есть в бд
                            foreach($Photos as $key => $value) {?> 

                                    <div class="imageWrapper" id="photo_<?= $key + 1 ?>">
                                        <div class="deleteButton" onclick="deleteImage('<?= $value['img_src']; ?>', '<?= $userid; ?>')">✖</div>
                                        <img src="<?= $value['img_src']; ?>">
                                    </div> <?php
                                
                            }
                            ?>
                            </div>

                            <script>
                                var userid = <?= $userid ?>;

                                function deleteImage(imgSrc, userId) {
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'update/delete_image.php', true);
                                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    var params = 'imgSrc=' + encodeURIComponent(imgSrc) + '&userId=' + encodeURIComponent(userId);
                                    xhr.send(params);

                                    xhr.onload = function() {
                                        if (xhr.status === 200) {
                                            console.log(xhr.responseText);
                                            var element = document.querySelector('[src="' + imgSrc + '"]').closest('.imageWrapper');
                                            if (element) {
                                                element.parentNode.removeChild(element);
                                            }
                                        }
                                    };
                                }

                                document.getElementById('photos').addEventListener('change', handleImageSelect);

                                function handleImageSelect(event) {
                                    var files = event.target.files;

                                    for (var i = 0; i < files.length; i++) {
                                        var file = files[i];
                                        displayImage(file);
                                        uploadImage(file, userid);
                                    }
                                }

                                function displayImage(file) {
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        var imageSrc = e.target.result;

                                        var imageWrapper = document.createElement('div');
                                        imageWrapper.classList.add('imageWrapper');

                                        var deleteButton = document.createElement('button');
                                        deleteButton.classList.add('deleteButton');
                                        deleteButton.innerHTML = '✖';

                                        deleteButton.addEventListener('click', function () {
                                            imageWrapper.remove();
                                        });

                                        var imageElement = document.createElement('img');
                                        imageElement.src = imageSrc;

                                        imageWrapper.appendChild(deleteButton);
                                        imageWrapper.appendChild(imageElement);
                                        document.getElementById('imageContainer').appendChild(imageWrapper);
                                    };

                                    reader.readAsDataURL(file);
                                }

                                function uploadImage(file, userid) {
                                    var formData = new FormData();
                                    formData.append('image', file);
                                    formData.append('userid', userid); // идентификатор пользователя в FormData

                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'upload_img.php', true);

                                    xhr.onreadystatechange = function () {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            console.log('Изображение успешно загружено');
                                        }
                                    };

                                    xhr.send(formData);
                                    }
                            </script>
                        </td>                        
                    </tr>
                </table>                
                
                <input type='submit' form="upd" value='Сохранить изменения' onclick="submitForm(event)">
                <a class="back" href="admin_bd.php">Вернуться</a>
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

                        xhr.open("POST", "update/update_form.php", true);
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
