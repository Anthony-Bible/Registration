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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>
<?php 

	include 'navbar.php';

 ?>

<div class="container">
	<form method="POST" action="" class="form-horizontal">
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

</div>
	
</body>
</html>

<?php
}
else{

redirect('../index.php');
}


 ?>


