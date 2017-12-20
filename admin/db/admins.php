<?php
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
    } else if( !Validator::isValidEmail($email) ){
    	$form_has_error = true;
        $error_arr['email'] = ' Email field need a valid email.';
    }else if( !$dbHelper->isUnique("admin", "email", $email) ){
        $form_has_error = true;
        $error_arr['email'] = ' Email Already Exist. Please try another one!.';
    }

     if( Validator::isEmpty( $phone ) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Phone field is required';
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

    if( $admin_type == 2 && $ref_id_counter <=0 ) {
        $form_has_error = true;
        $error_arr['ref_id_counter'] = 'You need to select one counter.';
    }


    if( !$form_has_error ) {
        $data = array();
        $data['full_name'] = $full_name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['password'] = md5($new_password);
        $data['admin_type'] = $admin_type;
        $data['ref_id_counter'] = $ref_id_counter;
        $data['address'] = $address;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->save("admin", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Admin Successfully Created.</h4>';
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
	$id_admin = $_POST['id'];
	$admin = $dbHelper->getByIdField("admin", 'id_admin', $id_admin);
	$data['item'] = $admin;
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
    } else if( !Validator::isValidEmail($email) ){
    	$form_has_error = true;
        $error_arr['email'] = ' Email field need a valid email.';
    }else if( !$dbHelper->isUnique("admin", "email", $email, $id_admin ) ){
        $form_has_error = true;
        $error_arr['email'] = ' Email Already Exist. Please try another one!.';
    }

     if( Validator::isEmpty( $phone ) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Phone field is required';
    }

    $process_new_password = true;
    
    if( !Validator::isEmpty( $new_password ) || !Validator::isEmpty( $confirm_password ) ) {
        if( !Validator::minLength( $new_password, 6 ) || !Validator::maxLength( $new_password, 100 ) ) {
            $form_has_error = true;
            $process_new_password = false;
            $error_arr['new_password'] = 'New Password field value need to be minimum 6 char and maximum 100 char long.';
        }
         

       if( !Validator::minLength( $confirm_password, 6 ) || !Validator::maxLength( $confirm_password, 100 ) ) {
            $form_has_error = true;
            $process_new_password =  false;
            $error_arr['confirm_password'] = 'Confirm Password field value need to be minimum 6 char and maximum 100 char long.';
        }

        if( $new_password != $confirm_password ) {
            $form_has_error = true;
            $process_new_password = false;
            $error_arr['confirm_password'] = 'New Password and Confirm Password field need to be same.';
        }
    
    }

    if( !$form_has_error ) {
        $data = array();

        $data['full_name'] = $full_name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        if( $process_new_password ) {
            $data['password'] = md5($new_password);
        }
        $data['admin_type'] = $admin_type;
        $data['ref_id_counter'] = $ref_id_counter;
        $data['address'] = $address;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->updateByIdField("admin", $data, "id_admin", $id_admin );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Admin Successfully Updated.</h4>';
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
	$id_admin = $_POST['id'];
    $has_bus_schedule = $dbHelper->getByIdField('bus_schedule','ref_id_admin', $id_admin);
    if( $has_bus_schedule ){
        $data['warning'] = "This Admin Can not be deleted beacuse of it is already used in bus schedule.";
    }else{    
    	$is_delete = $dbHelper->deleteByIdField("admin", 'id_admin', $id_admin);
    	if( $is_delete ){
    		$data['warning'] = "Admin Successfully Deleted.";
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