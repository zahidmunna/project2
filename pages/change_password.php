<?php
include('classes/DbHelper.php');
include('classes/Validator.php');
$dbHelper = new DbHelper();
$form_has_error = false;
if( isset($_POST['register']) ) {
    $data = array();
    $data['has_error'] = true;
    $data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();

    if( Validator::isEmpty($old_password) ) {
        $form_has_error = true;
        $error_arr['old_password'] = ' Old Password field is required';
    }else if( !Validator::minLength( $old_password, 6 ) || !Validator::maxLength( $old_password, 100 ) ) {
        $form_has_error = true;
        $error_arr['old_password'] = 'Old Password field value need to be minimum 6 char and maximum 100 char long.';
    }else if( md5($old_password) != $_SESSION['user']['password'] ) {
        $form_has_error = true;
        $error_arr['old_password'] = 'Old Password Does not matched. Please try again!';
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
        $data['password'] = md5($new_password);

        $is_save = $dbHelper->updateByIdField("user", $data, "id_user", $_SESSION['user']['id_user'] );
        if( $is_save ) {
            $user = $dbHelper->getByIdField("user", 'id_user', $_SESSION['user']['id_user']);
            $_SESSION['user'] = $user;
            $data['warning'] = '<h4 class="text-success">Your Password Successfully Updated.</h4>';
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
                    <h2>Change Password</h2>
                </div>
                <div class="panel-body">
                    <div style="max-width:600px;margin: 0 auto;">
                        <?php if(isset($data['warning'])){  echo $data['warning'];}?>
                    <form action="" method="POST" class="<?php if( $form_has_error ) { echo 'has-error'; }?>" >
                        <div class="form-group">
                            <label for="old-password"> Old Password</label>
                            <input type="password"  name="old_password" id="old-password" class="form-control" />
                            <div id="old_password_error" class="validation-error"><?php if(isset($error_arr['old_password'])) {echo $error_arr['old_password']; } ?></div>
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
                        <input type="submit" name="register" class="btn btn-success" value="Save Setting" />
                    </form>
                    </div>
                </div>
                    
            </div>
           
         </div>
        
        
