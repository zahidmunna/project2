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
    
    if( Validator::isEmpty($transection_id) ) {
        $form_has_error = true;
        $error_arr['transection_id'] = ' Transection Id field is required';
    }else if( !$dbHelper->isUnique("bkash_transection", "transection_id", $transection_id) ){
        $form_has_error = true;
        $error_arr['transection_id'] = ' bKash Transection Id Already Exist. Please try another one!';
    }

     if( Validator::isEmpty( $amount ) ) {
        $form_has_error = true;
        $error_arr['amount'] = ' Amount field is required';
    }
   
 
    if( !$form_has_error ) {
        $data = array();
        $data['transection_id'] = $transection_id;
        $data['amount'] = $amount;
        $data['is_already_used'] = 0;

        $is_save = $dbHelper->save("bkash_transection", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">bKash Transection Successfully Added.</h4>';
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
	$id_bkash_transection = $_POST['id'];
	$bkash_transection = $dbHelper->getByIdField("bkash_transection", 'id_bkash_transection', $id_bkash_transection);
	$data['item'] = $bkash_transection;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='update' ) {

	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
 

    if( Validator::isEmpty($transection_id) ) {
        $form_has_error = true;
        $error_arr['transection_id'] = ' bKash Transection Id field is required';
    } else if( !$dbHelper->isUnique("bkash_transection", "transection_id", $transection_id, $id_bkash_transection) ){
    	$form_has_error = true;
        $error_arr['transection_id'] = ' bKash Transection No Already Exist. Please try another one!';
    }

     if( Validator::isEmpty( $amount ) ) {
        $form_has_error = true;
        $error_arr['amount'] = ' bKash Amount field is required';
    }

    if( !$form_has_error ) {
        $data = array();

        $data['transection_id'] = $transection_id;
        $data['amount'] = $amount;

        $is_save = $dbHelper->updateByIdField("bkash_transection", $data, "id_bkash_transection", $id_bkash_transection );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">bKash Transection Successfully Updated.</h4>';
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
	$id_bkash_transection = $_POST['id'];
	$is_delete = $dbHelper->deleteByIdField("bkash_transection", 'id_bkash_transection', $id_bkash_transection);
	if( $is_delete ){
		$data['warning'] = "bKash Transection Successfully Deleted.";
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