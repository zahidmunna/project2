<?php
session_start();
if(!$_SESSION['is_login']){
    header('Location:index.php');
    
}
$page_title = "Road";
$page_menu = 'road';
include('include/header.php');
include('../classes/DbHelper.php');
include('../classes/Validator.php');
$dbHelper = new DbHelper();
$warning = '';
$results = $dbHelper->getAll("road");
?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Road</h2> 
                            <div class="hidden" id="url">db/road.php</div>  
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
                                    <h5>Add New Road</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <div id="add-new-form-warning"></div>
                                    <form action="" method="post" id="add-new-form" name="add_new_form">
                                        <input type="hidden" name="action" value="add_new" />
                                        <div class="form-group">
                                            <label for="road-name">Road Name</label>
                                            <input class="form-control" name="road_name" type="text" placeholder="Enter road name." id="road-name">
                                            <div id="road_name_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="start-from">Start From</label>
                                            <input class="form-control" name="start_from" type="text" placeholder="Enter Start From." id="start-from">
                                            <div id="start_from_error" class="validation-error"></div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="end-to">End To</label>
                                            <input class="form-control" name="end_to" type="text" placeholder="Enter End To." id="end-to">
                                            <div id="end_to_error" class="validation-error"></div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="distance">Distance</label>
                                            <input class="form-control" name="distance" type="text" placeholder="Enter Distance." id="distance">
                                            <div id="distance_error" class="validation-error"></div>                                            
                                        </div>                                             
                                        <div class="form-group">
                                            <label for="ac-price">A/C Price</label>
                                            <input class="form-control" name="ac_price" type="text" placeholder="Enter A/C Price." id="ac-price">
                                            <div id="ac_price_error" class="validation-error"></div>                                            
                                        </div> 
                                        <div class="form-group">
                                            <label for="non-ac-price">Non A/C Price</label>
                                            <input class="form-control" name="non_ac_price" type="text" placeholder="Enter Non A/C Price." id="non-ac-price">
                                            <div id="non_ac_price_error" class="validation-error"></div>                                            
                                        </div> 
                                        <div class="form-group">
                                            <label for="discount-amount">Discount Amount</label>
                                            <input class="form-control" name="discount_amount" type="text" placeholder="Enter Discount Amount." id="discount-amount">
                                            <div id="discount_amount_error" class="validation-error"></div>                                            
                                        </div>                                                    
                                        <div class="form-group">
                                            <label for="max_seat_needed_for_discount">Max Seat Needed for discount</label>
                                            <input class="form-control" name="max_seat_needed_for_discount" type="text" placeholder="Enter Max Seat Needed For Discount." id="max_seat_needed_for_discount">
                                            <div id="max_seat_needed_for_discount_error" class="validation-error"></div>                                            
                                        </div> 
                                        <div class="form-group">
                                            <label for="max-seat-can-booked">Max Seat Can Booked</label>
                                            <input class="form-control" name="max_seat_can_booked" type="text" placeholder="Enter Max Seat Can Booked." id="max-seat-can-booked">
                                            <div id="max_seat_can_booked_error" class="validation-error"></div>                                            
                                        </div>                                                                              
                                        <div class="form-group">
                                            <label for="details">Road Details</label>
                                            <textarea class="form-control" name="details" placeholder="Enter Road Details" rows="6"></textarea>
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
                                    <h5>View All Road</h5>
                                </div>
                                <div class="panel-body">
                                     <div class="table-responsive">
                                      <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Action</th>
                                            <th>Road Name</th>
                                            <th>Start From</th>
                                            <th>End To</th>
                                            <th>Distance</th>
                                            <th>A/C price</th>
                                            <th>Non A/C price</th>
                                            <th>Discount</th>
                                            <th>Max Seat Needed For Discount</th>
                                            <th>Max Seat Can Booked</th>
                                            <th>Details</th>
                                            <th>Is Active</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while( $row = mysqli_fetch_array( $results ) ) {
                                                ?>
                                                  <tr>
                                                    <td class="text-center"><a class="edit-item" href="<?php echo $row['id_road']; ?>"><i class="fa fa-2x fa-edit"></i></a> <a class="delete-item" href="<?php echo $row['id_road']; ?>"><i class="fa fa-2x fa-trash-o"></i></a></td>
                                                    <td><?php echo $row['road_name']; ?></td>
                                                    <td><?php echo $row['start_from']; ?></td>
                                                    <td><?php echo $row['end_to']; ?></td>
                                                    <td><?php echo $row['distance']; ?></td>
                                                    <td><?php echo $row['ac_price']; ?></td>
                                                    <td><?php echo $row['non_ac_price']; ?></td>
                                                    <td><?php echo $row['discount_amount']; ?></td>
                                                    <td><?php echo $row['max_seat_needed_for_discount']; ?></td>
                                                    <td><?php echo $row['max_seat_can_booked']; ?></td>

                                                    <td><?php echo $row['details']; ?></td>
                                                    <td><?php if($row['is_active'] ==1){ echo 'Yes'; }else{echo 'No'; } ?></td>
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
                                    <h5>Update Road Information</h5>
                                </div>
                                <div class="panel-body">
                                    
                                    <?php echo $warning; ?>
                                    <form action="" method="post" id="edit-form" name="edit_form">
                                        <div class="form-group">
                                            <div id="edit-form-warning"></div>
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="id_road" id="id_road_edit" />
                                        </div>
                                        <div class="form-group">
                                            <label for="full_name_edit">Road Name</label>
                                            <input class="form-control" name="road_name" type="text" placeholder="Enter road name." id="road_name_edit" >
                                            <div id="road_name_edit_error" class="validation-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="start_from_edit">Start From</label>
                                            <input class="form-control" name="start_from" type="text" placeholder="Enter Start From." id="start_from_edit">
                                            <div id="start_from_edit_error" class="validation-error"></div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="end_to_edit">End To</label>
                                            <input class="form-control" name="end_to" type="text" placeholder="Enter End To." id="end_to_edit">
                                            <div id="end_to_edit_error" class="validation-error"></div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="distance_edit">Distance</label>
                                            <input class="form-control" name="distance" type="text" placeholder="Enter Distance." id="distance_edit">
                                            <div id="distance_edit_error" class="validation-error"></div>                                            
                                        </div>                                             
                                        <div class="form-group">
                                            <label for="ac_price_edit">A/C Price</label>
                                            <input class="form-control" name="ac_price" type="text" placeholder="Enter A/C Price." id="ac_price_edit">
                                            <div id="ac_price_edit_error" class="validation-error"></div>                                            
                                        </div> 
                                        <div class="form-group">
                                            <label for="non_ac_price_edit">Non A/C Price</label>
                                            <input class="form-control" name="non_ac_price" type="text" placeholder="Enter Non A/C Price." id="non_ac_price_edit">
                                            <div id="non_ac_price_edit_error" class="validation-error"></div>                                            
                                        </div> 
                                        <div class="form-group">
                                            <label for="discount_amount_edit">Discount Amount</label>
                                            <input class="form-control" name="discount_amount" type="text" placeholder="Enter Discount Amount." id="discount_amount_edit">
                                            <div id="discount_amount_edit_error" class="validation-error"></div>                                            
                                        </div>                                                    
                                        <div class="form-group">
                                            <label for="max_seat_needed_for_discount_edit">Max Seat Needed for discount</label>
                                            <input class="form-control" name="max_seat_needed_for_discount" type="text" placeholder="Enter Max Seat Needed For Discount." id="max_seat_needed_for_discount_edit">
                                            <div id="max_seat_needed_for_discount_edit_error" class="validation-error"></div>                                            
                                        </div> 
                                        <div class="form-group">
                                            <label for="max_seat_can_booked_edit">Max Seat Can Booked</label>
                                            <input class="form-control" name="max_seat_can_booked" type="text" placeholder="Enter Max Seat Can Booked." id="max_seat_can_booked_edit">
                                            <div id="max_seat_can_booked_edit_error" class="validation-error"></div>                                            
                                        </div>                                                                              
                                        <div class="form-group">
                                            <label for="details_edit">Road Details</label>
                                            <textarea class="form-control" name="details" placeholder="Enter Road Details" rows="6" id="details_edit"></textarea>
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