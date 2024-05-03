<?php include 'admin_header.php';?>

<div class="input">
    
<h2>Все проекты</h2>
<div class="filter">
    <form action="search.php" method="post">
        <label for="searchTerm">Введите название проекта для поиска:</label>
        <input type="text" id="searchTerm" oninput="search()" required style='font-size: 18px;'>
        <button type="submit" style="display: none">Поиск</button>
    </form>
</div>

<div class="add">
    <a href="admin_add.php" style="text-decoration: none; color: white;">Добавить проект</a>
</div>

<div class="bd">

    <?php 
        require '../connect.php';
    ?>

<?php

    if (isset($_GET['del'])) {
        $pr_del = $_GET['del'];

        $query = "DELETE FROM projects WHERE id = $pr_del";
        mysqli_query($connect, $query) or die(mysqli_error($connect));
    }
    
    $query = "SELECT p.id, p.namepr, p.price, p.square, (SELECT i.img_src FROM images i WHERE i.id = p.id LIMIT 1) AS img_src FROM projects p";

    $count = 0;

    ?>

    <div class="table">
        <table class="table" id="searchResults"></table>
    </div>


    <div class="table">
        <table class="table" id="dataTable" style="display: none;">
            <tr>
                <td>№</td>
                <td>Название проекта</td>
                <td>Цена</td>
                <td>Площадь</td>
                <td>Фото</td>
                <td>Действие</td>
            </tr>            
                <?php

                    if ($result = mysqli_query($connect, $query)) {
                        $count = 1;

                        while($row = mysqli_fetch_assoc($result)) {  
                            
                            $id = $row['id'];
                            $title = $row['namepr'];
                            $price = $row['price'];
                            $square = $row['square'];
                            $imagePath = $row["img_src"];
                            ?>
                            <tr>
                                <td><?=$count?></td>
                                <td><?=$title?></td>
                                <td><?=number_format($price, 0, '.', ' ')?></td>
                                <td><?=$square?></td>
                                <td><img src="<?= $imagePath; ?>" alt=""></td>
                                <td><a href="admin_upd.php?id=<?=$id?>">Изменить</a> / <a href="?del=<?=$id?>" onclick="return confirm('Вы уверены, что хотите удалить проект?');">Удалить</a></td>
                            </tr>
                            <?php   
                            $count = $count+1;
                        } 
                        
                    } 
                    else {
                        printf("Ошибка при чтении из таблицы"); 
                        exit; 
                    }
                ?>

        </table>
    </div>

    <script>
            window.onload = function () {
                search();
            };

        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchTerm");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            // Очистка таблицы результатов
            document.getElementById("searchResults").innerHTML = "<tr> <td>№</td> <td>Название проекта</td> <td>Цена</td> <td>Площадь</td> <td>Фото</td> <td>Действие</td> </tr>";

            // Перебор всех строк таблицы
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Второй столбец
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        // Если есть совпадение, добавляем строку в таблицу результатов
                        document.getElementById("searchResults").innerHTML += tr[i].innerHTML;
                    }
                }
            }
        }
    </script>

        </div>
    </div>
</div>
</div>
</body>

</html>