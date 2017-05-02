<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Your wall</title>

<?php 
include 'session.php';


$sess= new session();
if($sess->checkLogin()){
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php 

	include 'navbar.php';

 ?>

<div class="container">
	<form id ="postForm" action="post.php" class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-sm-2" for="content">Content:</label>
    <div class="col-sm-10">
      <textarea  class="form-control" id="content" name="content" placeholder="Enter your log"></textarea>
    </div>
  </div>
  
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>
</form>
<div id="messages">
	<div class="Messagecontainer "></div>
</div>

</div>
<script src="js/wall.js"></script>
	
</body>
</html>

<?php
}
else{

redirect('../index.php');
}


 ?>


