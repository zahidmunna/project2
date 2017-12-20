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
    
    if( Validator::isEmpty($full_name) ) {
        $form_has_error = true;
        $error_arr['full_name'] = ' Full Name field is required';
    }

    if( Validator::isEmpty($email) ) {
        $form_has_error = true;
        $error_arr['email'] = ' Email field is required';
    } else if( !$dbHelper->isUnique("driver", "email", $email) ){
    	$form_has_error = true;
        $error_arr['email'] = ' Email Already Exist. Please try another one!.';
    }

    if( Validator::isEmpty($phone) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Phone field is required';
    } else if( !$dbHelper->isUnique("driver", "phone", $phone) ){
        $form_has_error = true;
        $error_arr['phone'] = ' Phone Already Exist. Please try another one!.';
    }
   
 
    if( !$form_has_error ) {
        $data = array();
        $data['full_name'] = $full_name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['address'] = $address;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->save("driver", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Driver Successfully Created.</h4>';
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
	$id_driver = $_POST['id'];
	$driver = $dbHelper->getByIdField("driver", 'id_driver', $id_driver);
	$data['item'] = $driver;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='update' ) {

	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
 
    if( Validator::isEmpty($full_name) ) {
        $form_has_error = true;
        $error_arr['full_name'] = ' Full Name field is required';
    }

    if( Validator::isEmpty($email) ) {
        $form_has_error = true;
        $error_arr['email'] = ' Email field is required';
    } else if( !$dbHelper->isUnique("driver", "email", $email, $id_driver ) ){
        $form_has_error = true;
        $error_arr['email'] = ' Email Already Exist. Please try another one!.';
    }

    if( Validator::isEmpty($phone) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Phone field is required';
    } else if( !$dbHelper->isUnique("driver", "phone", $phone, $id_driver ) ){
        $form_has_error = true;
        $error_arr['phone'] = ' Phone Already Exist. Please try another one!.';
    }

    if( !$form_has_error ) {
        $data = array();

        $data['full_name'] = $full_name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['address'] = $address;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->updateByIdField("driver", $data, "id_driver", $id_driver );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Driver Successfully Updated.</h4>';
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
	$id_driver = $_POST['id'];
    $has_bus_schedule = $dbHelper->getByIdField('bus_schedule','ref_id_driver', $id_driver);
    if( $has_bus_schedule ){
        $data['warning'] = "This Driver Can not be deleted beacuse of it is already used in bus schedule.";
    }else{
    	$is_delete = $dbHelper->deleteByIdField("driver", 'id_driver', $id_driver);
    	if( $is_delete ){
    		$data['warning'] = "Driver Successfully Deleted.";
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