
<?php 
include 'core/init.php';
protect_page();

   function change_passwordHere($user_id, $password)
{

		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", "")or die($connect_error);
			mysql_select_db("seru_students")or die($connect_error);
			
	$user_id = (int)($user_id);
	$password = md5($password);

	$myquery = "UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id";
	
		$sqlhere = mysql_query($myquery);
		
		if(!empty($sqlhere))
		{
			$_SESSION['QuerySuccess'] = "Your password has been changed.";
		}
		else
		{
			$_SESSION['QuerySuccess'] = "Could not change password.<br/>";
		}
		
			mysql_close($dbconn) or die ("could not close database");
}

if(!isset($_SESSION['QuerySuccess']))
{
	$_SESSION['QuerySuccess'] = "";
}

if(empty($_POST) === false){
$required_fields = array('current_password', 'password', 'password_again');
foreach($_POST as $key=>$value) { // iterating tru all post data so all foelds will loop thru n check each one
if(empty($value) && in_array($key, $required_fields) === true){ //if particlar value we loop thru is empty(value) and if the key is in the required field
$errors[] = 'Fields mark with * asteriks are required';
break 1;
}
}
if(md5($_POST['current_password']) === $user_data['password']){
if(trim($_POST['password']) !== trim($_POST['password_again'])){
$errors[] = 'Your new password do not match';
}
if (strlen($_POST['password']) < 6) {
$errors[] = 'Your new password is less than 6 character';
}
}
else{
$errors[] ='Your current password is incorrect';
}

}

include 'includes/overall/header.php';?>
		<h1> Change Password</h1>
		
		<?php
		if(isset($_GET['success']) && empty($_GET['success']))
		{ // of the success variable comes in the url
			//echo 'your password has been changed';
			echo "<br/><br/>" . $_SESSION['QuerySuccess'];
		} else {
		if(empty($_POST) === false && empty($errors) === true){
		// posted the form and no errors 
	change_passwordHere($session_user_id, $_POST['password']);
	header('Location: changepassword.php?success');
		} else if(empty($errors) === false) {
		//output errors
		echo output_errors($errors);
		
		}
		
		?>

<form style="min-height: 490px" action="" method="post">
<ul>
<li>
Current password*:</br>
<input class="boxshadow" type="password" name="current_password">
</li>
<li>
New password*:</br>
<input class="boxshadow" type="password" name="password">
</li>
<li>
New password again*:</br>
<input class="boxshadow" type="password" name="password_again">
</li>
<li>
</br>
<input class="button2 width145 p5" type="submit" value="Change password">
</li>
</ul>
</form>
   <?php 
  } 
   include 'includes/overall/footer.php';
   
   
?>