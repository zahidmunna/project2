<?php
include('classes/DbHelper.php');
include('classes/Validator.php');
$dbHelper = new DbHelper();

if( isset($_POST['register']) ) {
    $data = array();
    $data['has_error'] = true;
    $data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;

    
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
   
 
    if( !$form_has_error ) {
        $data = array();
        $data['full_name'] = $full_name;
        $data['phone'] = $phone;
        $data['address'] = $address;

        $is_save = $dbHelper->updateByIdField("user", $data, "id_user", $_SESSION['user']['id_user'] );
        if( $is_save ) {
            $user = $dbHelper->getByIdField("user", 'id_user', $_SESSION['user']['id_user']);
            $_SESSION['user'] = $user;
            $data['warning'] = '<h4 class="text-success">User Setting Successfully Updated.</h4>';
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
                    <h2>User Setting </h2>
                </div>
                <div class="panel-body">
                    <div style="max-width:600px;margin: 0 auto;">
                        <?php if(isset($data['warning'])){  echo $data['warning'];}?>
                    <form action="" method="POST" class="<?php if( $form_has_error ) { echo 'has-error'; }?>" >
                        <div class="form-group">
                            <label for="full-name" > Full Name</label>
                            <input type="text"  name="full_name" id="full-name" class="form-control"  value="<?php echo $_SESSION['user']['full_name']; ?>" />
                            <div id="full_name_error" class="validation-error"><?php if(isset($error_arr['full_name'])) {echo $error_arr['full_name']; } ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" >Email</label>
                            <input type="text" name="email" id="email" class="form-control"  value="<?php echo $_SESSION['user']['email']; ?>" readonly="readonly"/>
                            <div id="email_error" class="validation-error"><?php if(isset($error_arr['email'])) {echo $error_arr['email']; } ?></div>
                        </div>
                         <div class="form-group">
                            <label for="phone" > Phone</label>
                            <input type="number"  name="phone" class="form-control"  value="<?php echo $_SESSION['user']['phone']; ?>"/>
                            <div id="phone_error" class="validation-error"><?php if(isset($error_arr['phone'])) {echo $error_arr['phone']; } ?></div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" > <?php echo $_SESSION['user']['address']; ?></textarea>
                        </div>
                        <input type="submit" name="register" class="btn btn-success" value="Save Setting" />
                    </form>
                    </div>
                </div>
                    
            </div>
           
         </div>
        
        
