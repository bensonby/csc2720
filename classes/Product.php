<?php
class Product {
  static function get_all_products(){
    $products = sql("SELECT * FROM products ORDER BY id");
    for($i=0; $i<count($products); $i++){
      $products[$i]["attr_list"] = explode(",", $products[$i]["attr_list"]);
    }
    return $products;
  }
}
?>
