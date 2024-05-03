<?php include 'admin_header.php';
require '../connect.php';
?>

<div class="input">
    <div class="add_form">
        <h2>Форма добавления проекта</h2>
        <form method="post" enctype="multipart/form-data" id="add">
            <table class="tbl">
                <tr>
                    <td style="width: 266px;">Проект:</td>
                    <td><input type='text' name='namepr' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Наименование проекта:</td>
                    <td><input type='text' name='card_name' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Цена проекта:</td>
                    <td><input type='number' name='price' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Площадь проекта:</td>
                    <td><input type='number' name='square' required/></p></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Площадь террасы:</td>
                    <td ><input type='number' name='square_terrace' required/></p></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Количество спален:</td>
                    <td><input type='number' name='bedroom' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Количество с/у:</td>
                    <td><input type='number' name='bathroom' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Технология проекта:</td>
                    <td>
                        <label>
                            <input type="checkbox" name="technology[]" id="brick" value="кирпич"> кирпич
                        </label>
                        <label>
                            <input type="checkbox" name="technology[]" id="gasblock" value="газобетон"> газобетон
                        </label>
                        <label>
                            <input type="checkbox" name="technology[]" id="frame" value="каркас"> каркас
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 266px;">Описание проекта:</td>
                    <td><textarea name='description' rows="6" required></textarea></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Фото:</td>
                    <td>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple required>
                        <div id="imageContainer"></div>
                    </td>
                </tr>
            </table>

            <input type='submit' value='Добавить проект'><br><br>
            <a class="back" href="admin_bd.php">Вернуться</a>
        </form>

        <script>
            document.getElementById('images').addEventListener('change', handleImageSelect);

            function handleImageSelect(event) {
                var files = event.target.files;

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    displayImage(file);
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
        </script>

        <?php   
        // Проверяем, была ли отправлена форма
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Получение данных из формы
            $namepr = $_POST['namepr'];
            $card_name = $_POST['card_name'];
            $price = $_POST['price'];
            $square = $_POST['square'];
            $square_terrace = $_POST['square_terrace'];
            $bedroom = $_POST['bedroom'];
            $bathroom = $_POST['bathroom'];
            $description = $_POST['description'];
            $technology = isset($_POST['technology']) ? implode(", ", $_POST['technology']) : "";

            $connect->begin_transaction();

            try {
                $sqlTest = "INSERT INTO projects (namepr, card_name, price, square, square_terrace, bedroom, bathroom, technology, description) VALUES ('$namepr', '$card_name', '$price', '$square', '$square_terrace', '$bedroom', '$bathroom', '$technology', '$description')";
                if ($connect->query($sqlTest) !== TRUE) {
                    throw new Exception("Ошибка при добавлении данных в таблицу 'projects': " . $connect->error);
                }

                // Получение id только что вставленной записи в таблицу 'projects'
                $lastInsertedId = $connect->insert_id;

                // Получение данных из загруженных файлов
                $targetDirectory = "uploads/";
                $uploadedImages = [];

                foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
                    $fileName = basename($_FILES["images"]["name"][$key]);
                    $targetFilePath = $targetDirectory . $fileName;

                    if (move_uploaded_file($tmp_name, $targetFilePath)) {
                        $uploadedImages[] = $targetFilePath;

                        // Вставка данных в таблицу 'images'
                        $sqlImages1 = "INSERT INTO images (id, img_src) VALUES ('$lastInsertedId', '$targetFilePath')";
                        if ($connect->query($sqlImages1) !== TRUE) {
                            throw new Exception("Ошибка при добавлении изображения в таблицу 'images': " . $connect->error);
                        }
                    } else {
                        throw new Exception("Ошибка при загрузке изображения $fileName.");
                    }
                }

                // Фиксация транзакции
                $connect->commit();
            } catch (Exception $e) {
                // Откат транзакции в случае ошибки
                $connect->rollback();
                echo "Ошибка: " . $e->getMessage();
            }

            echo "<br>"."$namepr успешно добавлен!";
            
        }       

        // Закрытие соединения
        $connect->close();?>
            
    </div>

    <!-- запрет на повторную отправку формы при перезагрузке -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

    </div>
</div>
</div>
</body>

</html>