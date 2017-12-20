<?php
session_start();
$id=$_SESSION['id'];
$username=$_SESSION['user_name'];
if($id==NULL){
    header('Location:userlogin.php');
    
}
 
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require './classes/super_admin.php';;
        $obj_user_admin = new user_admin();
        $obj_user_admin->logout();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
		<meta charset="utf-8">
		<meta name = "format-detection" content = "telephone=no" />
		<link rel="icon" href="images/favicon.ico">
		<link rel="shortcut icon" href="images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="assets/Front_end_assets/css/bootstrap.min.css">
                <link rel="stylesheet" href="assets/user_assets/booking/css/booking.css">
		<link rel="stylesheet" href="assets/user_assets/css/camera.css">
		<link rel="stylesheet" href="assets/user_assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/user_assets/css/style.css">
                <link rel="stylesheet" href="assets/user_assets/css/select2.min.css">
                <link rel="stylesheet" href="assets/user_assets/css/custom.css">
		<script src="assets/user_assets/js/jquery.js"></script>
		<script src="assets/user_assets/js/jquery-migrate-1.2.1.js"></script>
		<script src="assets/user_assets/js/script.js"></script>
		<script src="assets/user_assets/js/superfish.js"></script>
		<script src="assets/user_assets/js/jquery.ui.totop.js"></script>
		<script src="assets/user_assets/js/jquery.equalheights.js"></script>
		<script src="assets/user_assets/js/jquery.mobilemenu.js"></script>
		<script src="assets/user_assets/js/jquery.easing.1.3.js"></script>
		<script src="assets/user_assets/js/owl.carousel.js"></script>
		<script src="assets/user_assets/js/camera.js"></script>
                <script src="assets/user_assets/js/select2.full.min.js"></script>
		<!--[if (gt IE 9)|!(IE)]><!-->
		<script src="assets/user_assets/js/jquery.mobile.customized.min.js"></script>
		<!--<![endif]-->
		<script src="assets/user_assets/booking/js/booking.js"></script>
		<script>
			$(document).ready(function(){
				jQuery('#camera_wrap').camera({
					loader: false,
					pagination: false ,
					minHeight: '444',
					thumbnails: false,
					height: '28.28125%',
					caption: true,
					navigation: true,
					fx: 'mosaic'
				});
				$().UItoTop({ easingType: 'easeOutQuart' });
			});
		</script>
		<!--[if lt IE 8]>
			<div style=' clear: both; text-align:center; position: relative;'>
				<a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
					<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
				</a>
			</div>
			<![endif]-->
		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<link rel="stylesheet" media="screen" href="css/ie.css">
		<![endif]-->
	</head>
	<body class="page1" id="top">
		<div class="main">
<!--==============================header=================================-->
                    <header>
                            <div class="menu_block ">
                                    <div class="container_12">
                                            <div class="grid_12">
                                                    <nav class="horizontal-nav full-width horizontalNav-notprocessed">
                                                            <ul class="sf-menu">
                                                                <li class="current"><a href="Usersite.php">Home</a></li>
                                                                <li><a href="UserSetting.php">Settings</a></li>
                                                                    <li><a href="profile.php"><?php echo $username;?></a></li>
                                                                    <li><a href="?status=logout">Logout</a></li>
                                                            </ul>
                                                    </nav>
                                                    <div class="clear"></div>
                                            </div>
                                            <div class="clear"></div>
                                    </div>
                            </div>
                            <div class="clear"></div>
                    </header>
<!--==============================content=================================-->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="" method="POST" class="user-form">
                <div>
                    <div class="form-group">
                        <label for="id_label_single">
                            <select class="js-example-basic-single js-states form-control" id="id_label_single">
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
                                <option value="WY">jjj</option>
                                <option value="WY">oming</option>
                                <option value="WY">kkkng</option>
                            </select>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="route" class="">TO: </label>
                        <input type="text" class="js-example-basic-single js-states form-control" placeholder="Route Name" id="route"/>
                        <select class="js-example-basic-single">
                            <option value="AL">Chittagong</option>
                            <option value="WY">Dhaka</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="">DATE TO JOURNEY: </label>
                            <input class="datepicker form-control" data-date-format="mm/dd/yyyy"/>
                        </div>
                        <div class="col-md-6">
                            <label class="">DATE TO RETURN: </label>
                            <input class="datepicker form-control" data-date-format="mm/dd/yyyy"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input class="btn btn-success col-md-12" type="submit" value="SEARCH" name="submit"/>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="bus-image">
                <img class="img-responsive" src="assets/user_assets/images/bus-image-1.jpg" />
            </div>
        </div>
    </div>
</div>
<!--==============================footer=================================-->
		<footer>
			<div class="container_12">
				<div class="grid_12">
					<div class="f_phone"><span>Call Us:</span> + 1800 559 6580</div>
					<div class="socials">
						<a href="#" class="fa fa-twitter"></a>
						<a href="#" class="fa fa-facebook"></a>
						<a href="#" class="fa fa-google-plus"></a>
					</div>
					<div class="copy">
						<div class="st1">
						<div class="brand">BLANK<span class="color1">S</span>PACE</div>
						&copy; 2017	| <a href="#">Privacy Policy</a> </div> Website designed by BLANK SPACE
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</footer>
		<script>
			$(function (){
				$('#bookingForm').bookingForm({
					ownerEmail: '#'
				});
			})
			$(function() {
				$('#bookingForm input, #bookingForm textarea').placeholder();
			});
                        
                        //DATEPICKER
                        $('.datepicker').datepicker({
                            format: 'mm/dd/yyyy',
                            startDate: '-3d'
                        });
                        
                        //SELECT JS
                        //$('#route').select2();
//                        $(document).ready(function() {
//                          $(".js-example-basic-single").select2();
//                        });
//                        $(".js-example-placeholder-single").select2({
//                            placeholder: "Select a state",
//                            allowClear: true
//                          });
		</script>
	</body>
</html>