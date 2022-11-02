<?php 

    include ('php/config.php'); //подключается файл с глобальными функциями

?>


<!DOCTYPE html>
<html lang="uk">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Авторизація</title>

	<!-- CSS -->

	<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="shortcut icon" href="img/icons/logo.png" type="image/png">

  <style>
    body {
      height: 100vh;
      background-color: #eeeeee;
    }

    .form-signin {
      width: 30%;
      height: 100%;
      margin: 0 auto;
      display: flex;
      align-items: center;
    }

    .form-content {
      width: 100%;
    }

    .form-label-group {
      margin: 10px 0px;
    }

    #auth_msg {
      font-size: 18px;
      transition: 1s;
      margin-bottom: 20px;
    }

    @media (max-width: 425px) {

      .form-signin {
        width: 55%;
      }
      .form-content {
        font-size: 15px;
      }
      .form-content h1 {
        font-size: 34px;
      }
      .form-content button {
        font-size: 16px;
        width: 50%;
        margin: 0 auto;
      }
      .form-label-group input {
        font-size: 15px;
      }
    }


  </style>

  <!-- Scripts -->
    <script src="js/jquery.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->

    <script src="js/bootstrap.min.js"></script> <!-- Bootstrap framework -->

    <script src="js/validator.min.js"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->

  <script>

  $(document).ready(function() {

    /* Auth Form */
    $("#authForm").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
            event.preventDefault();
            

            $("#auth_msg").addClass('badge badge-danger').text('');

            login = $("#login").val();
            pass = $("#password").val();


            var formData = new FormData();

            formData.append('login', login);
            formData.append('password', pass);
            formData.append('log_in', true);


            // TO DO
            $.ajax({
                type: "POST",
                url: "php/auth.php",
                processData: false,
                contentType: false,
                data: formData,

                success: function(text) {
                    
                    if (text == "success") {

                        window.location.href = 'index.php';
                    }
                    else {
                      $("#auth_msg").addClass('badge badge-danger').text(text);
                        // alert(text);
                    }

                }
            });

        }
    });
  });

  </script>
  </head>


  <body>

    <form id="authForm" class="form-signin" data-toggle="validator" data-focus="false">
      <div class="form-content">
        <div class="text-center mb-4">

          <h1 class="h1 mb-3 font-weight-normal">Авторизація</h1>
          <p>Заповніть дані для того щоб увійти на сайт</p>
        </div>

        <div class="form-label-group">
          <input type="text" id="login" class="form-control" placeholder="Логін" autocomplete="off" required autofocus>
          
        </div>

        <div class="form-label-group">
          <input type="password" id="password" class="form-control" placeholder="Пароль" autocomplete="off" required>
          
        </div>

        <div id="auth_msg"></div>
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Увійти" name="log_in" />
        <p class="mt-5 mb-3 text-muted text-center">&copy; Team Your Way 2022</p>
      </div>
    </form>
  </body>
</html>