<?php

include "config.php";

if (is_admin($_SESSION['id'])) {  

  // $link = mysqli_connect('localhost:3306','root','root','yourway');

  if (isset($_POST['delete_file'])) {

      $family_id = $_POST['family_id'];
      $delete_file_name = $_POST['delete_file'];

      $path = '../' . $delete_file_name;
      if ( file_exists( $path ) ) {

      $dir = '../img/' . $family_id;

        chmod($path, 0644);
        unlink( $path );
        echo "success";
     }
      else {
        echo "Error";
    }
  }



  if (isset($_POST['id'])) {

  	$id = $_POST['id'];

  	deletePersonFromId($id);

  	$dir = $_SERVER['DOCUMENT_ROOT'] . '/img/' . $id;
  	RDir( $dir );

  	echo "success";

  	} else {
  	echo "Error";
  }
  
 }
 else {
  header("Location: ".$_SERVER['REQUEST_URI']);
 }

?>