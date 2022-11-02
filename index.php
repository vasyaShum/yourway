<?php
	require ('php/config.php');
	if (login()) {
		require ('header.php');
	
?>	

		<!-- Search -->
	    <form class="form-inline" id="search-form">
	      <div class="col-7">
	      	<div class="">
				<input class="form-control" id='search' type="text" placeholder="Прізвище..." aria-label="Search" autocomplete="off" required>
	      	</div>
	      	<div class="search_result"></div>
	      </div>
	      <button class="btn-search btn btn-success my-2 my-sm-0" type="submit">Пошук</button>
	    </form>

	    <div class="result"></div>


		<?php


	    // Текущая страница
	    if (isset($_GET['page'])){
	        $page = $_GET['page'];
	    }else {
	        $page = 1;
	        $_GET['page'] = 1;
	    }

	    $kol = 15;  // количество записей для вывода
	    $art = ($page * $kol) - $kol;


	    $rows = showAll($art, $kol);


		foreach ($rows as $row):?>
			<div class="info-row row bg-light m-2">
		        <div class="col-12 col-sm-7 col-md-7 col-lg-7 col-xl-7 pt-2 py-sm-2">
		            <a class="h6 text-dark" href="view.php?id=<?=$row['id']?>"><?=' Сім\'я ' .$row['surname'] . "<span class='text-muted'> (" . $row['count_children'] . ')</span>'?> </a>
		        </div>

		        <div class="col-12 col-sm-3 col-md-3 col-lg-2 col-xl-2 pb-2 py-sm-2">
		            <div class="h6 text-dark text-center text-place"><?=$row['place']?></div>
		        </div>

		        <div class="col-sm-2 col-md-1 col-lg-1 col-xl-1 px-3 d-flex align-items-center justify-content-center">
		        	<a href="view.php?id=<?=$row['id']?>" class="pr-2"><img class="btn-img" src="img/icons/docs.png" width="24px;" alt="show row"></a>

		        	<?php if (is_admin($_SESSION['id'])) : ?>

		        	<a href="edit.php?id=<?=$row['id']?>" class=""><img class="btn-img" src="img/icons/edit.png" width="24px;" alt="edit row"></a>
		        	
		        	<?php endif; ?>
		        </div>
		    </div>
	    <?php endforeach;?>

 
<?php 


    // Пагинация

    // Определяем все количество записей в таблице
    $total = getCountFamily();
    // echo $total;

    // Количество страниц для пагинации
    $str_pag = ceil($total / $kol);
    // echo $str_pag;
	
?>
    <!-- // формируем пагинацию -->

    <nav aria-label="Page navigation example" class="pt-3">
    	<ul class="pagination justify-content-start">
    		<li class="page-item<?php if ($_GET['page'] == 1) echo ' disabled'; ?>">
    			<a class="page-link" href="index.php?page=<?= $_GET['page']-1 ?>" tabindex="-1">Попередня</a>
    		</li>

    		<?php for ($i = 1; $i <= $str_pag; $i++): ?>
    			<li class="page-item<?php if ($_GET['page'] == $i) echo ' active'; ?>"><a class="page-link" href="index.php?page=<?=$i?>"><?=$i?></a></li>
    		<?php endfor; ?>


    		<li class="page-item<?php if ($_GET['page'] >= $str_pag) echo ' disabled'; ?>">
    			<a class="page-link" href="index.php?page=<?= $_GET['page']+1 ?>">Наступна</a>
    		</li>
    	</ul>
    </nav>
	


	<?php 




	require ('footer.php');
}

else {
	header("Location: authorization.php");
}

?>