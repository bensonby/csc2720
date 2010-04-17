<?php

spl_autoload_register('myclass__autoload');

Mysql::connect("localhost", "csc2720", "addoil", "csc2720");

function myclass__autoload($class_name){
  if(file_exists("classes/$class_name.php")){
    require_once("classes/$class_name.php");
  }
}

function sql($query, $limit=2){
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
    $ret.="'".str_replace("'", "\\'", $value)."'";
    $first=0;
  }
  return $ret;
}

//$a=new Cup(array("size"=>"Medium", "type"=>"type 1", "image"=>"hello.jpg"));
//$a->save();
?>
