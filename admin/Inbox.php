<?php
session_start();
$admin_id = $_SESSION['admin_id'];
if ($admin_id == NULL) {
    header('Location:index.php');
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require '../classes/super_admin.php';
        $obj_super_admin = new super_admin();
        $obj_super_admin->logout();
    }
}
?>




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title> Admin panel</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="../assets/admin_assets/css/bootstrap.min.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="../assets/admin_assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="../assets/admin_assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        
        <link href="../assets/admin_assets/css/datatable.css" rel="stylesheet" />
    </head>
    <body>



        <div id="wrapper">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="adjust-nav">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">
                            <img src="../assets/admin_assets/img/logo.png" />
                        </a>
                    </div>

                    <span class="logout-spn" >
                        <a href="?status=logout" style="color:#fff;">LOGOUT</a>  

                    </span>
                </div>
            </div>
            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">


                        <li >
                            <a href="admin_master.php" ><i class="fa fa-desktop "></i>Dashboard <span class="badge">Included</span></a>
                        </li>


                        <li>
                            <a href="ui.html"><i class="fa fa-table "></i>UI Elements  <span class="badge">Included</span></a>
                        </li>
                        <li class="active-link">
                            <a href="blank.html"><i class="fa fa-edit "></i>Blank Page  <span class="badge">Included</span></a>
                        </li>



                        <li>
                            <a href="inbox.php"><i class="fa fa-qrcode "></i>inbox</a>
                        </li>
                        <li>
                            <a href="Userlist.php"><i class="fa fa-bar-chart-o"></i>User List</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-edit "></i>My Link Three </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table "></i>My Link Four</a>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-edit "></i>My Link Five </a>
                        </li>
                    </ul>
                </div>

            </nav>
            <!-- /. NAV SIDE  -->

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-6">
                                <div class="content-box-large">
                                    <div class="panel-heading">
                                        <div class="panel-title">Message</div>
                                        <?php
                                        
                                        $link = mysqli_connect("localhost","root","","reservation");
                                         if(isset($_GET['seenid'])){
                                         $seenid = $_GET['seenid'];
    
    //$id="";
    
                                         $query_str = "UPDATE tbl_message SET status='1' WHERE id=$seenid";
                                         $result = mysqli_query($link,$query_str);
                                         if($result)
                                         {
                                             
                                        echo "<span class='success'>Send success fully</span>";
                                            }  else {
                                                echo "<span class='error'>Message not sent </span>";
    
                                            }
                                         }
      
                                          
                                       
                                        
                                        ?>
                                       <?php
                                        if(isset($_GET['delid'])){
                                            $delid=$_GET['delid'];
                                            $link = mysqli_connect("localhost","root","","reservation");
                                     $query_str = "DELETE FROM tbl_message WHERE id=$delid";
                                     $result = mysqli_query($link,$query_str);
                                     if($result)
                                       {
                                        echo "<span class='success'>Delete success fully</span>";
                                            }  else {
                                                echo "<span class='error'>Message not deleted </span>";
    
                                            }
      
                                    }
                                        ?>
                                        
                                        
                                        <table  id="example" class="display" >
                                            <thead>
                                                <tr>
                                                    <th>serial</th>
                                                    <th>name</th>
                                                    <th>Email</th>
                                                    <th>address</th>
                                                    <th>Message</th>
                                                    <th>date</th>
                                                    <th>Viewing</th>
                                                    <th>Sending</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>serial</th>
                                                    <th>name</th>
                                                    <th>Email</th>
                                                    <th>address</th>
                                                    <th>Message</th>
                                                    <th>date</th>
                                                    <th>Viewing</th>
                                                    <th>Sending</th>
                                                    <th>Delete</th>
                                                </tr>
                                                
                                            </tfoot>
                                            <tbody>
                                            <?php
                                            $link = mysqli_connect("localhost","root","","reservation");

                                             $result = mysqli_query($link, "SELECT * FROM tbl_message where status='0'");
                                            if($result) {
                                            $sl = 1;
                                            while($row = mysqli_fetch_array( $result )) {
                                             ?>
                                            <tr>
                                               <td><?php echo $sl; ?></td>
                                               <td><?php echo $row['name']; ?></td>
                                               <td><?php echo $row['email']; ?></td>
                                               <td><?php echo $row['address']; ?></td>
                                               <td><?php echo $row['message'] ?></td>
                                               <td><?php echo $row['date'] ?></td>
                                               <td><a class="btn btn-primary" href="Viewing.php?id=<?php echo $row['id'];?>">Viewing</a></td>
                                               <td ><a class="btn btn-default" href="Reply_msg.php?id=<?php echo $row['id'];?>">Reply</a></td>

                                               <td><a class="btn btn-success" onclick="return confirm('Are you suer to Sent!');" href="?seenid=<?php echo $row['id'];?>">Seen</a></td>

                                       
                                        
                                               

                                            
                                            </tr>
                                            <?php
                                               $sl++;
                                            }
                                           }
                                           else{
                                           echo mysqli_error ($link);
                                           }       
                                           ?>
                                                
                                            
                                            
                                            </tbody>
                                            
                                            
                                        </table>
                                        

                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>              
                    <!-- /. ROW  -->
                    <hr />

                    <!-- /. ROW  -->           
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-6">
                                <div class="content-box-large">
                                    <div class="panel-heading">
                                        <div class="panel-title"> <i class="success">Seen Message</i></div>
                                       
                                        
                                        
                                        <table  id="mytable" class="display"  >
                                            <thead>
                                                <tr>
                                                    <th>serial</th>
                                                    <th>name</th>
                                                    <th>Email</th>
                                                    <th>address</th>
                                                    <th>Message</th>
                                                    <th>date</th>
                                                    
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>serial</th>
                                                    <th>name</th>
                                                    <th>Email</th>
                                                    <th>address</th>
                                                    <th>Message</th>
                                                    <th>date</th>
                                                    
                                                    <th>Delete</th>
                                                </tr>
                                                
                                            </tfoot>
                                            <tbody>
                                            <?php
                                            $link = mysqli_connect("localhost","root","","reservation");

                                             $result = mysqli_query($link, "SELECT * FROM tbl_message where status='1'");
                                            if($result) {
                                            $sl = 1;
                                            while($row = mysqli_fetch_array( $result )) {
                                             ?>
                                            <tr>
                                               <td><?php echo $sl; ?></td>
                                               <td><?php echo $row['name']; ?></td>
                                               <td><?php echo $row['email']; ?></td>
                                               <td><?php echo $row['address']; ?></td>
                                               <td><?php echo $row['message'] ?></td>
                                               <td><?php echo $row['date'] ?></td>
			                       
                                               <td><a class="btn btn-warning" onclick="return confirm('Are you suer to Delete!');"
                                                      href="?delid=<?php echo $row['id'];?>">Delete</a></td>
                                       
                                        
                                               

                                            
                                            </tr>
                                            <?php
                                               $sl++;
                                            }
                                           }
                                           else{
                                           echo mysqli_error ($link);
                                           }       
                                           ?>
                                                
                                            
                                            
                                            </tbody>
                                            
                                            
                                        </table>
                                        

                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>              
                    <!-- /. ROW  -->
                    <hr />

                    <!-- /. ROW  -->           
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>

        <div class="footer">


            <div class="row">
                <div class="col-lg-12" >
                    &copy;  2014 yourdomain.com | Design by: <a href="http://binarytheme.com" style="color:#fff;"  target="_blank">www.binarytheme.com</a>
                </div>
            </div>
        </div>



        <!-- /. WRAPPER  -->
        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        
        <script src="../assets/admin_assets/js/jquery-1.12.3.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/admin_assets/js/bootstrap.min.js"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/admin_assets/js/custom.js"></script>
        
        <script src="../assets/admin_assets/js/jquery.datatable.js"></script>

        <script>
                $(document).ready(function() {
                $('#example').DataTable();
                } );
        
        </script>
        <script>
                $(document).ready(function() {
                $('#mytable').DataTable();
                } );
        
        </script>

    </body>
