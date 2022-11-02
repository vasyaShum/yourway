<?php
 
// Подключаем файл конфигурации
include "config.php";

// Получаем значение переменной "search" из файла "script.js".
if (isset($_POST['search'])) {

    $i = 0;
 
    // Помещаем поисковой запрос в переменной
    $search = trim(htmlspecialchars($_POST['search']));
 
    // Запрос для выбора из базы данных
    $sql = "SELECT children.id, children.surname, children.place, children.location, children.phone, children.photo, children.description, COUNT(child.name) as count_children  FROM children LEFT JOIN child ON children.id=child.family_id WHERE surname LIKE '%$search%' GROUP BY children.id, children.surname, children.place, children.location, children.phone, children.photo, children.description ";

// $link = mysqli_connect('localhost:3306','root','','yourway');
    //Производим поиск в базе данных
    $ExecQuery = $link->query($sql);
 
    // Создаем список для отображения результатов
    // echo '<ul>';
 
    //Перебираем результаты из базы данных
    while ($Result = $ExecQuery->fetch(PDO::FETCH_ASSOC)) {
        $i++;
?>
        <!-- Создаем элементы списка. При клике на результат вызываем функцию обработчика fill() из файла "script.js". В параметре передаем найденное имя-->
 
            <div class="info-row row text-white m-2">

                <div class="col-12 col-sm-7 col-md-7 col-lg-7 col-xl-7 pt-2 py-sm-2">
                    <a class="h6 text-dark" href="view.php?id=<?=$Result['id']?>"><?=' Сім\'я ' .$Result['surname'] . "<span class='text-muted'> (" . $Result['count_children'] . ')</span>'?> </a>

                </div>


                <div class="col-12 col-sm-3 col-md-3 col-lg-2 col-xl-2 pb-2 py-sm-2">
                    <div class="h6 text-dark text-center text-place"><?=$Result['place']?></div>
                </div>

                <div class="col-sm-2 col-md-1 col-lg-1 col-xl-1 px-3 d-flex align-items-center justify-content-center">
                    <a href="../view.php?id=<?=$Result['id']?>" class="pr-2"><img class="btn-img" src="../img/icons/docs.png" width="24px;" alt="show row"></a>

                    <?php if (is_admin($_SESSION['id'])) : ?>

                    <a href="../edit.php?id=<?=$Result['id']?>" class=""><img class="btn-img" src="../img/icons/edit.png" width="24px;" alt="edit row"></a>
                    
                    <?php endif; ?>
                </div>
            </div>
 
<?php
    }

    if ($i == 0) :?>

        <span>Немає результатів за таким пошуком "<b><?= $search ?></b>.</span> 

    <?php else: ?>

        <span>Було знайдено <b><?= $i ?></b> результати(та).</span> 

    <?php endif; 

}
?>
    
    <hr>