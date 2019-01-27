<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once  'functions.php';
class session{
	function checkLogin()
    {

        if (isset($_SESSION['user_id'])) {
            return True;
  
		} else {
		   return False; 
		}
    }
    function logout()
    {
    	$_SESSION['user_id']='45jk54145kjkCRAP';
    	session_destroy();

    }


}


 ?>