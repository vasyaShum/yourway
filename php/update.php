<?php

include "config.php";

if (is_admin($_SESSION['id'])) { 


    function downloadImage ($id, $file_name) {
        $dir = '../img/' . $id;

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
                $img = imageCreateFromPng($filename); 
                imageSaveAlpha($img, true);
                break;
            default:
                $img = imageCreateFromJpeg($path);

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



    if (isset($_POST['id'])) {

        # ID row
        $id = $_POST['id'];

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
        if (isset($_FILES['new_photo']['tmp_name'])) {
            $photo = 'img/' . $id . '/' . $_FILES['new_photo']['name'];
            $photo = downloadImage($id, 'new_photo');

            $query = "UPDATE children SET surname = ?, region_id = ?, place = ?, location = ?, phone = ?, description = ?, photo = ? WHERE id = '$id'";
            $data = [$surname, $region_id, $place, $location, $phone, $description, $photo];
        }
        // Not new photo   
        else {

            $query = "UPDATE children SET surname = ?, region_id = ?, place = ?, location = ?, phone = ?, description = ? WHERE id = '$id'";
            $data = [$surname, $region_id, $place, $location, $phone, $description];
        }


        for ($i=1; $i <= 5 ; $i++) { 
            if (isset($_FILES['image-'.$i]['tmp_name'])) {
                $file_name = 'image-'. $i;
                downloadImage($id, $file_name);
            }
        }


        $stmt = $link->prepare($query);
        $stmt->execute($data);

        // Add delete old photo


        // Delete old rows with table Child
        $sql = "DELETE FROM child WHERE family_id = :id";
        $result = $link->prepare($sql);
        $result->bindParam(':id', $id);
        $result->execute();





        // For CHILD table
        $sql2 = "INSERT INTO child (id, name, birth, family_id) VALUES (:id,:name,:birth,:fam_id)";


        // Write all children into Table CHILD
        $names = explode(',', $name_child);
        $years = explode(',', $year);


        $stmt2 = $link->prepare($sql2);

        $child_id = selectIdLastRowChild() + 1;

        for ($i = 0;$i < count($names);$i++) {

            $stmt2->bindParam(':id', $child_id);
            $stmt2->bindParam(':fam_id', $id);

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
 }

 else {
  header("Location: ".$_SERVER['REQUEST_URI']);
 }

?>