<?php
include('classes/DbHelper.php');
include('classes/Validator.php');
$dbHelper = new DbHelper();

if( isset($_POST['confirm_bkash_payment']) ) {
    $data = array();
    $data['has_error'] = true;
    $data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);
    print_r($_POST);

    $error_arr = array();
    $form_has_error = false;
    
    if( Validator::isEmpty($full_name) ) {
        $form_has_error = true;
        $error_arr['full_name'] = ' Full Name field is required';
    }

     if( Validator::isEmpty( $phone ) ) {
        $form_has_error = true;
        $error_arr['phone'] = ' Phone field is required';
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
                    <h2>Paypal Payment <span class="pull-right"><a href="login.php" class=" btn btn-primary">Already a User</a></span></h2>
                </div>
                <div class="panel-body">
                    <div style="max-width:600px;margin: 0 auto;">
                        <?php if(isset($data['warning'])){  echo $data['warning'];}?>
                    <?php
                    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
                    $paypalID = 'dummy@gmail.com'; //Business Email
                    $number_of_seat = 10; 
                    $amount = 1000;

                    ?>
                        <form action="<?php echo $paypalURL; ?>" method="post">
                            <!-- Identify your business so that you can collect the payments. -->
                            <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
                            
                            <!-- Specify a Buy Now button. -->
                            <input type="hidden" name="cmd" value="_xclick">
                            
                            <!-- Specify details about the item that buyers will purchase. -->
                            <input type="hidden" name="item_name" value="Booked Seat">
                            <input type="hidden" name="item_number" value="<?php echo $number_of_seat; ?>">
                            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                            <input type="hidden" name="currency_code" value="USD">
                            
                            <!-- Specify URLs -->
                            <input type='hidden' name='cancel_return' value='http://localhost/paypal_integration_php/cancel.php'>
                            <input type='hidden' name='return' value='http://localhost/paypal_integration_php/success.php'>
                            
                            <!-- Display the payment button. -->
                            <input type="image" name="submit" border="0"
                            src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
                            <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
                        </form>
                   
                    </div>
                </div>
                    
            </div>
           
         </div>
        
        
