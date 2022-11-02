<?php
session_start();




// Подключение к базе данных
global $link;

try {

  $link = new PDO('mysql:host=localhost:3306;dbname=yourway', 'root','',[PDO::ATTR_PERSISTENT=>true]);
  $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  echo "Error";
}




// FUNCTIONS

function showAll($art, $kol) {
  global $link;
    // $link = mysqli_connect('localhost:3306','root','root','yourway');
    $sql = "SELECT children.id, children.surname, children.place, children.location, children.phone, children.photo, children.description, COUNT(child.name) as count_children  FROM children LEFT JOIN child ON children.id=child.family_id GROUP BY children.id, children.surname, children.place, children.location, children.phone, children.photo, children.description LIMIT $art, $kol";
    $result = $link->query($sql);
    $rows = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    return $rows;
}


function showPersonFromId($id) {
    // $link = mysqli_connect('localhost:3306','root','root','yourway');
   global $link;

   $sql = "SELECT children.id, children.surname, children.place, children.location, children.phone, children.photo, children.description, regions.name as region  FROM children LEFT JOIN regions ON regions.id=children.region_id  WHERE children.id = :id";

    $result = $link->prepare($sql);
    $result->bindParam(':id', $id);
    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);


    $without = $row['photo'];


    $row['files'] = showNameFiles($id, $without);
    // print_r($row['files']);
    $row['phone'] = unserialize($row['phone']);

    if ($row['location'] != '') {
        $row['coordinates'] = $row['location'];
        $row['location'] = 'https://www.google.com.ua/maps/place/' . $row['location'];
    }
    
    return $row;
}

function getCountFamily() {

    global $link;

    
    $sql = "SELECT COUNT(*) as count_family FROM children";

    $result = $link->prepare($sql);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    return $row['count_family'];
}


function showChildFromFamily($id) {
    global $link;

    // For select children for family
    $sql2 = "SELECT id, name, birth FROM child WHERE family_id = :id";

    $result2 = $link->prepare($sql2);
    $result2->bindParam(':id', $id);
    $result2->execute();

    $child_from_family = [];
    while ($child = $result2->fetch(PDO::FETCH_ASSOC)){
        $child_from_family[] = $child;
    }
    
    return $child_from_family;

}
 

function editPersonFromId($id) {
    global $link;

    $sql = "SELECT * FROM children WHERE id = :id";

    $result = $link->prepare($sql);
    $result->bindParam(':id', $id);
    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);

    $without = $row['photo'];
    // echo $without .'<br>';

    $row['files'] = showNameFiles($id, $without);
    
    $row['phone'] = unserialize($row['phone']);

    return $row;
}


function selectIdLastRow() {

    global $link;

    $sql = "SELECT id FROM children WHERE id = (SELECT max(id) FROM children)";
    $result = $link->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row['id'];
}

function selectIdLastRowChild() {

    global $link;

    $sql = "SELECT id FROM child WHERE id = (SELECT max(id) FROM child)";
    $result = $link->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row['id'];
}


function deletePersonFromId($id) {

    global $link;

    $sql = "DELETE FROM children WHERE id = :id";

    $result = $link->prepare($sql);
    $result->bindParam(':id', $id);
    $result->execute();


    $sql2 = "DELETE FROM child WHERE family_id = :id";
    $result2 = $link->prepare($sql2);
    $result2->bindParam(':id', $id);
    $result2->execute();
}

function deleteCommentFromId($id) {

    global $link;

    $sql = "DELETE FROM comments WHERE id = :id";
    // $link->exec($sql);

    $result = $link->prepare($sql);
    $result->bindParam(':id', $id);
    $result->execute();
}


function showNameFiles($id, $without) {

    global $link;

    $directory = "img/". $id;    // Папка с изображениями
    $allowed_types=array("jpg", "jpeg", "png", "gif");  //разрешеные типы изображений
    $file_parts = array();
      $ext="";
      $title="";
      // $i=0;
      $files = array();
    //пробуем открыть папку
      $dir_handle = @opendir($directory);
    while ($file = readdir($dir_handle))    //поиск по файлам
      {
      if($file=="." || $file == "..") continue;  //пропустить ссылки на другие папки
 

      $files[] = 'img/'. $id . '/' . $file;

      }
    closedir($dir_handle);  //закрыть папку


    if ($without == 'img/default_photo.jpg') {
        return $files;
    }
    elseif (file_exists($without)) {
        unset($files[array_search($without, $files)]);
        return $files;
    }
    else {
        return $files;
    }

    
}


function showComments($id) {

    global $link;

    $sql = "SELECT * FROM comments WHERE user_id = :id";

    $result = $link->prepare($sql);
    $result->bindParam(':id', $id);
    $result->execute();


    $comments = [];
    while ($comment = $result->fetch(PDO::FETCH_ASSOC)){
        $comments[] = $comment;
    }
    
    return $comments;

}

function getAllRegions() {

    global $link;

    $sql = "SELECT name FROM regions";
    
    $result = $link->query($sql);

    $regions = [];
    $i = 1;
    while ($region = $result->fetch(PDO::FETCH_ASSOC)){
        $regions[$i] = $region['name'];
        $i++;
    }
    
    return $regions;

}

function getAllChildrenFromRegions() {

    global $link;


    $children_region = [];

    for ($i=1; $i <= 17; $i++) { 
      

      $sql = "SELECT children.id, children.surname, children.place, children.location, children.phone, children.photo, children.description, COUNT(child.name) as count_children  FROM children LEFT JOIN child ON children.id=child.family_id WHERE region_id = $i GROUP BY children.id, children.surname, children.place, children.location, children.phone, children.photo, children.description";

      $result = $link->query($sql);

      $rows = [];
      while ($row = $result->fetch(PDO::FETCH_ASSOC)){
          $rows[] = $row;
      }

      $children_region[$i] = $rows;

    }

    return $children_region;
}



function RDir( $path ) {
 // если путь существует и это папка
 if ( file_exists( $path ) AND is_dir( $path ) ) {
   // открываем папку
    $dir = opendir($path);
    while ( false !== ( $element = readdir( $dir ) ) ) {
      // удаляем только содержимое папки
      if ( $element != '.' AND $element != '..' )  {
        $tmp = $path . '/' . $element;
        chmod( $tmp, 0777 );
       // если элемент является папкой, то
       // удаляем его используя нашу функцию RDir
        if ( is_dir( $tmp ) ) {
         RDir( $tmp );
       // если элемент является файлом, то удаляем файл
        } else {
          unlink( $tmp );
       }
     }
   }
   // закрываем папку
    closedir($dir);
    // удаляем саму папку
   if ( file_exists( $path ) ) {
     rmdir( $path );
   }
 }
}


function delPhoto( $path ) {
  print_r($path);
 // если путь существует и это папка
 // if ( file_exists( $path ) AND is_dir( $path ) ) {
 //   // открываем папку
 //    $dir = opendir($path);
 //    while ( false !== ( $element = readdir( $dir ) ) ) {
 //      // удаляем только содержимое папки
        chmod( $path, 0777 );
        unlink( $path );
   //   }
   // }
   // закрываем папку
    // closedir($dir);
 }


function enter()
{

    global $link;

    $error = array(); //массив для ошибок
    if ($_POST['login'] != "" && $_POST['password'] != "") //если поля заполнены

    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE login =:login";
        $result = $link->prepare($sql);
        $result->bindParam(':login', $login);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);


        if (isset($row['id'])) //если нашлась одна строка, значит такой юзер существует в базе данных

        {
            if (password_verify($password, $row['password'])) //сравнивается хэшированный пароль из базы данных с хэшированными паролем, введённым пользователем

            {
                //пишутся логин и хэшированный пароль в cookie, также создаётся переменная сессии
                setcookie("login", $row['login'], time() + 50000);
                setcookie("password", $row['password'], time() + 50000);
                $_SESSION['id'] = $row['id'];   //записываем в сессию id пользователя

                $id = $_SESSION['id'];
                lastAct($id);
            } else //если пароли не совпали

            {
                $error[] = "Неправильний пароль";
            }
            return $error;
        } else //если такого пользователя не найдено в базе данных

        {
            $error[] = "Неправильний логін та пароль";
            return $error;
        }
    } else {
        $error[] = "Поля не повинні бути пустими!";
        return $error;
    }

}





function login () {     
    // ini_set ("session.use_trans_sid", true);
    // session_start();

    global $link;

    //если сесcия есть
    if (isset($_SESSION['id'])) {       

        //если cookie есть, обновляется время их жизни и возвращается true      
        if(isset($_COOKIE['login']) && isset($_COOKIE['password'])) {      
            SetCookie("login", "", time() - 1, '/');            
            SetCookie("password","", time() - 1, '/');
            setcookie ("login", $_COOKIE['login'], time() + 50000, '/');            
            setcookie ("password", $_COOKIE['password'], time() + 50000, '/'); 
            $id = $_SESSION['id'];          
            lastAct($id);           
            return true;        
        }  
        //иначе добавляются cookie с логином и паролем, чтобы после перезапуска браузера сессия не слетала         
        else {
            //запрашивается строка с искомым id     

            $result = $link->prepare("SELECT * FROM users WHERE id =:id");
            $result->bindParam(':id', $_SESSION['id']);
            $result->execute();

            $row = $result->fetch(PDO::FETCH_ASSOC);  


            //если получена одна строка
            if (isset($row)) {                     

                setcookie ("login", $row['login'], time()+50000, '/');              

                setcookie ("password", $row['password'], time() + 50000, '/'); 

                $id = $_SESSION['id'];
                lastAct($id); 
                return true;            

            } 
            else 
                return false;      
        }   
    }   

  //если сессии нет, проверяется существование cookie. Если они существуют, проверяется их валидность по базе данных 
  else {       
    //если куки существуют    
    if(isset($_COOKIE['login']) && isset($_COOKIE['password'])) {           
      
      //запрашивается строка с искомым логином и паролем             
      $result = $link->prepare("SELECT * FROM users WHERE login =:login");
      $result->bindParam(':login', $_COOKIE['login']);
      $result->execute();

      $row = $result->fetch(PDO::FETCH_ASSOC);                   



      //если логин и пароль нашлись в базе данных  
      if(@count($row) == 1 && $row['password'] == $_COOKIE['password']) {               
        $_SESSION['id'] = $row['id']; //записываем в сесиию id              
        $id = $_SESSION['id'];              

        lastAct($id);               
        return true;            
      }
      //если данные из cookie не подошли, эти куки удаляются  
      else {               
        SetCookie("login", "", time() - 360000, '/');               

        SetCookie("password", "", time() - 360000, '/');                    
        return false;           

      }       
    }       
    else //если куки не существуют      
    {           
      return false;       
    }   
  } 
}



function is_admin($id) {    

    global $link;

  
    $result = $link->prepare("SELECT * FROM users WHERE id=:id");
    $result->bindParam(':id', $id);
    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);     

    if (isset($row['role'])) {

        $role = 'admin';       

        if ($row['role'] == $role) {
            return true;
        }

        else return false; 

    }   
    else return false;   
}


function out () {   
    // session_start();    

    global $link;

    $id = $_SESSION['id'];              

    //обнуляется поле online, говорящее, что пользователь вышел с сайта (пригодится в будущем) 
    $query = "UPDATE users SET online=0 WHERE id=?"; 
    
    $stmt = $link->prepare($query);
    $stmt->execute([$id]);


    unset($_SESSION['$id']); //удалятся переменная сессии 
    // session_unset();   
    session_destroy();
    SetCookie("login", ""); //удаляются cookie с логином    

    SetCookie("password", ""); //удаляются cookie с паролем 

    header('Location: http://'.$_SERVER['HTTP_HOST'].'/'); //перенаправление на главную страницу сайта 
}


function lastAct($id) {   

    global $link;

    $tm = time();   

    $query = "UPDATE users SET online=?, last_act=? WHERE id=?"; 
    
    $stmt = $link->prepare($query);
    $stmt->execute([$tm, $tm, $id]);

}



?>