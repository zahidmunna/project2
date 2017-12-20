<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$page_title = "Admin";
$page_menu = 'admin';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$results = $dbHelper->getAll("admin");
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>ADMIN</h2> 
                            <div class="hidden" id="url">db/admins.php</div>  
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
                                    <h5>Add New Admin</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <div id="add-new-form-warning"></div>
                                    <form action="" method="post" id="add-new-form" name="add_new_form">
                                        <input type="hidden" name="action" value="add_new" />
                                        <div class="form-group">
                                            <label for="full-name">Full Name</label>
                                            <input class="form-control" name="full_name" type="text" placeholder="Enter admin full name." id="full-name">
                                            <div id="full_name_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input class="form-control" name="email" type="text" placeholder="Enter admin email." id="email">
                                            <div id="email_error" class="validation-error"></div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input class="form-control" name="phone" type="text" placeholder="Enter admin phone." id="phone">
                                            <div id="phone_error" class="validation-error"></div>
                                        </div>                     
                                        <div class="form-group">
                                            <label for="new-password">New Password</label>
                                            <input class="form-control" type="password" name="new_password" placeholder="Enter New Password">
                                            <div id="new_password_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm-password">Confirm Password</label>
                                            <input class="form-control" type="password" name="confirm_password" placeholder="Enter Confirm Password">
                                            <div id="confirm_password_error" class="validation-error"></div>
                                        </div>  
                                        <div class="form-group">
                                            <label for="admin-type">Admin Type</label>
                                            <select name="admin_type" class="form-control" id="admin-type">
                                                <option value="1">Super Admin</option>
                                                <option value="2">Counter Admin</option>
                                            </select>
                                        </div>  
                                        <div class="form-group">
                                            <label for="counter">Counter</label>
                                            <select name="ref_id_counter" class="form-control" id="counter">
                                            <option value="">Select Counter</option>
                                                <?php echo $dbHelper->selectBox("counter", "counter_name", "id_counter"); ?>
                                            </select>
                                            <div id="ref_id_counter_error" class="validation-error"></div>
                                        </div>  
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" placeholder="Enter Address" rows="6"></textarea>
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
                                    <h5>View All Admin</h5>
                                </div>
                                <div class="panel-body">
                                     <div class="table-responsive">
                                      <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Action</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Admin Type</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while( $row = mysqli_fetch_array( $results ) ) {
                                                ?>
                                                  <tr>
                                                    <td class="text-center"><a class="edit-item" href="<?php echo $row['id_admin']; ?>"><i class="fa fa-2x fa-edit"></i></a> <a class="delete-item" href="<?php echo $row['id_admin']; ?>"><i class="fa fa-2x fa-trash-o"></i></a></td>
                                                    <td><?php echo $row['full_name']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['phone']; ?></td>
                                                    <td><?php if( $row['admin_type'] == 1 ){ echo 'Super Admin'; }else if( $row['admin_type'] == 2 ) { echo 'Counter Admin'; } ?></td>
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
                                    <h5>Update Admin Information</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <?php echo $warning; ?>
                                    <form action="" method="post" id="edit-form" name="edit_form">
                                        <div class="form-group">
                                            <div id="edit-form-warning"></div>
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="id_admin" id="id_admin_edit" />
                                        </div>
                                        <div class="form-group">
                                            <label for="full_name_edit">Full Name</label>
                                            <input class="form-control" name="full_name" type="text" placeholder="Enter admin full name." id="full_name_edit" >
                                            <div id="full_name_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email_edit">Email</label>
                                            <input class="form-control" name="email" type="text" placeholder="Enter admin email." id="email_edit">
                                            <div id="email_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_edit">Phone</label>
                                            <input class="form-control" name="phone" type="text" placeholder="Enter admin phone." id="phone_edit" >
                                            <div id="phone_edit_error" class="validation-error"></div>
                                        </div> 
                                        <div class="form-group">
                                            <p class="alert alert-info">Only Fill up following field if you want to change password.</p>
                                        </div>                    
                                        <div class="form-group">
                                            <label for="new_password_edit">New Password</label>
                                            <input class="form-control" type="password" name="new_password" id="new_password_edit" placeholder="Enter New Password">
                                            <div id="new_password_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password_edit">Confirm Password</label>
                                            <input class="form-control" type="password" name="confirm_password" placeholder="Enter Confirm Password">
                                            <div id="confirm_password_edit_error" class="validation-error"></div>
                                        </div>  
                                        <div class="form-group">
                                            <label for="admin_type_edit">Admin Type</label>
                                            <select name="admin_type" class="form-control" id="admin_type_edit">
                                                <option value="1">Super Admin</option>
                                                <option value="2">Counter Admin</option>
                                            </select>
                                        </div>  
                                        <div class="form-group">
                                            <label for="ref_id_counter_edit">Counter</label>
                                            <select name="ref_id_counter" class="form-control" id="ref_id_counter_edit">
                                            <option value="">Select Counter</option>
                                                <?php echo $dbHelper->selectBox("counter", "counter_name", "id_counter"); ?>
                                            </select>
                                            <div id="ref_id_counter_edit_error" class="validation-error"></div>
                                        </div>  
                                        <div class="form-group">
                                            <label for="address_edit">Address</label>
                                            <textarea class="form-control" name="address" placeholder="Enter Address" rows="6" id="address_edit"></textarea>
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