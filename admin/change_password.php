<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$page_title = "Change Password";
$page_menu = 'change_password';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Change Password</h2> 
                            <div class="hidden" id="url">db/change_password.php</div>  
                        </div>
                        <div class="col-md-4">
                            <!--<div class="form-group text-right" style="margin:20px 0;">
                                <a href="" class="btn btn-primary">View All</a>
                                <a href="#add-new-section" class="btn btn-primary show-section">Add New</a>
                            </div> -->
                        </div>                        
                    </div>              
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row sections" id="add-new-section">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Change Password</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <div id="add-new-form-warning"></div>
                                    <form action="" method="post" id="add-new-form" name="add_new_form">
                                        <input type="hidden" name="action" value="add_new" />
                                        <div class="form-group">
                                            <label for="old-password"> Old Password</label>
                                            <input type="password"  name="old_password" id="old-password" class="form-control" />
                                            <div id="old_password_error" class="validation-error"></div>
                                        </div>                    
                                        <div class="form-group">
                                            <label for="new-password"> New Password</label>
                                            <input type="password"  name="new_password" id="new-password" class="form-control" />
                                            <div id="new_password_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm-password"> Confirm-Password</label>
                                            <input type="password" name="confirm_password" id="confirm-password" class="form-control"/>
                                            <div id="confirm_password_error" class="validation-error"></div>
                                        </div>                                      
                                        <div class="action text-right">
                                            <input type="submit" name="save_setting" class="btn btn-primary btn-lg" value=" Save Setting" />
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