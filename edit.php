<?php
  session_start();
	require ('php/config.php');

  if (is_admin($_SESSION['id'])) {   

	require ('header.php');

    if (isset($_GET['id'])) {
        $row = editPersonFromId($_GET['id']);

        $child_from_family = showChildFromFamily($_GET['id']);
    }

    $regions = getAllRegions();

    // // Sort day, month, year
    // $tmp_date = explode('-' ,$row['birth']);

    // $month = [
    //             '01' => 'січень',
    //             '02' => 'лютий',
    //             '03' => 'березень',
    //             '04' => 'квітень',
    //             '05' => 'травень',
    //             '06' => 'червень',
    //             '07' => 'липень',
    //             '08' => 'серпень',
    //             '09' => 'вересень',
    //             '10' => 'жовтень',
    //             '11' => 'листопад',
    //             '12' => 'грудень'
    // ];

?>


    <style type="text/css">
        #image-preview {
          width: 400px;
          height: 400px;
          position: relative;
          overflow: hidden;
          background-color: #ffffff;
          color: #ecf0f1;
          margin: 0 auto;
    }
        }
        #image-preview input {
          line-height: 200px;
          font-size: 200px;
          position: absolute;
          opacity: 0;
          z-index: 10;
        }
        #image-preview label {
          position: absolute;
          z-index: 5;
          opacity: 0.8;
          cursor: pointer;
          background-color: #bdc3c7;
          width: 200px;
          height: 50px;
          font-size: 20px;
          line-height: 50px;
          text-transform: uppercase;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          margin: auto;
          text-align: center;
        }

          #image-preview-mini-1,
          #image-preview-mini-2,
          #image-preview-mini-3,
          #image-preview-mini-4,
          #image-preview-mini-5 {
            width: 200px;
            height: 200px;
            position: relative;
            
            /*background-color: #ffffff;*/
            /*color: #ecf0f1;*/
          }

          #image-preview-mini-1 img,
          #image-preview-mini-2 img,
          #image-preview-mini-3 img,
          #image-preview-mini-4 img,
          #image-preview-mini-5 img {
            position: absolute;
            /*overflow: hidden;*/
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

          }



    </style>

    <script type="text/javascript" src="js/jquery.uploadPreview.min.js"></script>

<script type="text/javascript">
    
function removeImage(id, del_file_name) {

        $('.loading').addClass('loading_anim');

        var formData = new FormData();

        formData.append('family_id', id);
        formData.append('delete_file', del_file_name);


        $.ajax({
        type: "POST",
        url: "php/delete.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function(text) {
            
            if (text == "success") {
                window.location.reload();
            }
            else {
                alert(text);
            }
        }
    });
}
</script>

    
    <div class="row">
        <div class="col-lg-12 margin-tb">
        	<div class="pull-right">
                <a href="index.php" class="btn btn-outline-dark my-3">Назад</a>
            </div>

            <div class="text-center">
                <div class="title-page">Редагувати: <span class="text-info"><?= $row['surname'] ?></span></div><br>
            </div>

        </div>
    </div>


    <form id="editForm" data-toggle="validator" data-focus="false" enctype="multipart/form-data">

        <div class="form-content row">

            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="edit-photo-content row">
                    <!-- <strong>Фото:</strong> -->
                    <div class="avatar-edit col-6">
                        <img src="<?= $row['photo'] ?>" alt="Avatar">
                    </div>
                    <div class="custom-edit-file col-xs-12 col-sm-12 col-md-9">
                        <div id="image-preview">
                          <label for="new_photo" id="image-label">Новий файл</label>
                          <input type="file" id="new_photo" name="new_photo" multiple="multiple" accept="image/jpg, image/jpeg" />
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="form-group">
                    <strong>Прізвище сім'ї: *</strong>
                    <input type="hidden" id="id" value="<?= $row['id'] ?>">
                    <input type="text" class="form-control" id="surname" value="<?= $row['surname'] ?>" required>
                    <div class="help-block with-errors text-danger"></div>
                </div>
            </div>

              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Діти: *</strong>

                      <div id="add_field_child_area">
                        
                        <?php 

                        $j = 1;
                        foreach ($child_from_family as $child):?>

                            <div id="addChild<?=$j?>" class="row addChild py-1">
                              <div class='col-1 col-sm-1 py-2 py-sm-0' style = 'text-align: end'>
                                <?= $j ?>
                              </div>
                              <div class="col-6 col-sm-5 py-2 py-sm-0">
                                  <input type="text" id="name_child" name="name_child[]" value="<?= $child['name'] ?>" class="form-control" autocomplete="off" placeholder="Прізвище, Ім'я" required>
                                  <div class="help-block with-errors text-danger"></div>
                              </div>
                      
                              <div class="col-3 col-sm-2 py-2 py-sm-0">
                                  <input type="text" class="form-control" id="year" name="year[]"  value="<?= $child['birth'] ?>"autocomplete="off" placeholder="Рік">
                              </div>

                              <div onclick="removeChildField(<?=$j?>);" class="close col-1" style="font-size: 30px" aria-label="Close"> ×
                              </div>

                            </div> 

                        <?php 
                        $j++;
                        endforeach;?> 

                      </div>
                      <div class="add-field-child"><span onclick="addFieldChild();" id="add_field_child_btn" class="text-info">Додати ще</span></div>
                      
                     
                  </div>
              </div>


            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="form-group">
                    <strong>Район: *</strong>

                    <select class="custom-select form-control" name="select[]" id="region" required>

                    <option value="">-- Виберіть район --</option>

                    <?php foreach ($regions as $key => $value): ?>

                        <?php if ($key == $row['region_id']): ?>
                            <option value="<?= $key ?>" selected><?= $value ?></option>
                        <?php else: ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php endif ?>

                    <?php endforeach ?>

                    </select>


                    <div class="help-block with-errors text-danger"></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="form-group">
                    <strong>Населений пункт: *</strong>
                    <input type="text" class="form-control" id="place" value="<?= $row['place'] ?>" placeholder="с. Олександрія" required>
                    <div class="help-block with-errors text-danger"></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="form-group">
                    <strong>Локація:</strong>
                    <input type="text" class="form-control" id="location" value="<?= $row['location'] ?>" placeholder="50.619261, 26.249964">
                    <a href="<?= 'https://www.google.com.ua/maps/place/' . $row['location'] ?>" target="_blank">Переглянути у Google Maps</a>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="form-group">
                    <strong>Телефон:</strong>
               
                    <div id="add_field_area">
            <?php 
            $i = 1;

            if ($row['phone']) {
            
            
                foreach ($row['phone'] as $key => $value): ?>
                            <div id="add<?=$i?>" class="row justify-content-center add py-1">
                                <input type="text" name="number[]" class="col-5 form-control" id="number" value="<?=$key?>" placeholder="Номер телефону" autocomplete="off">
                                <input type="text" name="name_contact[]" class="col-4 offset-1 form-control" id="name_contact" value="<?=$value?>" placeholder="Ім'я контакта" autocomplete="off">

                                <div onclick="removeField(<?=$i?>);" class="close col-1" style="font-size: 30px" aria-label="Close">
                                        ×
                                    </div>
                            </div>
                <?php 
                // Increment for $i
                $i++;
                endforeach; 
            } ?>
                    </div>
                    <div class="add-field"><span onclick="addField();" id="add_field_btn" class="text-info">Додати ще номер</span></div>
                </div>
            </div>

  

            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="form-group">
                    <strong>Опис: *</strong><br>
                    <div id="">

                        <textarea class="tinymce" id="description" required><?= $row['description'] ?></textarea>
                        <div class="help-block with-errors text-danger"></div>
                        
	                </div>
	            </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-9">
                <strong>Додаткові фото:</strong>
                <div class="form-group each-images row">

                <?php for ($i=1; $i <= 5; $i++) { 
                    if ($row['files'][$i-1] == ''):?>

                        <div id="image-preview-mini-<?=$i?>" class="m-2">
                            <label for="image-<?=$i?>" id="image-label-mini-<?=$i?>">Виберіть файл</label>
                            <input type="file" id="image-<?=$i?>" name="image-<?=$i?>" accept="image/jpg, image/jpeg" />
                        </div>

                    <?php 

                    else: ?>

                        <div id="image-preview-mini-<?=$i?>" class="m-2">
                            <img src="<?=$row['files'][$i-1]?>" id="image-<?=$i?>" alt="" style="">
                        </div>
                        <div onclick="removeImage(<?= $row['id']?> ,'<?= $row['files'][$i-1]?> ');" class="close" style="font-size: 30px" aria-label="Close">
                                    ×
                        </div>

                    <?php 
                    endif;

                } ?>

                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-danger" data-href="/php/delete.php?id=<?= $row['id']?>" data-toggle="modal" data-target="#confirm-delete">
                        Видалити
                    </a>
                    <button type="submit" class="btn btn-info ml-2">Змінити</button>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="text-center form-message">
                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                </div>
            </div>

	    </div>
    </form>


            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Підтвердити видалення</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                    
                        <div class="modal-body">
                            <p>Ви хочете видалити <b><?= $row['surname'] . ' ' . $row['name'] ?></b></p>
                            <p>Продовжити видалення?</p>
                            <p class="debug-url"></p>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Скасувати</button>
                            <form id="deleteData" data-toggle="validator" data-focus="false">
                                <input type="hidden" id="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-ok">Видалити</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
         

      <!-- Script for connect TinyMCE -->
      <script type="text/javascript" src="components/tinymce/js/tinymce/tinymce.min.js"></script>
      <script type="text/javascript" src="components/tinymce/js/tinymce/init-tinymce.js"></script>


<?php 


	require ('footer.php');

 }

 else {
  header("Location: ".$_SERVER['REQUEST_URI']);
 }

?>