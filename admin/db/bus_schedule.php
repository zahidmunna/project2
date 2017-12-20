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
    //echo print_r($_POST);

    $error_arr = array();
    $form_has_error = false;
    
    if( Validator::isEmpty($ref_id_bus) ) {
        $form_has_error = true;
        $error_arr['ref_id_bus'] = ' Select Bus field is required';
    }

    if( Validator::isEmpty($ref_id_driver) ) {
        $form_has_error = true;
        $error_arr['ref_id_driver'] = ' Select Driver field is required';
    }

    if( Validator::isEmpty( $ref_id_road ) ) {
        $form_has_error = true;
        $error_arr['ref_id_road'] = ' Select Road field is required';
    }
   
     if( Validator::isEmpty( $starting_datetime ) ) {
        $form_has_error = true;
        $error_arr['starting_datetime'] = ' Starting datetime field is required';
    }

     if( Validator::isEmpty( $ending_datetime ) ) {
        $form_has_error = true;
        $error_arr['ending_datetime'] = ' Ending datetime field is required';
    }

    if( !$form_has_error ){

        $query_str = "SELECT * FROM bus_schedule WHERE ref_id_bus='".$ref_id_bus."' AND ending_datetime>='".$starting_datetime."' AND ending_datetime<='".$ending_datetime."' ";
        $results = $dbHelper->rawQuery($query_str);

        if( mysqli_num_rows( $results) > 0 ) {
            $form_has_error = true;
            $error_arr['ref_id_bus'] = ' This Bus already in scheudle that time. Please select another bus.';
        }

        $query_str = "SELECT * FROM bus_schedule WHERE ref_id_driver='".$ref_id_driver."' AND ending_datetime>='".$starting_datetime."' AND ending_datetime<='".$ending_datetime."' ";
        $results = $dbHelper->rawQuery($query_str);

        if( mysqli_num_rows( $results) > 0 ) {
            $form_has_error = true;
            $error_arr['ref_id_driver'] = ' This Driver already in scheudle that time. Please select another Driver.';
        }


        /*$query_str = "SELECT * FROM bus_schedule WHERE ref_id_bus='".$ref_id_bus."' AND ref_id_driver='".$ref_id_driver."' AND ref_id_road='".$ref_id_road."' AND ending_datetime>='".$starting_datetime."' AND ending_datetime<='".$ending_datetime."' ";
        $results = $dbHelper->rawQuery($query_str);
        if( mysqli_num_rows( $results) > 0 ) {
            $form_has_error = true;
            $data['warning'] = '<h4 class="alert-danger">You can not set this schedule as there is bus or driver already booked that time.</h4>';

        }*/

    }


    if( !$form_has_error ) {

        $bus_schedule_no = time();
        $bus_schedule_status = 1;

        $data = array();
        $data['ref_id_bus'] = $ref_id_bus;
        $data['ref_id_driver'] = $ref_id_driver;
        $data['ref_id_road'] = $ref_id_road;
        $data['bus_schedule_no'] = $bus_schedule_no;
        $data['starting_datetime'] = $starting_datetime;
        $data['ending_datetime'] = $ending_datetime;
        $data['bus_schedule_status'] = $bus_schedule_status;

        $is_save = $dbHelper->save("bus_schedule", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Bus Schedule Successfully Created.</h4>';
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
	$id_bus_schedule = $_POST['id'];
	$bus_schedule = $dbHelper->getByIdField("bus_schedule", 'id_bus_schedule', $id_bus_schedule);
	$data['item'] = $bus_schedule;
	echo json_encode($data);
}else if( isset($_POST['action']) && $_POST['action']=='update' ) {

	$data = array();
	$data['has_error'] = true;
	$data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
    
    if( Validator::isEmpty($ref_id_bus) ) {
        $form_has_error = true;
        $error_arr['ref_id_bus'] = ' Select Bus field is required';
    }

    if( Validator::isEmpty($ref_id_driver) ) {
        $form_has_error = true;
        $error_arr['ref_id_driver'] = ' Select Driver field is required';
    }

    if( Validator::isEmpty( $ref_id_road ) ) {
        $form_has_error = true;
        $error_arr['ref_id_road'] = ' Select Road field is required';
    }
   
     if( Validator::isEmpty( $starting_datetime ) ) {
        $form_has_error = true;
        $error_arr['starting_datetime'] = ' Starting datetime field is required';
    }

     if( Validator::isEmpty( $ending_datetime ) ) {
        $form_has_error = true;
        $error_arr['ending_datetime'] = ' Ending datetime field is required';
    }

    if( !$form_has_error ){

        $query_str = "SELECT * FROM bus_schedule WHERE ref_id_bus='".$ref_id_bus."' AND ending_datetime>='".$starting_datetime."' AND ending_datetime<='".$ending_datetime."' AND id_bus_schedule!='".$id_bus_schedule."' ";
        $results = $dbHelper->rawQuery($query_str);

        if( mysqli_num_rows( $results) > 0 ) {
            $form_has_error = true;
            $error_arr['ref_id_bus'] = ' This Bus already in scheudle that time. Please select another bus.';
        }

        $query_str = "SELECT * FROM bus_schedule WHERE ref_id_driver='".$ref_id_driver."' AND ending_datetime>='".$starting_datetime."' AND ending_datetime<='".$ending_datetime."' AND id_bus_schedule!='".$id_bus_schedule."' ";
        $results = $dbHelper->rawQuery($query_str);

        if( mysqli_num_rows( $results) > 0 ) {
            $form_has_error = true;
            $error_arr['ref_id_driver'] = ' This Driver already in scheudle that time. Please select another Driver.';
        }

    }

    if( !$form_has_error ) {
        $data = array();

        $data['ref_id_bus'] = $ref_id_bus;
        $data['ref_id_driver'] = $ref_id_driver;
        $data['ref_id_road'] = $ref_id_road;
        $data['starting_datetime'] = $starting_datetime;
        $data['ending_datetime'] = $ending_datetime;
        $data['bus_schedule_status'] = $bus_schedule_status;

        $is_save = $dbHelper->updateByIdField("bus_schedule", $data, "id_bus_schedule", $id_bus_schedule );
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">Bus Schedule Successfully Updated.</h4>';
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
	$id_bus_schedule = $_POST['id'];
    $has_bus_seat_booked = $dbHelper->getByIdField('bus_seat_booked','ref_id_bus_schedule', $id_bus_schedule);
    if( $has_bus_seat_booked ){
        $data['warning'] = "This Bus Schedule Can not be deleted beacuse of it is already used to book bus seat.";
    }else{
    	$is_delete = $dbHelper->deleteByIdField("bus_schedule", 'id_bus_schedule', $id_bus_schedule);
    	if( $is_delete ){
    		$data['warning'] = "Bus Schedule Successfully Deleted.";
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