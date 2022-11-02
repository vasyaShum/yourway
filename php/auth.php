<?php 
    include ('config.php');


    if($_GET['action'] == "out") out(); //если передана переменная action, «разавторизируем» пользователя

    if (login()) //вызываем функцию login, которая определяет, авторизирован пользователь или нет

    {
      $UID = $_SESSION['id']; //если пользователь авторизирован, присваиваем переменной $UID его id
      $admin = is_admin($UID); //определяем, админ ли пользователь

      echo "success";



    }
    else //если пользователь не авторизирован, проверяем, была ли нажата кнопка входа на сайт
    {
      if(isset($_POST['log_in'])) 
      {
          $error = enter(); //функция входа на сайт

          if (count($error) == 0) //если ошибки отсутствуют, авторизируем пользователя
          {
              $UID = $_SESSION['id'];

              $admin = is_admin($UID);

              echo "success";
          }
          else {
              foreach ($error as $err) {
                  echo $err;
              }
          }
      }
    }



 ?>