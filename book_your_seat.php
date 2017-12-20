<?php
session_start();
/*if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}*/
$id_bus_schedule = 0;
$pages = 'book_your_seat';
if( isset($_GET['id_bus_schedule']) ){
    $id_bus_schedule = $_GET['id_bus_schedule'];
}else{
    header('Location:index.php');
}
include('classes/DbHelper.php');
include('classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$bus_schedule = $dbHelper->getByIdField("bus_schedule", "id_bus_schedule", $id_bus_schedule);
$road = $dbHelper->getByIdField("road", "id_road", $bus_schedule['ref_id_road']);
$driver = $dbHelper->getByIdField("driver", "id_driver", $bus_schedule['ref_id_driver']);
$bus = $dbHelper->getByIdField("bus", "id_bus", $bus_schedule['ref_id_bus']);

$price = 0;
if( $bus['bus_type'] == 1 ) {
    $price = $road['ac_price'];
}else if( $bus['bus_type'] == 2 ) {
    $price = $road['non_ac_price'];
}
$already_booked_seat = $dbHelper->getBookedSeatByBusSchedule( $id_bus_schedule );

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Book Your Seat</title>
        
        <link rel="shortcut icon" href="assets/Front_end_assets/images/favicon/favicon.ico">
        <link rel="apple-touch-icon" sizes="144x144" type="image/x-icon" href="assets/Front_end_assets/favicon/apple-touch-icon.png">
        <link rel="stylesheet" type="text/css" href="assets/Front_end_assets/css/plugin.css">
        <link rel="stylesheet" type="text/css" href="assets/Front_end_assets/css/style.css">
        <!-- Google Web Fonts  -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700">


<link href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">
        <link href="assets/admin_assets/css/jquery.seat-charts.css" rel="stylesheet" />
           <link href="assets/admin_assets/css/book_your_seat_style.css" rel="stylesheet" />
           <script src="assets/admin_assets/js/jquery-1.12.3.js"></script>
           <script src="assets/admin_assets/js/jquery.seat-charts.js"></script>        
    </head>
    <body>
        <?php include './Includes/navbar.php';?>

<section id="bus-schedule" class=" section-space-padding <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ echo "padding-top-zero"; }?>">
   <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="section-title">
                    <h2>Book Your Seat</h2>
                </div>
            </div>
        </div>
                    <div class="row section" id="add-new-section">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Road :- <span class="alert-warning"><?php echo $road['road_name']; ?> </span>
                                    Bus Type :- <span class="alert-warning">
                                    <?php 
                                    if( $bus['bus_type'] == 1){ 
                                        echo 'A/C';
                                    }else{
                                        echo 'Non A/C';
                                    }
                                    ?>
                                    </span>
                                    Bus Name :- <span class="alert-warning">
                                    <?php
                                    echo $bus['bus_name']." ( ".$bus['bus_no']." ) ";
                                         ?> </span></h5>
                                </div>
                                <div class="panel-body">
                                    <div id="warning"></div>
                                <div class="wrapper">
                                    <div id="seat-map">
                                        <div class="front-indicator"><h3>Front</h3></div>
                                    </div>
                                    <div class="booking-details">
                                                <div id="legend"></div>
                                                <h3> Selected Seats (<span id="counter">0</span>):</h3>
                                                <ul id="selected-seats" class="scrollbar scrollbar1"></ul>
                                                Total: <b>$<span id="total_without_discount">0</span></b> <br /> <br />
                                                Discount: <b>$<span id="discount">0</span></b><br /><br />
                                                Net Total: <b>$<span id="total">0</span></b><br /><br />
                                                  <?php if(isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ ?>
                                                <div class="form">
                                                    <div id="max_seat_can_booked_error" class="validation-error"></div>
                                                </div>
                                                <div class="form">
                                                <label>Passenger Full Name</label>
                                                <input type="text" id="passenger-full-name" class="form-control" name="passenger_full_name" value="<?php echo $_SESSION['user']['full_name'];?>"/>
                                                <div id="passenger_full_name_error" class="validation-error"></div>                                                
                                                <label>Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $_SESSION['user']['phone'];?>">
                                                </div>
                                               <div id="phone_error" class="validation-error"></div>                                                
                                                <label>Payment Type</label>
                                                <select class="form-control" name="payment_type" id="payment-type">
                                                    <option value="0">Select Payment Type</option>
                                                    <option value="2"> Via Bkash</option>
                                                    <option value="3">Via Paypal</option>
                                                </select>
                                                <div id="payment_type_error" class="validation-error"></div>                                               
                                                <button id="confirm-booking" class="checkout-button">Confirm Booking</button>
                                                <?php }else{  ?>
                                                    <a class="" href="login.php">Already a user</a> Or <a href="user_registration.php">Register as a New Member</a>
                                                <?php

                                                    } ?>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <script type="text/javascript">
                                        var firstSeatLabel = 1;
                                    
                                        $(document).ready(function() {

                                            var $cart = $('#selected-seats'),
                                                $counter = $('#counter'),
                                                $total = $('#total'),
                                                sc = $('#seat-map').seatCharts({
                                                map: [
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                    'ee_ee',
                                                ],
                                                seats: {
                                                    
                                                    e: {
                                                        price   : <?php echo $price; ?>,
                                                        classes : 'empty-seat', //your custom CSS class
                                                        category: 'Booking Candidate'
                                                    }                   
                                                
                                                },
                                                naming : {
                                                    top : false,
                                                    getLabel : function (character, row, column) {
                                                        return firstSeatLabel++;
                                                    },
                                                },
                                                legend : {
                                                    node : $('#legend'),
                                                    items : [
                                                        
                                                        [ 'e', 'available',   'Available Seat'],
                                                        [ 'f', 'unavailable', 'Already Booked']
                                                    ]                   
                                                },
                                                click: function () {
                                                    if (this.status() == 'available') {
                                                        //let's create a new <li> which we'll add to the cart items
                                                        $('<li>'+this.data().category+' : Seat no '+this.settings.label+': <b>$'+this.data().price+'</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
                                                            .attr('id', 'cart-item-'+this.settings.id)
                                                            .data('seatId', this.settings.id)
                                                            .appendTo($cart);
                                                        
                                                        /*
                                                         * Lets update the counter and total
                                                         *
                                                         * .find function will not find the current seat, because it will change its stauts only after return
                                                         * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
                                                         */
                                                        $counter.text(sc.find('selected').length+1);
                                                        $total.text((recalculateTotal(sc)+this.data().price)-recalculateDiscount(sc));
                                                        $("#total_without_discount").text(recalculateTotal(sc)+this.data().price);
                                                        
                                                        return 'selected';
                                                    } else if (this.status() == 'selected') {
                                                        //update the counter
                                                        $counter.text(sc.find('selected').length-1);
                                                        //and total
                                                        $total.text( (recalculateTotal(sc)-this.data().price)-recalculateDiscount(sc));
                                                        $("#total_without_discount").text(recalculateTotal(sc)-this.data().price);
                                                        //remove the item from our cart
                                                        $('#cart-item-'+this.settings.id).remove();
                                                    
                                                        //seat has been vacated
                                                        return 'available';
                                                    } else if (this.status() == 'unavailable') {
                                                        //seat has been already booked
                                                        return 'unavailable';
                                                    } else {
                                                        return this.style();
                                                    }
                                                }
                                            });

                                            //this will handle "[cancel]" link clicks
                                            $('#selected-seats').on('click', '.cancel-cart-item', function () {
                                                //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic heresafa
                                                sc.get($(this).parents('li:first').data('seatId')).click();
                                            });

                                            //let's pretend some seats have already been booked
                                            //sc.get(['1_2', '4_1', '7_1', '7_2']).status('unavailable');
                                            sc.get([<?php echo $already_booked_seat; ?>]).status('unavailable');
                                        
                                        $("#confirm-booking").click(function(){
                                            alert("confirm clicked");
                                            var seat_numbers = '';
                                            var total = 0;
                                            var is_first = true;
                                            var number_of_seat = 0; 
                                            var discount = $("#discount").text();
                                            var ref_id_road = <?php echo $road['id_road']; ?>;
                                            $("#seat-map .selected").each(function(){
                                                if( is_first ){
                                                    seat_numbers = $(this).attr('id');
                                                    is_first = false;
                                                }else{
                                                    seat_numbers = seat_numbers+"#"+$(this).attr('id');
                                                }
                                                number_of_seat ++;
                                            });
                                            total = $("#total").html();

                                            var per_seat_price = <?php echo $price; ?>; 
                                            var ref_id_bus_schedule = <?php echo $id_bus_schedule; ?>;
                                            var passenger_full_name = $("#passenger-full-name").val();
                                            var phone = $("#phone").val();
                                            var payment_type = $("#payment-type").val();
                                            $.ajax({
                                                url: "admin/db/book_your_seat.php",
                                                type: 'post',
                                                dataType: 'json',
                                                data: {action:'add_new',ref_id_bus_schedule:ref_id_bus_schedule,seat_numbers:seat_numbers,per_seat_price:per_seat_price,number_of_seat:number_of_seat,discount:discount,ref_id_road:ref_id_road,passenger_full_name:passenger_full_name,phone:phone,payment_type:payment_type },
                                                success: function(data){
                                                    $(".validation-error").html("");
                                                    if(data.has_error){
                                                        console.log(data);
                                                        $.each(data.errors, function( index, value ) {
                                                            var errorDiv = '#'+index+'_error';
                                                            $(errorDiv).addClass('alert-danger');
                                                            $(errorDiv).empty().append(value);                        
                                                        });
                                                        $('#warning').html(data.warning);
                                                    }else{   
                                                        $("#warning").html(data.warning);
                                                        window.location.href = "http://localhost/reservation/payment.php?payment_type="+payment_type;
                                                    }
                                                }
                                            }).fail(function (ts) {
                                                alert('Something went wrong :-.'+ts.responseText);
                                                $("#loading").hide();
                                            });                                           
                                        });                                            
                                    
                                    });

                                    function recalculateTotal(sc) {
                                        var total = 0;
                                    
                                        //basically find every selected seat and sum its price
                                        sc.find('selected').each(function () {
                                            total += this.data().price;
                                        });
                                        return total;
                                    }
                                    function recalculateDiscount(sc) {
                                        var discount = 0;
                                        var seat_counter = $("#counter").text();
                                        var max_seat_needed_for_discount = <?php echo $road['max_seat_needed_for_discount']; ?>;
                                        if( seat_counter >= max_seat_needed_for_discount ) {
                                            discount = <?php echo $road['discount_amount']; ?>;
                                        }
                                        $("#discount").text(discount);
                                        return discount;
                                    }                                    
                                </script>
                                </div>                                
                            </div>
                        </div>
                    </div>     
    </div>
</section>


        <footer class="footer-section">
            <div class="container">
                <div class="row">

                    <div class="col-md-4 text-left">
                        <p><span><a href="#about" class="smoth-scroll">About us</a></span> | <span><a href="#portfolio" class="smoth-scroll">Portfolio</a></span></p>
                    </div>

                    <div class="col-md-4 text-center">
                        <p>© Copyright 201y Buying ticket.</p>
                         <div class="margin-top-50"> 
        <ul class="social-icon">
            <li><a href="#" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" target="_blank" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a></li>
        </ul>
    </div>
                    </div>
                    
                    <div class="col-md-4 uipasta-credit text-right">
                        <p>Design By <a href="design.php" target="_blank" title="kabir">blank space</a></p>
                    </div>
                </div>
            </div>
        </footer>      
        <a href="#" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <script type="text/javascript" src="assets/Front_end_assets/js/plugin.js"></script>
        <script type="text/javascript" src="assets/Front_end_assets/js/scripts.js"></script>
    </body>
</html>