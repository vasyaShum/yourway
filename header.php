<!DOCTYPE html>
<html lang="ua">
<head>
	<meta charset="UTF-8">

	<meta name="robots" content="noindex, nofollow"/>
	<meta name="robots" content="none"/>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>YourWayCamp</title>

	<!-- CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">
	
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/baguetteBox.min.css">
	<link rel="shortcut icon" href="img/icons/logo.png" type="image/png">


	<!-- Scripts -->
    <script src="js/jquery.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
    <script src="js/baguetteBox.min.js" async></script>
    <!-- <script src="js/dropzone.min.js"></script> -->

    <script src="js/bootstrap.min.js"></script> <!-- Bootstrap framework -->

    <script src="js/validator.min.js"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->

  	<script src="js/script.js"></script>

</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand text-success" href="/">YourWay</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    	<ul class="navbar-nav mr-auto">
	    		<li class="nav-item">
	        		<a class="nav-link" href="/">Пошук<span class="sr-only">(current)</span></a>
	    		</li>

	    		<?php if (is_admin($_SESSION['id'])) : ?>

	    		<li class="nav-item">
	        		<a class="nav-link" href="create.php">Створити</a>
	    		</li>

	    		<?php endif; ?>

	    		<li class="nav-item">
	        		<a class="nav-link" href="regions.php">Райони</a>
	    		</li>
	    	</ul>

    		<div class="navbar-nav justify-content-end pr-2">
    			<a class="nav-link" href="php/auth.php?action=out">Вихід</a>
    		</div>

		</div>
	</nav>

	<div class="content container">
