<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$id_bus_schedule = 0;
if( isset($_GET['id_bus_schedule']) ){
    $id_bus_schedule = $_GET['id_bus_schedule'];
}else{
    header('Location:dashboard.php');
}
$page_title = "Book Your Seat";
$page_menu = 'book_your_seat';
$styles = '<link href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">
        <link href="../assets/admin_assets/css/jquery.seat-charts.css" rel="stylesheet" />
           <link href="../assets/admin_assets/css/book_your_seat_style.css" rel="stylesheet" />
           <script src="../assets/admin_assets/js/jquery-1.12.3.js"></script>
           <script src="../assets/admin_assets/js/jquery.seat-charts.js"></script>';

include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
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

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Book your seat Now</h2> 
                            <div class="hidden" id="url">db/seat_booked.php</div>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group text-right" style="margin:20px 0;">
                                <a href="available_bus_schedule.php" class="btn btn-primary">Available Bus</a>
                            </div>                         
                        </div>                        
                    </div>              
                    <!-- /. ROW  -->
                    <hr />
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
                                                <div class="form">
                                                    <div id="max_seat_can_booked_error" class="validation-error"></div>
                                                </div>                                         
                                                <div class="form">
                                                <label>Passenger Full Name</label>
                                                <input type="text" id="passenger-full-name" class="form-control"/>
                                                <div id="passenger_full_name_error" class="validation-error"></div>
                                                <label>Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control">
                                                <div id="phone_error" class="validation-error"></div> 
                                                </div>
                                                <button id="confirm-booking" class="checkout-button">Confirm Booking</button>
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
                                            var payment_type = 1;
                                            $.ajax({
                                                url: "db/book_your_seat.php",
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
            </div>
            
<?php 
$scripts = '
            <script src="../assets/admin_assets/js/section.js"></script>
            <script src="../assets/admin_assets/js/single_item_action.js"></script>
            ';
            ?>
        </div>
        <div class="footer">


            <div class="row">
                <div class="col-lg-12" >
                    &copy;  2014 busreservation.com | Design by: <a href="http://busreservation.com" style="color:#fff;" target="_blank">www.busreservation.com</a>
                </div>
            </div>
        </div>

        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/admin_assets/js/bootstrap.min.js"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/admin_assets/js/custom.js"></script>
        <?php
            if( isset( $scripts ) ) {
                echo $scripts;
            }
        ?>

    </body>
</html>
