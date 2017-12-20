<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$styles = '<link href="../assets/admin_assets/css/jquery.datetimepicker.css" rel="stylesheet" />';
$page_title = "Bus Schedule";
$page_menu = 'bus_schedule';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$results = $dbHelper->getAll("bus_schedule");
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Bus Schedule</h2> 
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
                    <div class="row section" id="add-new-section">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Add Bus To Schedule</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <div id="add-new-form-warning"></div>
                                    <form action="" method="post" id="add-new-form" name="add_new_form">
                                        <input type="hidden" name="action" value="add_new" />
                                        <div class="form-group">
                                            <label for="road">Select Road</label>
                                            <select name="ref_id_road" class="form-control">
                                                <option value="">Select Road</option>
                                                <?php echo $dbHelper->selectBox("road","road_name","id_road"); ?>
                                            </select>
                                            <div id="ref_id_road_error" class="validation-error"></div>
                                        </div>                                       
                                        <div class="form-group">
                                            <label for="counter">Select Bus</label>
                                            <select name="ref_id_bus" class="form-control">
                                                <option value="">Select Bus</option>
                                                <?php echo $dbHelper->selectBox("bus","bus_no","id_bus"); ?>
                                            </select>
                                            <div id="ref_id_bus_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="counter">Select Driver</label>
                                            <select name="ref_id_driver" class="form-control">
                                                <option value="">Select Driver</option>
                                                <?php echo $dbHelper->selectBox("driver","full_name","id_driver"); ?>
                                            </select>
                                            <div id="ref_id_driver_error" class="validation-error"></div>
                                        </div> 
                                        <div class="form-group">
                                            <label for="counter">Starting Datetime</label>
                                            <input type="text" name="starting_datetime" class="form-control datetime" autocomplete="off">
                                            <div id="starting_datetime_error" class="validation-error"></div>
                                        </div>                                      
                                        <div class="form-group">
                                            <label for="counter">Ending Datetime</label>
                                            <input type="text" name="ending_datetime" class="form-control datetime" autocomplete="off">
                                            <div id="ending_datetime_error" class="validation-error"></div>
                                        </div>                                                                                       
                                        <div class="action text-right">
                                            <button type="button" class="btn btn-default close-this-section">Close</button>
                                            <input type="submit" name="save_admin" class="btn btn-primary btn-lg" value=" Save " />
                                        </div>                                          
                                     </form>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="row section" id="view-all-section">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>View All Bus Schedule</h5>
                                </div>
                                <div class="panel-body">
                                     <div class="table-responsive">
                                      <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Action</th>
                                            <th>Bus Schedule No</th>
                                            <th>Road Name</th>
                                            <th>Bus No</th>
                                            <th>Driver Name</th>
                                            <th>Starting Datetime</th>
                                            <th>Ending Datetime</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while( $row = mysqli_fetch_array( $results ) ) {
                                                ?>
                                                  <tr>
                                                    <td class="text-center"> <a class="edit-item" href="<?php echo $row['id_bus_schedule']; ?>" title="Edit"><i class="fa fa-edit"></i></a><a class="delete-item" href="<?php echo $row['id_bus_schedule']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                                                    <td><?php echo $row['bus_schedule_no']; ?></td>
                                                    <td><?php $road = $dbHelper->getByIdField("road", "id_road", $row['ref_id_road']);
                                                    echo $road['road_name']; 

                                                    ?></td>
                                                    <td><?php 
                                                    $counter = $dbHelper->getByIdField("bus","id_bus", $row['ref_id_bus']);
                                                    echo $counter['bus_no']; ?></td>
                                                     <td><?php $driver = $dbHelper->getByIdField("driver", "id_driver", $row['ref_id_driver']);
                                                    echo $driver['full_name']; 

                                                    ?></td>
                                                    <td><?php echo $row['starting_datetime']; ?></td>
                                                    <td><?php echo $row['ending_datetime']; ?></td>
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
                    <div class="row section" id="edit-section">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Update Bus Information</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <?php echo $warning; ?>
                                    <form action="" method="post" id="edit-form" name="edit_form">
                                        <div class="form-group">
                                            <div id="edit-form-warning"></div>
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="id_bus_schedule" id="id_bus_schedule_edit" />
                                        </div>
                                        <div class="form-group">
                                            <label for="ref_id_road_edit">Select Road</label>
                                            <select name="ref_id_road" class="form-control" id="ref_id_road_edit">
                                                <option value="">Select Road</option>
                                                <?php echo $dbHelper->selectBox("road","road_name","id_road"); ?>
                                            </select>
                                            <div id="ref_id_road_edit_error" class="validation-error"></div>
                                        </div>                                       
                                        <div class="form-group">
                                            <label for="ref_id_bus_edit">Select Bus</label>
                                            <select name="ref_id_bus" class="form-control" id="ref_id_bus_edit">
                                                <option value="">Select Bus</option>
                                                <?php echo $dbHelper->selectBox("bus","bus_no","id_bus"); ?>
                                            </select>
                                            <div id="ref_id_bus_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ref_id_driver_edit">Select Driver</label>
                                            <select name="ref_id_driver" class="form-control" id="ref_id_driver_edit">
                                                <option value="">Select Driver</option>
                                                <?php echo $dbHelper->selectBox("driver","full_name","id_driver"); ?>
                                            </select>
                                            <div id="ref_id_driver_edit_error" class="validation-error"></div>
                                        </div> 
                                        <div class="form-group">
                                            <label for="starting_datetime_edit">Starting Datetime</label>
                                            <input type="text" name="starting_datetime" class="form-control datetime" autocomplete="off" id="starting_datetime_edit">
                                            <div id="starting_datetime_error" class="validation-error"></div>
                                        </div>                                      
                                        <div class="form-group">
                                            <label for="ending_datetime_edit">Ending Datetime</label>
                                            <input type="text" name="ending_datetime" class="form-control datetime" autocomplete="off" id="ending_datetime_edit">
                                            <div id="ending_datetime_edit_error" class="validation-error"></div>
                                        </div>   
                                        <div class="form-group">
                                            <label for="bus_schedule_status_edit">Is Active</label>
                                            <select name="bus_schedule_status" class="form-control" id="bus_schedule_status_edit">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>                                            
                                        <div class="action text-right">
                                            <button type="button" class="btn btn-default close-this-section">Close</button>
                                            <input type="submit" name="save_admin" class="btn btn-primary btn-lg" value=" Update " />
                                        </div>  
                                     </form>
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