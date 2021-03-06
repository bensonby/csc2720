<?php
class Order {
  private $info = array(); //id, user, status, time, name, address, email, phone, price
  private $cus_products = array();

  function __construct(){
    $this->info = array("id" => '',
                        "user" => false,
                        "status" => "created",
                        "time" => time(),
                        "name" => "",
                        "address" => "",
                        "email" => "",
                        "phone" => "",
                        "price" => 0.0);
  }

  private function update_price(){
    $price = 0;
    foreach($this->cus_products as $cus_product){
      $price += $cus_product->get_quantity()*$cus_product->get_price();
    }
    $this->info["price"] = $price;
  }

  function assign_user($user){
    if(!$user instanceof User){
      log2('invalid object as a class of User when assigning user to an order');
      return false;
    }
    $this->info["user"] = $user;
    return true;
  }

  function is_saved(){
    return !empty($this->info["id"]);
  }

  function save(){
    if(empty($this->info["user"])){
      log2('Invalid User for the Cart');
      return false;
    }
    if($this->is_saved()){
      log2('Invalid action - save for a created cart');
      return false;
    }
    $str = dbstr(array('id'      => '',
                       'user_id' => $this->info["user"]->get_id(),
                       'status'  => $this->info["status"],
                       'time'    => "NOW()",
                       'name'    => $this->info["name"],
                       'address' => $this->info["address"],
                       'email'   => $this->info["email"],
                       'phone'   => $this->info["phone"],
                       'price'   => $this->info["price"]
                 ), ",", false);
    $result=sql("INSERT INTO orders VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->info["id"] = mysql_insert_id();
    return $this->info["id"];
  }

  function update(){
    if(!$this->is_saved()){
      log2('Invalid action - update for an unsaved order');
      return false;
    }
    $this->update_price();
    $str = dbstr(array('user_id' => $this->info["user"]->get_id(),
                       'status'  => $this->info["status"],
                       'time'    => "NOW()",
                       'name'    => $this->info["name"],
                       'address' => $this->info["address"],
                       'email'   => $this->info["email"],
                       'phone'   => $this->info["phone"],
                       'price'   => $this->info["price"]
                 ), ",", true);
    $result = sql("UPDATE orders SET $str WHERE id = {$this->info["id"]}");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  function delete(){
    if(!$this->is_saved()){
      log2('Invalid action - delete a non-existing order');
      return false;
    }
    $result = sql("DELETE FROM orders WHERE id = {$this->info["id"]}");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  static function find($id, $isCommitted=false){
    if(!$id) return false;

    if((string)(int)$id != (string)$id) return false;

    $id = intval($id);

    $committed_sql = ($isCommitted?"AND status='completed'":"");
    $info = sql("SELECT * FROM orders WHERE id = $id $committed_sql", SQL_SINGLE_ROW);
    if(!$info){
      log2("failed to find the order with id $id");
      return false;
    }
    $order = new Order();
    $order->info = $info;
    $order->info["user"] = new User($info["user_id"]);

    $cus_product_ids = sql("SELECT cus_product_id FROM order_products WHERE order_id= {$id}", SQL_SINGLE_COL);
    foreach($cus_product_ids as $cp_id){
      $obj = CusProduct::find(intval($cp_id));
      if($obj instanceof CusProduct) $order->cus_products[] = $obj;
    }
    return $order;
  }
  
  
  static function get_orderid($user_id){
    $result=sql("SELECT id FROM orders WHERE user_id={$user_id} AND status='created'
                   ORDER BY time DESC LIMIT 1", SQL_SINGLE_COL);
    if (!count($result)==1) return false;
    else return intval($result[0]);
  }

  static function get_orderid_from_cusproduct($cus_product_id){
    if((string)(int)$cus_product_id != (string)$cus_product_id) return false;
    $cus_product_id = intval($cus_product_id);
    $result = sql("SELECT order_id FROM order_products WHERE cus_product_id={$cus_product_id}", SQL_SINGLE_VALUE);
    if(!$result){
      log2("Find order ID from customized product Error! cus_product_id: {$cus_product_id}");
      return false;
    }
    return $result;
  }

  function add_product($cus_product){
    //both the cart and the customized product should have been saved into db
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log2('error: add_product to cart');
      return false;
    }
    $str=dbstr(array('id'=>'',
                     'cart_id'=>$this->info["id"],
                     'cus_product_id'=>$cus_product->get_id()
                    ), ",", false);
    $result=sql("INSERT INTO order_products VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->cus_products[] = $cus_product;
    return mysql_insert_id();
  }

  function remove_product($cus_product){
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
       log2('error: add_product to cart');
      return false;
    }
    $str = dbstr(array('order_id' => $this->info["id"],
                       'cus_product_id' => $cus_product->get_id()
                 ), " AND ", true);
    $result = sql("DELETE FROM order_products WHERE $str");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->update();
    $cus_product->delete();
    return true;
  }
  
  function set_name($name){
    if (!empty($name)){
        $this->info["name"]=$name;
        return true;
    }
    return false;
  }
  
  function get_id(){
    return $this->info["id"];
  }
  
  function get_cus_product(){
    return $this->cus_products;
  }  

  function get_user(){
    return $this->info["user"];
  }

  function get_time(){
    return $this->info["time"];
  }

  function get_name(){
    return $this->info["name"];
  }

  function get_address(){
    return $this->info["address"];
  }

  function get_email(){
    return $this->info["email"];
  }

  function get_phone(){
    return $this->info["phone"];
  }

  function get_price(){
    return $this->info["price"];
  }
  
  function set_address($address){
    if (!empty($address)){
        $this->info["address"]=$address;
        return true;
    }
    return false;
  }
  
  function set_email($email){
    if (!empty($email)){
        $this->info["email"]=$email;
        return true;
    }
    return false;
  }
  
  function set_phone($phone){
    if (!empty($phone)){
        $this->info["phone"]=$phone;
        return true;
    }
    return false;
  }
  
  function set_price($price){
  if (!empty($price)){
        $this->info["price"]=$price;
        return true;
    }
    return false;
  }

  static function search($info){ //array with keys: time_start, time_end, andor, email
    $info["email"] = mysql_real_escape_string($info["email"]);

    if(!preg_match('/^(19|20)\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/', $info["time_start"]))
      $info["time_start"] = "";
    if(!preg_match('/^(19|20)\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/', $info["time_end"]))
      $info["time_end"] = "";
    if($info["andor"]!="and" && $info["andor"]!="or") $info["andor"]="and";

    $time_sql = "";
    if(!empty($info["time_start"])) $time_sql = "time >= '{$info["time_start"]}'";
    if(!empty($info["time_start"])) $time_sql.= (!empty($time_sql)?" AND ":"")."time <= '{$info["time_end"]}'";
    
    $email_sql = "";
    if(!empty($info["email"])) $email_sql = "email = '{$info["email"]}'";

    if(!empty($time_sql) && !empty($email_sql)) $where_sql = " AND (".$time_sql.") ".$info["andor"]." $email_sql";
    else if(!empty($time_sql)|| !empty($email_sql)) $where_sql = " AND $time_sql $email_sql";
    else $where_sql = "";
    $result = sql("SELECT id FROM orders WHERE status='completed' $where_sql ORDER BY time DESC", SQL_SINGLE_COL);
    if(!$result){
      log2("SQL Execution Error -- ".mysql_error().": SELECT id FROM orders $where_sql");
      return array();
    }

    $ret = array();
    foreach($result as $id) $ret[] = Order::find($id);
    return $ret;
  }

  function set_status($var){
    $this->info["status"] = $var;
  }

  function get_status(){
    return $this->info["status"];
  }
}
