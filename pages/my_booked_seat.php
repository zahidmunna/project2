<?php
include('classes/DbHelper.php');
include('classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$starting_datetime = date('Y-m-d H:i:s');
$ending_datetime = date("Y-m-d H:i:s", strtotime( '+720 hours', strtotime($starting_datetime) ));
$ref_id_road = 0;
$bus_type = 0;

if( isset($_POST['find_bus_schedule']) ) {
    $starting_datetime = $_POST['starting_datetime'];
    $ending_datetime = $_POST['ending_datetime'];
    $ref_id_road = $_POST['ref_id_road'];
    $bus_type = $_POST['bus_type'];
    
}
$results = $dbHelper->getUserBookedSeatBYFilter($_SESSION['user']['id_user'], $starting_datetime,$ending_datetime, $ref_id_road,$bus_type);
?>
<section id="bus-schedule" class="section-space-padding <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ echo "padding-top-zero"; }?>">
   <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="section-title">
                    <h2>My Booked Seat</h2>
                   
                </div>
            </div>
        </div>

        <div class="row">
            <div class="stestimonial-carousel-list margin-top-20">
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
                                <input type="text" name="ending_datetime" class="form-control datetime" value="<?php echo $ending_datetime; ?>" autocomplete="off" />
                                <div id="ending_datetime_error" class="validation-error"></div>
                            </div>                                                              
                            <div class="form-group col-md-3">
                                <label for="road">Select Road</label>
                                <select name="ref_id_road" class="form-control">
                                    <option value="">Select Road</option>
                                    <?php echo $dbHelper->selectBox("road","road_name","id_road"); ?>
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
                                        <th>Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $serial_no = 1;
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
                                                        echo $row['number_of_seat']*$row['per_seat_price'];
                                                    ?>
                                                </td>  
                                                <td><?php echo $row['discount']; ?></td>                                            
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
                                    ?>
                                    </tbody>                                        
                                  </table>
                                </div>                                     
                            </div>
                        </div>
                    </div>                        
                </div> 

            </div>
        </div>
    </div>
</section>
<!-- About End -->


