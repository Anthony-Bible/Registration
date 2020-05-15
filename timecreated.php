<?php

var $conn;
require(dirname(__FILE__) . "/vendor/autoload.php");
     	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
	$dotenv->load();   

function connect() {
    try {
      $user=getenv('TWITTERDBUSER');
      $pass = getenv('TWITTERDBPASS');
      $dbname=getenv('TWITTERDBNAME');
      $servername=getenv('TWITTERDBHOST');
  //connect ot database using PDO
  $conn = new PDO('mysql:host='. $servername.';dbname='. $dbname, $user, $pass,
        [
              PDO::ATTR_PERSISTENT            => true,
              PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION
          ]);
  //$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  //use prepared statements for user submitted information
  return conn;
  
  } catch (PDOException $e) {
    echo 'ERROR: '. $e->getMessage();
    echo "<br><br>";
    print_r($e);
  
  }
}
function insertVerified($userID){
    $link=connect();
      $sql = "update users set verified=1 where user_id=:id LIMIT 1";   
      $stmt = $link->prepare($sql);
      $stmt->bindValue(":id", $userID);
      $stmt->execute();
  
    
  
  }
function getuserIDFromEmail($email)
  {
    $link=connect();
    $sql = 'SELECT user_id from users WHERE email = :user LIMIT 1';
   	$stmt = $link->prepare($sql);
    $stmt->bindParam(':user', $email, PDO::PARAM_STR); 
    $stmt->execute();
    //set to fetch associative array
  	$stmt->setFetchMode(PDO::FETCH_ASSOC);
  	
    while($row = $stmt->fetch()) {
       return $row['user_id']; 
      
    }
    echo "Something went wrong, Please try again later";
  }

$link = connect();
$userId= getuserIDFromEmail($email);
$sql = "SELECT token, timeCreated from verification where user_id= :id";
     $stmt = $link->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT); 
    $stmt->execute();
    //set to fetch associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    while($row = $stmt->fetch()) {
      echo $timeCreated=$row['timeCreated'];
      echo  $token=$row['token']; 

      }
      $timeCreatedsec= strtotime($timeCreated);
      $timeSince =time()-$timeCreatedsec; 
      if ($timeSince <= 3600)
      {
        echo "<verified>You are verified you can now login</verified>";
        insertVerified($userId);
      }else{
        echo "<verified>Looks like you responded past one hour</verified>";

      }
      ?>
