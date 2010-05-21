<?php
include 'inc.php';

//get the list of products
$products = Product::get_all_products();

include 'header.php';

include 'menu.php';

?>
<div id="content">
  <?php foreach($products as $product){ ?>
    <div class="products-block">
      <div class="products-img-container">
        <img src="<?php echo $product->get_sample_image(); ?>" />
      </div>
      <div class="products-desc-container">
        <h4><?php echo $product->get_name(); ?></h4>
        <h5>Description: </h5>
          <span class="products-desc-text"><?php echo $product->get_description(); ?></span>
        <h5>Customizable Features: </h5>
          <span class="products-attr-list"><?php echo implode(", ", $product->get_attr_list()); ?></span>
        <h5>Price: </h5>
           <span class="products-price-text">HKD <?php echo $product->get_price(); ?></span>
      </div>
      <div class="products-buy-container">
        <a onclick="show_product_box(<?php echo $product->get_id(); ?>); return false" 
           href="add_product.php?id=<?php echo $product->get_id(); ?>">
          <img src="images/cart.png" alt="cart icon" /> Add to Cart
        </a>
      </div>
    </div>
  <?php } ?>

</div>

<?php
include 'footer.php';
?>
