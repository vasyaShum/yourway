<?php

include "config.php";


// $link = new PDO('mysql:host=localhost:3306;dbname=yourway', 'root','root',[PDO::ATTR_PERSISTENT=>true]);

if (isset($_POST['text'])) {


    $name = htmlspecialchars($_POST['name']);
    $text = htmlspecialchars($_POST['text']);
    $user_id = $_POST['user_id'];
    $date = date("Y-m-d H:i:s");


    $sql = "INSERT INTO comments (name, text, date, user_id) VALUES (:name,:text, :date,:user_id)";

    $stmt = $link->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':date', $date);


    $stmt->execute();

    echo "success";

}

?>