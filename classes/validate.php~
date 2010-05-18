<?php
class Validation {

  static function email($subject){
    $pattern = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/i';
    $num=preg_match($pattern, $subject); 
    if ($num==0)
        return false;
    return true;
  }

  static function phone($subject){
    $pattern = '/^[0-9]{8}/';
    $num=preg_match($pattern, $subject); 
    if ($num==0)
        return false;
    return true;
  }
  
  static function name($subject){
    $pattern = '/^[A-Za-z][A-Za-z ]+[A-Za-z]$/';
    $num=preg_match($pattern, $subject); 
    if ($num==0)
        return false;
    return true;
  }

}

?>
