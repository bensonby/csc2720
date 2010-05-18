<?php
class Mysql{
  static public function connect($host, $un, $pw, $db){
    if(!($link=mysql_connect($host, $un, $pw))){
      die('Cannot connect to database'); //error
    }
    mysql_select_db($db);
    mysql_query("SET NAMES utf8");
  }

  static public function query($str, $limit=SQL_MULTIPLE_ROWS){
    $result=mysql_query($str);
    if(!$result) return false;

    if($limit==SQL_SINGLE_VALUE){ //return only a single value
      if(mysql_num_rows($result)!=1) return false;
      else return mysql_result($result, 0);
    }else if($limit==SQL_SINGLE_ROW){ //return only a single row (associative array)
      if(mysql_num_rows($result)!=1) return false;
      else return mysql_fetch_assoc($result);
    }else if($limit==SQL_SINGLE_COL){ //return only a single column (numeric array)
      if(mysql_num_fields($result)!=1){
        return array();
      }else{
        $ret=array();
        while($row=mysql_fetch_array($result, MYSQL_NUM)) $ret[]=$row[0];
        return $ret;
      }
    }else{ //return multiple rows with multiple columns
      $ret=array();
      if($result!==true){
        while($row=mysql_fetch_assoc($result)) $ret[]=$row;
        return $ret;
      }else return true;
    }
  }
}
?>
