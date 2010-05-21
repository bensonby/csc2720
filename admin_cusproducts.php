<?php
include 'inc.php';

if(!$user->is_admin()){
  set_msg("You do not have enough permission.");
  header("Location: index.php");
  exit();
}

$products = Product::get_all_products();
if($_SERVER["REQUEST_METHOD"]=="POST") $product_ids = $_POST["product_ids"];
if(empty($product_ids)) $product_ids = array();
$cus_products = CusProduct::search($product_ids);

include 'header.php';

include 'menu.php';

?>
<div id="content">
  <div id="ajax-popup" style="display: none;">
    <div id="ajax-close"><a href="#" onclick="close_ajax()">Close</a></div>
    <div id="ajax-title">Cart Details for Customized Product ID <span id="ajax-id"> </span></div>
    <div id="ajax-loading">
      <p>Loading...</p>
      <img src="images/ajax-loader.gif" width="220" height="19" alt="Loading" />
    </div>
    <div id="ajax-body" style=""> </div>
  </div>
  <div id="admin-menu">
    <h2>Admin Panel</h2>
    <div class="admin-menu-item"><a href="admin_orders.php">Search Orders</a></div>
    <div class="admin-menu-item"><a href="admin_cusproducts.php">Search Customized Products</a></div>
  </div>
  <div id="admin-content">
    <form id="admin-cusproducts-search-form" action="admin_cusproducts.php" method="post">
      <h2>Search Committed Customized Products</h2>
      Leave the field empty for no restrictions<br />
      <table border="0">
        <tr><td><label for="product_ids[]">Product Types: </label>
                <select name="product_ids[]" multiple="multiple">
                  <?php foreach($products as $p){ ?>
                    <option value="<?php echo $p->get_id(); ?>"><?php echo $p->get_name(); ?></option>
                  <?php } ?>
            </td>
        </tr>
     </table>
     <input type="submit" name="submit" value="Search Orders" />
    </form>

    <h2>Customized Products</h2>
    <?php if(empty($cus_products)){ ?>
      No results found. Please try another search.
    <?php }else{ ?>
      <table border="0" class="collapse">
        <tr class="show-table"><td>Details</td><td>ID</td><td>User</td><td>Product</td><td>Quantity</td><td>Attributes</td></tr>
    <?php  foreach($cus_products as $p){ ?>
        <tr>
          <td class="up-and-low" rowspan="2"><a href="javascript:find_cart(<?php echo $p->get_id(); ?>)">Cart details</a></td>
          <td class="up-and-low" rowspan="2"><?php echo $p->get_id(); ?></td>
          <td class="up-and-low" rowspan="2"><?php echo $p->find_username(); ?></td>
          <td class="up-and-low" rowspan="2"><?php echo $p->get_name(); ?></td>
          <td class="up-and-low" rowspan="2"><?php echo $p->get_quantity(); ?></td>
          
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td class="up"><?php echo $key; ?></td>
          <?php } ?>
          <?php echo str_repeat("<td class='up-and-low' rowspan='2'> </td>", 5-count($p->get_attr_list())); ?>
        </tr>
        <tr>
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td class="low"><em><?php echo ($key!="image"?$value:"<a target='_blank' href='show_image.php?id=$value'>$value</a>"); ?></em></td>
          <?php } ?>
        </tr>
    <?php } ?>
    <?php } ?>
  </div>
    
</div>

<?php
include 'footer.php';
?>
