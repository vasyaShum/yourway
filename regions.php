<?php

	require ('php/config.php');

	if (login()) {
		require ('header.php');


	    $regions = getAllRegions();
	    $children_region = getAllChildrenFromRegions();

	?>


	<div id="accordion" role="tablist" class="px-0 py-5">

		<?php foreach ($regions as $key => $value): ?>

			  <div class="card">
			    <div class="card-header" role="tab" id="heading<?= $key ?>">
			      <h5 class="mb-0">
			        <a data-toggle="collapse" href="#collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>">
			          <?= $value?> (<?= count($children_region[$key])?>)
			        </a>
			      </h5>
			    </div>

			    <div id="collapse<?= $key ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?= $key ?>" style="">
			      <div class="card-body">
			        
			        

					<? foreach ($children_region[$key] as $row):?>
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

				    


			      </div>
			    </div>
			  </div>
		<?php endforeach ?>
	</div>


	<?php 

		require ('footer.php');
	}

?>