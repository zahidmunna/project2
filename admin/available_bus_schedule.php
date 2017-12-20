<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$styles = '<link href="../assets/admin_assets/css/jquery.datetimepicker.css" rel="stylesheet" />';
$page_title = "Available Bus Schedule";
$page_menu = 'available_bus_schedule';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$starting_datetime = date('Y-m-d H:i:s');
$ending_datetime = date("Y-m-d H:i:s", strtotime("+24 hours", strtotime($starting_datetime) ));
$ref_id_road = 0;
$bus_type = 0;

if( isset($_POST['find_bus_schedule']) ) {
    $starting_datetime = $_POST['starting_datetime'];
    $ending_datetime = $_POST['ending_datetime'];
    $ref_id_road = $_POST['ref_id_road'];
    $bus_type = $_POST['bus_type'];
    
}
$results = $dbHelper->getAllBusScheduleBYFilter($starting_datetime,$ending_datetime, $ref_id_road,$bus_type);
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Available Bus Schedule</h2> 
                            <div class="hidden" id="url">db/bus_schedule.php</div>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group text-right" style="margin:20px 0;">
                                <a href="" class="btn btn-primary">View All</a>
                                <a href="#add-new-section" class="btn btn-primary show-section">Add New</a>
                            </div> 
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
                                            <th>Action</th>
                                            <th>Bus Schedule No</th>
                                            <th>Road Name</th>
                                            <th>Bus</th>
                                            <th>Bus Type</th>
                                            <th>Seat Available</th>
                                            <th>Booking</th>
                                            <th>Driver Name</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while( $row = mysqli_fetch_array( $results ) ) {
                                                ?>
                                                  <tr>
                                                    <td class="text-center"> <a class="delete-item" href="<?php echo $row['id_bus_schedule']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a></td>
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
                                                            echo $dbHelper->getEmptySeatByBusScheduleId($row['id_bus_schedule']);
                                                        ?>
                                                    </td>
                                                    <td> <a href="book_your_seat.php?id_bus_schedule=<?php echo $row['id_bus_schedule']?>" >Book Your Seat</a></td>
                                                     <td><?php $driver = $dbHelper->getByIdField("driver", "id_driver", $row['ref_id_driver']);
                                                    echo $driver['full_name']; 

                                                    ?></td>
                                                  </tr>                                                
                                                <?php   
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
            
<?php 
$scripts = '
            <script src="../assets/admin_assets/js/section.js"></script>
            <script src="../assets/admin_assets/js/single_item_action.js"></script>
            <script src="../assets/admin_assets/js/jquery.datatable.js"></script>
            <script src="../assets/admin_assets/js/jquery.datetimepicker.js"></script>
            ';
include('include/footer.php'); 
?>