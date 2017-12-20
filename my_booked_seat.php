<?php
session_start();
if( !isset($_SESSION['is_user_login']) ) {
	header("Location: index.php");
}
$pages='my_booked_seat';
include './index.php';