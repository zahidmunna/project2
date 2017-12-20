<?php 
$link= mysqli_connect("localhost","root","","reservation");
  if(isset($_POST['send'])){
      $name=$_POST['name'];
      $email=$_POST['email'];
      $message=$_POST['message'];
      $address=$_POST['address'];
      $date="";
      $status="";
     
      
      $id="";
  
      $query_str="INSERT INTO tbl_message() VALUES('".$id."','".$name."','".$email."','".$message."','".$address."','".$date."','".$status."')";
      $result=  mysqli_query($link, $query_str);
      if($result){
          $msg= 'success';
      }  else {
          $msg='Something Wrong'.  mysqli_error($link);    
      }
  }

?>

<section class="call-to-action section-space-padding text-center <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ echo "padding-top-zero"; }?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">   

                <h2>Are You Looking For Hiring a bus?</h2>

                <div class="text-center margin-top-20">
                    <a class="button button-style button-style-dark button-style-icon fa fa-long-arrow-right smoth-scroll" href="#contact">Contact Us</a>
                </div>

            </div>    
        </div>
    </div>
</section>

<section id="contact" class="contact-us section-space-padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="section-title">
                    <h2>Contact Us.</h2>
                    
                </div>
            </div>
        </div>


        <div class="text-center margin-top-10 margin-bottom-50">
            <div class="row">

                <div class="col-md-4 col-sm-4">
                    <div class="contact-us-detail">  
                        <i class="fa fa-mobile color-6"></i>
                        <p><a href="tel:+8801956698968">+8801956698968</a></p>
                        <p><a href="tel:+1234567890">+1234 567 890 </a></p>
                        <p><a href="tel:+">+1234 567 890</a></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="contact-us-detail">
                        <i class="fa fa-mail-reply color-5"></i>
                        <p><a href="safayetkabir@hotmail.com">safayetkabir@hotmail.com</a></p>
                        <p><a href="safayetkabir@hotmail.com">safayetkabir@hotmail.com</a></p>
                        <p><a href="safayetkabir@hotmail.com">safayetkabir@hotmail.com</a></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="contact-us-detail">
                        <i class="fa fa-clock-o color-3"></i>
                        <p>sat - tue 09:00AM – 5:00PM</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">   
                <div class="row">
                    <form action="" method="post">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="email"  name="email" class="form-control" placeholder="Your Email">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" name="address" class="form-control" placeholder="Where are You From?">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="textarea-message form-group">
                                <textarea  class="textarea-message form-control" name="message" placeholder="Your Message" rows="5"></textarea>
                            </div>
                        </div>
                         
                        <h6><?php if(isset($msg)){    echo $msg;                     }  ?></h6>
                        
                        <div class="text-center">      
                      
                            <button type="submit" name="send" class="button button-style button-style-dark button-style-icon fa fa-long-arrow-right text-center">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">   
                <div id="my-address" class="map space-set">
                    
                    <p>Map will not be display without Internet Connection.</p>
                </div>
            </div>
        </div>
    </div>
   
</section>