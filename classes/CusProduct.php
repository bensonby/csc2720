<?php
abstract class CusProduct {
  private $info=array(); //id, product_id, name, price, description, quantity
                         //user, cart
//  private $product_id, $product_name;
  protected $attr=array(); //preset attributes
  private $custom=array(); //customized attributes input
//  private $id;
//  private $user_id;
//  private $cart_id;

  function __construct($main, $attrs, $isValidate=1){
    $this->info = array_merge($this->info, $main);
    foreach($this->attr as $key=>$value){
      if($isValidate && $key=="text" && (strlen($attrs[$key])>$value || empty($attrs[$key])))
        throw new Exception('Hacking Attempt -- customized attribute of type "text"');
      if($isValidate && $key=="image" && empty($attrs[$key]))
        throw new Exception('Hacking Attempt -- customized attribute of type "image"');
      if($isValidate && !in_array($key, array_keys($attrs)))
        throw new Exception("Hacking Attempt -- missing attribute $key");
      if($isValidate && is_array($value) && !in_array($attrs[$key], $value))
        throw new Exception("Hacking Attempt -- invalid value of attribute $key");
      $this->custom[$key]=$attrs[$key];
    }
  }

  function save(){
    if($this->is_saved()) return false;
    $str = dbstr(array('id' => '',
                       'product_id' => $this->info["product_id"],
                       'quantity'   => $this->info["quantity"]
                 ), ",", false);

    $result = sql("INSERT INTO cus_products VALUES($str)");
    if(!result) return false;
    $this->info["id"] = mysql_insert_id();

    foreach($this->attr as $attr=>$value){
      $str = dbstr(array('id' => '',
                         'cus_product_id' => $this->info["id"],
                         'attr_name' => $attr,
                         'attr_value' => $this->custom[$attr]
                   ), ",", false);
  
      $result = sql("INSERT INTO attrs VALUES($str)");
      if(!$result) return false;
    }
  
    return $this->info["id"];
  }


  function update(){
    //update the customized product in the database
    //return true/false on success/failure
    if(!$this->is_saved()) return false;
    $str = dbstr(array('product_id' => $this->info["product_id"],
                       'quantity'   => $this->info["quantity"],
                 ), ",", true);
    $result = sql("UPDATE cus_products SET $str WHERE id = {$this->info["id"]}");
    if(!$result) return false;

    foreach($this->attr as $attr){
      $str = dbstr(array('attr_name' => $attr,
                         'cus_product_id' => $this->info["id"]
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

    $result = sql("DELETE FROM cus_products WHERE id = {$this->info["id"]}");
    if(!$result) return false;

    $result = sql("DELETE FROM attrs WHERE cus_product_id = {$this->info["id"]}");
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
    $result_main = sql("SELECT c.quantity, c.id AS id, c.product_id, p.*
                        FROM cus_products c, products p
                        WHERE c.id=$id AND c.product_id=p.id", SQL_SINGLE_ROW);
    if(!$result_main) return false;

    $attrs = sql("SELECT * FROM attrs WHERE cus_product_id=$id");
    //some data processing..
    foreach($attrs as $attr) $result_attrs[$attr["attr_name"]] = $attr["attr_value"];
    if(!$result_attrs) return false;
    switch(intval($result_main["product_id"])){
      case 1: try{ return new Shirt($result_main, $result_attrs);
              }catch(Exception $e){ return false; }
      case 2: try{ return new Cup($result_main, $result_attrs);
              }catch(Exception $e){ return false; }
      case 3: try{ return new Cap($result_main, $result_attrs);
              }catch(Exception $e){ return false; }
      default: return false;
    }
  }

  function is_saved(){
    return !empty($this->info["id"]);
  }

  function get_id(){ return $this->info["id"]; }
  function get_quantity(){ return $this->info["quantity"]; }
  function get_product_id(){ return $this->info["product_id"]; }
  function get_name(){ return $this->info["name"]; }
  function get_description(){ return $this->info["description"]; }
  function get_price(){ return $this->info["price"]; }
  function get_sample_image(){ return $this->info["sample_image"]; }
  function get_attr_list(){ return $this->info["attr_list"]; }
  function get_attr(){ return $this->attr; }
}
?>
