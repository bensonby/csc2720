<?php
define("SQL_SINGLE_VALUE",  1000);
define("SQL_SINGLE_ROW",    1001);
define("SQL_SINGLE_COLUMN", 1002);
define("SQL_MULTIPLE_ROWS", 1003);
$allowed_for_guests = array("index.php", "about.php", "contact.php", "products.php");

session_start();

spl_autoload_register('myclass__autoload');

Mysql::connect("localhost", "csc2720", "addoil", "csc2720");
//Mysql::connect("localhost", "root", "", "csc2720");


$user = User::logged_in_user();
if(!$user instanceof User && 
   !in_array(after_last("/", $_SERVER["SCRIPT_NAME"]), $allowed_for_guests)){
  set_msg("Please login first");
  header("Location: index.php");
  exit();
}

function myclass__autoload($class_name){
  if(file_exists("classes/$class_name.php")){
    require_once("classes/$class_name.php");
  }
}

function sql($query, $limit=1003){
  return Mysql::query($query, $limit);
}

function dbstr($data, $delimiter, $isField=true){
  $first=1;
  $ret="";
  if(!is_array($data)){
    return ""; //error
  }
  foreach($data as $key=>$value){
    $ret.=($first!=1?$delimiter:"").($isField?$key."=":"");
    $ret.=($key!='time'?"'":"").str_replace("'", "\\'", $value).($key!='time'?"'":"");
    $first=0;
  }
  return $ret;
}

function set_msg($message){
  $_SESSION["msg"] = $message;
}

function get_msg(){
  $message = $_SESSION["msg"];
  unset($_SESSION["msg"]);
  return $message;
}

function has_msg(){
  return !empty($_SESSION["msg"]);
}

function log2($msg){
  //internal error log
  $fp = fopen("log.txt", "a");
  fwrite($fp, "-------------------------------------------------------\n");
  fwrite($fp, "Time: ".date("Y-m-d H:i:s")."\n$msg\n");
  fwrite($fp, print_r(debug_backtrace(), true));
  fclose($fp);
}

function display_form_attr($user, $cusproduct, $old_inputs){
  $ret = "";
  if(!$cusproduct instanceof CusProduct) return "";
  $attr = $cusproduct->get_attr();
  foreach($attr as $key=>$values){
    $ret.="<tr><td class='row1'><label for='attr[$key]'>".ucwords($key)."</label></td><td class='row2'>\n";
    if($key=="image"){
//      $ret.="<input type='file' name='attr[$key]' />\n";
      $ret.="<input type='radio' name='attr[$key]' value='0' />Upload your own photo:\n";
      $ret.="<input type='file' name='upload' /><br />\n";
      $ret.="Or select from below:<br />\n";
      $images = Image::get_available_images($user->get_id());
      $ret.="<div id='product-browse-images'>\n";
      foreach($images as $image){
        $checked = ($old_inputs["attr"][$key] == $image->get_id() ? "checked='checked'" : "");
        $ret.="<input type='radio' name='attr[$key]' value='{$image->get_id()}' $checked/>";
        $ret.="<img src='images/{$image->get_path()}' alt='images/{$image->get_path()}' />";
      }
      $ret.="</div>\n";                   
    }else if($key=="text"){
      $ret.="<input type='text' name='attr[$key]' maxlength='$values' 
              value='{$old_inputs["attr"][$key]}' />\n";
    }else{
      foreach($values as $value){
        $checked = ($old_inputs["attr"][$key] == $value ? "checked='checked'" : "");
        $ret.="<input type='radio' name='attr[$key]' value='$value' $checked /> $value \n";
      }
    }
    $ret.="</tr>\n";
  }
  return $ret;
    
}

//a set of string functions
   function after ($this, $inthat)
   {
       if (!is_bool(strpos($inthat, $this)))
       return substr($inthat, strpos($inthat,$this)+strlen($this));
   };

   function after_last ($this, $inthat)
   {
       if (!is_bool(strrevpos($inthat, $this)))
       return substr($inthat, strrevpos($inthat, $this)+strlen($this));
   };

   function before ($this, $inthat)
   {
       return substr($inthat, 0, strpos($inthat, $this));
   };

   function before_last ($this, $inthat)
   {
       return substr($inthat, 0, strrevpos($inthat, $this));
   };

   function between ($this, $that, $inthat)
   {
     return before($that, after($this, $inthat));
   };

   function between_last ($this, $that, $inthat)
   {
     return after_last($this, before_last($that, $inthat));
   };

   // USES
   function strrevpos($instr, $needle)
   {
       $rev_pos = strpos (strrev($instr), strrev($needle));
       if ($rev_pos===false) return false;
       else return strlen($instr) - $rev_pos - strlen($needle);
   };
?>
