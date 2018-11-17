<?php 
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/header.php';

$_SESSION['currentYear'] = date("Y");
$_SESSION['currentMonth'] = date("n");
$_SESSION['currentDate'] = date("d");

$_SESSION['REGISTER_Registration_Date'] = $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'];

if(isset($_POST['agreetermsandconditions']))
{
	$_SESSION['agreetermsandconditions'] = $_POST['agreetermsandconditions'];
}
else
{
	$_SESSION['agreetermsandconditions'] = false;
}

if(!isset($_SESSION['firstTimeCount']))
{
	$_SESSION['firstTimeCount'] = 0;
}
else
{
	$_SESSION['firstTimeCount'] = $_SESSION['firstTimeCount'] + 1;
}

if(isset($_POST['username']))
{
	$_SESSION['REGISTER_username'] = $_POST['username'];
}
if(isset($_POST['password']))
{
	$_SESSION['REGISTER_password'] = $_POST['password'];
}
if(isset($_POST['first_name']))
{
	$_SESSION['REGISTER_first_name'] = strtoupper($_POST['first_name']);
}
if(isset($_POST['last_name']))
{
	$_POST['last_name'] = str_replace ("  ", " ", $_POST['last_name']);
	$_SESSION['REGISTER_last_name'] = strtoupper($_POST['last_name']);
}
if(isset($_POST['Matric_Number']))
{
	$_POST['Matric_Number'] = str_replace (" ", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("_", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("-", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace (",", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace (".", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("?", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("/", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("!", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("@", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("#", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("%", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("&", "", $_POST['Matric_Number']);
	$_POST['Matric_Number'] = str_replace ("$", "", $_POST['Matric_Number']);
	$_SESSION['REGISTER_Matric_Number'] = strtoupper($_POST['Matric_Number']);
}
if(isset($_POST['IC_number']))
{
	$_SESSION['REGISTER_IC_number'] = strtoupper($_POST['IC_number']);
}
if(isset($_POST['CGPA']))
{
	$_SESSION['REGISTER_CGPA'] = $_POST['CGPA'];
}
if(isset($_POST['Kolej_Kediaman']))
{
	$_SESSION['REGISTER_Kolej_Kediaman'] = $_POST['Kolej_Kediaman'];
}
if(isset($_POST['Hand_Phone_Number']))
{
	$_SESSION['REGISTER_Hand_Phone_Number'] = $_POST['Hand_Phone_Number'];
}
if(isset($_POST['email']))
{
	$_SESSION['REGISTER_email'] = $_POST['email'];
}

if(empty($_POST) === false)
{
	$required_fields = array('username', 'password', 'password_again', 'first_name', 'email', 'role');
	foreach($_POST as $key=>$value) 
	{
		if(empty($value) && in_array($key, $required_fields) === true)
		{
			$errors[] = 'Fields mark with * asteriks are required';
			break 1;
		}
	}
	if(empty($errors) === true)
	{
		if(user_exists($_POST['username']) === true)
		{
			$errors[] = 'Sorry, the username \'' . $_POST['username'] . '\' is already taken';
		}
		if(preg_match("/\\s/", $_POST['username']) == true)
		{
			$errors[] = 'your username must not contain any spaces';
		}
		if(strlen($_POST['password']) < 6)
		{
			$errors[] = 'Your password must be at least 6 characters long';
		}
		if($_POST['password'] !== $_POST['password_again'])
		{
			$errors[] = 'your password do not match';
		}
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
		{
			$errors[] = 'A valid email address is required';
		}
		if(email_exists($_POST['email']) === true)
		{
			$errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in used';
		}
	}
}
else
{
	
}

?>
		<h1> REGISTRATION</h1>
		
		<?php
		
		if(isset($_GET['success']) && empty($_GET['success']))
		{
			echo 'you have been registered successfully';
		}
		else
		{
		
			if($_SESSION['agreetermsandconditions'] == true)
			{
				if(empty($_POST) === false && empty($errors) === true)
				{
					$_POST['first_name'] = strtoupper($_POST['first_name']);
					$_POST['last_name'] = strtoupper($_POST['last_name']);
					$_POST['Matric_Number'] = strtoupper($_POST['Matric_Number']);
					//register user
					$register_data = array(
					'username'   => $_POST['username'],
					'password'   => $_POST['password'],
					'first_name' => $_POST['first_name'],
					'last_name'  => $_POST['last_name'],
					'email'      => $_POST['email'],
					'Matric_Number'      => $_POST['Matric_Number'],
					'IC_number'      => $_POST['IC_number'],
					'CGPA'      => $_POST['CGPA'],
					'Kolej_Kediaman'      => $_POST['Kolej_Kediaman'],
					'Hand_Phone_Number'      => $_POST['Hand_Phone_Number'],
					'Registration_Date'      => $_SESSION['REGISTER_Registration_Date'],
					'role'      => "student"
					);
					register_user($register_data);
					//redirect
					header('Location: register.php?success');
					// exit
					exit();
				} 
				else if(empty($errors) === false) 
				{
					//output errors
					echo output_errors($errors);
				}
			}
			else
			{
				if($_SESSION['firstTimeCount'] > 0)
				{
					?>
						PLEASE AGREE TO THE TERMS AND CONDITIONS BEFORE PROCEEDING
						<br/>
						<br/>
					<?php
				}
			}
		
		?>
		
		<form action="" method="post">
		<ul>
		<li>
		Username*:<br>
		<input type="text" name="username" value="<?php echo "" . $_SESSION['REGISTER_username'];?>">
		</li>
		<li>
		Password*:<br>
		<input type="password" name="password">
		</li>
		<li>
		Password_Again*:<br>
		<input type="password" name="password_again">
		</li>
		<li>
		First_Name* (as appears in IC / Passport):<br>
		<input type="text" name="first_name" value="<?php echo "" . $_SESSION['REGISTER_first_name'];?>">
		</li>
		<li>
		Last_Name* (as appears in IC / Passport)<br>
		<input type="text" name="last_name" value="<?php echo "" . $_SESSION['REGISTER_last_name'];?>">
		</li>
		<li>
		Identification Number (IC No. / Passport No.):<br>
		<input type="text" name="IC_number" value="<?php echo "" . $_SESSION['REGISTER_IC_number'];?>">
		</li>
		<li>
		Patient ID:<br>
		<input type="text" name="Matric_Number" value="<?php echo "" . $_SESSION['REGISTER_Matric_Number'];?>">
		</li>
		<li>
		Email*:<br>
		<input type="text" name="email" value="<?php echo "" . $_SESSION['REGISTER_email'];?>">
		</li>
		<li>
		pH:<br>
		<input type="text" name="CGPA" value="<?php echo "" . $_SESSION['REGISTER_CGPA'];?>">
		</li>
		<li>
		Address:<br>
		<input type="text" name="Kolej_Kediaman" value="<?php echo "" . $_SESSION['REGISTER_Kolej_Kediaman'];?>">
		</li>
		<li>
		Hand Phone Number (xxx-xxxxxxx):<br>
		<input type="text" name="Hand_Phone_Number" value="<?php echo "" . $_SESSION['REGISTER_Hand_Phone_Number'];?>">
		</li>
		<li>
		<!Checkbox!>
		<label for="<?php echo "agreetermsandconditions" . $my_little_counter;?>">I HEREBY AGREE TO THE <?php echo "<a href = \"TandC.pdf\" target = \"blank\">TERMS AND CONDITIONS </a>";?></label>
		<input type="checkbox" name="agreetermsandconditions" id="agreetermsandconditions" value="true" />
		
		</li>
		<li>
		<input type="submit" name "register">
		</li>
		</ul>
		</form>

   <?php
		}
   include 'includes/overall/footer.php';?>