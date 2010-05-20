<?php
include 'inc.php';

include 'header.php';

include 'menu.php';

function remove($cp_id){
  $val=Validation::own_cus_product($cp_id,$_SESSION["user_id"]);
  if ($val){
    $cus_pro=CusProduct::find($cp_id);
    $order->remove_product($cus_pro);
  }
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
  
  $cus_products=$cus_product_ids->get_cus_product();
  //Validation::testing("cus_product",$cus_products); 
  foreach($cus_products as $cp){
    print $cp->get_id()."<br>";
    print $cp->get_quantity()."<br>";
    print $cp->get_product_id()."<br>";
    print $cp->get_name()."<br>";
    print $cp->get_description()."<br>";
    print $cp->get_price()."<br>";
    print $cp->get_sample_image()."<br>";
    
    print "<table>";
    foreach($cp->get_custom() as $name=>$cus){
      print "<tr><th>".$name."</th><td>".$cus."</td></tr>";    
    }
    print "</table>";
    print "<br>";
  }
  
$val=Validation::own_cus_product(2,$_SESSION["user_id"]);
var_dump($val);
}
?>

<table>
<?php

?>

</table>







<?php
include 'footer.php';
?>
