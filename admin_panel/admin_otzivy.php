<?php include 'admin_header.php';?>

<div class="input">
    
<h2>Все Отзывы</h2>

<div class="add">
    <a href="otziv_add.php" style="text-decoration: none; color: white;">Добавить отзыв</a>
</div>

<div class="bd" style="padding-top: 20px">

    <?php 
        require '../connect.php';
    ?>

<?php

    if (isset($_GET['del'])) {
        $pr_del = $_GET['del'];

        $query = "DELETE FROM feedback WHERE id = $pr_del";
        mysqli_query($connect, $query) or die(mysqli_error($connect));
    }
    
    $query = "SELECT * FROM feedback";
    $count = 0;

    ?>

    <div class="table">
        <table class="table">
            <tr>
                <td>№</td>
                <td>Имя</td>
                <td>Отзыв</td>
            </tr>            
                <?php

                    if ($result = mysqli_query($connect, $query)) {
                        $count = 1;

                        while($row = mysqli_fetch_assoc($result)) {  
                            
                            $id = $row['id'];
                            $name = $row['name'];
                            $text = $row['fback'];
                            ?>
                            <tr>
                                <td><?=$count?></td>
                                <td><?=$name?></td>
                                <td><?=$text?></td>
                                <td><a href="otziv_upd.php?id=<?=$id?>">Изменить</a> / <a href="?del=<?=$id?>" onclick="return confirm('Вы уверены, что хотите удалить отзыв?');">Удалить</a></td>
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

    

        </div>
    </div>
</div>
</div>
</body>

</html>