<?php

include(dirname(__FILE__) . "/database.php");
if(session_status() == 1){
	session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['id'])){
	$db = new database;
	$id=$_POST['id'];
	$db ->addLike($id);
}else{
	echo "you aren't allowed to be here";
	redirect("../index.php");
}

?>
