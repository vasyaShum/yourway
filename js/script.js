$(document).ready(function() {

    /* Create Form */
    $("#createForm").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            // // handle the invalid form...
            // rformError();
            // rsubmitMSG(false, "Please fill all fields!");
        } else {
            // everything looks good!
            event.preventDefault();
            submitCreateForm();
        }
    });



    /* Create Form */
    $("#search-form").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            // // handle the invalid form...
            // rformError();
            // rsubmitMSG(false, "Please fill all fields!");
        } else {
            // everything looks good!
            event.preventDefault();
            submitSearchForm();
        }
    });


    /* Edit Form */
    $("#editForm").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
            event.preventDefault();
            submitEditForm();
        }
    });



    /* Delete Data */
    $("#deleteData").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
            event.preventDefault();
            deleteData();
        }
    });


    /* Add Comment */
    $("#addComment").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
            event.preventDefault();
            addComment();
        }
    });


      $.uploadPreview({
        input_field: "#new_photo",
        preview_box: "#image-preview",
        label_field: "#image-label",
      });

            $.uploadPreview({
        input_field: "#photo",
        preview_box: "#image-preview",
        label_field: "#image-label",
      });

      $.uploadPreview({
        input_field: "#image-1",
        preview_box: "#image-preview-mini-1",
        label_field: "#image-label-mini-1",
      });

      $.uploadPreview({
        input_field: "#image-2",
        preview_box: "#image-preview-mini-2",
        label_field: "#image-label-mini-2",
      });

      $.uploadPreview({
        input_field: "#image-3",
        preview_box: "#image-preview-mini-3",
        label_field: "#image-label-mini-3",
      });

      $.uploadPreview({
        input_field: "#image-4",
        preview_box: "#image-preview-mini-4",
        label_field: "#image-label-mini-4",
      });

      $.uploadPreview({
        input_field: "#image-5",
        preview_box: "#image-preview-mini-5",
        label_field: "#image-label-mini-5",
      });



});


 
function fill(Value) {
    // Функция 'fill', является обработчиком события 'click'.
    // Она вызывается, когда пользователь кликает по элементу из результата поиска.
 
    $('#search').val(Value); // Берем значение элемента из результата поиска и добавляем его в значение поля поиска
 
    // $('#display').hide(); // Скрываем результаты поиска
 
}





function submitCreateForm() {

    // Animation
    $('.loading').addClass('loading_anim');


    // initiate variables with form content
    var surname = $("#surname").val();
    // var name = $("#name").val();
    // var middle_name = $("#middle_name").val();

    // var day = $("#day").val();
    // var month = $("#month").val();
    // var year = $("#year").val();
   
    // // All in one date birth
    // if (day == '' || month == '' || year == '') 
    //     var birth = '';
    // else 
    //     var birth = year + '-' + month + '-' + day;

    var region = $("#region").val();
    var place = $("#place").val();
    var location = $("#location").val();
    var description = $("#description").val();
    


    var number = new Array();
    $('input[name^="number"]').each(function() 
    {
    number.push($(this).val());
    });

    var name_contact = new Array();
    $('input[name^="name_contact"]').each(function() 
    {
    name_contact.push($(this).val());
    });


    // For Table Child
    var name_child = new Array();
    $('input[name^="name_child"]').each(function() 
    {
    name_child.push($(this).val());
    });

    var year = new Array();
    $('input[name^="year"]').each(function() 
    {
    year.push($(this).val());
    });

    
    var formData = new FormData();

    formData.append('photo', $('#photo').prop('files')[0]);
    formData.append('image-1', $('#image-1').prop('files')[0]);
    formData.append('image-2', $('#image-2').prop('files')[0]);
    formData.append('image-3', $('#image-3').prop('files')[0]);
    formData.append('image-4', $('#image-4').prop('files')[0]);
    formData.append('image-5', $('#image-5').prop('files')[0]);

    formData.append('surname', surname);

    formData.append('name_child', name_child);
    formData.append('year', year);

    formData.append('region', region);
    formData.append('place', place);
    formData.append('location', location);
    formData.append('number', number);
    formData.append('name_contact', name_contact);
    formData.append('description', description);


    
    $.ajax({
        type: "POST",
        url: "../php/add.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function(text) {
            
            if (text == "success") {
                // formSuccess();
                
                // Animation
                $('.loading').removeClass('loading_anim');

                $('.send_success').addClass('send_success_anim');

                window.location.href = '../index.php';
            }
            else {
                alert(text);
                submitMSG(false, "Error!");
            }

        }
    });

}

function submitSearchForm() {

    // Animation
    $('.loading').addClass('loading_anim');


    // initiate variables with form content
    var search = $("#search").val();
    
    var formData = new FormData();

    formData.append('search', search);

    
    $.ajax({
        type: "POST",
        url: "../php/handler.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function(text) {
            
            if (text) {
                // formSuccess();
                
                // Animation
                $('.loading').removeClass('loading_anim');

                $('.result').html(text);

            }
            else {
                alert(text);
                submitMSG(false, "Error!");
            }

        }
    });

}



function submitEditForm() {

    // Animation
    $('.loading').addClass('loading_anim');


    // initiate variables with form content
    var id = $("#id").val();
    var surname = $("#surname").val();


    var region = $("#region").val();
    var place = $("#place").val();
    var location = $("#location").val();
    var description = $("#description").val();


    var number = new Array();
    $('input[name^="number"]').each(function() 
    {
    number.push($(this).val());
    });

    var name_contact = new Array();
    $('input[name^="name_contact"]').each(function() 
    {
    name_contact.push($(this).val());
    });


    // For Table Child
    var name_child = new Array();
    $('input[name^="name_child"]').each(function() 
    {
    name_child.push($(this).val());
    });

    var year = new Array();
    $('input[name^="year"]').each(function() 
    {
    year.push($(this).val());
    });

    
    var formData = new FormData();

    formData.append('new_photo', $('#new_photo').prop('files')[0]);

    for (var i = 1; i <= 5; i++) {
        if ($("#image-" + i).is('input')) {
            formData.append('image-' + i, $("#image-" + i).prop('files')[0]);
        }
    }



    formData.append('id', id);
    formData.append('surname', surname);

    formData.append('name_child', name_child);
    formData.append('year', year);

    formData.append('region', region);
    formData.append('place', place);
    formData.append('location', location);
    formData.append('number', number);
    formData.append('name_contact', name_contact);
    formData.append('description', description);


    
    $.ajax({
        type: "POST",
        url: "../php/update.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function(text) {
            
            if (text == "success") {
                window.location.href = '../view.php?id=' + id;
            }
            else {
                alert(text);
                submitMSG(false, "Error!");
            }

        }
    });
}




function deleteData() {

    // Animation
    $('.loading').addClass('loading_anim');


    // initiate variables with form content
    var id = $("#id").val();

    var formData = new FormData();

    formData.append('id', id);

    
    $.ajax({
        type: "POST",
        url: "../php/delete.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function(text) {
            
            if (text == "success") {
                window.location.href = '../index.php';
            }
            else {
                alert(text);
                submitMSG(false, "Error!");
            }
        }
    });
}



function addComment() {

     $('.loading').addClass('loading_anim');

    // initiate variables with form content
    
    var name = $("#name_comment").val();
    var text = $("#comment").val();
    var user_id = $("#user_id").val();
 
    var formData = new FormData();

    formData.append('name', name);
    formData.append('text', text);
    formData.append('user_id', user_id);

    
    $.ajax({
        type: "POST",
        url: "../php/comment.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function(text) {
            
            if (text == "success") {
                setTimeout(function() { 
                    $('.loading').removeClass('loading_anim');
                }, 1500);

                window.location.reload();

            }
            else {
                alert(text);
                submitMSG(false, "Error!");
            }
        }
    });

}


function deleteComment(id) {

    // Animation
    $('.loading').addClass('loading_anim');



    var formData = new FormData();

    formData.append('id', id);

    
    $.ajax({
        type: "POST",
        url: "../php/delete_comment.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function(text) {
            
            if (text == "success") {
                setTimeout(function() { $('.loading').removeClass('loading_anim');}, 1000);
                window.location.reload();
            }
            else {
                alert(text);
                submitMSG(false, "Error!");
            }
        }
    });
}




function formSuccess() {
    $("#createForm")[0].reset();
    submitMSG(true, "Submitted!");
    $("input").removeClass('notEmpty'); // resets the field label after submission
    $("textarea").removeClass('notEmpty'); // resets the field label after submission
}

function submitMSG(valid, msg) {
    if (valid) {
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}


// Scripts for add new field whith write phone
function addField () {
    var telnum = parseInt($("#add_field_area").find("div.add:last").attr("id").slice(3)) + 1;
    $("div#add_field_area").append("<div id='add" + telnum +"' class='row justify-content-center add py-2'>" +
        "<input type='text' class='col-5 form-control' name='number[]' id='number'  value='' placeholder='Номер телефону' autocomplete='off' required/>" +
        "<input type='text' class='col-4 offset-1 form-control' name='name_contact[]' id='name_contact' value='' placeholder='Імя контакта' autocomplete='off' required>" +
        "<div onclick=\"removeField("+ telnum +");\" class=\"close col-1\" style=\"font-size: 30px\" aria-label=\"Close\">\n" +
        "                                    &times;\n" +
        "                                </div></div>");
}

function removeField(id) {
    $("div#add"+id).remove();
}



// For add new field whith write CHILDREN
function addFieldChild () {
    var namenum = parseInt($("#add_field_child_area").find("div.addChild:last").attr("id").slice(8)) + 1;

    $("div#add_field_child_area").append("<div id='addChild" + namenum + "' class='row addChild py-1'>" +
        "<div class='col-1 col-sm-1 py-2 py-sm-0' style = 'text-align: end'>" + namenum + "</div>" +
        "<div class='col-6 col-sm-5 py-2 py-sm-0'> <input type='text' id='name_child' name='name_child[]' class='form-control' autocomplete='off' required>" +
        "<div class='help-block with-errors text-danger'></div></div>" + 
    
        "<div class='col-3 col-sm-2 py-2 py-sm-0'> <input type='text' class='form-control' id='year' name='year[]' autocomplete='off'></div>" +

        "<div onclick=\"removeChildField("+ namenum +");\" class=\"close col-1\" style=\"font-size: 30px\" aria-label=\"Close\">\n" +
        "                                    &times;\n" +
        "                                </div></div>");
}

function removeChildField(id) {
    $("div#addChild"+id).remove();
}

