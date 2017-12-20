<?php

class User {

    private $db_connect;
    public function __construct() {
      $host_name='localhost';
      $user_name='root';
      $password='';
      $db_name='reservation';
      
      $this->db_connect=  mysqli_connect($host_name,$user_name,$password,$db_name);
      if(!$this->db_connect){
          die('connection failed'.  mysqli_error($this->db_connect)); 
      }   
    }

    public function UserRegistration($data) {
        $id="";
        $full_name = $data['full_name'];
        $user_name = $data['user_name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $password=  md5($data['password']);
        $Con_password = md5($data['Con_password']);
        $chk_email=  $this->Checkemail($email);
        if($full_name=="" OR $user_name=="" OR $email=="" OR $phone=="" OR $password=="" OR $Con_password==""){
            $msg="<div class='alert alert-danger'><strong>ERROR! </strong>Field must'nt be empty</div>";
            return $msg;
        }
        
        if($chk_email==true){
            $msg="<div class='alert alert-danger'><strong>Sorry  ! </strong>the email address already exist</div>";
            return $msg;
            
        }
        if ($password == $Con_password) {
           
            $query_str = "INSERT INTO user_login () VALUES ('".$id."','". $full_name . "', '" . $user_name . "','" . $email . "','" . $phone. "','".$password."')";
            $result = mysqli_query($this->db_connect, $query_str);
            if ($result) {
                $msg="<div class='alert alert-success'><strong>successfully </strong>inserted </div>" ;
                return $msg;
            } else {
                $msg= "someting wrong. " . mysqli_error($this->db_connect);
                return $msg;
            }
        } else {
            $msg= "Password and Confirm PASSWORD NEED TO MATCH";
            return $msg;
        }
    }
    public function Checkemail($email){
        $query_str="SELECT email FROM user_login WHERE email='".$email."'";
        $result=  mysqli_query($this->db_connect, $query_str);
        if($result){
                return true;
            } else {
              
                return false;
            }
    }


    
    public function User_login_check($data){
        $email=$data['email'];
        $password=  md5($data['password']);
        $sql="SELECT * FROM user_login WHERE email='$email' AND password='$password'";
        if(mysqli_query($this->db_connect, $sql)){
        $query_result=  mysqli_query($this->db_connect, $sql);
        $user_info= mysqli_fetch_assoc($query_result);
        if($user_info){
            session_start();
            $_SESSION['user_name']=$user_info['user_name'];
            $_SESSION['id']=$user_info['id'];
            header('Location:Usersite.php');
        }  else {
            $message="your email address or password is incorrect";
            return $message;
            
        }   
    }else {
        die('Query problem'.mysqli_error($this->db_connect));
          }
  }

}

