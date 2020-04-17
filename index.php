<!DOCTYPE HTML>
<head>
	
<?php 
  include(dirname(__FILE__) . "/inc/session.php");
$sess= new session();
 ?>
 <title>The Social Network</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

</head>
<body>
	<?php 
	include_once(dirname(__FILE__) . "/inc/navbar.php");

if($sess->checkLogin()){
	## DO i need to change this to match the above?
	redirect('inc/wall.php');
}
else{
 ?>






<div class="container">
	<form id="loginForm" action="inc/login.php">
		<input type="text" name="username" placeholder="username">
		<input type="password" name="password" placeholder="password" id="loginPass">
		<input type="submit" value="Submit" name="submit">
	</form>
<a href="inc/register.php">Register</a>

										<div id="errors">
											<!-- This is where any login errors will go through ajax -->
										</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>

<?php 
}
?>
