<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$page_title = "Assign Counter";
$page_menu = 'assign_counter';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$results = $dbHelper->getAll("road_counter");
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Bus</h2> 
                            <div class="hidden" id="url">db/assign_counter.php</div>  
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
                                    <h5>Assign New Counter</h5>
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
                                            <label for="counter">Select Counter</label>
                                            <select name="ref_id_counter" class="form-control">
                                                <option value="">Select Counter</option>
                                                <?php echo $dbHelper->selectBox("counter","counter_name","id_counter"); ?>
                                            </select>
                                            <div id="ref_id_counter_error" class="validation-error"></div>
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
                                    <h5>View All Assign Counter</h5>
                                </div>
                                <div class="panel-body">
                                     <div class="table-responsive">
                                      <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Action</th>
                                            <th>Road Name</th>
                                            <th>Counter Name</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while( $row = mysqli_fetch_array( $results ) ) {
                                                ?>
                                                  <tr>
                                                    <td class="text-center"> <a class="delete-item" href="<?php echo $row['id_counter']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                                                    <td><?php $road = $dbHelper->getByIdField("road", "id_road", $row['ref_id_road']);
                                                    echo $road['road_name']; 

                                                    ?></td>
                                                    <td><?php 
                                                    $counter = $dbHelper->getByIdField("counter","id_counter", $row['ref_id_counter']);
                                                    echo $counter['counter_name']; ?></td>
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
                                            <input type="hidden" name="id_bus" id="id_bus_edit" />
                                        </div>
                                        <div class="form-group">
                                            <label for="full_name_edit">Bus Name</label>
                                            <input class="form-control" name="bus_name" type="text" placeholder="Enter bus name." id="bus_name_edit" >
                                            <div id="bus_name_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bus_no_edit">Bus No</label>
                                            <input class="form-control" name="bus_no" type="text" placeholder="Enter Bus No." id="bus_no_edit">
                                            <div id="bus_no_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bus_type_edit">Bus Type</label>
                                            <select name="bus_type" class="form-control" id="bus_type_edit">
                                                <option value="1">AC</option>
                                                <option value="2">NON AC</option>
                                            </select>
                                            <div id="bus_type_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bus_details_edit">Bus Details</label>
                                            <textarea class="form-control" name="bus_details" placeholder="Enter Bus Details" rows="6" id="bus_details_edit"></textarea>
                                        </div>  
                                        <div class="form-group">
                                            <label for="is_active_edit">Is Active</label>
                                            <select name="is_active" class="form-control" id="is_active_edit">
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
            ';
include('include/footer.php'); 
?>