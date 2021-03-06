<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$page_title = "Counter";
$page_menu = 'counter';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$results = $dbHelper->getAll("counter");
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Counter</h2> 
                            <div class="hidden" id="url">db/counter.php</div>  
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
                                    <h5>Add New Counter</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <div id="add-new-form-warning"></div>
                                    <form action="" method="post" id="add-new-form" name="add_new_form">
                                        <input type="hidden" name="action" value="add_new" />
                                        <div class="form-group">
                                            <label for="counter-name">Counter Name</label>
                                            <input class="form-control" name="counter_name" type="text" placeholder="Enter counter name." id="counter-name">
                                            <div id="counter_name_error" class="validation-error"></div>
                                        </div>                                       
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" placeholder="Enter Driver Address" rows="6"></textarea>
                                        </div>  
                                        <div class="form-group">
                                            <label for="is-active">Is Active</label>
                                            <select name="is_active" class="form-control" id="is-active">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
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
                                    <h5>View All Driver</h5>
                                </div>
                                <div class="panel-body">
                                     <div class="table-responsive">
                                      <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Action</th>
                                            <th>Counter Name</th>
                                            <th>Address</th>
                                            <th>Is Active</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while( $row = mysqli_fetch_array( $results ) ) {
                                                ?>
                                                  <tr>
                                                    <td class="text-center"><a class="edit-item" href="<?php echo $row['id_counter']; ?>" title="Edit"><i class="fa fa-edit"></i></a> <a class="delete-item" href="<?php echo $row['id_counter']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                                                    <td><?php echo $row['counter_name']; ?></td>
                                                    <td><?php echo $row['address']; ?></td>
                                                    <td><?php echo $row['is_active']; ?></td>
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
                                            <input type="hidden" name="id_counter" id="id_counter_edit" />
                                        </div>
                                        <div class="form-group">
                                            <label for="counter_name_edit">Counter Name</label>
                                            <input class="form-control" name="counter_name" type="text" placeholder="Enter counter name." id="counter_name_edit">
                                            <div id="counter_name_edit_error" class="validation-error"></div>
                                        </div>                                       
                                        <div class="form-group">
                                            <label for="address_edit">Address</label>
                                            <textarea class="form-control" name="address" placeholder="Enter Driver Address" rows="6" id="address_edit"></textarea>
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