<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$page_title = "bKash Transection";
$page_menu = 'bkash_transection';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$results = $dbHelper->getAll("bkash_transection");
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>bKash Transection</h2> 
                            <div class="hidden" id="url">db/bkash_transection.php</div>  
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
                                    <h5>Add New bKash Transection</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <div id="add-new-form-warning"></div>
                                    <form action="" method="post" id="add-new-form" name="add_new_form">
                                        <input type="hidden" name="action" value="add_new" />
                                        <div class="form-group">
                                            <label for="transection-id">Transection Id</label>
                                            <input class="form-control" name="transection_id" type="text" placeholder="Enter Transection id." id="transection-id">
                                            <div id="transection_id_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input class="form-control" name="amount" type="text" placeholder="Enter Amount" id="amount">
                                            <div id="amount_error" class="validation-error"></div>                                      
                                        </div>                                       
                                        <div class="action text-right">
                                            <button type="button" class="btn btn-default close-this-section">Close</button>
                                            <input type="submit" name="save_transection" class="btn btn-primary btn-lg" value=" Save Transection" />
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
                                    <h5>View All bKash Transection</h5>
                                </div>
                                <div class="panel-body">
                                     <div class="table-responsive">
                                      <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Action</th>
                                            <th>Transection Id</th>
                                            <th>Amount</th>
                                            <th>Is Already Used</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while( $row = mysqli_fetch_array( $results ) ) {
                                                ?>
                                                  <tr>
                                                    <td class="text-center"><a class="edit-item" href="<?php echo $row['id_bkash_transection']; ?>"><i class="fa fa-2x fa-edit"></i></a> <a class="delete-item" href="<?php echo $row['id_bkash_transection']; ?>"><i class="fa fa-2x fa-trash-o"></i></a></td>
                                                    <td><?php echo $row['transection_id']; ?></td>
                                                    <td><?php echo $row['amount']; ?></td>
                                                    <td><?php echo $row['is_already_used']; ?></td>
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
                                    <h5>Update bKash Transection</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <?php echo $warning; ?>
                                    <form action="" method="post" id="edit-form" name="edit_form">
                                        <div class="form-group">
                                            <div id="edit-form-warning"></div>
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="id_bkash_transection" id="id_bkash_transection_edit" />
                                        </div>
                                        <div class="form-group">
                                            <label for="transection_id_edit">Transection Id</label>
                                            <input class="form-control" name="transection_id" type="text" placeholder="Enter Transection id." id="transection_id_edit">
                                            <div id="transection_id_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount_edit">Amount</label>
                                            <input class="form-control" name="amount" type="text" placeholder="Enter Amount" id="amount_edit">
                                            <div id="amount_edit_error" class="validation-error"></div>                                      
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