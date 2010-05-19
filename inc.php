<?php
define("SQL_SINGLE_VALUE",  1000);
define("SQL_SINGLE_ROW",    1001);
define("SQL_SINGLE_COLUMN", 1002);
define("SQL_MULTIPLE_ROWS", 1003);

session_start();

spl_autoload_register('myclass__autoload');

Mysql::connect("localhost", "root", "", "csc2720");

$user = User::logged_in_user();

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

function log2($msg){
  //internal error log
  $fp = fopen("log.txt", "a");
  fwrite($fp, "Time: ".date("Y-m-d H:i:s")."\n$msg\n------------------");
  fclose($fp);
}
//$a=new Cup(array("size"=>"Medium", "type"=>"type 1", "image"=>"hello.jpg"));
//$a->save();
?>
