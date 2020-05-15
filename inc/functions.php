<?php

// include_once 'mail/contact.php';
include_once(dirname(__FILE__) . "/database.php"); 
include_once(dirname(__FILE__) . "/mail/contact.php");
// include_once 'mail/test2.php';


error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
$db = new database();
function redirect($place)
{
	header("Location: $place");
	die();
}
function hashPassword($password)
{
	// echo 'current Version is '.phpversion();
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	return $hashedPassword;
}

//check to make sure the username is free
function checkUsername($username,$db)
{		
		$link=$db->connect();

	 	$sql = "SELECT * FROM users where username = :user ";
		
		
	   	$stmt = $link->prepare($sql);
	    $stmt->bindParam(':user', $username, PDO::PARAM_STR); 
	    $stmt->execute();
	    //set to fetch associative array
		if($stmt->rowCount()>0){
  		  	//create xml for ajax to respond with wrong username
          
            echo "<errors>".
                 "That Username is Taken ".
                 'Did you mean to 
                 <![CDATA[<a href=" ../index.php">Login?</a>
    			 ]]> '.
                 "</errors>";
            return true;


		}
            return false;


}
//check to see if email is taken
function checkEmail($email,$db){
 		$link=$db->connect();
	 	
		
		$sql = 'SELECT * from users WHERE email = :email LIMIT 1';
	   	$stmt = $link->prepare($sql);
	    $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
	    $stmt->execute();
	    //set to fetch associative array
		if($stmt->rowCount()>0){
  		  	//create xml for ajax to respond with wrong username

            echo "<errors>".
                 "That email is already in use ".
                 'Did you mean to 
                 <![CDATA[<a href=" ../index.php">Login?</a>
    			 ]]> '.
                 "</errors>";
            return true;
		}
            return false;

	

}
//check to see if phone number is taken
function checkPhone($phone,$db)
{
 		$link=$db->connect();
	 	$sql = "SELECT * FROM users where phone = :phone ";
		
		$stmt = $link->prepare($sql);
	    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR); 
	    $stmt->execute();
	    //set to fetch associative array
		if($stmt->rowCount()>0){
  		  	//create xml for ajax to respond with wrong username
         
         	echo "<errors>".
                 "That Phone number is in use ".
                 'Did you mean to 
                 <![CDATA[<a href=" ../index.php">Login?</a>
    			 ]]> '.
                 "</errors>";
            return true;


		}
            return false;

	

}
function mailVerify($usertoken,$firstname,$email){
	$secondEmail=urlencode($email);
	$_SESSION['email']=$email;
	$_SESSION['encodedEmail']=$secondEmail;

	$_SESSION['firstName']=$firstname;
	$_SESSION['token']=$usertoken;
	sendEmail();
	// testInclude3();
	// testInclude2();
}

 ?>