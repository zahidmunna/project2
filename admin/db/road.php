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
    
    if( Validator::isEmpty($road_name) ) {
        $form_has_error = true;
        $error_arr['road_name'] = ' Road Name field is required';
    } else if( !$dbHelper->isUnique("road", "road_name", $road_name) ){
        $form_has_error = true;
        $error_arr['road_name'] = ' Road Name Already Exist. Please try another one!.';
    }

    if( Validator::isEmpty($start_from) ) {
        $form_has_error = true;
        $error_arr['start_from'] = ' Start From field is required';
    }

    if( Validator::isEmpty($end_to) ) {
        $form_has_error = true;
        $error_arr['end_to'] = ' End to field is required';
    }
   
    if( Validator::isEmpty($distance) ) {
        $form_has_error = true;
        $error_arr['distance'] = 'Distance field is required';
    }

    if( Validator::isEmpty($ac_price) ) {
        $form_has_error = true;
        $error_arr['ac_price'] = 'A/C Price field is required';
    }else if( !Validator::isNumeric($ac_price) ) {
        $form_has_error = true;
        $error_arr['ac_price'] = 'A/C Price field need numeric value only.';
    }

    if( Validator::isEmpty($non_ac_price) ) {
        $form_has_error = true;
        $error_arr['non_ac_price'] = 'Non A/C Price field is required';
    }else if( !Validator::isNumeric($non_ac_price) ) {
        $form_has_error = true;
        $error_arr['non_ac_price'] = 'Non A/C Price field need numeric value only.';
    }

    if( Validator::isEmpty($discount_amount) ) {
        $form_has_error = true;
        $error_arr['discount_amount'] = 'Discount Amount field is required';
    }else if( !Validator::isNumeric($discount_amount) ) {
        $form_has_error = true;
        $error_arr['discount_amount'] = 'Discount Amount field need numeric value only.';
    }

    if( Validator::isEmpty($max_seat_needed_for_discount) ) {
        $form_has_error = true;
        $error_arr['max_seat_needed_for_discount'] = 'Max Seat Needed For Discount field is required';
    }else if( !Validator::isNumeric($max_seat_needed_for_discount) ) {
        $form_has_error = true;
        $error_arr['max_seat_needed_for_discount'] = 'Max Seat Needed For Discount field need numeric value only.';
    }

    if( Validator::isEmpty($max_seat_can_booked) ) {
        $form_has_error = true;
        $error_arr['max_seat_can_booked'] = 'Max Seat Can Booked field is required';
    }else if( !Validator::isNumeric($max_seat_can_booked) ) {
        $form_has_error = true;
        $error_arr['max_seat_can_booked'] = 'Max Seat Can Booked field need numeric value only.';
    }


    if( !$form_has_error ) {
        $data = array();
        $data['road_name'] = $road_name;
        $data['start_from'] = $start_from;
        $data['end_to'] = $end_to;
        $data['distance'] = $distance;
        $data['ac_price'] = $ac_price;
        $data['non_ac_price'] = $non_ac_price;
        $data['discount_amount'] = $discount_amount;
        $data['max_seat_needed_for_discount'] = $max_seat_needed_for_discount;
        $data['max_seat_can_booked'] = $max_seat_can_booked;
        $data['details'] = $details;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->save("road", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Road Successfully Created.</h4>';
        }else{
            $data['warning'] = '<h4 class="text-danger">Something went wrong. Please try again!!</h4>'.$dbHelper->isUnique("road", "road_name", $road_name);
        }   
        $form_has_error = false;
    } 	
    $data['has_error'] = $form_has_error;
    $data['errors'] = $error_arr;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='edit' ) {
	$data = array();
	$id_road = $_POST['id'];
	$road = $dbHelper->getByIdField("road", 'id_road', $id_road);
    $_SESSION['road_name'] = $road['road_name'];
	$data['item'] = $road;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='update' ) {

	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
 
     if( Validator::isEmpty($road_name) ) {
        $form_has_error = true;
        $error_arr['road_name'] = ' Road Name field is required';
    } else if( !$dbHelper->isUnique("road", "road_name", $road_name, $id_road) ){
        $form_has_error = true;
        $error_arr['road_name'] = ' Road Name Already Exist. Please try another one!.';
    }

    if( Validator::isEmpty($start_from) ) {
        $form_has_error = true;
        $error_arr['start_from'] = ' Start From field is required';
    }

    if( Validator::isEmpty($end_to) ) {
        $form_has_error = true;
        $error_arr['end_to'] = ' End to field is required';
    }
   
    if( Validator::isEmpty($distance) ) {
        $form_has_error = true;
        $error_arr['distance'] = 'Distance field is required';
    }

    if( Validator::isEmpty($ac_price) ) {
        $form_has_error = true;
        $error_arr['ac_price'] = 'A/C Price field is required';
    }else if( !Validator::isNumeric($ac_price) ) {
        $form_has_error = true;
        $error_arr['ac_price'] = 'A/C Price field need numeric value only.';
    }

    if( Validator::isEmpty($non_ac_price) ) {
        $form_has_error = true;
        $error_arr['non_ac_price'] = 'Non A/C Price field is required';
    }else if( !Validator::isNumeric($non_ac_price) ) {
        $form_has_error = true;
        $error_arr['non_ac_price'] = 'Non A/C Price field need numeric value only.';
    }

    if( Validator::isEmpty($discount_amount) ) {
        $form_has_error = true;
        $error_arr['discount_amount'] = 'Discount Amount field is required';
    }else if( !Validator::isNumeric($discount_amount) ) {
        $form_has_error = true;
        $error_arr['discount_amount'] = 'Discount Amount field need numeric value only.';
    }

    if( Validator::isEmpty($max_seat_needed_for_discount) ) {
        $form_has_error = true;
        $error_arr['max_seat_needed_for_discount'] = 'Max Seat Needed For Discount field is required';
    }else if( !Validator::isNumeric($max_seat_needed_for_discount) ) {
        $form_has_error = true;
        $error_arr['max_seat_needed_for_discount'] = 'Max Seat Needed For Discount field need numeric value only.';
    }

    if( Validator::isEmpty($max_seat_can_booked) ) {
        $form_has_error = true;
        $error_arr['max_seat_can_booked'] = 'Max Seat Can Booked field is required';
    }else if( !Validator::isNumeric($max_seat_can_booked) ) {
        $form_has_error = true;
        $error_arr['max_seat_can_booked'] = 'Max Seat Can Booked field need numeric value only.';
    }

    if( !$form_has_error ) {
        $data = array();

        $data['road_name'] = $road_name;
        $data['start_from'] = $start_from;
        $data['end_to'] = $end_to;
        $data['distance'] = $distance;
        $data['ac_price'] = $ac_price;
        $data['non_ac_price'] = $non_ac_price;
        $data['discount_amount'] = $discount_amount;
        $data['max_seat_needed_for_discount'] = $max_seat_needed_for_discount;
        $data['max_seat_can_booked'] = $max_seat_can_booked;
        $data['details'] = $details;
        $data['is_active'] = $is_active;

        $is_save = $dbHelper->updateByIdField("road", $data, "id_road", $id_road );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Road Successfully Updated.</h4>';
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
	$id_road = $_POST['id'];
    $has_bus_schedule = $dbHelper->getByIdField('bus_schedule','ref_id_road', $id_road);
    if( $has_bus_schedule ){
        $data['warning'] = "This Road Can not be deleted beacuse of it is already used in bus schedule.";
    }else{
    	$is_delete = $dbHelper->deleteByIdField("road", 'id_road', $id_road);
    	if( $is_delete ){
    		$data['warning'] = "Road Successfully Deleted.";
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