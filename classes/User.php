<?php
class User {
  private $id;
  private $username;
  private $is_admin;

  function __construct($id){
    $info = sql("SELECT * FROM users WHERE id = $id", SQL_SINGLE_ROW);
    $this->id = $id;
    $this->username = $info["username"];
    $this->is_admin = (intval($info["is_admin"]) == 1);
  }

  function is_admin(){
    return $this->is_admin;
  }

  function get_id(){
    return $this->id;
  }

  function get_name(){
    return $this->username;
  }

  static function logged_in_user(){
    if(@isset($_SESSION["user_id"])) return new User($_SESSION["user_id"]);
    else return false;
  }

  function assign_order($order){
    //assign an order to the user
    //return true/false on success/failure
    if(!$order instanceof Order){
      log2('order is not an instance of Order when calling assign_order for a user');
      return false;
    }
    $this->order = $order;
    return $order->assign_user($this);
  }

  static function auth($username, $password){
    $username = mysql_real_escape_string($username);
    $password = md5($password);
    $ids = sql("SELECT id FROM users 
                     WHERE username = '$username' AND
                           password = '$password'", SQL_SINGLE_COL);
    if(!count($ids)==1) return false;
    else return intval($ids[0]);
  }

}
?>
