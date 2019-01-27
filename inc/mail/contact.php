<?php
// namespace SendGrid;
require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

 use \SendGrid\Mail\From as From;
 use \SendGrid\Mail\To as To;
 use \SendGrid\Mail\Subject as Subject;
 use \SendGrid\Mail\PlainTextContent as PlainTextContent;
 use \SendGrid\Mail\HtmlContent as HtmlContent;
 use \SendGrid\Mail\Mail as Mail;
 use \SendGrid\Mail\Personalization as Personalization;

	
	function setParamsEmail(){
		/* This sets all neccessary details for the email. The more settings the better, 
		this will help prevent it from going into the spam folder. */
		
		//set the details 
		$senderName= "Anthony Bible";
		$senderEmail="howdy@anthonybible.com";
		$senderEmail2="anthony@anthonybible.com";

		
		$recieverEmail = $_SESSION['email'];
		$encodedEmail=$_SESSION['encodedEmail'];
		$firstname = $_SESSION['firstName'];
		$usertoken = $_SESSION['token'];
		$subject = "Endixium Quote";
		$from = new From($senderEmail, $senderName);

		$tos = [
			new To(
				$recieverEmail,
				$firstname,
				[
					'subject' => 'Thank you for signing up!',
					'header' => 'Welcome!',
					'name' => $firstname,
					'email' => $recieverEmail,
					'encodedEmail'=>$encodedEmail,
					'token' => $usertoken
					
				]
			)
		];
		$email = new Mail($from, $tos);


		



	    //set spam settings
		$mail_settings = new \SendGrid\Mail\MailSettings();
	    $spam_check = new \SendGrid\Mail\SpamCheck();
	    $spam_check->setEnable(true);
	    $spam_check->setThreshold(1);
	    $spam_check->setPostToUrl("https://spamcatcher.sendgrid.com");
	    $mail_settings->setSpamCheck($spam_check);
	    $email->setMailSettings($mail_settings);


	    //set tacking settings
	    $tracking_settings = new \SendGrid\Mail\TrackingSettings();
	    $click_tracking = new \SendGrid\Mail\ClickTracking();
	    $click_tracking->setEnable(true);
	    $click_tracking->setEnableText(true);
	    $tracking_settings->setClickTracking($click_tracking);
	    $open_tracking = new \SendGrid\Mail\OpenTracking();
	    $open_tracking->setEnable(true);
	    $tracking_settings->setOpenTracking($open_tracking);
	    $subscription_tracking = new \SendGrid\Mail\SubscriptionTracking();
	    $subscription_tracking->setEnable(true);
	    $tracking_settings->setSubscriptionTracking($subscription_tracking);
	    $ganalytics = new \SendGrid\Mail\Ganalytics();
	    $ganalytics->setEnable(true);
	    $ganalytics->setCampaignSource("contactForm");
	    $ganalytics->setCampaignContent("Contactfrom");
	    $ganalytics->setCampaignName("ContactForm");
	    $ganalytics->setCampaignMedium("web");
	    $tracking_settings->setGanalytics($ganalytics);
		$email->setTrackingSettings($tracking_settings);
	    

	    $reply_to = new \SendGrid\Mail\ReplyTo("anthony@anthonybible.com");
		$email->setReplyTo($reply_to);
		$email->setTemplateId("d-aa8eb7292c184c67adf418f69a6e6b32");
		
		return $email;
	  }

function sendEmail(){
	$apikey = getenv('SENDGRID_API_KEY');
	$sg = new \SendGrid(getenv('SENDGRID_API_KEY'));
	
	// start pre debugging******************************
	
	$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
	$request_body =setParamsEmail();
	try 
		{
			/* We've set all the parameters, it's now time to send it. To do this we just check the captcha response. If they failed we won't send the mail. This has dramatically reduced the spam to almost zero */
			
			
			// $captchaResponse=$_POST["captcha"];
		
			echo "<message>";

			// $verifyUrl="https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captchaResponse";
			// $verify=file_get_contents($verifyUrl);
				// $captcha_success=json_decode($verify);
				// if ($captcha_success->success==false) {			
					// echo "Looks like the robot overlords deterimined you were a bot, please try the Recaptcha again";
				// }
				
				// if ($captcha_success->success==true) {
				//This user is verified by recaptcha
				$response = $sendgrid->send($request_body);
				echo "<h3>Please check your email for verification</h3>";



				// }

			
			echo "</message>";
			
			

		}
	 catch (Exception $e) {
	
			echo "<response>";
			echo "<message>";
			echo "Unable to send mail: ", $e->getMessage();
			echo "</message>";
			echo "</response>";
			
	}
	// function sendEmail(){
	// echo "<errors>"."debugging"."</errors>";
}











?>