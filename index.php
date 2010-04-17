<?php
include 'inc.php';

$is_logged_in = User::is_logged_in();

if(!$is_logged_in){
  header("Location: login.php");
  die();
}


include 'header.php';

include 'footer.php';
?>
