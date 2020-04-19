<?php

include(dirname(__FILE__) . "/database.php");
if(session_status() == 1){
	session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['content'])){
	$db = new database;
	$content=$_POST['content'];
	$db ->createPost($content);
}else{
	echo "you aren't allowed to be here";
	redirect("../index.php");
}

?>
