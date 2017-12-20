<?php
include('classes/DbHelper.php');
include('classes/Validator.php');
$dbHelper = new DbHelper();

if( isset($_POST['register']) ) {
    $data = array();
    $data['has_error'] = true;
    $data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);
    print_r($_POST);

    $error_arr = array();
    $form_has_error = false;

    if( Validator::isEmpty( $captcha_code ) ){
        $form_has_error = true;
        $error_arr['captcha_code'] = ' Captcha Code field is required.';
    }else if( $captcha_code != $_SESSION['captcha_code']) {
        $form_has_error = true;
        $error_arr['captcha_code'] = ' Captcha Code need to same as above one.';
    }
    
    if( Validator::isEmpty($full_name) ) {
        $form_has_error = true;
        $error_arr['full_name'] = ' Full Name field is required';
    }

    if( Validator::isEmpty($email) ) {
        $form_has_error = true;
        $error_arr['email'] = ' Email field is required';
    } else if( !Validator::isValidEmail($email) ){
        $form_has_error = true;
        $error_arr['email'] = ' Email field need a valid email.';
    }

     if( Validator::isEmpty( $phone ) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Phone field is required';
    }
   
    if( Validator::isEmpty($new_password) ) {
        $form_has_error = true;
        $error_arr['new_password'] = ' New Password field is required';
    }else if( !Validator::minLength( $new_password, 6 ) || !Validator::maxLength( $new_password, 100 ) ) {
        $form_has_error = true;
        $error_arr['new_password'] = 'New Password field value need to be minimum 6 char and maximum 100 char long.';
    }
     

   if( Validator::isEmpty($confirm_password) ) {
        $form_has_error = true;
        $error_arr['confirm_password'] = ' Confirm Password field is required';
    }else if( !Validator::minLength( $confirm_password, 6 ) || !Validator::maxLength( $confirm_password, 100 ) ) {
        $form_has_error = true;
        $error_arr['confirm_password'] = 'Confirm Password field value need to be minimum 6 char and maximum 100 char long.';
    }

    if( $new_password != $confirm_password ) {
        $form_has_error = true;
        $error_arr['confirm_password'] = 'New Password and Confirm Password field need to be same.';
    }

 
    if( !$form_has_error ) {
        $data = array();
        $data['full_name'] = $full_name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['password'] = md5($new_password);
        $data['address'] = $address;
        $data['is_active'] = 1;

        $is_save = $dbHelper->save("user", $data);
        if( $is_save ) {
            $data['warning'] = '<h4 class="text-success">User Registration Successfully Created.</h4>';
        }else{
            $data['warning'] = '<h4 class="text-danger">Something went wrong. Please try again!!</h4>';
        }   
        $form_has_error = false;
    } 
}
?>     
         <div class="container section-space-padding <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ echo "padding-top-zero"; }?>" >
           
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>User Registration <span class="pull-right"><a href="login.php" class=" btn btn-primary">Already a User</a></span></h2>
                </div>
                <div class="panel-body">
                    <div style="max-width:600px;margin: 0 auto;">
                        <?php if(isset($data['warning'])){  echo $data['warning'];}?>
                    <form action="" method="POST" class="<?php if( $form_has_error ) { echo 'has-error'; }?>" >
                        <div class="form-group">
                            <label for="full-name" > Full Name</label>
                            <input type="text"  name="full_name" id="full-name" class="form-control" />
                            <div id="full_name_error" class="validation-error"><?php if(isset($error_arr['full_name'])) {echo $error_arr['full_name']; } ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" >Email</label>
                            <input type="text" name="email" id="email" class="form-control" />
                            <div id="email_error" class="validation-error"><?php if(isset($error_arr['email'])) {echo $error_arr['email']; } ?></div>
                        </div>
                         <div class="form-group">
                            <label for="phone" > Phone</label>
                            <input type="number"  name="phone" class="form-control" />
                            <div id="phone_error" class="validation-error"><?php if(isset($error_arr['phone'])) {echo $error_arr['phone']; } ?></div>
                        </div>
                        <div class="form-group">
                            <label for="new-password"> New Password</label>
                            <input type="password"  name="new_password" id="new-password" class="form-control" />
                            <div id="new_password_error" class="validation-error"><?php if(isset($error_arr['new_password'])) {echo $error_arr['new_password']; } ?></div>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password"> Confirm-Password</label>
                            <input type="password" name="confirm_password" id="confirm-password" class="form-control"/>
                            <div id="confirm_password_error" class="validation-error"><?php if(isset($error_arr['confirm_password'])) {echo $error_arr['confirm_password']; } ?></div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" > </textarea>
                        </div>
                        <div class="form-group">
                        <label>Captcha</label> 
                            <span id="captcha-code" class="info"></span><br/>
                            <input type="text" name="captcha_code" id="captcha" class="demoInputBox"><br>
                        </div>
                        <div>
                            <img id="captcha_code" src="classes/capcha_code.php" style="width:100px;"/><button name="submit" class="btnRefresh" onClick="refreshCaptcha();">Refresh Captcha</button>
                        </div>
                        <div id="captcha_code_error" class="validation-error"><?php if(isset($error_arr['captcha_code'])) {echo $error_arr['captcha_code']; } ?></div>
                        <input type="submit" name="register" class="btn btn-success" value="Register" />
                    </form>
                    </div>
                </div>
                    
            </div>
           
         </div>
        
        
