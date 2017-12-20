<?php
session_start();
 if(isset($_POST['login'])){
     include('../classes/DbHelper.php');
     include('../classes/Validator.php');
     $dbHelper = new DbHelper();

    $warning = '';
    $error_arr = array();
    $form_has_no_error = true;
    
    extract($_POST);

    if( Validator::isEmpty($email) ) {
        $form_has_no_error = false;
        $error_arr['email'] = ' Email field is required';
    } else if( !Validator::isValidEmail($email) ){
        $error_arr['email'] = ' Email field need a valid email.';
    }

    if( Validator::isEmpty($password) ) {
        $form_has_no_error = false;
        $error_arr['password'] = 'Password field is required';
    }

    if( $form_has_no_error ) {
        $warning=$dbHelper->admin_login_check( $email, $password );    
    }
 }
 
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin Login Panel</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="../assets/admin_assets/css/bootstrap.min.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="../assets/admin_assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="../assets/admin_assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head>
    <body>
        <div class="header container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Logo -->
                        <div class="logo">
                            <h1 align="center"class="color-1">Well Come To Admin Panal</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="page-content container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login-wrapper">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="text-center">Admin Panel</h2>
                            </div>
                            <div class="panel-body">
                                
                                <h4 class="text-danger"><?php if(isset($warning)){ echo $warning; }?></h4>
                                <form action="" method="POST">
                                    
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input class="form-control" name="email" type="text" placeholder="E-mail">
                                        <div id="email-error"><?php echo isset($error_arr['email']) ? '<p class="alert-danger">'.$error_arr['email'].'</p>': ''; ?></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" name="password" placeholder="Password">
                                        <div id="password-error"><?php echo isset($error_arr['password']) ? '<p class="alert-danger">'.$error_arr['password'].'</p>': ''; ?></div>
                                    </div>
                                    <div class="action text-center">
                                        <button type="submit" name="login" class="btn btn-primary btn-lg">Login </button>
                                    </div>  
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../assets/admin_assets/js/bootstrap.min.js"></script>
        <script src="../assets/admin_assets/js/custom.js"></script>
        <script src="../assets/admin_assets/js/jquery-1.12.3.js"></script>




    </body>
</html>