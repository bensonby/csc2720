<?php
include 'inc.php';

include 'header.php';

include 'menu.php';

function remove($cp_id){
  $val=Validation::own_cus_product($cp_id,$_SESSION["user_id"]);
}

function change($cp_id,$attrs){
  //$val=Validation::cus_attrs($pid,$attrs);
}

$order_id=Order::get_orderid($_SESSION['user_id']);
//echo get_msg();
//$a=Order::find($order_id);
//echo "<pre>\n";
//var_dump($a);
//echo "</pre>\n";
//die();
if (!empty($order_id)){
  $cus_product_ids=Order::find($order_id);

  foreach($cus_product_ids as $cp_id){
      $cps[]=CusProduct::find($cp_id);
  }
  print $cps[0]->get_id();
}
?>







<?php
include 'footer.php';
?>
