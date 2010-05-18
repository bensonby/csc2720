<?php
include 'inc.php';

//get the list of products
$products = Product::get_all_products();

include 'header.php';

include 'menu.php';

?>
<div id="content">
  <? foreach($products as $product){ ?>
    <div class="products-block">
      <div class="products-img-container"><!-- perhaps 128x128 pixels? -->
        <img src="<?=$product["sample_image"] ?>" />
      </div>
      <div class="products-desc-container">
        <h4><?=$product["name"] ?></h4>
        <h5>Description: </h5>
          <span class="products-desc-text"><?=$product["description"] ?></span>
        <h5>Customizable Features: </h5>
           <span class="products-attr-list"><?=implode(", ", $product["attr_list"]) ?></span>
        <h5>Price: </h5>
           <span class="products-price-text"><?=$product["price"] ?></span>
      </div>
    </div>
  <? } ?>

</div>

<?
include 'footer.php';
?>
