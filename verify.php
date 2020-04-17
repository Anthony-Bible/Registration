<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" async></script>

<?php 
  include(dirname(__FILE__) . "/inc/session.php");
$sess= new session();
 ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" async ></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="css/style.css">
<!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
<!-- Calling defer and async makes it load after the form is rendered helping in preventdefault() -->
</head>
<body>
<?php include 'inc/navbar.php' ?>
<?php

?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="js/verify.js"></script> -->


<?php 
include_once 'inc/database.php';
$tokentoVerify=$_GET['token'];

$emailToverify=$_GET['email'];

$emailToverify2 = urldecode($emailToverify);

 $db->verifyUser($tokentoVerify,$emailToverify);
  
?>


</body>
</html>
