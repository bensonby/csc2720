<?php
class Product {

  static function find($id){
    $id = mysql_real_escape_string($id);
    if(empty($id)) return false;
    $result = sql("SELECT * FROM products WHERE id = $id", SQL_SINGLE_ROW);
    if(!$result){
      log2("Invalid SQL query -- ".mysql_error().": id = $id");
      return false;
    }
    $ret = new Product($result);
    return $ret;
  }

  private function __construct($info){
    $this->name = $info["name"];
    $this->description = $info["description"];
    $this->price = $info["price"];
    $this->sample_image = $info["sample_image"];
    $this->attr_list = explode(",", $info["attr_list"]);
  }

  static function get_all_products(){
    $products = sql("SELECT * FROM products ORDER BY id");
    foreach($products as $product) $ret[] = new Product($product);
    return $ret;
  }

  function get_id(){ return $this->id; }
  function get_name(){ return $this->name; }
  function get_description(){ return $this->description; }
  function get_price(){ return $this->price; }
  function get_sample_image(){ return $this->sample_image; }
  function get_attr_list(){ return $this->attr_list; }
}
?>
