<?php
include 'inc.php';

//get the list of products
$products = Product::get_all_products();

include 'header.php';

include 'menu.php';

?>
<div id="index-about">

</div>

<div id="index-news">

</div>

<div id="index-products">

</div>

<?
include 'footer.php';
?>