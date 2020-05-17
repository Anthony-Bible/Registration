<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<!DOCTYPE math
    PUBLIC "-//W3C//DTD MathML 2.0//EN"
           "http://www.w3.org/Math/DTD/mathml2/mathml2.dtd" >
<?php 

	require(dirname(__FILE__) . "/../vendor/autoload.php");
     	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
	$dotenv->load();   

echo "<response>";
#print_r($_ENV);
if(session_status() == 1){
	session_start();
}


include_once 'functions.php';
// echo "test";
include_once 'mail/contact.php';
// include_once 'mail/test2.php';


class database{
 
  var $conn;
    //connect to the database
  function connect() {
      try {
        $user=getenv('TWITTERDBUSER');
        $pass = getenv('TWITTERDBPASS');
        $dbname=getenv('TWITTERDBNAME');
        $servername=getenv('TWITTERDBHOST');
    //connect ot database using PDO
    $this->conn = new PDO('mysql:host='.$servername.';dbname='.$dbname, $user, $pass,
          [
                PDO::ATTR_PERSISTENT            => true,
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION
            ]);
    //$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //use prepared statements for user submitted information
     return $this->conn;
	
    
    } catch (PDOException $e) {
      echo 'ERROR: '. $e->getMessage();
      echo "<br><br>";
      print_r($e);
    
    }
  }

  //this will close the database connection
  function close() {
    $this->conn = null;
  }
  
    //get the data filled out of the registration and put it in the database
  function createUser(array $values)
  {
    $link=$this->connect();    	
       
        //pass $_POST in and use that to get the values from the form
  	$first_name=$values['firstName'];
    $last_name=$values['lastName'];
    $username=$values['username'];
  	$password=$values['password'];
    $email =$values['email'];
    $dob =$values['date'];
    $phone =$values['phone'];
    	
       
    //get todays date for created date
    //will have the time set local to the server for now but will change for user's timezone
    date_default_timezone_set("America/Denver");
          
    $password=hashPassword($password);

    // Check the values to make sure there won't be duplicates
		if ((checkUsername($username, $this) || checkEmail($email, $this) || checkPhone($phone, $this))) {
			# code...

		}else{
			$sql = "INSERT INTO users (first_name, last_name, dateOfBirth, email,username, password, phone, created,modified) VALUES (:fname, :lname, :dob,:email, :username, :pass,:phone, now(),now() )";
    		$sqlData  = array(
    				  ":fname"=>$first_name,
                      ":lname"=>$last_name,
                      ":dob"=>$dob, 
                      ":email"=>$email,
                      ":username" =>$username,
                      ":pass"=> $password,
                      ":phone" =>$phone
                       );
    		 echo "<errors>".
				  " No Errors".
                  "</errors>";     
		    $stmt = $link->prepare($sql);
        $stmt->execute($sqlData);
        $userToken = $this->createToken($email,$username);
        mailVerify($userToken,$first_name,$email);
        
        // $_SESSION['user_id']=$this->getuserID($username);
            // $_SESSION['user_agent']=$_SERVER['HTTP_USER_AGENT'];

		}
    
    // redirect('wall.php');
          echo "</response>";

		
		$this->close();
  }
  
    //Get the user id for the session to pull stuff out of the database later
  function getuserID($username)
  {
    $link=$this->connect();
    $sql = 'SELECT user_id from users WHERE username = :user LIMIT 1';
   	$stmt = $link->prepare($sql);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR); 
    $stmt->execute();
    //set to fetch associative array
  	$stmt->setFetchMode(PDO::FETCH_ASSOC);
  	
    while($row = $stmt->fetch()) {
       return $row['user_id']; 
      
    }
    echo "Something went wrong, Please try again later";
  }
  function getuserIDFromEmail($email)
  {
    $link=$this->connect();
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


  
    //check username and password against those in the database
  function login($username, $password)
  {
      $link=$this->connect();

 	// for now will check username first but will allow email later.
  	
    	$sql = "SELECT * FROM users where username = :user ";
		  $stmt = $link->prepare($sql);
      $stmt->bindParam(':user', $username, PDO::PARAM_STR); 
      $stmt->execute();
			if($stmt->rowCount()<1){
  		  	//create xml for ajax to respond with wrong username

        
          echo "<errors>".
                "Wrong Username".
                "</errors>";

			}
   			 /* fetch object array */
   			 	$hashedPassword= $password;
	    		

           //set to fetch associative array
         $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
        while($row = $stmt->fetch()) {
            $hashedPassword = $row['password'];
            $userId = $row['user_id']; 
        }
   		   
   		   
   		   //verify password and set the user id in session
   		   if(password_verify($password,$hashedPassword))
   		   		{
                if ($this->isVerified($userId)){
					       $_SESSION['user_id']=$this->getuserID($username);
              		 $_SESSION['user_agent']=$_SERVER['HTTP_USER_AGENT'];
                	 echo "<errors>".
                          " No Errors".
                           "</errors>";      
                }
                else{
                  echo "<errors>".
                          " please Verify".
                           "</errors>";   
                }
            }
            else
   		   		{
              //create xml for ajax to respond with wrong password
                echo "<errors>".
                	"<![CDATA[
       				 <br />
        		]]>".
                      " Wrong Password ".
                      "</errors>";   		   			
   		   		}
          echo "</response>";

  }
  function createPost($content= '')  {
      $link=$this->connect();
    
	if (!($content=='')){
		  $sql = "INSERT INTO tweets (user_id, content, date_posted, likes, retweets) VALUES (:user, :content,now(), :likes, :retweets )";
			
    		$sqlData  = array(
    				  ":user"=>$_SESSION['user_id'],
                      ":content"=>$content,
                      ":likes"=> "0", 
                      ":retweets" => "0",
                      );
    		 echo "<errors>".
				  " No Errors".
                  "</errors>";     
		    $stmt = $link->prepare($sql);
		    $stmt->execute($sqlData);

	}else{
		 echo "<errors>".
			  "You need to enter something in the content area".
              "</errors>"; 

	}
  echo "</response>";
	
  }
  function getNewMessages($id=0){
      $link=$this->connect();

  		if($id > 0)
		{
			$sql = 'SELECT id, user_id, content, DATE_FORMAT(date_posted, "%Y-%m-%d %H:%i:%s") AS date_posted FROM tweets WHERE id > :id ORDER BY id ASC';
			$stmt =$link->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute(); 
		}
		else{
			$sql = "SELECT id, user_id, content, date_posted FROM  (SELECT id, user_id, content, ' ' DATE_FORMAT(date_posted, '%Y-%m-%d %H:%i:%s') AS date_posted FROM tweets ORDER BY id DESC LIMIT 50) AS Last50 ORDER BY id ASC";
      $stmt = $link->query($sql);
      // $stmt->prepare();
		}
		//XML RESPONSE
		// $response .= $this->isDatabaseCleared($id);
		

		if($stmt->rowCount()>0)
    {
      $result = $stmt->fetchAll();
      foreach($result as $row)
        {
          echo "<wallMessage>";
          $id = $row['id'];
          $totalLikes=$this->getLikes($row['id']);
					$user_id = $row['user_id'];
          $user_id = $this->getUsernamefromId($user_id);
					$time = $row['date_posted'];
					$content = $row['content'];
 					$response = '<id>'.$id.'</id><user_id><![CDATA['. $user_id. ']]></user_id><likesCount>'.$totalLikes.'</likesCount>'.
          	'<time>'.$time. '</time>'.
								'<content><![CDATA['. htmlentities($content, ENT_QUOTES | ENT_HTML5, 'UTF-8')
              . ']]></content>';
          echo $response;
					echo "</wallMessage>";
				}
		$this->close();
		
  }
  echo "</response>";
}
  function getUsernamefromId($user_id){
    $link=$this->connect();
    $sql = 'SELECT username from users WHERE user_id = :user LIMIT 1';
    $stmt = $link->prepare($sql);
    $stmt->bindParam(':user', $user_id, PDO::PARAM_INT); 
    $stmt->execute();
    //set to fetch associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    while($row = $stmt->fetch()) {
       return $row['username']; 
      
    }
    echo "Something went wrong, Please try again later";

}
function addLike($id){
    $link=$this->connect();
    $sql ="UPDATE tweets SET likes = likes + 1 WHERE id = :id ";
    $stmt = $link->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    //get likes and put it in xml

    echo "<totalLikes>";
    $totalLikes = $this->getLikes($id);
    echo $totalLikes;
    echo "</totalLikes>";
    echo "</response>";
  }
  function getLikes($id){
    $link = $this->connect();
    $sql = "SELECT likes from tweets where id= :id";
     $stmt = $link->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute();
    //set to fetch associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    while($row = $stmt->fetch()) {
       return $row['likes']; 
      
  }
}
function createToken($email,$username){
  $link=$this->connect();
  $currentTime=time();
  $token=md5($email.$currentTime);
  $userID=$this->getuserID($username);

  $mysqlTimeStamp=date('Y-m-d H:i:s', $currentTime);

  $sql = "INSERT INTO verification (user_id,token,timeCreated,verified) VALUES (:userId, :token, :timeCreated, 0)";
  $sqlData  = array(
        ":userId"=>$userID,
                ":token"=>$token,
                ":timeCreated"=>$mysqlTimeStamp
                 );
        
  $stmt = $link->prepare($sql);
  $stmt->execute($sqlData);
  return $token;


}
function verifyUser($token,$email){
  $link = $this->connect();
  $userId= $this-> getuserIDFromEmail($email);
    $sql = "SELECT token, timeCreated from verification where user_id=:id LIMIT 1";
    $stmt = $link->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT); 
    $stmt->execute();
    //set to fetch associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
   
    while($row = $stmt->fetch()) {
      $timeCreated=$row['timeCreated'];
      $token=$row['token']; 

      }
      
       $timeCreatedsec= strtotime($timeCreated);
      $currentTime=time();
      
      $timeSince =$currentTime-$timeCreatedsec; 
    
      
      if ($timeSince <= 86400)
      {
        echo "<verified>You are verified you can now login</verified>";
        $this->insertVerified($userId);
      }else{
        echo "<verified>Looks like you responded past 24 hours</verified>";

      }
}
function insertVerified($userID){
  $link=$this->connect();
    $sql = "update users set verified=1 where user_id=:id LIMIT 1";   
    $stmt = $link->prepare($sql);
    $stmt->bindValue(":id", $userID);
    $stmt->execute();

  

}
function isVerified($userID){
  $link=$this->connect();
    $sql = 'SELECT verified from users WHERE user_id = :user LIMIT 1';
   	$stmt = $link->prepare($sql);
    $stmt->bindParam(':user', $userID, PDO::PARAM_STR); 
    $stmt->execute();
    //set to fetch associative array
  	$stmt->setFetchMode(PDO::FETCH_ASSOC);
  	
    while($row = $stmt->fetch()) {
        $verified=$row['verified']; 
        echo $verified;
       if($verified){
         return true;
       }else{
         return false;
       }
      
    }


}

}



 ?>

