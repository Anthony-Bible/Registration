<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" async></script>

<?php 
  include 'session.php';
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
<script src="js/register.js" defer async ></script>
</head>
<body>
<?php include '../inc/navbar.php' ?>
<div class="container">
	<div class="row">
			<div class="col-sm-6">
				<img src="http://www.ads.it/wp-content/uploads/2012/10/social-network.jpg" alt="Social Network" class="img-responsive">	
			</div>
			<div class="col-xs-6">
				<form id="registerForm" action="registration.php" method="POST">
					
					<div class="form-group"><label for="firstName">First Name: </label><input class="form-control" id="firstName" type="text" name="firstName" placeholder="John"  required></div>
					<div class="form-group"><label for="lastName">Last Name: </label><input class="form-control" id="lastName" type="text" name="lastName" placeholder="Doe" required></div>
					<div class="form-group"><label for="username">Username: </label><input class="form-control" id="userName" type="text" name="username" placeholder="username" required></div>
					<div class="form-group"><label for="email">Email: </label>
					<input type="email" id="email" class="form-control" name="email" placeholder="name@example.com" validate></div>
					<div class="form-group"><label for="phone">Phone Number: </label>
					<input type="tel" id="phone" class="form-control" name="phone" placeholder="555-555-5555" pattern="1?[\s-]?\(?(\d{3})\)?[\s-]?\d{3}[\s-]?\d{4}">
					<div class="form-group"><label for="date">Date of Birth: </label> <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="date" name='date' onblur="isDateSelected()"></div>
					<div class="form-group"><label for="password">Password: </label><input class="form-control" type= "password" id="password" name='password' maxlength="50" placeholder="Password"> </div>
					<div class="form-group"><label for="retype_password">Confirm Password</label>	<input class="form-control" type="password" id="retype_password" maxlength="50"  onkeyup="checkPass(); return false;" placeholder="Renter Password"> </div>

			      
					
					
						<div id="passwords"></div>
						<div id="dates"></div>
						<div id="finalErrors">
							
						</div>
						<div id="errors">
					</div>
					<div class="g-recaptcha" data-sitekey="6LeSbokUAAAAAOGU1sjWw8Ud_MPjx-kVRJleDpE6"></div>
					<!-- <button	type="submit" value="Submit" id="registerSubmit" class="btn btn-default g-recaptcha"
						data-sitekey="6LeSbokUAAAAAOGU1sjWw8Ud_MPjx-kVRJleDpE6"
						data-size="invisible">
						Submit
					</button> -->
					<input type="submit" value="Submit" id="registerSubmit" class="btn btn-default">
				</form>
	</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>





</body>
</html>