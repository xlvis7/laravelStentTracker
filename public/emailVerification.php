<?php 
	include 'core/init.php';
	logged_in_redirect();
	include 'includes/overall/header.php';

	if(isset($_GET['email']) && isset($_GET['activationKey']))
	{
		$email = $_GET['email'];
		$emailSanitized = sanitize($email);

		$regDate = mysql_result(mysql_query("SELECT `Registration_DateTime` FROM `users` WHERE `email` = '$emailSanitized'"),
			 0, 'Registration_DateTime');

		$expiryDate = date('Y-m-d H:i:s', strtotime( "$regDate + 1 day" ));
		
		// echo $regDate . "|";
		// echo $expiryDate . "|";
		// echo date("Y-m-d H:i:s");

		if ($expiryDate > date("Y-m-d H:i:s")){ //within 24 hours

			$keyUnhashed = $email . $regDate;
			$keyHashed = md5($keyUnhashed);

			if ($keyHashed == $_GET['activationKey']){ //valid activation key
				// change the isEmailVerified to true
				verifyEmail($emailSanitized);
				echo "Email verification success. You can log in now";
			} else {
				echo "Invalid email verification code";
			}
		} else {
			echo "Expired email verification code";
		}
	}
?>
<?php
   include 'includes/overall/footer.php';?>