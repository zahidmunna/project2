<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo $page_title; ?></title>
    
        <link href="../assets/admin_assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../assets/admin_assets/css/datatable.css" rel="stylesheet" />
        
        <link href="../assets/admin_assets/css/font-awesome.css" rel="stylesheet" />
        
        <link href="../assets/admin_assets/css/custom.css" rel="stylesheet" />
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
         <?php
            if( isset( $styles ) ) {
                echo $styles;
            }
        ?>       

    </head>
    <body>



        <div id="wrapper">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="adjust-nav">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">
                            <img src="../assets/admin_assets/img/logo.png" />

                        </a>

                    </div>

                    <span class="logout-spn" >
                        <a href="logout.php" style="color:#fff;">LOGOUT</a>  

                    </span>
                </div>
            </div>
            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">



                        <li class="<?php echo ($page_menu == "dashboard") ?  'active-link' : ''; ?>">
                            <a href="dashboard.php" ><i class="fa fa-desktop "></i> Dashboard</a>
                        </li>
                        <li class="<?php echo ($page_menu == "available_bus_schedule") ?  'active-link' : ''; ?>">
                            <a href="available_bus_schedule.php"><i class="fa fa-road "></i>Available Bus</a>
                        </li>
                        <li class="<?php echo ($page_menu == "booked_seat") ?  'active-link' : ''; ?>">
                            <a href="booked_seat.php"><i class="fa fa-road "></i>Booked Seat</a>
                        </li>                        
                        <?php if( $_SESSION['admin']['admin_type'] == 1 ) { ?>
                        <li class="<?php echo ($page_menu == "admin") ?  'active-link' : ''; ?>">
                            <a href="admins.php"><i class="fa fa-users "></i>Admin </a>
                        </li>
                        <li class="<?php echo ($page_menu == "bus") ?  'active-link' : ''; ?>">
                            <a href="bus.php"><i class="fa fa-users "></i>Bus </a>
                        </li>
                        <li class="<?php echo ($page_menu == "driver") ?  'active-link' : ''; ?>">
                            <a href="driver.php"><i class="fa fa-car "></i>Driver </a>
                        </li>
                        <li class="<?php echo ($page_menu == "road") ?  'active-link' : ''; ?>">
                            <a href="road.php"><i class="fa fa-road "></i>Road </a>
                        </li>
                        <li class="<?php echo ($page_menu == "counter") ?  'active-link' : ''; ?>">
                            <a href="counter.php"><i class="fa fa-road "></i>Counter </a>
                        </li>
                        <li class="<?php echo ($page_menu == "assign_counter") ?  'active-link' : ''; ?>">
                            <a href="assign_counter.php"><i class="fa fa-road "></i>Assign Counter </a>
                        </li>
                        <li class="<?php echo ($page_menu == "bus_schedule") ?  'active-link' : ''; ?>">
                            <a href="bus_schedule.php"><i class="fa fa-road "></i>Bus Scheduler </a>
                        </li>   
                       <li class="<?php echo ($page_menu == "bkash_transection") ?  'active-link' : ''; ?>">
                            <a href="bkash_transection.php"><i class="fa fa-road "></i>bKash Transection</a>
                        </li>  
                        <li>
                            <a href="delete_unpaid_seat_booked.php" target="_blank"><i class="fa fa-road "></i>Delete Candidate </a>
                        </li>                                                                       
                        <?php } ?>
                        <li class="<?php echo ($page_menu == "change_password") ?  'active-link' : ''; ?>">
                            <a href="change_password.php"><i class="fa fa-road "></i>Change Password </a>
                        </li>                         
                    </ul>
                </div>

            </nav>
            <!-- /. NAV SIDE  -->