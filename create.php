<?php
  // session_start();
	require ('php/config.php');

  if (is_admin($_SESSION['id'])) {	

    require ('header.php');


    $regions = getAllRegions();

  ?>

      <style type="text/css">
          #image-preview {
            width: 400px;
            height: 400px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
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
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
          }
          #image-preview-mini-1 input,
          #image-preview-mini-2 input,
          #image-preview-mini-3 input,
          #image-preview-mini-4 input,
          #image-preview-mini-5 input {
            line-height: 100px;
            font-size: 100px;
            position: absolute;
            opacity: 0;
            z-index: 10;
          }
          #image-preview-mini-1 label,
          #image-preview-mini-2 label,
          #image-preview-mini-3 label,
          #image-preview-mini-4 label,
          #image-preview-mini-5 label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            background-color: #bdc3c7;
            width: 100px;
            height: 25px;
            font-size: 10px;
            line-height: 25px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
          }

          @media (max-width: 576px) {

            .container {
              padding: 0px 20px; 
            } 

          }
  /*
          @media (max-width: 425px) {

            .container {
              margin: 40px 0px; 
            } 

          }*/


      </style>

      <script type="text/javascript" src="js/jquery.uploadPreview.js"></script>
  <!--     <script type="text/javascript">
      $(document).ready(function() {

      });
      </script> -->


  	<div class="row">
          <div class="col-lg-12 margin-tb">
          	<div class="pull-right">
                  <a href="index.php" class="btn btn-outline-dark my-3">Назад</a>
              </div>

              <div class="text-center">
                  <div class="title-page">Додати запис</div>
              </div>

          </div>
      </div>


      <form id="createForm" data-toggle="validator" data-focus="false" novalidate="true" enctype="multipart/form-data">

          <div class="form-content row">

              <div class="form-message">
                  <div id="rmsgSubmit" class="h3 text-center hidden"></div>
              </div>


              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Фото:</strong>
                      <div id="image-preview">
                        <label for="photo" id="image-label">Виберіть файл</label>
                        <input type="file" id="photo" name="photo" accept="image/jpg, image/jpeg" />
                      </div> 
                  </div>
              </div>


              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Прізвище сім'ї: *</strong>
                      <input type="text" class="form-control" id="surname" autocomplete="off" placeholder="Лише прізвище" required>
                      <div class="help-block with-errors text-danger"></div>
                  </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Діти: *</strong>

                      <div id="add_field_child_area">

                        <div id="addChild1" class="row addChild py-1">
                          <div class='col-1 col-sm-1 py-2 py-sm-0' style = 'text-align: end'>
                            1
                          </div>
                          <div class="col-6 col-sm-5 py-2 py-sm-0">
                              <input type="text" id="name_child" name="name_child[]" class="form-control" autocomplete="off" placeholder="Прізвище, Ім'я" required>
                              <div class="help-block with-errors text-danger"></div>
                          </div>
                  
                          <div class="col-3 col-sm-2 py-2 py-sm-0">
                              <input type="text" class="form-control" id="year" name="year[]" autocomplete="off" placeholder="Рік">
                          </div>
                        </div>  

                      </div>
                      <div class="add-field-child"><span onclick="addFieldChild();" id="add_field_child_btn" class="text-info">Додати ще</span></div>
                      
                     
                  </div>
              </div>


        			<div class="col-xs-12 col-sm-12 col-md-9">
        			    <div class="form-group">
        			    	<strong>Район: *</strong><br>

        		        <select class="custom-select form-control" name="select[]" id="region" required>

                      <option value="" selected>-- Виберіть район --</option>

                      <?php foreach ($regions as $key => $value): ?>
                      <option value="<?= $key ?>"><?= $value ?></option>
                      <?php endforeach ?>

        					  </select>
                    <div class="help-block with-errors text-danger"></div>

                  </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Населений пункт: *</strong>
                      <input type="text" class="form-control" id="place" autocomplete="off" placeholder="с. Олександрія" required>
                      <div class="help-block with-errors text-danger"></div>
                  </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Локація:</strong>
                      <input type="text" class="form-control" id="location" autocomplete="off" placeholder="50.619261, 26.249964">
                  </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Телефон:</strong>
                      <!-- <input type="text" class="form-control" id="phone" required> -->
                 
                      <div id="add_field_area">

                          <div id="add1" class="row justify-content-center add py-1">
                              <input type="text" name="number[]" class="col-6 form-control" id="number" value="" placeholder="Номер телефону" autocomplete="off">
                              <input type="text" name="name_contact[]" class="col-4 offset-1 form-control" id="name_contact" value="" placeholder="Ім'я контакта" autocomplete="off">
                          </div>
                      </div>
                      <div class="add-field"><span onclick="addField();" id="add_field_btn" class="text-info">Додати ще номер</span></div>
                  </div>
              </div>
            

              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="form-group">
                      <strong>Опис: *</strong><br>
                      <div id="">
  						<!-- <textarea class="form-control" style="height:150px" id="description" required></textarea> -->
              <textarea class="tinymce" id="description" required></textarea>
              <div class="help-block with-errors text-danger"></div>
                          
  	                </div>
  	            </div>
  	        </div>


              <div class="col-xs-12 col-sm-12 col-md-9">
                  <strong>Додаткові фото:</strong>
                  <div class="form-group each-images row">

                      <div id="image-preview-mini-1" class="m-2">
                          <label for="image-1" id="image-label-mini-1">Виберіть файл</label>
                          <input type="file" id="image-1" name="image-1" accept="image/jpg, image/jpeg" />
                      </div>

                      <div id="image-preview-mini-2" class="m-2">
                          <label for="image-2" id="image-label-mini-2">Виберіть файл</label>
                          <input type="file" id="image-2" name="image-2" accept="image/jpg, image/jpeg" />
                      </div>

                      <div id="image-preview-mini-3" class="m-2">
                          <label for="image-3" id="image-label-mini-3">Виберіть файл</label>
                          <input type="file" id="image-3" name="image-3" accept="image/jpg, image/jpeg" />
                      </div>

                      <div id="image-preview-mini-4" class="m-2">
                          <label for="image-4" id="image-label-mini-4">Виберіть файл</label>
                          <input type="file" id="image-4" name="image-4" accept="image/jpg, image/jpeg" />
                      </div>

                      <div id="image-preview-mini-5" class="m-2">
                          <label for="image-5" id="image-label-mini-5">Виберіть файл</label>
                          <input type="file" id="image-5" name="image-5" accept="image/jpg, image/jpeg" />
                      </div>


                  </div>
              </div>


              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-info ">Додати</button>
                  </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-9">
                  <div class="text-center form-message">
                      <div id="msgSubmit" class="h3 text-center hidden"></div>
                  </div>
              </div>



  	    </div>
      </form>
              <!-- DropZobe Place -->
              <!-- <form action="upload.php" class="dropzone" id="my-dropzone"></form> -->


          <div class="send_success">
              <img src="img/success-send.gif" alt="">
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