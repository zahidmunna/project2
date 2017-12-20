<?php
 if(isset($_POST['Send'])){
     require './classes/User.php';
     $obj_user=new User();
     $msg=$obj_user->UserRegistration($_POST);
 }

?>



<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="assets/Front_end_assets/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="assets/Front_end_assets/css/login.css"/>
    </head>
    <body>
     
      
         <div class="container">
           <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand " href="index.php">Login Register system</a>
                    </div>
                    
                </div>
               
               
            </nav >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>User login <span class="pull-right"><a href="userlogin.php" class=" btn btn-primary">back</a></span></h2>
                </div>
                <div class="panel-body">
                    <div style="max-width:600px;margin: 0 auto;">
                        <?php if(isset($msg)){  echo $msg;}?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="full" > full Name</label>
                            <input type="text"  name="full_name" class="form-control" />
                        </div>
                        
                        <div class="form-group">
                            <label for="user" > user Name</label>
                            <input type="text" name="user_name" class="form-control" />
                        </div>
                       
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control" />
                        </div>
                         <div class="form-group">
                            <label for="Mobile" > Mobile Number</label>
                            <input type="number"  name="phone" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="password"> Password</label>
                            <input type="password"  name="password" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="password"> Confirm-Password</label>
                            <input type="password" name="Con_password" class="form-control"/>
                        </div>
                        <div class="form-group">
                        <label>Captcha</label> 
                            <span id="captcha-info" class="info"></span><br/>
                            <input type="text" name="captcha" id="captcha" class="demoInputBox"><br>
                        </div>
                        <div>
                            <img id="captcha_code" src="classes/capcha_code.php" /><button name="submit" class="btnRefresh" onClick="refreshCaptcha();">Refresh Captcha</button>
                        </div>
                        <button type="submit" name="Send" class="btn btn-success">Send</button>
                    </form>
                    </div>
                </div>
                    
            </div>
            <div class="well">
                <h3>Safayet kabir Mimo
                                <span class="pull-right"> Like us</span>

                </h3>
                
            </div>
        </div
        <script src="assets/Front_end_assets/js/jquery.min.js"></script>
        <script src="assets/Front_end_assets/js/bootstrap.min.js"></script>
        
    </body>
</html>
