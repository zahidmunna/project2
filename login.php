<?php
session_start();
if( isset($_SESSION['is_user_login']) ) {
	header("Location: bus_schedule.php");
}
$pages='login';

include './index.php';
        

