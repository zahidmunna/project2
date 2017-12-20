<?php
session_start();
$admin_id = $_SESSION['admin_id'];
/*if ($admin_id == NULL) {
    header('Location:index.php');
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require '../classes/super_admin.php';
        $obj_super_admin = new super_admin();
        $obj_super_admin->logout();
    }
}*/
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
                                        if(isset($_GET['delid'])){
                                            $delid=$_GET['delid'];
                                            $link = mysqli_connect("localhost","root","","reservation");
                                     $query_str = "DELETE FROM user_login WHERE id=$delid";
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
                                                    <th>Full name</th>
                                                    <th>User Name </th>
                                                    <th>Email</th>
                                                    <th>phone</th>
                                                    <th>Delete</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>serial</th>
                                                    <th>Full name</th>
                                                    <th>User Name </th>
                                                    <th>Email</th>
                                                    <th>phone</th>
                                                    <th>Delete</th>
                                                </tr>
                                                
                                            </tfoot>
                                            <tbody>
                                            <?php
                                            $link = mysqli_connect("localhost","root","","reservation");

                                             $result = mysqli_query($link, "SELECT * FROM user_login ");
                                            if($result) {
                                            $sl = 1;
                                            while($row = mysqli_fetch_array( $result )) {
                                             ?>
                                            <tr>
                                               <td><?php echo $sl; ?></td>
                                               <td><?php echo $row['full_name']; ?></td>
                                               <td><?php echo $row['user_name']; ?></td>
                                               <td><?php echo $row['email']; ?></td>
                                               <td><?php echo $row['phone'] ?></td>
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

<?php include('include/footer.php'); ?>