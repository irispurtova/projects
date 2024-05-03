<?php 
    require 'header.php';
    require 'connect.php';
    require 'values/check.php'; //вставка значений в фильтр
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
        <div class="inner inner--1">
            <h1>Строительство загородных домов - проекты и цены</h1>

            <h2 class="uu" style="background-color: white; padding: 30px;">Фильтр <label class="linkk" for="hider" id="clickme"><strong>▼</strong></label></h2>
            <input type="checkbox" id="hider">

<!-- фильтр по цене/площади -->
            <div class="filter">
        
                <form id="filterForm" method="POST">

                    <div class="filter-blocks">

                        <div class="filter-price">
                            <div class="filter-price-header">
                                <p>СТОИМОСТЬ СТРОИТЕЛЬСТВА</p>
                            </div>

                            <div class="filter-price-inputs">
                                <div class="min">
                                    <label for="minPrice">от:</label>
                                    <input type="number" id="minPrice" name="minPrice" value=<?= $minPrice; ?>>
                                </div>

                                <div class="max">
                                    <label for="maxPrice">до:</label>
                                    <input type="number" id="maxPrice" name="maxPrice" value=<?= $maxPrice; ?>>
                                </div>
                            </div>

                        </div>

                        <div class="filter-square">
                            <div class="filter-square-header">
                                <p>ОБЩАЯ ПЛОЩАДЬ</p>
                            </div>

                            <div class="filter-square-inputs">
                                <div class="min">
                                    <label for="minSquare">от:</label>
                                    <input type="number" id="minSquare" name="minSquare" value=<?= $minSquare; ?>>
                                </div>

                                <div class="max">
                                    <label for="maxSquare">до:</label>
                                    <input type="number" id="maxSquare" name="maxSquare" value=<?= $maxSquare; ?>>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="filter-buttons">

                        <div class="filter-show-button">
                            <button type="button" onclick="applyFilter()">ПРИМЕНИТЬ ФИЛЬТР</button>
                        </div>

                        <div class="filter-del-button">
                            <button type="button" onclick="resetFilters('<?php echo $minPrice; ?>', '<?php echo $maxPrice; ?>', '<?php echo $minSquare; ?>', '<?php echo $maxSquare; ?>')">СБРОСИТЬ ФИЛЬТР</button>
                        </div>

                    </div> 

                </form>
            </div>          

<!-- сортировка -->
            <div class="sort">
                <a id="sortButton" onclick="toggleSort()">СОРТИРОВАТЬ ПО ЦЕНЕ <span id="sortSymbol">&#32;</span></a>
                <a id="sortAreaButton" onclick="toggleAreaSort()">СОРТИРОВАТЬ ПО ПЛОЩАДИ <span id="sortAreaSymbol">&#32;</span></a>
            </div>

            <div id="resultContainer"></div>

        <!-- script для сортировки и фильтрации -->
            <script>
                var sortDirection = 0;  // 0 - не сортировать, 1 - по возрастанию, 2 - по убыванию
                var areaSortDirection = 0;  // 0 - не сортировать, 1 - по возрастанию, 2 - по убыванию

                function toggleSort() { // для сортировки по цене
                    sortDirection = (sortDirection + 1) % 3;
                    updateSortSymbol();
                    updateAreaSortButtonState(); // Добавляем вызов функции для обновления состояния второй кнопки
                    applyFilter();
                }

                function toggleAreaSort() { // для сортировки по площади
                    areaSortDirection = (areaSortDirection + 1) % 3;
                    updateAreaSortSymbol();
                    updateSortButtonState(); // Добавляем вызов функции для обновления состояния первой кнопки
                    applyFilter();
                }

                function updateSortButtonState() {
                    var sortButton = document.getElementById("sortButton");

                    if (areaSortDirection !== 0) {
                        // Если выбрана сортировка по площади, делаем кнопку сортировки по цене недоступной
                        sortButton.disabled = true;
                        sortDirection = 0; // Сбрасываем направление сортировки по цене
                        updateSortSymbol(); // Обновляем символ сортировки по цене
                    } else {
                        // Если сортировка по площади не выбрана, делаем кнопку сортировки по цене доступной
                        sortButton.disabled = false;
                    }
                }

                function updateAreaSortButtonState() {
                    var sortAreaButton = document.getElementById("sortAreaButton");

                    if (sortDirection !== 0) {
                        // Если выбрана сортировка по цене, делаем кнопку сортировки по площади недоступной
                        sortAreaButton.disabled = true;
                        areaSortDirection = 0; // Сбрасываем направление сортировки по площади
                        updateAreaSortSymbol(); // Обновляем символ сортировки по площади
                    } else {
                        // Если сортировка по цене не выбрана, делаем кнопку сортировки по площади доступной
                        sortAreaButton.disabled = false;
                    }
                }

                function updateSortSymbol() {
                    var sortSymbolElement = document.getElementById("sortSymbol");
                    
                    if (sortDirection == 1) {
                        sortSymbolElement.innerHTML = "&#x25B2;"; // Символ треугольника вверх
                    } else if (sortDirection == 2) {
                        sortSymbolElement.innerHTML = "&#x25BC;"; // Символ треугольника вниз
                    } else {
                        sortSymbolElement.innerHTML = ""; // Сбрасываем в начальное значение (пустое)
                    }
                }

                function updateAreaSortSymbol() {
                    var sortAreaSymbolElement = document.getElementById("sortAreaSymbol");

                    if (areaSortDirection == 1) {
                        sortAreaSymbolElement.innerHTML = "&#x25B2;"; // Символ треугольника вверх
                    } else if (areaSortDirection == 2) {
                        sortAreaSymbolElement.innerHTML = "&#x25BC;"; // Символ треугольника вниз
                    } else {
                        sortAreaSymbolElement.innerHTML = ""; // Сбрасываем в начальное значение (пустое)
                    }
                }

                function applyFilter() {
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData(document.getElementById("filterForm"));
                    formData.append("sortDirection", sortDirection);
                    formData.append("areaSortDirection", areaSortDirection);

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById("resultContainer").innerHTML = xhr.responseText;
                        }
                    };

                    xhr.open("POST", "server/filter.php", true);
                    xhr.send(formData);
                }

                function resetFilters(minPrice, maxPrice, minSquare, maxSquare) {
                    document.getElementById("minPrice").value = minPrice;
                    document.getElementById("maxPrice").value = maxPrice;
                    document.getElementById("minSquare").value = minSquare;
                    document.getElementById("maxSquare").value = maxSquare;
                    applyFilter(); // Вызываем функцию applyFilter для сброса фильтров
                }

                // Вызываем applyFilter при загрузке страницы для отображения начальных данных
                document.addEventListener("DOMContentLoaded", function() {
                    applyFilter();
                    updateSortSymbol();
                    updateAreaSortSymbol();
                    updateSortButtonState();
                    updateAreaSortButtonState();
                });
            </script>
        </div>
    </div> 

<?php include 'blocks/footer.php';?>