<?php 
include_once(dirname(__FILE__) . "/functions.php");
require_once(dirname(__FILE__) . "/database.php");
$password=$_POST['password'];
$username=strtolower($_POST['username']);
$db = new database();
if ( isset( $_POST['submit'] ) ) { 
	$db->login($username, $password);
	// redirect('wall.php');



}else
{
	echo "You are not allowed here, we are redirecting you now";
	redirect("../index.php");
}

 ?>
