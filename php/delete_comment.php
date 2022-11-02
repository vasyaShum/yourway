<?php

include "config.php";

if (is_admin($_SESSION['id'])) {  


  if (isset($_POST['id'])) {

  	$comment_id = $_POST['id'];

  	deleteCommentFromId($comment_id);

  	echo "success";

  	} else {
  	echo "Error";
  }
  
 }
 else {
  header("Location: ".$_SERVER['REQUEST_URI']);
 }

?>