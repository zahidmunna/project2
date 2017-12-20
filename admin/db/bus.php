<?php
session_start();
include('../../classes/DbHelper.php');
include('../../classes/Validator.php');
$dbHelper = new DbHelper();

if(isset($_POST['action']) && $_POST['action']=='add_new') {
	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
    
    if( Validator::isEmpty($bus_name) ) {
        $form_has_error = true;
        $error_arr['bus_name'] = ' Bus Name field is required';
    }

    if( Validator::isEmpty($bus_no) ) {
        $form_has_error = true;
        $error_arr['bus_no'] = ' Bus No field is required';
    } else if( !$dbHelper->isUnique("bus", "bus_no", $bus_no) ){
    	$form_has_error = true;
        $error_arr['bus_no'] = ' Bus No Already Exist. Please try another one!.';
    }

     if( Validator::isEmpty( $bus_type ) ) {
        $form_has_error = true;
        $error_arr['bus_type'] = ' Bus Type field is required';
    }
   
 
    if( !$form_has_error ) {
        $data = array();
        $data['bus_name'] = $bus_name;
        $data['bus_no'] = $bus_no;
        $data['bus_type'] = $bus_type;
        $data['bus_details'] = $bus_details;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->save("bus", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Bus Successfully Created.</h4>';
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
	$id_bus = $_POST['id'];
	$bus = $dbHelper->getByIdField("bus", 'id_bus', $id_bus);
	$data['item'] = $bus;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='update' ) {

	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
 
     if( Validator::isEmpty($bus_name) ) {
        $form_has_error = true;
        $error_arr['bus_name'] = ' Bus Name field is required';
    }

    if( Validator::isEmpty($bus_no) ) {
        $form_has_error = true;
        $error_arr['bus_no'] = ' Bus No field is required';
    } else if( !$dbHelper->isUnique("bus", "bus_no", $bus_no, $id_bus) ){
    	$form_has_error = true;
        $error_arr['bus_no'] = ' Bus No Already Exist. Please try another one!';
    }

     if( Validator::isEmpty( $bus_type ) ) {
        $form_has_error = true;
        $error_arr['bus_type'] = ' Bus Type field is required';
    }

    if( !$form_has_error ) {
        $data = array();

        $data['bus_name'] = $bus_name;
        $data['bus_no'] = $bus_no;
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
	$id_bus = $_POST['id'];
    $has_bus_schedule = $dbHelper->getByIdField('bus_schedule','ref_id_bus', $id_bus);
    if( $has_bus_schedule ){
        $data['warning'] = "This Bus Can not be deleted beacuse of it is already used in bus schedule.";
    }else{
    	$is_delete = $dbHelper->deleteByIdField("bus", 'id_bus', $id_bus);
    	if( $is_delete ){
    		$data['warning'] = "Bus Successfully Deleted.";
    	}else{
    		$data['warning'] = "Something went wrong please try again!";
    	}
    }
	echo json_encode($data);
}else{
$data = array();
$data['action'] = $_SERVER['REQUEST_METHOD'];
$data['action1'] = $_POST;
echo json_encode($data);
}