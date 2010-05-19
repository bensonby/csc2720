<?php
include 'inc.php';

$product_id = $_GET["id"];
$product = Product::find($product_id);
if(!$product){
  log2("to find the non-existent product id: $product_id in add_product.php");
  header("Location: index.php");
  exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
  //handle add product request
  $result = add_product($user, $product, $_POST["attr"]);
  if($result){
    header("Location: cart.php");
    exit();
  }
}
$cusproduct = $product->get_cusproduct();

include 'header.php';

include 'menu.php';

echo get_msg();
?>
<div id="content">
  <h3>Customize the <?php echo $cusproduct->get_name(); ?></h3>
    <div class="products-block">
      <div class="products-img-container"><!-- perhaps 128x128 pixels? -->
        <img src="<?php echo $cusproduct->get_sample_image(); ?>" />
      </div>
      <div class="products-desc-container">
        <h4><?php echo $cusproduct->get_name(); ?></h4>
        <h5>Description: </h5>
          <span class="products-desc-text"><?php echo $cusproduct->get_description(); ?></span>
        <h5>Customizable Features: </h5>
          <span class="products-attr-list"><?php echo implode(", ", $cusproduct->get_attr_list()); ?></span>
        <h5>Price: </h5>
           <span class="products-price-text"><?php echo $cusproduct->get_price(); ?></span>
      </div>
      <div class="products-customize-container" style="clear: both;">
        <form method="post" enctype="multipart/form-data"
              action="add_product.php?id=<?php echo $cusproduct->get_product_id(); ?>">

          <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
          <label for="attr[quantity]">Quantity</label>
            <input type="text" name="attr[quantity]" value="<?php echo $_POST["attr"]["quantity"]; ?>" />
          <?php echo display_form_attr($cusproduct, $_POST); ?>
          <input type="submit" name="submit" value="Add to Cart" />

        </form>
      </div>
    </div>
  </h3>
</div>

<?
include 'footer.php';

function display_form_attr($cusproduct, $old_inputs){
  $ret = "";
  if(!$cusproduct instanceof CusProduct) return "";
  $attr = $cusproduct->get_attr();
  foreach($attr as $key=>$values){
    $ret.="<div class='products-customize-div'>\n";
    $ret.="<label for='attr[$key]'>".ucwords($key)."</label>\n";
    if($key=="image"){
//      $ret.="<input type='file' name='attr[$key]' />\n";
      $ret.="<input type='text' name='attr[$key]' value='{$old_inputs["attr"][$key]}' />\n";
    }else if($key=="text"){
      $ret.="<input type='text' name='attr[$key]' maxlength='$values' 
              value='{$old_inputs["attr"][$key]}' />\n";
    }else{
      foreach($values as $value){
        $checked = ($old_inputs["attr"][$key] == $value ? "checked='checked'" : "");
        $ret.="<input type='radio' name='attr[$key]' value='$value' $checked> $value \n";
      }
    }
    $ret.="</div>\n";
  }
  return $ret;
    
}

function add_product($user, $product, $attrs){
  $cusproduct = $product->create_cusproduct($attrs);
  if(!$cusproduct || !$cusproduct->save()){
    set_msg("Failed to create your customized product, please verify the input and try again.");
    return false;
  }
  $cart = Order::find(Order::get_orderid($user->get_id()));
  if(!$cart){
    log2("Failed to create the cart (Order) for the user {$user->get_id()}");
    set_msg("Failed to add the product to your cart. Please try again.");
    return false;
  }
  $result = $cart->add_product($cusproduct);
  if(!$result){
    set_msg("Failed to add the product to your cart. Please try again.");
    return false;
  }
  set_msg("Successfully added the product to your cart.");
  return true;
}
?>
