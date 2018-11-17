<head>
	<!-- <script src="jquery-3.3.1.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
</head>
<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';


$_SESSION['currentYear'] = date("Y");
$_SESSION['currentMonth'] = date("n");
$_SESSION['currentDate'] = date("d");

/*if($user_data['role'] != 'administrator')
{
	header("location: register_student_course.php");
}/**/ 

		
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
			mysql_select_db("seru_students")or die($connect_error);


	$counter = 1;
	$arrayIndex = 0;
	$row_Val3;
	
	$total=0;
	$totalcf=0;
	$currentCF = 0;
	$prevAnswer =0;
	$prevCF = 0;
	$minCF = 0;
	
	$user_id;
	$username;
	$password;
	$first_name;
	$last_name;
	$email;
	$active;
	$role;
	$Title;
	$IC_number;
	$Matric_Number;
	$Hand_Phone_Number;
	$Kolej_Kediaman;
	$CGPA;
	$Registration_Date;
	$changeValue;
	$search;
	
   
if( isset( $_POST['submit'] ))
{ 
	
	$my_little_counter = 0;
		$_SESSION['Order_By'] = $_POST["Order_ByS"];
		$_SESSION['view_role'] = $_POST["view_roleS"];
		$_SESSION['search'] = $_POST["search"];
		
		if($_SESSION['search'] == "")
		{
			$_SESSION['search'] = $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'];
		}
	
	while($my_little_counter < $_SESSION['counterMax'])
	{	
		//echo "<br/>LASTA = " . $_POST['last_name2'] . "=   <br/>";
		//echo "<br/>LAST = " . $_POST["last_name1"] . "=   ";
	
					
		$changeValue = "" . $_POST["changeValue". $my_little_counter];
				
		//echo "<br/>CHANGE = " . $changeValue . "=   CounterMax =" . $_SESSION['counterMax'] . "=";
		
		if(($_SESSION["changeProtect". $my_little_counter] == "true" || $changeValue == "true") && 
			($user_data['role'] == 'administrator' ||$user_data['role'] == 'doctor' || ($user_data['role'] == 'student' && $_POST["username" . $my_little_counter] == $user_data['username'])))
		{			
			updateUsers($my_little_counter);
		}//end if($changeValue == true)
	
		$my_little_counter++;
	}//end while($my_little_counter < $_SESSION['counterMax'])
	
	
	
	
	
}//end if( isset( $_POST["submit"] ) )
if( isset( $_POST['submit2'] ))
{ 
	
	$my_little_counter = 0;
		$_SESSION['Order_By'] = $_POST["Order_ByS"];
		$_SESSION['view_role'] = $_POST["view_roleS"];
		$_SESSION['search'] = $_POST["search"];
		
		if($_SESSION['search'] == "")
		{
			$_SESSION['search'] = $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'];
		}
	
}//end if( isset( $_POST["submit2"] ) )
else
{
$_SESSION['Order_By'] = "Registration_Date";
$_SESSION['view_role'] = "all";
$_SESSION['search'] = $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'];



}
mainDisplay();



function mainDisplay()
{
?>
</br>
</br>
<form name ="formOne" method ="Post" action ="register_student.php">
<?php
//<Form name ="formOne" Method ="Post" ACTION ="RadioButton.php">
	accessRulesDisp();
?>
<!--
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "100" />5 : Extreme
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "75" />4 : High
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "50" />3 : Moderate
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "25" />2 : Minimal
</br>
<input type = 'radio' name = "userResponse" id = "userResponseYes" value = "-100" />1 : Not Experiencing This Symptom
</br>
-->

<P>

	
</form>

<!--
<h1> <?php echo $user_data['first_name'];?> You have answered <?php echo $counter-1;?> question and total marks accumulated <?php echo $_SESSION['ActualCFFinal'];?> <?php echo $_SESSION['numglobalMax'];?> </h1>
-->



   <?php 
   }//end function mainDisplay()
   
   include 'includes/overall/footer.php';
   
    
   function accessRulesDisp()
   {
		global $counter;
		global $user_data;
		global $total;
		
		
		global $user_id;
		global $username;
		global $password;
		global $first_name;
		global $last_name;
		global $email;
		global $active;
		global $role;
		global $Title;
		global $IC_number;
		global $Matric_Number;
		global $Hand_Phone_Number;
		global $Kolej_Kediaman;
		global $CGPA;
		global $Registration_Date;
		global $changeValue;
		global $search;
		
		
		
		$my_little_counter = 0;
		$my_little_counter_disp = 1;
		
		if(!isset($_SESSION['view_role']))
		{
			$_SESSION['view_role'] = all;
		}
		if(!isset($_SESSION['search']))
		{
			$_SESSION['search'] = "";
		}
 
		?>
		<h1> USER MANAGEMENT PAGE</h1>
		
		
				<?php
				
				if(isset($_SESSION["Message_BLANK"]))
				{
					if($_SESSION["Message_BLANK"] == "")
					{
					}
					else if($_SESSION["Message_BLANK"] == "Thank you for Updating your information")
					{
						header("location: register_student_course.php");
					}
					else
					{
						echo "" . $_SESSION["Message_BLANK"];
						$_SESSION["Message_BLANK"] = "Thank you for Updating your information";
					}
				}
				
				/*
					$user_id = $row["user_id"];
					$username = $row["username"];
					$password = $row["password"];
					$first_name = $row["first_name"];
					$last_name = $row["last_name"];
					$email = $row["email"];
					$active = $row["active"];
					$role = $row["role"];
					$Title = $row["Title"];
					$IC_number = $row["IC_Number"];
					$Matric_Number = $row["Matric_Number"];
					$Hand_Phone_Number = $row["Hand_Phone_Number"];
					$Kolej_Kediaman = $row["Kolej_Kediaman"];
					$CGPA = $row["CGPA"];
					$Registration_Date = $row["Registration_Date"];*/
					
				if($user_data['role'] == 'administrator' || $user_data['role'] == 'doctor')
				{
				?>
				<script type="text/javascript">
				document.getElementById('Order_ByS').focus();
				</script>
				<!Multi Select!>
					<label for="<?php echo "Order_ByS"?>">Order_By</label>
						
						<select class="boxshadow" name = "<?php echo "Order_ByS";?>" id = "<?php echo "Order_ByS";?>">
						<?php
						if($_SESSION['Order_By'] == "username")
						{
							?>
							<option value = "username" selected = "selected">Username</option>
							<option value = "last_name">Last Name</option>					
							<option value = "first_name">First Name</option>				
							<option value = "Registration_Date">Registration Date</option>
							<?php
						}
						else if($_SESSION['Order_By'] == "last_name")
						{
							?>
							<option value = "last_name" selected = "selected">Last Name</option>				
							<option value = "first_name">First Name</option>				
							<option value = "Registration_Date">Registration Date</option>
							<option value = "username">Username</option>
							<?php
						}
						else if($_SESSION['Order_By'] == "first_name")
						{
							?>
							<option value = "first_name" selected = "selected">First Name</option>				
							<option value = "last_name">Last Name</option>				
							<option value = "Registration_Date">Registration Date</option>
							<option value = "username">Username</option>
							<?php
						}
						else if($_SESSION['Order_By'] == "Registration_Date")
						{
							?>
							<option value = "Registration_Date" selected = "selected">Registration Date</option>
							<option value = "last_name">Last Name</option>				
							<option value = "first_name">First Name</option>
							<option value = "username">Username</option>
							<?php
						}
						?>
						</select>
					
					<br/>
					<br/>
					
					<!Multi Select!>
					<label for="<?php echo "view_roleS"?>">View Role</label>
					<select class="boxshadow" name = "<?php echo "view_roleS";?>" id = "<?php echo "view_roleS";?>">
					<?php
					if($_SESSION['view_role'] == "student")
					{
						?>
						<option value = "student" selected = "selected">Patient</option>
						<option value = "administrator">Administrator</option>	
						<option value = "doctor">Doctor</option>					
						<option value = "all">All</option>
						<?php
					}
					else if($_SESSION['view_role'] == "administrator")
					{
						?>
						<option value = "administrator" selected = "selected">Administrator</option>
						<option value = "all">All</option>
						<option value = "student">Patient</option>
						<option value = "doctor">Doctor</option>
						<?php
					}
					else if($_SESSION['view_role'] == "doctor")
					{
						?>
						<option value = "doctor" selected = "selected">Doctor</option>				
						<option value = "all">All</option>
						<option value = "student">Patient</option>
						<option value = "administrator">Administrator</option>
						<?php
					}
					else if($_SESSION['view_role'] == "all")
					{
						?>
						<option value = "all" selected = "selected">All</option>
						<option value = "administrator">Administrator</option>	
						<option value = "student">Patient</option>
						<option value = "doctor">Doctor</option>
						<?php
					}
					?>
					</select>
					</br>
					</br>
					<label for="search">Search</label>
					<input class="boxshadow" type="text" name="search" id="search" value="<?php echo "" . $_SESSION['search']; ?>" />
					
					</br>
				</br>
					<input class="button2 width110 p5" type = "submit" name = "submit2" value = "Filter" />
		<?php
		
		
			//user_data($session_user_id, 'user_id', 'username', 'password',  'first_name', 'last_name', 'email', 'active', 'role', 'Title', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');
			$orderingDirection = " ASC";
			$orderByBackup = "";
			
			if($_SESSION['Order_By'] == "Registration_Date")
			{
				$orderingDirection = " DESC";
				$orderByBackup = $_SESSION['Order_By'];
				$_SESSION['Order_By'] = "user_id";
			}
			
			if($_SESSION['view_role'] == "all")
			{
				if($_SESSION['search'] == "" || strToLower($_SESSION['search']) == "all")
				{
					if(strToLower($_SESSION['search']) == "all")
					{
						$_SESSION['search'] = "";
						$theQuery = "SELECT * FROM users ORDER BY " . $_SESSION['Order_By'] . $orderingDirection . ";";
					}
					else
					{
					$theQuery = "SELECT * FROM users WHERE Registration_Date LIKE '%" . $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'] . 
													"%' ORDER BY " . $_SESSION['Order_By'] . $orderingDirection . ";";
					}
				}
				else
				{
					$theQuery = "SELECT * FROM users WHERE first_name LIKE '%" . $_SESSION['search'] . 
													"%' OR username LIKE '%" . $_SESSION['search'] .
													"%' OR last_name LIKE '%" . $_SESSION['search'] . 
													"%' OR Matric_Number LIKE '%" . $_SESSION['search'] . 
													"%' OR title LIKE '%" . $_SESSION['search'] . 
													"%' OR Registration_Date LIKE '%" . $_SESSION['search'] . 
													"%' ORDER BY " . $_SESSION['Order_By'] . $orderingDirection .
													";";
				}
			}
			else
			{
				if($_SESSION['search'] == "" || strToLower($_SESSION['search']) == "all")
				{
					if(strToLower($_SESSION['search']) == "all")
					{
						$_SESSION['search'] = "";
						$theQuery = "SELECT * FROM users WHERE role = '" . $_SESSION['view_role'] . "' ORDER BY " . $_SESSION['Order_By'] . $orderingDirection . ";";
					}
					else
					{
					$theQuery = "SELECT * FROM users WHERE role = '" . $_SESSION['view_role'] . "' AND Registration_Date LIKE '%" . $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'] . 
													"%' ORDER BY " . $_SESSION['Order_By'] . $orderingDirection . ";";
					}
				}
				else
				{
					$theQuery = "SELECT * FROM users WHERE role LIKE '" . $_SESSION['view_role'] . 
														"' AND (first_name LIKE '%" . $_SESSION['search'] . 
														"%' OR last_name LIKE '%" . $_SESSION['search'] . 
														"%' OR username LIKE '%" . $_SESSION['search'] . 
														"%' OR Matric_Number LIKE '%" . $_SESSION['search'] .
														"%' OR title LIKE '%" . $_SESSION['search'] . 
														"%' OR Registration_Date LIKE '%" . $_SESSION['search'] . 
														"%') ORDER BY " . $_SESSION['Order_By'] . $orderingDirection . ";";
							
				}
			}
			
			if($_SESSION['Order_By'] == "user_id")
			{
				$_SESSION['Order_By'] = "Registration_Date";
			}
				}//end if($user_data['role'] == 'administrator')
				else
				{
					$theQuery = "SELECT * FROM users WHERE username LIKE '" . $user_data['username'] . 
										"' AND password LIKE '" . $user_data['password'] . "' ORDER BY role DESC;";
				}
				
										
					//echo "<br/>" . $theQuery;
										
					$sql = mysql_query($theQuery);

//$sql = mysql_query("SELECT * FROM users WHERE role like '%student%'");
			try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{	
					
					$row_Val = $row["username"];
					
					$user_id = $row["user_id"];
					$username = $row["username"];
					$password = $row["password"];
					$first_name = $row["first_name"];
					$last_name = $row["last_name"];
					$email = $row["email"];
					$active = $row["active"];
					$role = $row["role"];
					$Title = $row["Title"];
					$IC_number = $row["IC_Number"];
					$Matric_Number = $row["Matric_Number"];
					$Hand_Phone_Number = $row["Hand_Phone_Number"];
					$Kolej_Kediaman = $row["Kolej_Kediaman"];
					$CGPA = $row["CGPA"];
					$Registration_Date = $row["Registration_Date"];
					
					$_SESSION["changeProtect". $my_little_counter] = "false";
					
					
			/*
			echo "<br/>TEST LAST = " . $first_name . "=   ";
			echo "<br/>TEST LAST = " . $last_name . "=   ";
			echo "<br/>TEST LAST = " . $email . "=   ";
			echo "<br/>TEST LAST = " . $active . "=   ";
			echo "<br/>TEST LAST = " . $role . "=   ";
			echo "<br/>TEST LAST = " . $Title . "=   ";
			echo "<br/>TEST LAST = " . $IC_number . "=   ";
			echo "<br/>TEST LAST = " . $Matric_Number . "=   ";
			echo "<br/>TEST LAST = " . $Hand_Phone_Number . "=   ";
			echo "<br/>TEST LAST = " . $Kolej_Kediaman . "=   ";
			/**/
					
					
					$my_little_counter_disp = $my_little_counter + 1;
										
					$count_ = $my_little_counter_disp;
					
					
											if(($count_ % 2) == 1)
											{
												$color = "#e6e6fa";
												$color2 = "#61bcff";
											}
											else
											{
												$color = "#ffffff";
												$color2 = "#FFC0CB";
											}
											
					
				?>
			</br></br>
					<table class="ep_tm_main"><tr><td align="left">	
				<table>
					<tr>
						<td bgcolor=" <?php echo "". $color2;?>"><strong></strong></td> 
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Username*</strong></td> 
						<td bgcolor=" <?php echo "". $color2;?>"><strong>First Name* <br/>(as in IC / Passport)</strong></td> 
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Last Name* <br/>(as in IC / Passport)</strong></td>
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Email*</strong></td>			
					</tr>	
					<?php	
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $my_little_counter_disp .  "</td>\r\n";
					
					$_SESSION["user_id" . $my_little_counter] = $user_id;
					$_SESSION["password" . $my_little_counter] = $password;
					?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "username" . $my_little_counter;?>" id="<?php echo "username" . $my_little_counter;?>" value="<?php echo "$username";?>" />
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "first_name" . $my_little_counter;?>" id="<?php echo "first_name" . $my_little_counter;?>" value="<?php echo "$first_name";?>" />
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "last_name" . $my_little_counter;?>" id="<?php echo "last_name" . $my_little_counter;?>" value="<?php echo "$last_name";?>" />
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "email" . $my_little_counter;?>" id="<?php echo "email" . $my_little_counter;?>" value="<?php echo "$email";?>" />
					</td><?php echo "\r\n"; ?>
					
				</table>
				</td></tr></table>
					
					
					<table class="ep_tm_main"><tr><td align="left">	
				<table>
					<tr>
						<td bgcolor=" <?php echo "". $color2;?>"><strong>IC number</strong></td>		
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Registration Date</strong></td>					
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Role*</strong></td>					
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Gender*</strong></td>			
					</tr>	
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "IC_number" . $my_little_counter;?>" id="<?php echo "IC_number" . $my_little_counter;?>" value="<?php echo "$IC_number";?>" />
					</td><?php echo "\r\n"; ?>
					
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<?php
					if($Registration_Date == null || $Registration_Date == ""  || $Registration_Date == "null")
					{
						$Registration_Date = "" . $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear']; 
						if($username != null)
						{
							$_SESSION["changeProtect". $my_little_counter] = "true";
						}
					}
					if($user_data['role'] == 'administrator'|| $user_data['role'] == 'doctor')
					{
					?>
						<input type="text" name="<?php echo "Registration_Date" . $my_little_counter;?>" id="<?php echo "Registration_Date" . $my_little_counter;?>" readonly="true" value="<?php echo "$Registration_Date";?>" />
					<?php
					}//end if($user_data['role'] == 'administrator')
					else
					{
					?>
						<input type="text" name="<?php echo "Registration_Date" . $my_little_counter;?>" id="<?php echo "Registration_Date" . $my_little_counter;?>" readonly="true"  value="<?php echo "$Registration_Date";?>" />
					<?php
					}//end else
					?>
					</td><?php echo "\r\n"; ?>
					
					
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<!Multi Select!>
					<label for="<?php echo "role" . $my_little_counter;?>">Role*</label>
					<select name = "<?php echo "role" . $my_little_counter;?>" id = "<?php echo "role" . $my_little_counter;?>">
					<?php
					if($user_data['role'] == 'administrator' || $user_data['role'] == 'doctor')
					{
					if($role == "student")
					{
						?>
						<option value = "student" selected = "selected">Patient</option>
						<option value = "administrator">Administrator</option>
						<option value = "doctor">Doctor</option>
						<?php
					}
					else if($role == "administrator")
					{
						?>
						<option value = "administrator" selected = "selected">Administrator</option>
						<option value = "student">Patient</option>
						<option value = "doctor">Doctor</option>
						<?php
					}
					else if($role == "doctor")
					{
						?>
						<option value = "doctor" selected = "selected">Doctor</option>
						<option value = "student">Patient</option>
						<option value = "administrator">Administrator</option>
						<?php
					}
					}//end if($user_data['role'] == 'administrator')
					else
					{
						?>
						<option value = "student" selected = "selected">Patient</option>
						<?php
					}
					?>
					</select>
					</td><?php echo "\r\n"; ?>
					
									
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<!Multi Select!>
					<label for="<?php echo "Title" . $my_little_counter;?>">Gender*</label>
					<select name = "<?php echo "Title" . $my_little_counter;?>" id = "<?php echo "Title" . $my_little_counter;?>">
					<?php
					if($Title == "male")
					{
						?>
						<option value = "male" selected = "selected">Male</option>
						<option value = "female">Female</option>
						<?php
					}
					else if($Title == "female")
					{
						?>
						<option value = "female" selected = "selected">Female</option>
						<option value = "male">Male</option>
						<?php
					}
					else
					{
						?>
						<option value = "male" selected = "selected">Male</option>
						<option value = "female">Female</option>
						<?php
						if($username != null)
						{
							$_SESSION["changeProtect". $my_little_counter] = "true";
						}
					}
					?>
					</select>
					</td><?php echo "\r\n"; ?>
					
					</table>
				</td></tr></table>
					
					
					<table class="ep_tm_main"><tr><td align="left">	
				<table>
					<tr>			
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Patient_ID</strong></td>				
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Hand_Phone_Number</strong></td>				
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Address</strong></td>			
						<td bgcolor=" <?php echo "". $color2;?>"><strong>pH</strong></td>				
					</tr>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "Matric_Number" . $my_little_counter;?>" id="<?php echo "Matric_Number" . $my_little_counter;?>" value="<?php echo "$Matric_Number";?>" />
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "Hand_Phone_Number" . $my_little_counter;?>" id="<?php echo "Hand_Phone_Number" . $my_little_counter;?>" value="<?php echo "$Hand_Phone_Number";?>" />
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "Kolej_Kediaman" . $my_little_counter;?>" id="<?php echo "Kolej_Kediaman" . $my_little_counter;?>" value="<?php echo "$Kolej_Kediaman";?>" />
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input type="text" name="<?php echo "CGPA" . $my_little_counter;?>" id="<?php echo "CGPA" . $my_little_counter;?>" value="<?php echo "$CGPA";?>" />
					</td><?php echo "\r\n"; ?>
					
					</table>
				</td></tr></table>
					
					
					<table class="ep_tm_main"><tr><td align="left">	
				<table>
					<tr>	
						<?php
						if($user_data['role'] == 'administrator' || $user_data['role'] == 'doctor')
						{
						?>
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Reset Password</strong></td>
						<?php
						}
						?>						
						<td bgcolor=" <?php echo "". $color2;?>"><strong>UPDATE</strong></td>		
						<td bgcolor=" <?php echo "". $color2;?>"><strong>Submit</strong></td>				
					</tr>
					<?php
					if($user_data['role'] == 'administrator' || $user_data['role'] == 'doctor')
					{
					?>
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<!Checkbox!>
					<label for="<?php echo "resetPassword" . $my_little_counter;?>">RESET PASSWORD</label>
					<input type="checkbox" name="<?php echo "resetPassword" . $my_little_counter;?>" id="<?php echo "resetPassword" . $my_little_counter;?>" value="true" />
					</td><?php echo "\r\n"; ?>
					<?php
					}
					?>

					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<!Checkbox!>
					<label for="<?php echo "changeValue" . $my_little_counter;?>">UPDATE</label>
					<input type="checkbox" name="<?php echo "changeValue" . $my_little_counter;?>" id="<?php echo "changeValue" . $my_little_counter;?>" value="true" />
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<input class="button2 width90 p5" type = "submit" name = "submit" value = "Submit" />
					</td><?php echo "\r\n"; ?>
					
				</table>
				</td></tr></table>
				<br/><br/><br/>
					
					<?php
					
					/*
					<label for="<?php echo "" . $my_little_counter;?>"></label>
					<input type="text" name="<?php echo "" . $my_little_counter;?>" id="<?php echo "" . $my_little_counter;?>" value="<?php echo "$";?>" />
					
					<label for=""></label>
					<input type="text" name="" id="" value="<?php echo "$";?>" />
					*/
										
					
					//echo "User ".$row_Val . "<br/>";
					$my_little_counter++;
					$_SESSION['counterMax'] = $my_little_counter;
					
					
				}//end while($row = mysql_fetch_assoc($sql))
				}
				else
				{
					echo "EMPTY...";
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
			
			if($user_data['role'] == 'administrator' || $user_data['role'] == 'doctor')
			{
					$my_little_counter_disp = $my_little_counter + 1;
					echo "<br/><br/>" . $my_little_counter_disp . ") ";
					
					$user_id = getMaxUserID() + 1;
					//echo "<br/>MAX ID = " . $user_id;
					//$user_id = $user_id + 1;
					$username = "";
					$password = "password";
					$password = md5($password);
					$first_name = "";
					$last_name = "";
					$email = "";
					$active = "";
					$role = "";
					$Title = "";
					$IC_number = "";
					$Matric_Number = "";
					$Hand_Phone_Number = "";
					$Kolej_Kediaman = "";
					$CGPA = 0.0;
					
					
					echo "ADD NEW USER:<br/><br/>";
					$_SESSION["user_id" . $my_little_counter] = $user_id;
					$_SESSION["password" . $my_little_counter] = $password;
					?>
					
					<label for="<?php echo "username" . $my_little_counter;?>">Username*</label>
					<input class="boxshadow" type="text" name="<?php echo "username" . $my_little_counter;?>" id="<?php echo "username" . $my_little_counter;?>" value="<?php echo "$username";?>" />
					</br></br>
					<label for="<?php echo "first_name" . $my_little_counter;?>">First Name*</label>
					<input class="boxshadow" type="text" name="<?php echo "first_name" . $my_little_counter;?>" id="<?php echo "first_name" . $my_little_counter;?>" value="<?php echo "$first_name";?>" />
					&nbsp; &nbsp;
					<label for="<?php echo "last_name" . $my_little_counter;?>">Last Name*</label>
					<input class="boxshadow" type="text" name="<?php echo "last_name" . $my_little_counter;?>" id="<?php echo "last_name" . $my_little_counter;?>" value="<?php echo "$last_name";?>" />
					</br></br>
					<label for="<?php echo "email" . $my_little_counter;?>">Email*</label>
					<input class="boxshadow" type="text" name="<?php echo "email" . $my_little_counter;?>" id="<?php echo "email" . $my_little_counter;?>" value="<?php echo "$email";?>" />
					&nbsp; &nbsp;
					<label for="<?php echo "IC_number" . $my_little_counter;?>">IC_number*</label>
					<input class="boxshadow" type="text" name="<?php echo "IC_number" . $my_little_counter;?>" id="<?php echo "IC_number" . $my_little_counter;?>" value="<?php echo "$IC_number";?>" />
					
					</br></br>
					<?php
						$Registration_Date = "" . $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear']; 
					?>
					<label for="<?php echo "Registration_Date" . $my_little_counter;?>">Registration Date</label>
					<input class="boxshadow" type="text" name="<?php echo "Registration_Date" . $my_little_counter;?>" id="<?php echo "Registration_Date" . $my_little_counter;?>" value="<?php echo "$Registration_Date";?>" />
					
					&nbsp; &nbsp;
					<!Multi Select!>
					<label for="<?php echo "role" . $my_little_counter;?>">Role*</label>
					<select class="boxshadow" name = "<?php echo "role" . $my_little_counter;?>" id = "<?php echo "role" . $my_little_counter;?>">
					<?php
					if($role == "student")
					{
						?>
						<option value = "student" selected = "selected">Patient</option>
						<option value = "administrator">Administrator</option>
						<option value = "doctor">Doctor</option>
						<?php
					}
					else if($role == "administrator")
					{
						?>
						<option value = "administrator" selected = "selected">Administrator</option>
						<option value = "student">Patient</option>
						<option value = "doctor">Doctor</option>
						<?php
					}
					else if($role == "doctor")
					{
						?>
						<option value = "doctor" selected = "selected">Doctor</option>
						<option value = "student">Patient</option>
						<option value = "administrator">Administrator</option>
						<?php
					}
					else
					{
						?>
						<option value = "student" selected = "selected">Patient</option>
						<option value = "administrator">Administrator</option>
						<option value = "doctor">Doctor</option>
						<?php
					}
					?>
					</select>
					
					<!--
					<label for="<?php echo "Title" . $my_little_counter;?>">Gender</label>
					<input type="text" name="<?php echo "Title" . $my_little_counter;?>" id="<?php echo "Title" . $my_little_counter;?>" value="<?php echo "$Title";?>" />
					-->
					&nbsp; &nbsp;
					<!Multi Select!>
					<label for="<?php echo "Title" . $my_little_counter;?>">Gender*</label>
					<select class="boxshadow" name = "<?php echo "Title" . $my_little_counter;?>" id = "<?php echo "Title" . $my_little_counter;?>">
					<?php
					if($Title == "male")
					{
						?>
						<option value = "male" selected = "selected">Male</option>
						<option value = "female">Female</option>
						<?php
					}
					else if($Title == "female")
					{
						?>
						<option value = "female" selected = "selected">Female</option>
						<option value = "male">Male</option>
						<?php
					}
					else
					{
						?>
						<option value = "male" selected = "selected">Male</option>
						<option value = "female">Female</option>
						<?php
					}
					?>
					</select>
					</br></br>
					<label for="<?php echo "Matric_Number" . $my_little_counter;?>">Patient ID</label>
					<input class="boxshadow" type="text" name="<?php echo "Matric_Number" . $my_little_counter;?>" id="<?php echo "Matric_Number" . $my_little_counter;?>" value="<?php echo "$Matric_Number";?>" />
					&nbsp; &nbsp;
					<label for="<?php echo "Hand_Phone_Number" . $my_little_counter;?>">Hand Phone Number</label>
					<input class="boxshadow" type="text" name="<?php echo "Hand_Phone_Number" . $my_little_counter;?>" id="<?php echo "Hand_Phone_Number" . $my_little_counter;?>" value="<?php echo "$Hand_Phone_Number";?>" />
					</br></br>
					<label for="<?php echo "Kolej_Kediaman" . $my_little_counter;?>">Address</label>
					<input class="boxshadow" type="text" name="<?php echo "Kolej_Kediaman" . $my_little_counter;?>" id="<?php echo "Kolej_Kediaman" . $my_little_counter;?>" value="<?php echo "$Kolej_Kediaman";?>" />
					&nbsp; &nbsp;
					<label for="<?php echo "CGPA" . $my_little_counter;?>">pH</label>
					<input class="boxshadow" type="text" name="<?php echo "CGPA" . $my_little_counter;?>" id="<?php echo "CGPA" . $my_little_counter;?>" value="<?php echo "$CGPA";?>" />
					
					&nbsp; &nbsp;
					
					<!Checkbox!>
					<label for="<?php echo "changeValue" . $my_little_counter;?>">ADD</label>
					<input type="checkbox" name="<?php echo "changeValue" . $my_little_counter;?>" id="<?php echo "changeValue" . $my_little_counter;?>" value="true" />
					
					<input class="button2 width110 p5" type = "submit" name = "submit" value = "Submit" />
					
					<?php
					$my_little_counter++;
			}//end if($user_data['role'] == 'administrator')
					$_SESSION['counterMax'] = $my_little_counter;
					
			
   }//end function accessRulesDisp()
   
   
   
   
   function updateUsers($my_little_counter)
   {		
		global $user_id;
		global $username;
		global $password;
		global $first_name;
		global $last_name;
		global $email;
		global $active;
		global $role;
		global $Title;
		global $IC_number;
		global $Matric_Number;
		global $Hand_Phone_Number;
		global $Kolej_Kediaman;
		global $CGPA;
		global $Registration_Date;
		
		$theQueryToExecute = "";
		
 
			
			$user_id = $_SESSION["user_id" . $my_little_counter];
			$username = $_POST["username" . $my_little_counter];
			$password = $_SESSION["password" . $my_little_counter];
			$first_name = $_POST["first_name". $my_little_counter];
			$last_name = $_POST["last_name". $my_little_counter];
			$email = $_POST["email". $my_little_counter];
			$active = $_POST["active". $my_little_counter];
			$role = $_POST["role". $my_little_counter];
			$Title = $_POST["Title". $my_little_counter];
			$IC_number = $_POST["IC_number". $my_little_counter];
			$Matric_Number = str_replace (" ", "", $_POST["Matric_Number". $my_little_counter]);
			$Hand_Phone_Number = $_POST["Hand_Phone_Number". $my_little_counter];
			$Kolej_Kediaman = $_POST["Kolej_Kediaman". $my_little_counter];
			$CGPA = $_POST["CGPA". $my_little_counter];
			$Registration_Date = $_POST["Registration_Date". $my_little_counter];
			
			
			
			if($_POST["resetPassword". $my_little_counter] == true)
			{
				$password = "password";
				$password = md5($password);
			}//end if($_POST["resetPassword". $my_little_counter] == true)

			/*
			echo "<br/>LAST username= " . $username . "=   ";
			echo "<br/>LAST password= " . $password . "=   ";
			echo "<br/>LAST user_id= " . $user_id . "=   ";
			echo "<br/>LAST first_name= " . $first_name . "=   ";
			echo "<br/>LAST last_name= " . $last_name . "=   ";
			echo "<br/>LAST email= " . $email . "=   ";
			//echo "<br/>LAST = " . $active . "=   ";
			echo "<br/>LAST role= " . $role . "=   ";
			echo "<br/>LAST Title= " . $Title . "=   ";
			echo "<br/>LAST IC_number= " . $IC_number . "=   ";
			echo "<br/>LAST Matric_Number= " . $Matric_Number . "=   ";
			echo "<br/>LAST Hand_Phone_Number= " . $Hand_Phone_Number . "=   ";
			echo "<br/>LAST Kolej_Kediaman= " . $Kolej_Kediaman . "=   ";
			/**/
			
			$first_name = strtoupper($first_name);
			$last_name = strtoupper($last_name);
			$Matric_Number = strtoupper($Matric_Number);
 
			
			$username = str_replace ("'", "\'", $username);
			$first_name = str_replace ("'", "\'", $first_name);
			$last_name = str_replace ("'", "\'", $last_name);
			$email = str_replace ("'", "\'", $email);
			$Kolej_Kediaman = str_replace ("'", "\'", $Kolej_Kediaman);
			
			if($username == "")
			{
				echo "<br/>username cannot be NULL " . $my_little_counter;
			}
			/*else if($password == "")
			{
				echo "<br/>password cannot be NULL " . $my_little_counter;
			}*/
			else if($first_name == "")
			{
				echo "<br/>first_name cannot be NULL " . $my_little_counter;
			}
			else if($last_name == "")
			{
				echo "<br/>last_name cannot be NULL " . $my_little_counter;
			}
			else if($email == "")
			{
				echo "<br/>email cannot be NULL " . $my_little_counter;
			}
			else if($role == "")
			{
				echo "<br/>role cannot be NULL " . $my_little_counter;
			}
			else
			{
				if($Title == "")
				{
					$Title = "null";
				}
				if($IC_Number == "")
				{
					$IC_Number = "null";
				}
				if($Matric_Number == "")
				{
					$Matric_Number = "null";
				}
				if($Hand_Phone_Number == "")
				{
					$Hand_Phone_Number = "null";
				}
				if($Kolej_Kediaman == "")
				{
					$Kolej_Kediaman = "null";
				}
				if($CGPA == "")
				{
					$CGPA = 0.0;
				}
				if($Registration_Date == "" || $Registration_Date == null)
				{
					$Registration_Date = "" . $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear']; 
				}
							
				if($user_id > getMaxUserID())
				{
					$theQueryToExecute = "INSERT INTO `seru_students`.`users`".
										" (`user_id`, `username`, `password`, `first_name`, ".
										"`last_name`, `email`, `active`, `role`, ".
										"`Title`, `IC_Number`, `Matric_Number`, `Hand_Phone_Number`, ".
										"`Kolej_Kediaman`, `CGPA`, `Registration_Date`) ".
										"VALUES (" . $user_id . ", '" . $username . "', '" . $password . "', '" . $first_name . "', ".
										"'" . $last_name . "', '" . $email . "', '1', '" . $role . "', ".
										"'" . $Title . "', '" . $IC_number . "', '" . $Matric_Number . "', '" . $Hand_Phone_Number . "', ".
										"'" . $Kolej_Kediaman . "', '" . $CGPA . "', '" . $Registration_Date . "');";
					//echo "<br/>" . $theQueryToExecute;
										
					$sql = mysql_query($theQueryToExecute);
										
					if($sql == null)
					{
						//echo "<br/>" . $theQueryToExecute;
						echo "<br/><br/>";
						?>
						<h1><font color="red">Could Not Add User</font></h1>
						<?php
					}
					else
					{
						echo "<br/>";
						?>
						<h1><font color="red">NEW USER ADDED</font></h1>
						<?php
					}
				}//end if($user_id > getMaxUserID())
				else
				{
					$sql = mysql_query("UPDATE users SET username = '". $username .
																"', password = '". $password .
																"', first_name = '". $first_name .
																"', last_name = '". $last_name .
																"', email = '". $email .
																"', role = '". $role .
																"', Title = '". $Title .
																"', IC_Number = '". $IC_number .
																"', Matric_Number = '". $Matric_Number .
																"', Hand_Phone_Number = '". $Hand_Phone_Number .
																"', Kolej_Kediaman = '". $Kolej_Kediaman .
																"', CGPA = '". $CGPA .
																"', Registration_Date = '". $Registration_Date .
																"' WHERE user_id = '" . $user_id . "';");
											
					if($sql == null)
					{
						echo "<br/><br/>";
						?>
						<h1><font color="red">Could Not Update User</font></h1>
						<?php
					}
					else
					{
						echo "<br/>";
						?>
						<h1><font color="red">DATABASE UPDATED</font></h1>
						<?php
					}
				}//end else for if($sqlTest == null)
			}
   }//end function updateUsers()
   
   
	function getMaxUserID()
	{
			$finalcounter = 0;
			$sql = mysql_query("SELECT * FROM users");
			
			try
			{
				if(!empty($sql))
				{	
					$_SESSION['numIDMax'] = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["user_id"];
						if($finalcounter > $_SESSION['numIDMax'])
						{
							$_SESSION['numIDMax'] = $finalcounter;
						}
					}
				}
				else
				{
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
			return $_SESSION['numIDMax'];
	}//end function getMaxUserID()
   
   function accessRulesB()
   {
		global $counter;
		global $user_data;
		global $total;
		global $mysqlPassword;
 
		?>
		<h1> consultation page</h1>
		<?php echo $counter; ?>) So <?php echo $user_data['first_name'];?> ,
		<?php
 
 
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
			mysql_select_db("lr")or die($connect_error);
			
$sql = mysql_query("SELECT * FROM expert WHERE number = $counter");
try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
					$row_Val = $row["symptoms"];
					$row_Val2 = $row["diagnose"];
					$_SESSION['cfglobal'] = $row["CF"];
					
					echo "Does the ".$row_Val;
				}
				}
				else
				{
					/*
					$row_Val = "symptoms";
					$row_Val2= "diagnose";
					echo $row_Val, " and ".$row_Val2;
					/**/
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
			
			
   }//end function accessRulesB()
   
   function getMaximumCFValue()
   {
		global $currentCF;
		global $mysqlPassword;
   
		$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", $mysqlPassword)or die($connect_error);
			mysql_select_db("seru_students")or die($connect_error);
			
$sql = mysql_query("SELECT * FROM expert");
try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
					$currentCF = $row["CF"];
					
					if($currentCF > $_SESSION['cfglobalMax'])
					{
						$_SESSION['cfglobalMax'] = $currentCF;
					}
				}
				}
				else
				{
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
   }//end function getMaximumCFValue()
   
	function getMaxCounterVal()
	{
	global $finalcounter;
			$sql = mysql_query("SELECT * FROM expert");
			try{
			if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
				$finalcounter= $row["number"];
				if($finalcounter > $_SESSION['numglobalMax']){
				$_SESSION['numglobalMax']=$finalcounter;
				}
				}
				}
				else {}
				}
				catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
				
	}
   
   
			mysql_close($dbconn) or die ("could not close database");
   
   ?>