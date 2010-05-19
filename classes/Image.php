<?php
class Image {
  private $info=array(); //id, path, owner
  function __construct($info){
    //provide all the 3 columns for Image::find;
    //provide only path and owner for user creation, and then save
    $this->info = $info;
  }

  static function find($id){
    $id = intval($id);
    $result = sql("SELECT * FROM images WHERE id = $id", SQL_SINGLE_ROW);
    if(!$result) return false;
    return new Image($result);
  }

  static function get_available_images($user_id){
    $ret=array();
    $results = sql("SELECT * FROM images WHERE owner=0 OR owner=$user_id");
    foreach($results as $result){
      $ret[] = new Image($result);
    }
    return $ret;
  }

  static function process_image($arr, $user){
    //save the uploaded image to database, return new Image id or error code on success/failure
    //$arr is the same as $_FILES['upload']
    if(@!isset($arr)) return 0;
    if($arr['error'] > 0) return -1;
    $allowed_types = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png');
    if(!in_array($arr['type'], $allowed_types)) return -2;
    $new_filename = time()."_".$arr['name'];
    if(!move_uploaded_file($arr['tmp_name'], "images/$new_filename")) return -3;
    if(file_exists($arr['tmp_name']) && is_file($arr['tmp_name'])) unlink($arr['tmp_name']);
    $image = new Image(array("path" => $new_filename, "owner" => $user->get_id()));
    $result = $image->save();
    if(!$result) return -4;
    return $result;
  }

  function save(){
    if(!empty($this->info["id"])) return false;
    $str = dbstr(array("id" => '',
                       "path" => $this->info["path"],
                       "owner" => $this->info["owner"]
                 ), ",", false);
    $result = sql("INSERT INTO images VALUES($str)");
    if(!$result) return false;
    $this->info["id"] = mysql_insert_id();
    return $this->info["id"];
  }

  function get_id(){ return $this->info["id"]; }
  function get_path(){ return $this->info["path"]; }
  function get_owner(){ return $this->info["owner"]; }
}
