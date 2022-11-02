<?php

include "config.php";

if (is_admin($_SESSION['id'])) {   


    function downloadImage ($fam_id, $file_name) {
        $dir = '../img/' . $fam_id;

        $path = $dir . '/' . $_FILES[$file_name]['name'];

        copy($_FILES[$file_name]['tmp_name'], $path);

      
        $info   = getimagesize($path);
        $width  = $info[0];
        $height = $info[1];
        $type   = $info[2];
         
        switch ($type) { 
            case 1: 
                $img = imageCreateFromGif($path);
                imageSaveAlpha($img, true);
                break;                  
            case 2: 
                $img = imageCreateFromJpeg($path);
                break;
            case 3: 
                $img = imageCreateFromPng($path); 
                imageSaveAlpha($img, true);
                break;

        }

        $out_file = $dir . '/YWC_' . $_FILES[$file_name]['name'];

        $file_size = filesize($path);
        // echo $file_size;
        unlink($path);

        if ($file_size < 524288) {
            imagejpeg($img, $out_file, 100);
        }
        elseif ($file_size < 1048576) {
            imagejpeg($img, $out_file, 75);
        }
        elseif ($file_size < 2097152) {
            imagejpeg($img, $out_file, 50);
        }
        else {
            imagejpeg($img, $out_file, 15);
        }
        

        return $out_file;

    }



    try {


        if (isset($_POST['surname'])) {

            # ID for new row
            $fam_id = selectIdLastRow() + 1;
            $child_id = selectIdLastRowChild() + 1;

        	$surname = htmlspecialchars($_POST['surname']);


            $name_child = htmlspecialchars($_POST['name_child']);
            $year = htmlspecialchars($_POST['year']);

            $region_id = htmlspecialchars($_POST['region']);
            $place = htmlspecialchars($_POST['place']);
            $location = htmlspecialchars($_POST['location']);
            $description = $_POST['description'];
            $number = htmlspecialchars($_POST['number']);
            $name_contact = htmlspecialchars($_POST['name_contact']);

            $phone = [];
            $key = explode(',', $number);
            $value = explode(',', $name_contact);

            for ($i = 0;$i < count($key);$i++) {
                $k = $key[$i];
                $v = $value[$i];
                $phone[$k] = $v;

            }
            $phone = serialize($phone);




            // For new photo
            if (isset($_FILES['photo']['tmp_name'])) {

                $dir = '../img/' . $fam_id;
                mkdir($dir);
                
                $photo = downloadImage($fam_id, 'photo');
            }
            // Not new photo   
            else {
                $photo = 'img/default_photo.jpg';

                $dir = '../img/' . $fam_id;
                mkdir($dir);
            }


            for ($i=1; $i<6 ; $i++) { 
                $file_name = 'image-'. $i;
                if (isset($_FILES[$file_name]['tmp_name'])) {
                    downloadImage($fam_id, $file_name);
                }
            }


            // For FAMILY table
            $sql = "INSERT INTO children (id, surname, region_id, place, location, phone, photo, description) VALUES (:id,:surname,:region_id,:place, :location, :phone, :photo, :description)";

            $stmt = $link->prepare($sql);
            $stmt->bindParam(':id', $fam_id);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':region_id', $region_id);
            $stmt->bindParam(':place', $place);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':photo', $photo);
            $stmt->bindParam(':description', $description);

            $stmt->execute();


            // For CHILD table
            $sql2 = "INSERT INTO child (id, name, birth, family_id) VALUES (:id,:name,:birth,:fam_id)";


            // Write all children into Table CHILD
            $names = explode(',', $name_child);
            $years = explode(',', $year);

            $stmt2 = $link->prepare($sql2);


            for ($i = 0;$i < count($names);$i++) {

                $stmt2->bindParam(':id', $child_id);
                $stmt2->bindParam(':fam_id', $fam_id);

                $stmt2->bindParam(':name', $names[$i]);

                if ($years[$i] != '') {
                    $stmt2->bindParam(':birth', $years[$i]);
                }
                else {
                    $years[$i] = NULL;
                    $stmt2->bindParam(':birth', $years[$i]);
                }
                
                $stmt2->execute();

                $child_id++;
            }


            echo "success";

        }

    } catch (PDOException $e) {
        
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/img/' . $fam_id;
        RDir( $dir );
        echo "Помилка. Повторіть заново";

    }

 }

 else {
  header("Location: ".$_SERVER['REQUEST_URI']);
 }

?>