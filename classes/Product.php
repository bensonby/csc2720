<?php
class Product {

  private $info = array(); //id, name, description, price, sample_image, attr_list(array)

  static function find($id){
    $id = intval($id);
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
    $this->info = array_merge($this->info, $info);
    $this->info["attr_list"] = explode(",", $this->info["attr_list"]);
  }

  function get_cusproduct(){
    return $this->create_cusproduct(array(), 0);
  }

  function create_cusproduct($attrs, $isValidate = 1){
    $result_main = $this->info;
    $result_main["product_id"] = $result_main["id"];
    $result_main["quantity"] = intval($attrs["quantity"]);
    unset($result_main["id"]);
    unset($attrs["quantity"]);
    switch($this->info["id"]){
      case 1: try{ return new Shirt($result_main, $attrs, $isValidate);
              }catch(Exception $e){ return false; }
      case 2: try{ return new Cup($result_main, $attrs, $isValidate);
              }catch(Exception $e){ return false; }
      case 3: try{ return new Cap($result_main, $attrs, $isValidate);
              }catch(Exception $e){ return false; }
      default: return false;
    }
  }

  static function get_all_products(){
    $products = sql("SELECT * FROM products ORDER BY id");
    foreach($products as $product) $ret[] = new Product($product);
    return $ret;
  }

  function get_id(){ return $this->info["id"]; }
  function get_name(){ return $this->info["name"]; }
  function get_description(){ return $this->info["description"]; }
  function get_price(){ return $this->info["price"]; }
  function get_sample_image(){ return $this->info["sample_image"]; }
  function get_attr_list(){ return $this->info["attr_list"]; }
}
?>
