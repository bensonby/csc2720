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
  <div id="admin-menu">
    <h2>Admin Panel</h2>
    <div class="admin-menu-item"><a href="admin_orders.php">List/Search Orders</a></div>
    <div class="admin-menu-item"><a href="admin_cusproducts.php">List/Search Customized Products</a></div>
  </div>
  <div id="admin-content">
    <form id="admin-cusproducts-search-form" action="admin_cusproducts.php" method="post">
      <h2>Search Committed Customized Products</h2>
      Leave the field empty for no restrictions<br />
      <table border="0">
        <tr><td><label for="product_ids[]">Product Types: </label>
                <select name="products_ids[]" multiple="multiple">
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
      <table border="0">
        <tr><td>Details</td><td>ID</td><td>User</td><td>Product</td><td>Quantity</td><td>Attributes</td></tr>
    <?php  foreach($cus_products as $p){ ?>
        <tr>
          <td rowspan="2"><a href="admin_cusproduct.php?id=<?php echo $p->get_id(); ?>">details</a></td>
          <td rowspan="2"><?php echo $p->get_id(); ?></td>
          <td rowspan="2"><?php echo $p->find_username(); ?></td>
          <td rowspan="2"><?php echo $p->get_name(); ?></td>
          <td rowspan="2"><?php echo $p->get_quantity(); ?></td>
          
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td><?php echo $key; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td><em><?php echo $value; ?></em></td>
          <?php } ?>
        </tr>
    <?php } ?>
    <?php } ?>
  </div>
    
</div>

<?php
include 'footer.php';
?>
