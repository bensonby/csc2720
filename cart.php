<?php
include 'inc.php';

include 'header.php';

include 'menu.php';

$order_id=Order::get_orderid($_SESSION['user_id']);
$cus_product_ids=Order::find($order_id);
foreach($cus_product_ids as $cp_id){
    print $cp_id;
    $cps[]=CusProduct::find($cp_id);
}
foreach($cps as $cp) print $cp[0];
?>



<?php
include 'footer.php';
?>
