<?php
include('classes/DbHelper.php');
include('classes/Validator.php');
$dbHelper = new DbHelper();
$id_bus_seat_booked = $_SESSION['id_bus_seat_booked'];
$bus_seat_booked = $dbHelper->getByIdField( 'bus_seat_booked', 'id_bus_seat_booked', $id_bus_seat_booked);
$amount = ($bus_seat_booked['number_of_seat'] * $bus_seat_booked['per_seat_price'])- $bus_seat_booked['discount'];

if( $bus_seat_booked['ref_id_payment'] > 0 ) {
    $data['warning'] = '<h4 class="alert-danger">Payment Already Done for this booking.</h4>';
}

if( isset($_POST['confirm_bkash_payment']) ) {

    $data = array();
    $data['has_error'] = true;
    $data['warning'] = '<h4 class="alert-danger">Please fixed the following error before procede.</h4>';
    extract($_POST);

    $error_arr = array();
    $form_has_error = false;
    
    if( Validator::isEmpty($transection_no) ) {
        $form_has_error = true;
        $error_arr['transection_no'] = ' Transection No field is required';
    }

        $data = array();

    if( !$form_has_error ) {

        $bkash_transection = $dbHelper->getByIdField( 'bkash_transection', 'transection_id', $transection_no);

        if( $bkash_transection ) {
            if( $bkash_transection['is_already_used'] == 1) {
                $form_has_error = true;
                $data['warning'] = ' <h4 class="text-danger">Transection Already Used Please make sure payment</h4>';
            }else if( $bkash_transection['amount'] != $amount) {
                $form_has_error = true;
                $data['warning'] = '<h4 class="text-danger"> Transection Amount Need to same as booking price.</h4>';
            }else if( $bkash_transection['is_already_used'] == 0 && $bkash_transection['amount']==$amount ){
                $form_has_error = false;
                $update_arr = array();
                $update_arr['is_already_used'] = 1;
                $dbHelper->updateByIdField('bkash_transection', $update_arr, 'id_bkash_transection', $bkash_transection['id_bkash_transection']); 
                $payment_arr = array();
                $payment_arr['transection_type'] = 2;
                $payment_arr['transection_id'] = $transection_no;
                $payment_arr['transection_amount'] = $amount;
                $payment_id = $dbHelper->save("payment", $payment_arr);

                $update_bus_seat_booked_arr = array();
                $update_bus_seat_booked_arr['ref_id_payment'] = $payment_id;
                $dbHelper->updateByIdField('bus_seat_booked', $update_bus_seat_booked_arr, 'id_bus_seat_booked', $id_bus_seat_booked );

                $data['warning'] = ' <h4 class="text-success">Your payment Successfully done.</h4>';

            }
        }else{
            $form_has_error = true;
            $data['warning'] = ' <h4 class="text-danger">There is no such payment found. Please make sure payment</h4>';            
        }
    } 
}
?>     
         <div class="container section-space-padding <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ echo "padding-top-zero"; }?>" >
           
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>bKash Payment <span class="pull-right"><a href="login.php" class=" btn btn-primary">Already a User</a></span></h2>
                </div>
                <div class="panel-body">
                    <div style="max-width:600px;margin: 0 auto;">
                        <?php if(isset($data['warning'])){  echo $data['warning'];}?>
                    <form action="" method="POST" class="<?php if( $form_has_error ) { echo 'has-error'; }?>" >
                        <div class="form-group">
                            <label for="transection-no" > Transection NO</label>
                            <input type="text"  name="transection_no" id="transection-no" class="form-control" />
                            <div id="transection_no_error" class="validation-error"><?php if(isset($error_arr['transection_no'])) {echo $error_arr['transection_no']; } ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="amount" >Amount</label>
                            <input type="text" name="readonly_amount" id="amount" class="form-control" value="<?php echo $amount; ?>" readonly="readonly"/>
                            <div id="amount_error" class="validation-error"><?php if(isset($error_arr['amount'])) {echo $error_arr['amount']; } ?></div>
                        </div>
                        <?php if( $bus_seat_booked['ref_id_payment'] <=0 ) { ?>
                        <input type="submit" name="confirm_bkash_payment" class="btn btn-success" value="Confirm bKash Payment" />
                        <?php } ?>
                    </form>
                    </div>
                </div>
                    
            </div>
           
         </div>
        
        
