<?php
session_start();
include('../../classes/DbHelper.php');
include('../../classes/Validator.php');
$dbHelper = new DbHelper();

if(isset($_POST['action']) && $_POST['action']=='add_new') {
	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fix the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
    
    if( Validator::isEmpty($ref_id_road) ) {
        $form_has_error = true;
        $error_arr['ref_id_road'] = ' Select Road field is required';
    }
 
    if( Validator::isEmpty($ref_id_counter) ) {
        $form_has_error = true;
        $error_arr['ref_id_counter'] = ' Select Counter field is required';
    }

    if( !$form_has_error ) {
        $data = array();
        $data['ref_id_road'] = $ref_id_road;
        $data['ref_id_counter'] = $ref_id_counter;

        $is_save = $dbHelper->save("road_counter", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Counter Successfully Assigned.</h4>';
        }else{
            $data['warning'] = '<h4 class="text-danger">Something went wrong. Please try again!!</h4>';
        }   
        $form_has_error = false;
    } 	
    $data['has_error'] = $form_has_error;
    $data['errors'] = $error_arr;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='edit' ) {
	$data = array();
	$id_counter = $_POST['id'];
	$counter = $dbHelper->getByIdField("bus", 'id_counter', $id_counter);
    $_SESSION['counter_name'] = $counter['counter_name'];
	$data['item'] = $counter;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='update' ) {

	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
 
     if( Validator::isEmpty($counter_name) ) {
        $form_has_error = true;
        $error_arr['counter_name'] = ' Counter Name field is required';
    }

    if( Validator::isEmpty($phone) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Bus No field is required';
    } else if( $phone!= $_SESSION['phone'] && !$dbHelper->isUnique("bus", "phone", $phone) ){
    	$form_has_error = true;
        $error_arr['phone'] = ' Bus No Already Exist. Please try another one!';
    }

     if( Validator::isEmpty( $bus_type ) ) {
        $form_has_error = true;
        $error_arr['bus_type'] = ' Bus Type field is required';
    }

    if( !$form_has_error ) {
        $data = array();

        $data['counter_name'] = $counter_name;
        $data['phone'] = $phone;
        $data['bus_type'] = $bus_type;
        $data['bus_details'] = $bus_details;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->updateByIdField("bus", $data, "id_bus", $id_bus );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Bus Successfully Updated.</h4>';
        }else{
            $data['warning'] = '<h4 class="text-danger">Something went wrong. Please try again!!</h4>';
        }   
        $form_has_error = false;
    } 	
    $data['has_error'] = $form_has_error;
    $data['errors'] = $error_arr;
	echo json_encode($data);

}else if( isset($_POST['action']) && $_POST['action']=='delete' ) {
	$data = array();
	$id_counter = $_POST['id'];
	$is_delete = $dbHelper->deleteByIdField("counter", 'id_counter', $id_counter);
	if( $is_delete ){
		$data['warning'] = "Counter Successfully Deleted.";
	}else{
		$data['result'] = "Something went wrong please try again!";
	}

	echo json_encode($data);
}else{
$data = array();
$data['action'] = $_SERVER['REQUEST_METHOD'];
$data['action1'] = $_POST;
echo json_encode($data);
}