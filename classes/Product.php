<?php
class Product {
  static function get_all_products(){
    $products = sql("SELECT * FROM products ORDER BY id");
    $products["attr_list"] = explode(",", $products["attr_list"]);
    return $products;
  }
}
?>
