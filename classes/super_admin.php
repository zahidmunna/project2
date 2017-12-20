<?php

class super_admin{
    public function logout(){
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_id']);
        header('Location:index.php');
    }
}
class user_admin{
   public function logout(){
        unset($_SESSION['user_name']);
        unset($_SESSION['id']);
        header('Location:userlogin.php');
}
}
