<?php
class User {
  private $id;

  function __construct($id){
  }

  function is_admin(){
  }

  function get_id(){
    return $this->id;
  }

  static function is_logged_in(){
    return @isset($_SESSION["user_id"]);
  } 

}
?>
