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
    

    if( Validator::isEmpty($old_password) ) {
        $form_has_error = true;
        $error_arr['old_password'] = ' Old Password field is required';
    }else if( !Validator::minLength( $old_password, 6 ) || !Validator::maxLength( $old_password, 100 ) ) {
        $form_has_error = true;
        $error_arr['old_password'] = 'Old Password field value need to be minimum 6 char and maximum 100 char long.';
    }else if( md5($old_password) != $_SESSION['admin']['password'] ) {
        $form_has_error = true;
        $error_arr['old_password'] = 'Old Password Does not matched. Please try again!';
    }


    if( Validator::isEmpty($new_password) ) {
        $form_has_error = true;
        $error_arr['new_password'] = ' New Password field is required';
    }else if( !Validator::minLength( $new_password, 6 ) || !Validator::maxLength( $new_password, 100 ) ) {
        $form_has_error = true;
        $error_arr['new_password'] = 'New Password field value need to be minimum 6 char and maximum 100 char long.';
    }
     

   if( Validator::isEmpty($confirm_password) ) {
        $form_has_error = true;
        $error_arr['confirm_password'] = ' Confirm Password field is required';
    }else if( !Validator::minLength( $confirm_password, 6 ) || !Validator::maxLength( $confirm_password, 100 ) ) {
        $form_has_error = true;
        $error_arr['confirm_password'] = 'Confirm Password field value need to be minimum 6 char and maximum 100 char long.';
    }

    if( $new_password != $confirm_password ) {
        $form_has_error = true;
        $error_arr['confirm_password'] = 'New Password and Confirm Password field need to be same.';
    }

 
    if( !$form_has_error ) {
        $data = array();
        $data['password'] = md5($new_password);

        $is_save = $dbHelper->updateByIdField("admin", $data, "id_admin", $_SESSION['admin']['id_admin'] );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Your Password Successfully Updated.</h4>';
        }else{
            $data['warning'] = '<h4 class="text-danger">Something went wrong. Please try again!!</h4>';
        }   
        $form_has_error = false;
    }  	
    $data['has_error'] = $form_has_error;
    $data['errors'] = $error_arr;
	echo json_encode($data);
}else{
    $data = array();
    $data['action'] = $_SERVER['REQUEST_METHOD'];
    $data['action1'] = $_POST;
    echo json_encode($data);
}