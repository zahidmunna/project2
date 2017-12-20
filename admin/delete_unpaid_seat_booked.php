<?php

include('../classes/DbHelper.php');
$dbHelper = new DbHelper();
$warning = '';

if( isset($_GET['delete']) ) {

	$delete_candidate = $_GET['delete'];
	if( $delete_candidate > 0 ) {
		$is_delete = $dbHelper->delete('bus_seat_booked', 'id_bus_seat_booked', $delete_candidate);
		if( $is_delete ) {
			$warning = '<p class="alert alert-danger text-center">Your Selected Bus Seat Booked is Deleted Successfully.</p>';
		}
	}

}

/*$is_delete = $dbHelper->deleteAllUnPaidBooked();
if( $is_delete ) {
	$warning = '<p class="alert alert-danger text-center">All Unpaid Bus Seat Booked is Deleted Successfully.</p>';
}*/


$table_body = '';
$i = 1;
$delete_seat_booked_candidates = $dbHelper->getAllUnPaidBooked();
while( $delete_seat_booked_candidate = mysqli_fetch_array($delete_seat_booked_candidates) ) {
	$mobile_number = $delete_seat_booked_candidate['phone'];
	$passenger_full_name = $delete_seat_booked_candidate['passenger_full_name'];
	$seat_numbers = $delete_seat_booked_candidate['seat_numbers'];
	$per_seat_price = $delete_seat_booked_candidate['per_seat_price'];
	$bus_schedule_no = $delete_seat_booked_candidate['bus_schedule_no'];
	$number_of_seat = $delete_seat_booked_candidate['number_of_seat'];
	
	$table_body .= '<tr>';
		$table_body .='<td>'.$i.'</td>';
		$table_body .='<td>'.$mobile_number.'</td>';
		$table_body .='<td>'.$passenger_full_name.'</td>';
		$table_body .='<td>'.$seat_numbers.'</td>';
		$table_body .='<td>'.$per_seat_price.'</td>';
		$table_body .='<td>'.$bus_schedule_no.'</td>';
		$table_body .='<td>'.$number_of_seat.'</td>';
		$table_body .='<td><a href="?delete='.$delete_seat_booked_candidate['id_bus_seat_booked'].'">Delete</a></td>';
	$table_body .= '</tr>';
	$i++;

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Delete Seat Booked Candidate</title>
    
        <link href="../assets/admin_assets/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
    	<?php echo $warning; ?>
		<table class="table table-bordered">
			<caption class="text-center">Delete Seat Booked Candidate</caption>
			<tr>
				<th>Serial No</th>
				<th>Mobile Number</th>
				<th>Passenger Full Name</th>
				<th>Seat Numbers</th>
				<th>Per Seat Price</th>
				<th>Bus Schedule No</th>
				<th>Number Of Seat</th>
				<th>Action</th>
			</tr>
			<?php echo $table_body; ?>
		</table>
	</body>
</html>