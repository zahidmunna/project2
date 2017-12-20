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
    $ref_id_admin = 0;
    $ref_id_counter = 0;
    $ref_id_user = 0;
    $total_seat_booked_by_this_user = 0;
    $ref_id_payment = 0;
    
    $road = $dbHelper->getByIdField("road", "id_road", $ref_id_road );
    
    if( isset($_SESSION['user']) && isset($_SESSION['user']['id_user']) ) {
        $ref_id_user = $_SESSION['user']['id_user'];
        $total_seat_booked_by_this_user = $dbHelper->getSeatBookedByUserInaSchedule( $ref_id_bus_schedule, $ref_id_user );
    }
    
    if( isset($_SESSION['admin']) && isset($_SESSION['admin']['id_admin']) ) {
        $ref_id_admin = $_SESSION['admin']['id_admin'];
        $ref_id_counter = $_SESSION['admin']['ref_id_counter'];
        $total_seat_booked_by_this_user = $dbHelper->getSeatBookedByPhoneInaSchedule( $ref_id_bus_schedule, $phone );
    }


    if( $number_of_seat <= 0){
        $error_arr['max_seat_can_booked'] = ' You need to select at least one seat.';
        $form_has_error = true;        
    }else if( ($total_seat_booked_by_this_user+$number_of_seat) > $road['max_seat_can_booked'] ) {
        $error_arr['max_seat_can_booked'] = ' You can not booked maximum '.$road['max_seat_can_booked'].' seat.';
        $form_has_error = true;
    }

    
    if( Validator::isEmpty($passenger_full_name) ) {
        $form_has_error = true;
        $error_arr['passenger_full_name'] = ' Passenger Full Name field is required';
    }

    if( Validator::isEmpty($phone) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Phone field is required';
    }

    if( $payment_type <=0 || $payment_type > 3 ) {
        $form_has_error = true;
        $error_arr['payment_type'] = ' You need to select one Payment Type';
    }

    if( !$form_has_error ) {
        $data = array();
        $data['ref_id_bus_schedule'] = $ref_id_bus_schedule;
        $data['ref_id_counter'] = $ref_id_counter;
        $data['ref_id_user'] = $ref_id_user;
        $data['number_of_seat'] = $number_of_seat;
        $data['per_seat_price'] = $per_seat_price;
        $data['discount'] = $discount;
        $data['seat_numbers'] = $seat_numbers;
        $data['ref_id_admin'] = $ref_id_admin;
        $data['passenger_full_name'] = $passenger_full_name;
        $data['phone'] = $phone;
        $data['is_notified_by_sms'] = 0;
        if( isset($_SESSION['admin']) && isset($_SESSION['admin']['id_admin']) ) {
            $payment_arr = array();
            $transection_id = time();
            $amount = ($per_seat_price * $number_of_seat)-$discount;
            $payment_arr['transection_type'] = 1;
            $payment_arr['transection_id'] = $transection_id;
            $payment_arr['transection_amount'] = $amount;
            $ref_id_payment = $dbHelper->save("payment", $payment_arr);
        }

        $data['ref_id_payment'] = $ref_id_payment;
        $data['created_at'] = date("Y-m-d H:i:s");

        $is_save = $dbHelper->save("bus_seat_booked", $data);
        $_SESSION['id_bus_seat_booked'] = $is_save;
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Your Seat Successfully Booked.</h4>';
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
    $_SESSION['bus_no'] = $bus['bus_no'];
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
    } else if( $bus_no!= $_SESSION['bus_no'] && !$dbHelper->isUnique("bus", "bus_no", $bus_no) ){
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
	$is_delete = $dbHelper->deleteByIdField("bus", 'id_bus', $id_bus);
	if( $is_delete ){
		$data['warning'] = "Bus Successfully Deleted.";
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