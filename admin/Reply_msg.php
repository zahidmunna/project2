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
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $to=$_POST['toEmail'];
    $form=$_POST['FormEmail'];
    $message=$_POST['message'];
    $Sendmail=  mail($to, $form, $message);
    if($Sendmail){
        echo "<span class='success'>Message sent successfully</span>";
    }else{
                echo "<span class='success'>Something Wrong</span>";

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
                            <a href="#"><i class="fa fa-bar-chart-o"></i>My Link Two</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-edit "></i>My Link Three </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table "></i>My Link Four</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit "></i>My Link Five </a>
                        </li>
                    </ul>
                </div>

            </nav>
            <!-- /. NAV SIDE  -->

             <div id="page-wrapper" >
                 <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            
              
                 <div class="block">
                     <form action="" method="post">
                          <?php
                                            $link = mysqli_connect("localhost","root","","reservation");


                                            $id= $_GET['id'];
                                             $result = mysqli_query($link, "SELECT * FROM tbl_message WHERE ID='$id'");
                                            if($result) {
                                            $sl = 1;
                                            while($row = mysqli_fetch_array( $result )) {
                                             $sl++;   
                                            
                                             ?>
                         <table class="form">
                             <tr>
                                 <td>
                                     <label>Name</label>
                                 </td>
                                 <td>
                                     <input type="text" value="<?php echo $row['name']; ?>"class="medium" style="width: 250px;" />
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     <label>TO</label>
                                 </td>
                                 <td>
                                     <input type="email" name="toEmail" value="<?php echo $row['email']; ?>" class="medium" style="width: 250px;"/>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     <label>form</label>
                                 </td>
                                 <td>
                                     <input type="text" name="FormEmail" placeholder="Enter your Email" class="medium" style="width: 250px;"/>
                                 </td>
                             </tr>
                             
                             <tr>
                                 <td>
                                     <label>message</label>
                                 </td>
                                 <td>
                                     <textArea class="tinymce" name="message">
                                       
                                         
                                     </textArea>
                                 </td>
                             </tr>
                             <tr>
                                 <td></td>
                                 <td><input type="submit" name="submit" value="send"</td>
                             </tr>
                             
                         </table>
                         
                                            <?php
                                            }
                                            }
                                            ?>
                         
                         
                     </form>
                 </div>
                        </div>
                    </div>
                     
                     
                     
                     
                 </div>
                 
             </div>              
                  
        </div>


        <!-- /. WRAPPER  -->
        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        
        <!-- JQUERY SCRIPTS -->
      
        <script src="../assets/admin_assets/js/tinymce/tinymce.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(Document).ready(function(){
               setuoTINYMCE();
               setDatePicker('date-picker');
               $('input[type="checkbox"]').fancybutton();
               $('input[type="radio"]').fancybutton();

            });
        
        </script>
        <script src="../assets/admin_assets/js/jquery-1.12.3.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/admin_assets/js/bootstrap.min.js"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/admin_assets/js/custom.js"></script>
        <script src="../assets/admin_assets/js/tables.js"></script>


    </body>
