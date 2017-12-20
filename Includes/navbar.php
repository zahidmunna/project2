

<div id="preloader">
    <div class="loader"></div>
</div>
<!-- Preloader End -->



<!-- Home & Menu Section Start -->
<header id="home" class="home-section <?php if( isset($pages) ) {echo 'home'; }?>">
    
    <div class="header-top-area">
        <div class="container">
            <div class="row">

                <div class="col-sm-3">
                    <div class="logo">
                        <a href="#">Buying Ticket</a>
                    </div>
                </div>

                <div class="col-sm-9">
                    <div class="navigation-menu">
                        <div class="navbar">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="navbar-collapse collapse">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="active"><a class="smoth-scroll" href="index.php">Home <div class="ripple-wrapper"></div></a>
                                    </li>
                                    <li><a class="smoth-scroll" href="about.php">About</a>
                                    </li>
                                    <li><a class="smoth-scroll" href="portfolio.php">Portfolio</a>
                                    </li>
                                    <li><a class="smoth-scroll" href="testimonials.php">Testimonial</a>
                                    </li>
                                    <li><a class="smoth-scroll" href="services.php">services</a>
                                    </li>
                                    <li><a class="smoth-scroll" href="bus_schedule.php">Bus Schedule</a>
                                    </li>
                                    <li><a class="smoth-scroll" href="contact.php">Contact</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ ?>
    <div class="login-user-nav">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                <h2><?php echo $_SESSION['user']['full_name']; ?></h2>
                </div>
                <div class="col-md-9">
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="smoth-scroll" href="user_setting.php">User Setting</a>
                            </li>
                            <li><a class="smoth-scroll" href="my_booked_seat.php">My Booked Seat</a>
                            </li>
                            <li><a class="smoth-scroll" href="change_password.php">Change Password</a>
                            </li>
                            <li><a class="smoth-scroll" href="logout.php">Log Out</a>
                            </li>
                            
                        </ul>
                    </div>            
                </div>
            </div>
        </div>
    </div>
    <?php }