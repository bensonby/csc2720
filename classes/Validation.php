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
  
  static function own_cus_product($cp_id,$uid){
    $result=sql("SELECT orders.id 
                 FROM orders od, order_products op 
                 WHERE od.user_id=$uid and od.id=op.order_id and op.cus_product_id=$cp_id");
    if (!count($result)==1)
      return false;
    return true;
  }
  
  static function cus_attrs($pid,$attrs){
    $result=sql("SELECT * FROM `products` WHERE attr_list LIKE '$attrs' and id=$pid");
    if (!count($result)==1)
      return false;
    return true;
  }
  
  static function testing($sign,$var){
    print "<br><b> $sign test start=> </b>";
    var_dump($var);
    print " <=<b>test end</b><br>";
  }
  

}

?>
