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
    
    if( Validator::isEmpty($counter_name) ) {
        $form_has_error = true;
        $error_arr['counter_name'] = ' Counter Name field is required';
    }else if( !$dbHelper->isUnique("counter", "counter_name", $counter_name) ){
        $form_has_error = true;
        $error_arr['counter_name'] = ' Counter Name Already Exist. Please try another one!.';
    }

 
    if( !$form_has_error ) {
        $data = array();
        $data['counter_name'] = $counter_name;
        $data['address'] = $address;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->save("counter", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Counter Successfully Created.</h4>';
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
	$counter = $dbHelper->getByIdField("counter", 'id_counter', $id_counter);
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
    }else if( !$dbHelper->isUnique("counter", "counter_name", $counter_name, $id_counter ) ){
        $form_has_error = true;
        $error_arr['counter_name'] = ' Counter Name Already Exist. Please try another one!.';
    }


    if( !$form_has_error ) {
        $data = array();

        $data['counter_name'] = $counter_name;
        $data['address'] = $address;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->updateByIdField("counter", $data, "id_counter", $id_counter );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Counter Successfully Updated.</h4>';
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

    $admin_has_this_counter = $dbHelper->getByIdField('admin','ref_id_counter', $id_counter);
    $road_counter_has_this_counter = $dbHelper->getByIdField('road_counter','ref_id_counter', $id_counter);
    if( $admin_has_this_counter || $road_counter_has_this_counter ){
        $data['warning'] = "This Counter Can not be deleted beacuse of it is already used in System.";
    }else{
    	$is_delete = $dbHelper->deleteByIdField("counter", 'id_counter', $id_counter);
    	if( $is_delete ){
    		$data['warning'] = "Counter Successfully Deleted.";
    	}else{
    		$data['result'] = "Something went wrong please try again!";
    	}
    }
	echo json_encode($data);
}else{
$data = array();
$data['action'] = $_SERVER['REQUEST_METHOD'];
$data['action1'] = $_POST;
echo json_encode($data);
}