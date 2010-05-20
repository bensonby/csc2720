<?php
include 'inc.php';

include 'header.php';

include 'menu.php';

function remove($order,$product){
  $val=Validation::own_cus_product($cp_id,$_SESSION["user_id"]);
  $order->remove_product($product);
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
  
  //Validation::testing("cart ",$cus_product_ids[0]->$cus_products);
  //print $cps[0]->get_id();
}
?>

<table>
<?php

?>

</table>







<?php
include 'footer.php';
?>
