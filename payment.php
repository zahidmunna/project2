<?php
if( isset($_GET['payment_type']) ) {
	$payment_type = $_GET['payment_type'];
	echo $payment_type."<br />";
	//echo $_SESSION['id_bus_seat_booked'];
	if( $payment_type == 2 ) {
		$pages='bkash';
		include './index.php';
	}else if( $payment_type == 3 ) {
		$pages='paypal';
		include './index.php';
	}
}else{
	header("Location: book_your_seat.php");
}