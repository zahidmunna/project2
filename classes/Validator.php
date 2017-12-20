<?php
class Validator{

    public static function isEmpty( $value ) {
        if( empty(trim($value)) && strlen(trim($value))<=0 ) {
            return true;
        }
        return false;
    }

    public static function isValidEmail( $email )
    {
        //Validate the email address
        if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email) )
        {
            return true;
        }
        return false;
    }
    public static function minLength( $value, $minLength )
    {
        //Validate the minlength of the field
        if(strlen($value) >= $minLength)
        {
            return true;
        }
        return false;
    }
    
    public static function maxLength( $value, $maxLength )
    {
        //Validate the maxLength of the field
        if(strlen($value) <= $maxLength)
        {
           return true;
        }
        return false;
    }   

    public static function alphaNumeric( $value )
    {
        //Check if the value is alphabetical and numerical
        if(!preg_match('/^([a-z0-9])+$/i', $value))
        {
            return true;
        }
        return false;
    }
    
    public static function isNumeric( $value )
    {
        //Check if the value is numeric
        if(preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $value))
        {
           return true;
        }
        return false;
    }     	
}
