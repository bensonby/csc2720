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
if (!empty($order_id)){
  $cus_product_ids=Order::find($order_id);

  foreach($cus_product_ids as $cp_id){
      $cps[]=CusProduct::find($cp_id);
  }
}
?>







<?php
include 'footer.php';
?>
