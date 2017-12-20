<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$styles = '<link href="../assets/admin_assets/css/jquery.datetimepicker.css" rel="stylesheet" />';
$page_title = "Booked Seat";
$page_menu = 'booked_seat';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$starting_datetime = date('Y-m-d H:i:s');
$ending_datetime = date("Y-m-d H:i:s", strtotime("+24 hours", strtotime($starting_datetime) ));
$ref_id_road = 0;
$bus_type = 0;
$ref_id_counter = 0;
//$results = array();

if( isset($_POST['find_bus_schedule']) ) {
    $starting_datetime = $_POST['starting_datetime'];
    $ending_datetime = $_POST['ending_datetime'];
    $ref_id_road = $_POST['ref_id_road'];
    $bus_type = $_POST['bus_type'];
    if(isset($_POST['ref_id_counter'])) {
        $ref_id_counter = $_POST['ref_id_counter'];
    }
    
}

if( $_SESSION['admin']['admin_type'] == 2 && $_SESSION['admin']['ref_id_counter'] > 0 ) {
    $ref_id_counter = $_SESSION['admin']['ref_id_counter'];
}

if( $ref_id_counter > 0 ) {
$results = $dbHelper->getCounterBookedSeatBYFilter( $ref_id_counter, $starting_datetime,$ending_datetime, $ref_id_road,$bus_type);
}else{
$results = $dbHelper->getCounterBookedSeatBYFilter( 0, $starting_datetime,$ending_datetime, $ref_id_road,$bus_type);    
}
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Booked Seat</h2> 
                            <div class="hidden" id="url">db/bus_schedule.php</div>  
                        </div>
                        <div class="col-md-4">
                        </div>                        
                    </div>              
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <form class="" action="" method="post">
                                <div class="form-group col-md-3">
                                    <label for="counter">Starting Datetime</label>
                                    <input type="text" name="starting_datetime" class="form-control datetime" value="<?php echo $starting_datetime; ?>" autocomplete="off"/>
                                    <div id="starting_datetime_error" class="validation-error"></div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="counter">Ending Datetime</label>
                                    <input type="text" name="ending_datetime" class="form-control datetime" value="<?php echo $ending_datetime; ?>" autocomplete="off"/>
                                    <div id="ending_datetime_error" class="validation-error"></div>
                                </div> 
                                <?php if($_SESSION['admin']['admin_type'] == 1 ) { ?>      
                                <div class="form-group col-md-3"> 
                                    <label for="counter">Select Counter</label>
                                    <select name="ref_id_counter" class="form-control" id="counter">
                                    <option value="">Select Counter</option>
                                        <?php echo $dbHelper->selectBox("counter", "counter_name", "id_counter"); ?>
                                    </select>
                                </div>  
                                <?php } ?>                                                   
                                <div class="form-group col-md-3">
                                    <label for="road">Select Road</label>
                                    <select name="ref_id_road" class="form-control">
                                        <option value="">Select Road</option>
                                        <?php 
                                        if( $_SESSION['admin']['admin_type'] == 1 ) {
                                             echo $dbHelper->selectBox("road","road_name","id_road"); 
                                        }else if( $_SESSION['admin']['admin_type'] == 2 ){
                                            $roads = $dbHelper->getCounterRoad($_SESSION['admin']['ref_id_counter']);

                                            while( $road = mysqli_fetch_array($roads) ){
                                                echo '<option value="'.$row['id_road'].'">'.$road['road_name'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div id="ref_id_road_error" class="validation-error"></div>
                                </div>                                       
                                <div class="form-group col-md-2">
                                    <label for="counter">Bus Type</label>
                                    <select name="bus_type" class="form-control">
                                        <option value="0">All Type</option>
                                        <option value="1">A/C</option>
                                        <option value="2">Non A/C</option>
                                    </select>
                                    <div id="ref_id_counter_error" class="validation-error"></div>
                                </div>  
                                <div class="form-group text-right col-md-1">
                                <label for="counter">Action</label>
                                    <input type="submit" name="find_bus_schedule" class="btn btn-primary" value=" Find " />
                                </div>                                          
                             </form>                            
                        </div>
                    </div>
                    <div class="row section" id="view-all-section">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>View All Available Bus Schedule</h5>
                                </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>Sl. No.</th>
                                        <th>Coach No</th>
                                        <th>Road Name</th>
                                        <th>Bus</th>
                                        <th>Bus Type</th>
                                        <th>No of Seat</th>
                                        <th>Per Seat Price</th>
                                        <th>Total Price</th>
                                        <th>Discount</th>
                                        <th>Seat Numbers</th>
                                        <th>Starting Datetime</th>
                                        <th>Ending Datetime</th>
                                        <th>Passenger Full Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if( isset( $results) ){
                                        $serial_no = 1;
                                        $total_seat = 0;
                                        $total_price = 0;
                                        $total_discount = 0;
                                        while( $row = mysqli_fetch_array( $results ) ) {
                                            ?>
                                              <tr>
                                                <td><?php echo $serial_no; ?></td>
                                                <td><?php echo $row['bus_schedule_no']; ?></td>
                                                <td><?php $road = $dbHelper->getByIdField("road", "id_road", $row['ref_id_road']);
                                                echo $road['road_name']; 

                                                ?></td>
                                                <td><?php 
                                                $bus = $dbHelper->getByIdField("bus","id_bus", $row['ref_id_bus']);
                                                echo $bus['bus_name']." ( ".$bus['bus_no']." ) "; ?></td>
                                                <td>
                                                    <?php
                                                        if( $bus['bus_type'] == 1 ) {
                                                            echo 'A/C';
                                                        }else if( $bus['bus_type'] == 2 ) {
                                                            echo 'Non A/C';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $total_seat += $row['number_of_seat'];
                                                        echo $row['number_of_seat'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $row['per_seat_price'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $total_price += $row['number_of_seat']*$row['per_seat_price'];
                                                        echo $row['number_of_seat']*$row['per_seat_price'];
                                                    ?>
                                                </td>    
                                                <td><?php $total_discount +=$row['discount']; echo $row['discount']; ?></td>                                          
                                                <td>
                                                    <?php
                                                        echo $row['seat_numbers'];
                                                    ?>
                                                </td>                                                                                          
                                                <td>
                                                    <?php
                                                        echo $row['starting_datetime'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $row['ending_datetime'];
                                                    ?>
                                                </td>   
                                                <td> <?php echo $row['passenger_full_name']; ?></td>                                                      <td><?php echo $row['phone']; ?></td>                                       
                                                <td> 
                                                <?php
                                                    $format = 'Y-m-d H:i:s'; //the format
                                                    $starting_datetime = strtotime((new DateTime($row['starting_datetime']))->format($format));
                                                    $ending_datetime = strtotime((new DateTime($row['ending_datetime']))->format($format));   

                                                    $now_datetime = strtotime((new DateTime())->format($format));                                           
                                                     if($starting_datetime > $now_datetime) {
                                                        echo '<span class="text-warning">Upcoming</span>';
                                                     }else if( $ending_datetime < $now_datetime){
                                                        echo '<span class="text-success">Completed</span>';
                                                     }else{
                                                        echo '<span class="text-info">Runing </span>';
                                                     }
                                                ?>
                                                </td>
                                              </tr>                                                
                                            <?php  
                                            $serial_no++; 
                                        }
                                    }
                                    ?>
                                    </tbody>    
                                    <tfoot>
                                        <tr>
                                            <td colspan="5"> Total Information</td>
                                            <td><?php echo $total_seat; ?></td>
                                            <td colspan="2" style="text-align:right;"><?php echo $total_price; ?></td>
                                            <td><?php echo $total_discount; ?></td>
                                            <td colspan="2">Net Total</td>
                                            <td colspan="4"><?php echo $total_price - $total_discount; ?></td>
                                        </tr>
                                    </tfoot>                                    
                                  </table>
                                </div>                                     
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
            <script src="../assets/admin_assets/js/jquery.datatable.js"></script>
            <script src="../assets/admin_assets/js/jquery.datetimepicker.js"></script>
            ';
include('include/footer.php'); 
?>