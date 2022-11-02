<?php

	require ('php/config.php');

	if (login()) {

		require ('header.php');

	?>

			<div class="view-page">

				<?php 

				$row = showPersonFromId($_GET['id']);

				$child_from_family = showChildFromFamily($_GET['id']);

				$comments = showComments($_GET['id']);

				?>

				<div class="row">
					<a href="index.php" class="btn btn-outline-dark btn-back my-3">Назад</a>
				</div>

				<div class="row">
					<div class="person-img col-12 col-sm-6">
						<img src="<?=$row['photo']?>" alt="" width="100%">
					</div>

					<div class="person-info col-12 col-sm-6">
						<div class="font-weight-bold">Сім'я <?=$row['surname'] ?>

						<?php if (is_admin($_SESSION['id'])): ?>
							<a href="edit.php?id=<?=$row['id']?>" class="btn-edit"><img src="img/icons/edit.png" width="24px;" alt="edit row"></a>
						<?php endif ?>

						</div>

						

						<div><?=$row['place']?></div>

						<div><?=$row['region']?></div>

						<?php foreach ($row['phone'] as $key => $value): ?>
							<div>
								<a href="tel:<?=$key?>" class="link font-weight-bold"><?=$key?></a>
								<span> - <?=$value?></span>
							</div>
						<?php endforeach ?>
						

						<div>
							<?php if ($row['location']): ?>
													
								<!-- <a href="#" class="btn-call btn btn-success">ВИКЛИК</a> -->
								<a href="<?=$row['location']?>" class="btn-gps btn btn-success" target="_blank">МАРШРУТ</a>
								 <img src="img/icons/copy.png" onclick="CopyCoordinates()" class="btn-copy" alt="copy">
								 <input type="text" style="opacity: 0" value="<?= $row['coordinates'] ?>" id="coordinates">  

							<?php endif ?>
						</div>
						<div>
							<div class="header-view">Діти:</div>
								<ol>
									<?php foreach ($child_from_family as $child):?>
										<li> 
											<?= $child['name'] ?>
											<?php
												if ($child['birth']) {
													echo "(" . (date('Y') - $child['birth']) . " р.)";
												}
											?>		
										</li>
									<?php endforeach;?>
								</ol>
						</div>
					</div>

					<div class="person-description col-12">
						<div class="header-view">Опис:</div>
						<p class="text-description"><?=$row['description']?></p>
					</div>

				</div>
			</div>


	        <?php if ($row['files']): ?>

	        <div class="header-view">Галерея</div>

			<div class="container">            	
	            
			    <div class="baguetteBoxOne gallery">
			    	

			    	<?php foreach ($row['files'] as $key => $value) :?>

				        <a href="<?=$value?>" data-caption="<?=$value?>">
				            <img src="<?=$value?>" class="m-1" height="300px" alt="">
				        </a>

			    	<?php endforeach; ?>


			    </div>
			</div>
			<?php endif ?>


			<div class="row comments p-3">
		        <div class="header-view">Коментарі</div>
		        <div class="w-100"></div>


		        <div class="alert alert-success comment-success d-none" role="alert">
				    
				</div>

	            <div class="row">
	                <div class="col-xs-12 col-sm-12 col-md-12">
	                    <div class="form-group row">
	                        <div class="col-12">
	                            <div class="text-secondary">Новий коментар:</div>
	                            <form id="addComment" data-toggle="validator" data-focus="false">
	                            	<input type="text" id="name_comment" class="form-control mb-2" placeholder="Ваше ім'я" autocomplete="off" required>
		                            <textarea id="comment" class="form-control" cols="150" rows="3" maxlength="1000" style="width: 100% " required></textarea>
		                            <input type="hidden" id="user_id" value="<?= $row['id'] ?>">
		                            <button type="submit" class="btn btn-primary my-3">Додати</button>
	                        	</form>
	                        </div>
	                    </div>
	                </div>
	            </div>


		        <div class="row container">

		        	<?php if(count($comments)): ?>
		            	<?php foreach($comments as $comment): ?>

		                    <div class="comment-item col-lg-12 bg-white m-2 p-3 p-sm-4">
		                        <div class="row">
		                            <div class="col-12 col-lg-9 pb-1 d-flex align-items">
		                                <img src="img/icons/account.png" alt="" width="25px"
		                                height="25px" class="mr-1">
		                                <strong><?= $comment['name'] ?></strong>
		                            </div>
		                            <div class="col-10 col-lg-2 comment-date"><i><?= $comment['date'] ?></i>
		                            </div>
		                            <?php if (is_admin($_SESSION['id'])) : ?>	
			                            <div class="close col-2 col-lg-1" onclick="deleteComment(<?= $comment['id'] ?>);" style="font-size: 30px" aria-label="Close"> ×
	                              		</div>
                              		<?php endif; ?>
		                        </div>
		                        <div class="pt-2"><?= $comment['text'] ?></div>
		                    </div>

		                <?php endforeach; ?>

		            <?php else: ?>
		                <div class="comment-item col-lg-12 bg-white m-2 p-3 p-sm-4">
		                     Немає коментарів
		                </div>
		            <?php endif; ?>
		        </div>
		    </div>


	    </div>

	    <script>
			window.addEventListener('load', function() {
			  baguetteBox.run('.gallery');
			});


			function CopyCoordinates() {
			  /* Get the text field */
			  var copyText = document.getElementById("coordinates");

			  /* Select the text field */
			  copyText.select();


			  /* Copy the text inside the text field */
			  document.execCommand("copy");

			  /* Alert the copied text */
			  alert("Скопійовано у буфер обміну");
			}

			// function delComment() {
			// 	// 
			// }


		</script>

	<?php 

	require ('footer.php');
}

else {
	header("Location: /");
}

?>