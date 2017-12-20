<?php
session_start();
if( !isset($_SESSION['is_user_login']) ) {
    header("Location: index.php");
}
$pages='change_password';
include './index.php';
