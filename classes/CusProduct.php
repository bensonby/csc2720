<?php
abstract class CusProduct {
  private $product_id, $product_name;
  private $attr=array(); //preset attributes
  private $custom=array(); //customized attributes input
  private $id;
  private $user_id;
  private $cart_id;

  function __construct($main, $attrs){
    foreach($this->attr as $key=>$values){
      if(!in_array($key, array_keys($attrs))) die('Hacking Attempt!');
      if(!in_array($attributes[$key], $this->attr[$key])) die('Hacking Attempt!');
      $this->custom[$key]=$attributes[$key];
    }
  }

  function save(){
    if($this->is_saved()) return false;
    $str = dbstr(array('id' => '',
                       'product_id' => $this->product_id,
                       'quantity'   => $this->quantity
                 ), ",", false);
    $result = sql("INSERT INTO cusproducts VALUES($str)");
    if(!result) return false;
    $this->id = mysql_insert_id();

    foreach($this->attr as $attr){
      $str = dbstr(array('id' => '',
                         'cus_product_id' => $this->id,
                         'attr_name' => $attr,
                         'attr_value' => $this->custom[$attr]
                   ), ",", false);
  
      $result = sql("INSERT INTO attrs VALUES($str)");
      if(!$result) return false;
    }
  
    return $this->id;
  }


  function update(){
    //update the customized product in the database
    //return true/false on success/failure
    if(!$this->is_saved()) return false;
    $str = dbstr(array('product_id' => $this->product_id,
                       'quantity'   => $this->quantity
                 ), ",", true);
    $result = sql("UPDATE cus_products SET $str WHERE id = {$this->id}");
    if(!$result) return false;

    foreach($this->attr as $attr){
      $str = dbstr(array('attr_name' => $attr,
                         'cus_product_id' => $this->id
                   ), ",", true);
      $result = sql("UPDATE attrs SET attr_value = {$this->custom[$attr]}
                     WHERE $str");
      if(!$result) return false;
    }

    return true;
  }

  function delete(){
    //remove the customized product in the database
    //return true/false on success/failure
    if(!$this->is_saved()) return false;

    $result = $this->cart->remove_product($this);
    if(!$result) return false;

    $result = sql("DELETE FROM cus_products WHERE id = {$this->id}");
    if(!$result) return false;

    $result = sql("DELETE FROM attrs WHERE cus_product_id = {$this->id}");
    if(!$result) return false;

    return true;
  }

  static function find($id){
    //create the object CusProduct of the specific type from reading the database for the id
    //return the object/false on success/failure

    if((string)(int)$id != (string)$id){
      log2("invalid ID passed to CusProduct::find -- $id");
      return false;
    }
    $result_main = sql("SELECT * FROM cus_products WHERE id=$id", SQL_SINGLE_ROW);
    if(!$result_main) return false;

    $attrs = sql("SELECT * FROM attrs WHERE cus_product_id=$id");
    //some data processing..
    foreach($attrs as $attr) $result_attrs[$attr["attr_name"]] = $attr["attr_value"];

    switch($result["product_id"]){
      case 1: return new Shirt($result_main, $result_attrs);
      case 2: return new Cup($result_main, $result_attrs);
      case 3: return new Cap($result_main, $result_attrs);
      default: return false;
    }
  }

  function is_saved(){
    return !empty($this->id);
  }

  function display_form(){
    //generate an HTML form according to the customizable attributes of the product
    //return an HTML string
  }
}
?>
