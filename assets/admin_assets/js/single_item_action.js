$(document).ready(function(){
    var url = $("#url").html();
    $('#add-new-form').on('submit',submitAddNewForm);
    function submitAddNewForm(e){
        e.preventDefault();
        $("#loading").show();
        var form = document.forms.namedItem("add_new_form");  
        var formdata = new FormData(form); 
        var method = $(this).attr('method');
        $.ajax({
            async: true,
            type: method,
            dataType: "json",
            contentType: false,
            url: url,
            data: formdata, 
            processData: false,
            success: function (data) {
                console.log(data);
                $(".validation-error").html("");
                if(data.has_error){
                    $.each(data.errors, function( index, value ) {
                        var errorDiv = '#'+index+'_error';
                        $(errorDiv).addClass('alert-danger');
                        $(errorDiv).empty().append(value);                        
                    });
                    $('#add-new-form-warning').html(data.warning);
                }else{
                    $('#add-new-form-warning').html(data.warning);
                    document.getElementById("add-new-form").reset();
                    //$(".section").showSection('.section',"#view-all-section");
                    //$('#view-data-table').html(data);
                }     
                navigationFn.goToSection("#add-new-form-warning",500);
                $("#loading").hide();
            }
        }).fail(function (ts) {
            alert('items could not be saved.'+ts.responseText);
            $("#loading").hide();
        });
    }
    $(document).on('click','.edit-item',function(e){
        e.preventDefault();
        $("#loading").show();
        var item_id = $(this).attr('href');
        //var url = url+'/'+item_id+'/edit';
        var method = "POST";
        var data = "action=edit"+"&id="+item_id;
        $.ajax({
            //async: true,
            type: method,
            data: {'action':'edit','id':item_id},
            dataType: "json",
            //contentType: false,
            url: url, 
            //processData: false,
            success: function (data) {
                console.log(data);
                    $(".section").showSection('.section',"#edit-section");
                    $.each(data.item, function( index, value ) {
                        //alert(index+"=="+value);
                        $("#"+index+"_edit").val(value);
                        //var errorDiv = '#'+index+'_error';
                        //$(errorDiv).addClass('alert-danger');
                        //$(errorDiv).empty().append(value);                        
                    });
                    //$('#edit-section').html(data);  
                    $("#loading").hide();
            }
        }).fail(function (ts) {
            alert('items could not be loaded.'+ts.responseText);
            $("#loading").hide();
        });; 
    });
    $(document).on('submit','#edit-form',submitUpdateForm);
    function submitUpdateForm(e){
        e.preventDefault();
        $("#loading").show();
        var form = document.forms.namedItem("edit_form");  
        var formdata = new FormData(form); 
        //var url = $(this).attr('action');
        var method = $(this).attr('method');
        $.ajax({
            async: true,
            type: method,
            dataType: "json",
            contentType: false,
            url: url,
            data: formdata, 
            processData: false,
            success: function (data) {
                console.log("Update Function");
                console.log(data);
                $(".validation-error").html("");
                if(data.has_error){
                    $.each(data.errors, function( index, value ) {
                        var errorDiv = '#'+index+'_edit_error';
                        $(errorDiv).addClass('alert-danger');
                        $(errorDiv).empty().append(value);                       
                    });
                    $('#edit-form-warning').html(data.warning);
                    //navigationFn.goToSection("#edit-form-warning",500);
                }else{
                    $('#edit-form-warning').html(data.warning);
                    document.getElementById("edit-form").reset();
                    //$(".section").showSection('.section',"#view-all-section");
                    //$('#view-data-table').html(data);
                }     
                $("#loading").hide();
            }
        }).fail(function (ts) {
            alert('items could not be updated.'+ts.responseText);
            $("#loading").hide();
        });
    }    
    $(document).on('click','.delete-item',function(e){
        e.preventDefault();
        var is_ok_to_delete = confirm("Are you sure you want to delete this item?");
        if(is_ok_to_delete){
            $("#loading").show();
            var item_id = $(this).attr('href');
            //var url = url+'/'+bank_id;
            var method = 'POST';
            $.ajax({
                //async: true,
                type: method,
                data: {'action':'delete','id':item_id},
                dataType: "json",
                //contentType: false,
                url: url, 
                //processData: false,
                success: function (data) {
                    alert(data.warning);
                    location.reload();
                }
            }); 
        }
    }); 
    $(document).on('click','.view-item',function(e){
        e.preventDefault();
        $("#loading").show();
        var item_id = $(this).attr('href');
        var method = 'POST';
        $.ajax({
            async: true,
            type: method,
            dataType: "json",
            contentType: false,
            url: url, 
            processData: false,
            success: function (data) {
                    $(".section").showSection('.section',"#view-section");
                    $('#view-section').html(data);  
                    $("#loading").hide();
            }
        });        
    });     
});
