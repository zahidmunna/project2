<?php
 if(isset($_POST['login'])){
     include('classes/DbHelper.php');
     include('classes/Validator.php');
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
        $warning=$dbHelper->user_login_check( $email, $password );    
    }
 }
 
?>
      
         <div class="container section-space-padding <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ echo "padding-top-zero"; }?>" >
           
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>User login <span class="pull-right"><a class="btn btn-default" href="index.php">Home</a></span></h2>
                    
                </div>
                <div class="panel-body">
                    <div style="max-width: 600px; margin: 0 auto;" >
                    <form action="" method="POST"  class="<?php if( !$form_has_no_error ) { echo 'has-error'; }?>" >
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control" />
                            <div id="email_error" class="validation-error"><?php if(isset($error_arr['email'])) {echo $error_arr['email']; } ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" />
                            <div id="password_error" class="validation-error"><?php if(isset($error_arr['password'])) {echo $error_arr['password']; } ?></div>
                        </div>
                        <div class="well-sm">
                        <div class="form-group-sm">
                            <input type="checkbox" /> Rememmber Me
                            <span class="pull-right"><a href="user_registration.php">Register as a New Member</a></span>
                        </div>
                        </div>
                        <input type="submit" name="login" class="btn btn-success" value="login" />
                    </form>
                    </div>
                </div>
                    
            </div>
           
         </div>
        
        
