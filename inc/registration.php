<?php
if(session_status() == 1){
	session_start();
}

include(dirname(__FILE__) . "database.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// print_r($_POST);

$db = new database;
$_SESSION['register']=$_POST;
$db ->createUser($_SESSION['register']);
?>
