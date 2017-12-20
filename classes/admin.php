<?php

class Admin{
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
    public function admin_login_check($data){
        $email_address=$data['email_address'];
        $password=  md5($data['password']);
        $sql="SELECT * FROM admin WHERE email='$email_address' AND password='$password'";
        if(mysqli_query($this->db_connect, $sql)){
        $query_result=  mysqli_query($this->db_connect, $sql);
        $admin_info= mysqli_fetch_assoc($query_result);
        if($admin_info){   
            $_SESSION['is_login'] = true;        
            $_SESSION['admin']=$admin_info;
            header('Location:dashboard.php');
        }  else {
            $message="your email address or password is incorrect";
            return $message;
            
        }   
    }else {
        die('Query problem :- '.mysqli_error($this->db_connect));
    }
}
}
