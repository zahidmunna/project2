<?php

include('../classes/DbHelper.php');
$dbHelper = new DbHelper();
$table_body = '';
$i = 1;
$sms_candidates = $dbHelper->getSmsCandidate();
while( $sms_candidate = mysqli_fetch_array($sms_candidates) ) {
	$mobile_number = $sms_candidate['phone'];
	$passenger_full_name = $sms_candidate['passenger_full_name'];
	$seat_numbers = $sms_candidate['seat_numbers'];
	$per_seat_price = $sms_candidate['per_seat_price'];
	$bus_schedule_no = $sms_candidate['bus_schedule_no'];
	$number_of_seat = $sms_candidate['number_of_seat'];
	
	$table_body .= '<tr>';
		$table_body .='<td>'.$i.'</td>';
		$table_body .='<td>'.$mobile_number.'</td>';
		$table_body .='<td>'.$passenger_full_name.'</td>';
		$table_body .='<td>'.$seat_numbers.'</td>';
		$table_body .='<td>'.$per_seat_price.'</td>';
		$table_body .='<td>'.$bus_schedule_no.'</td>';
		$table_body .='<td>'.$number_of_seat.'</td>';
	$table_body .= '</tr>';
	$i++;

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sms Candidate</title>
    
        <link href="../assets/admin_assets/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
		<table class="table table-bordered">
			<caption class="text-center">Sms Candidate</caption>
			<tr>
				<th>Serial No</th>
				<th>Mobile Number</th>
				<th>Passenger Full Name</th>
				<th>Seat Numbers</th>
				<th>Per Seat Price</th>
				<th>Bus Schedule No</th>
				<th>Number Of Seat</th>
			</tr>
			<?php echo $table_body; ?>
		</table>
	</body>
</html>