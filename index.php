<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Book Your Bus</title>
        
        <link rel="shortcut icon" href="assets/Front_end_assets/images/favicon/favicon.ico">
        <link rel="apple-touch-icon" sizes="144x144" type="image/x-icon" href="assets/Front_end_assets/favicon/apple-touch-icon.png">
        <link rel="stylesheet" type="text/css" href="assets/Front_end_assets/css/plugin.css">
        <link rel="stylesheet" type="text/css" href="assets/Front_end_assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/admin_assets/css/jquery.datetimepicker.css" />
        <!-- Google Web Fonts  -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700">
    </head>
    <body>
        <?php include './Includes/navbar.php';?>
        
       <?php
       if(isset($pages)){
           if($pages=='about'){
               include './pages/about_contant.php';
           }
           elseif ($pages=='contact') {
               include './pages/contact_contant.php';
           }
           elseif ($pages=='portfolio') {
               include './pages/portfolio_contant.php';
           }
           elseif ($pages=='services') {
               include './pages/services_contant.php';
           }
           elseif ($pages=='testimonials') {
                include './pages/testimonials_contant.php';
           }
           elseif ($pages=='design') {
               include './pages/design_by.php';
           
           }elseif( $pages == 'bus_schedule' ) {
              include './pages/bus_schedule.php';
           }elseif( $pages == 'book_your_seat' ) {
              include './pages/book_your_seat.php';
           }else if( $pages == 'user_registration' ){
              include './pages/user_registration.php';
           }else if( $pages == 'bkash') {
              include './pages/bkash.php';
           }else if( $pages == 'paypal') {
              include './pages/paypal.php';
           }else if( $pages == 'user_setting' ){
              include './pages/user_setting.php';
           }else if( $pages == 'my_booked_seat' ) {
              include './pages/my_booked_seat.php';
           }else if( $pages == 'change_password' ){
              include './pages/change_password.php';
           }elseif ($pages=='login') {
               include './pages/userlogin.php';
          }
          
           
          
       } else {
        include './Includes/Header_top.php';    
       }
       ?>
        
  
      
       
        <footer class="footer-section">
            <div class="container">
                <div class="row">

                    <div class="col-md-4 text-left">
                        <p><span><a href="about.php" class="smoth-scroll">About us</a></span> | <span><a href="portfolio.php" class="smoth-scroll">Portfolio</a></span></p>
                    </div>

                    <div class="col-md-4 text-center">
                        <p>© Copyright 201y Buying ticket.</p>
                         <div class="margin-top-50"> 
        <ul class="social-icon">
            <li><a href="#" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" target="_blank" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a></li>
        </ul>
    </div>
                    </div>
                    
                    <div class="col-md-4 uipasta-credit text-right">
                        <p>Design By <a href="http://www.busreservation.com" target="_blank" title="www.busreservation.com">www.busreservation.com</a></p>
                    </div>
                </div>
            </div>
        </footer>      
        <a href="#" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <script type="text/javascript" src="assets/Front_end_assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/Front_end_assets/js/plugin.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyC0HAKwKinpoFKNGUwRBgkrKhF-sIqFUNA"></script>
        <script type="text/javascript" src="assets/admin_assets/js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="assets/Front_end_assets/js/scripts.js"></script>
    </body>
</html>