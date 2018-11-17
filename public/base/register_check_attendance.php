<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
	<style>
		div.dataTables_wrapper {
        width: 850px;
    	}	
	</style>
</head>
<body>

<?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';


$_SESSION['currentYear'] = date("Y");
$_SESSION['currentMonth'] = date("n");
$_SESSION['currentDate'] = date("d");

if($user_data['role'] != 'administrator' && $user_data['role'] != 'doctor')
{
	header("location: register_student_course.php");
} 

	

	if(!isset($_SESSION["Show_Username"]))
	{
		$_SESSION["Show_Username"] = true;
	}
	if(!isset($_SESSION["Show_First_Name"]))
	{
		$_SESSION["Show_First_Name"] = true;
	}
	if(!isset($_SESSION["Show_Last_Name"]))
	{
		$_SESSION["Show_Last_Name"] = true;
	}
	if(!isset($_SESSION["Show_Email"]))
	{
		$_SESSION["Show_Email"] = true;
	}
	if(!isset($_SESSION["Show_Active"]))
	{
		$_SESSION["Show_Active"] = true;
	}
	if(!isset($_SESSION["Show_Title"]))
	{
		$_SESSION["Show_Title"] = true;
	}
	if(!isset($_SESSION["Show_IC_Number"]))
	{
		$_SESSION["Show_IC_Number"] = true;
	}
	if(!isset($_SESSION["Show_Matric_Number"]))
	{
		$_SESSION["Show_Matric_Number"] = true;
	}
	if(!isset($_SESSION["Show_Contact_Number"]))
	{
		$_SESSION["Show_Contact_Number"] = true;
	}
	if(!isset($_SESSION["Show_Residential_College"]))
	{
		$_SESSION["Show_Residential_College"] = true;
	}
	if(!isset($_SESSION["Show_CGPA"]))
	{
		$_SESSION["Show_CGPA"] = true;
	}
	if(!isset($_SESSION["Show_Attendance"]))
	{
		$_SESSION["Show_Attendance"] = true;
	}
	if(!isset($_SESSION["Show_Evaluation_Form"]))
	{
		$_SESSION["Show_Evaluation_Form"] = true;
	}
	if(!isset($_SESSION["Show_Paid"]))
	{
		$_SESSION["Show_Paid"] = true;
	}
	if(!isset($_SESSION["Show_Completed_Status"]))
	{
		$_SESSION["Show_Completed_Status"] = true;
	}
	if(!isset($_SESSION["Show_Everything"]))
	{
		$_SESSION["Show_Everything"] = true;
		$_SESSION["Show_Completed_Status"] = true;
		$_SESSION["Show_Paid"] = true;
		$_SESSION["Show_Evaluation_Form"] = true;
		$_SESSION["Show_Attendance"] = true;
		$_SESSION["Show_CGPA"] = true;
		$_SESSION["Show_Residential_College"] = true;
		$_SESSION["Show_Contact_Number"] = true;
		$_SESSION["Show_Matric_Number"] = true;
		$_SESSION["Show_IC_Number"] = true;
		$_SESSION["Show_Title"] = true;
		$_SESSION["Show_Active"] = true;
		$_SESSION["Show_Email"] = true;
		$_SESSION["Show_Username"] = true;
		$_SESSION["Show_First_Name"] = true;
		$_SESSION["Show_Last_Name"] = true;
	}
	if(!isset($_SESSION["Show_All"]))
	{
		$_SESSION["Show_All"] = true;
	}
	if(!isset($_SESSION["Show_Unpaid"]))
	{
		$_SESSION["Show_Unpaid"] = true;
	}
	if(!isset($_SESSION["search"]))
	{
		$_SESSION["search"] = "";
	}
	if(!isset($_SESSION["searchMatric"]))
	{
		$_SESSION["searchMatric"] = "";
	}
	
	
if(isset($_SESSION["First_Time"]))
{
	if(isset($_POST["Show_Username"]))
	{
		$_SESSION["Show_Username"] = $_POST["Show_Username"];
	}
	else
	{
		$_SESSION["Show_Username"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_First_Name"]))
	{
		$_SESSION["Show_First_Name"] = $_POST["Show_First_Name"];
	}
	else
	{
		$_SESSION["Show_First_Name"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Last_Name"]))
	{
		$_SESSION["Show_Last_Name"] = $_POST["Show_Last_Name"];
	}
	else
	{
		$_SESSION["Show_Last_Name"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Email"]))
	{
		$_SESSION["Show_Email"] = $_POST["Show_Email"];
	}
	else
	{
		$_SESSION["Show_Email"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Active"]))
	{
		$_SESSION["Show_Active"] = $_POST["Show_Active"];
	}
	else
	{
		$_SESSION["Show_Active"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Title"]))
	{
		$_SESSION["Show_Title"] = $_POST["Show_Title"];
	}
	else
	{
		$_SESSION["Show_Title"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_IC_Number"]))
	{
		$_SESSION["Show_IC_Number"] = $_POST["Show_IC_Number"];
	}
	else
	{
		$_SESSION["Show_IC_Number"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Matric_Number"]))
	{
		$_SESSION["Show_Matric_Number"] = $_POST["Show_Matric_Number"];
	}
	else
	{
		$_SESSION["Show_Matric_Number"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Contact_Number"]))
	{
		$_SESSION["Show_Contact_Number"] = $_POST["Show_Contact_Number"];
	}
	else
	{
		$_SESSION["Show_Contact_Number"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Residential_College"]))
	{
		$_SESSION["Show_Residential_College"] = $_POST["Show_Residential_College"];
	}
	else
	{
		$_SESSION["Show_Residential_College"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_CGPA"]))
	{
		$_SESSION["Show_CGPA"] = $_POST["Show_Attendance"];
	}
	else
	{
		$_SESSION["Show_CGPA"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Attendance"]))
	{
		$_SESSION["Show_Attendance"] = $_POST["Show_Attendance"];
	}
	else
	{
		$_SESSION["Show_Attendance"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Paid"]))
	{
		$_SESSION["Show_Paid"] = $_POST["Show_Paid"];
	}
	else
	{
		$_SESSION["Show_Paid"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Evaluation_Form"]))
	{
		$_SESSION["Show_Evaluation_Form"] = $_POST["Show_Evaluation_Form"];
	}
	else
	{
		$_SESSION["Show_Evaluation_Form"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_Completed_Status"]))
	{
		$_SESSION["Show_Completed_Status"] = $_POST["Show_Completed_Status"];
	}
	else
	{
		$_SESSION["Show_Completed_Status"] = false;
		$_SESSION["Show_Everything"] = false;
	}
	if(isset($_POST["Show_All"]))
	{
		$_SESSION["Show_All"] = $_POST["Show_All"];
	}
	else
	{
		$_SESSION["Show_All"] = false;
	}
	if(isset($_POST["Show_Unpaid"]))
	{
		$_SESSION["Show_Unpaid"] = $_POST["Show_Unpaid"];
	}
	else
	{
		$_SESSION["Show_Unpaid"] = false;
	}
	if(isset($_POST["Show_Everything"]))
	{
		$_SESSION["Show_Everything"] = $_POST["Show_Everything"];
	}
	else
	{
		$_SESSION["Show_Everything"] = false;
	}
	
	if($_SESSION["Show_Everything"] == true)
	{
		$_SESSION["Show_Completed_Status"] = true;
		$_SESSION["Show_Paid"] = true;
		$_SESSION["Show_Evaluation_Form"] = true;
		$_SESSION["Show_Attendance"] = true;
		$_SESSION["Show_CGPA"] = true;
		$_SESSION["Show_Residential_College"] = true;
		$_SESSION["Show_Contact_Number"] = true;
		$_SESSION["Show_Matric_Number"] = true;
		$_SESSION["Show_IC_Number"] = true;
		$_SESSION["Show_Title"] = true;
		$_SESSION["Show_Active"] = true;
		$_SESSION["Show_Email"] = true;
		$_SESSION["Show_Username"] = true;
		$_SESSION["Show_First_Name"] = true;
		$_SESSION["Show_Last_Name"] = true;
	}
	
	
}
else
{
	$_SESSION["First_Time"] = true;
}

	if(isset($_POST["searchMatric"]))
	{
		$_SESSION["searchMatric"] = $_POST["searchMatric"];
	}
	else
	{
		$_SESSION["searchMatric"] = "";
	}
	
	if(isset($_POST["search"]))
	{
		$_SESSION["search"] = $_POST["search"];
	}
	else
	{
		$_SESSION["search"] = "";
	}
		
	
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
	$changeValue;
	$total_Credits;
	
	
	$No;
	$Programmes;
	$Date;
	$Year;
	$registered;
	$Credits;
	$Attendance;
	$AttendanceStudent;
	$Evaluationform;
	$changeValue;
	$student_id;
	$student_user_id;
	$CGPA;
	$Paid;
	$Paid_Date;
	$Paid_Number;
	$Cost;
	$Time;
	$Total_Payment_Due;
	$Total_Payment_Paid;
	
   
mainDisplay();



function mainDisplay()
{
?>
</br>
</br>
<form name ="formOne" method ="Post" action ="register_check_attendance.php">

		<h1> STENT SUMMARY STATUS</h1>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Everything"] == true)
						{
						?>
							<input type="checkbox" name="Show_Everything" id="Show_Everything" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Everything" id="Show_Everything" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Everything">SHOW ALL FIELDS</label>
						<br/><br/>

						<!Checkbox!>
						<?php
						if($_SESSION["Show_Username"] == true)
						{
						?>
							<input type="checkbox" name="Show_Username" id="Show_Username" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Username" id="Show_Username" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Username">Patient Name</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_First_Name"] == true)
						{
						?>
							<input type="checkbox" name="Show_First_Name" id="Show_First_Name" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_First_Name" id="Show_First_Name" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_First_Name">First Name</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Last_Name"] == true)
						{
						?>
							<input type="checkbox" name="Show_Last_Name" id="Show_Last_Name" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Last_Name" id="Show_Last_Name" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Last_Name">Last Name</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Email"] == true)
						{
						?>
							<input type="checkbox" name="Show_Email" id="Show_Email" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Email" id="Show_Email" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Email">Email</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Active"] == true)
						{
						?>
							<input type="checkbox" name="Show_Active" id="Show_Active" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Active" id="Show_Active" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Active">Active Status</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Title"] == true)
						{
						?>
							<input type="checkbox" name="Show_Title" id="Show_Title" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Title" id="Show_Title" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Title">Gender</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_IC_Number"] == true)
						{
						?>
							<input type="checkbox" name="Show_IC_Number" id="Show_IC_Number" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_IC_Number" id="Show_IC_Number" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_IC_Number">IC Number</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Matric_Number"] == true)
						{
						?>
							<input type="checkbox" name="Show_Matric_Number" id="Show_Matric_Number" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Matric_Number" id="Show_Matric_Number" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Matric_Number">Patient ID</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Contact_Number"] == true)
						{
						?>
							<input type="checkbox" name="Show_Contact_Number" id="Show_Contact_Number" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Contact_Number" id="Show_Contact_Number" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Contact_Number">Contact Number</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Residential_College"] == true)
						{
						?>
							<input type="checkbox" name="Show_Residential_College" id="Show_Residential_College" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Residential_College" id="Show_Residential_College" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Residential_College">Address</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_CGPA"] == true)
						{
						?>
							<input type="checkbox" name="Show_CGPA" id="Show_CGPA" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_CGPA" id="Show_CGPA" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_CGPA">pH</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Attendance"] == true)
						{
						?>
							<input type="checkbox" name="Show_Attendance" id="Show_Attendance" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Attendance" id="Show_Attendance" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Attendance">Check Up</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Paid"] == true)
						{
						?>
							<input type="checkbox" name="Show_Paid" id="Show_Paid" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Paid" id="Show_Paid" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Paid">Paid</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Evaluation_Form"] == true)
						{
						?>
							<input type="checkbox" name="Show_Evaluation_Form" id="Show_Evaluation_Form" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Evaluation_Form" id="Show_Evaluation_Form" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Evaluation_Form">Evaluation Form Submitted</label>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Completed_Status"] == true)
						{
						?>
							<input type="checkbox" name="Show_Completed_Status" id="Show_Completed_Status" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="Show_Completed_Status" id="Show_Completed_Status" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<label for="Show_Completed_Status">Completed Status</label>
						<br/><br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_All"] == true)
						{
						?>
							<label for="Show_All">Show all stents</label>
							<input type="checkbox" name="Show_All" id="Show_All" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<label for="Show_All">Show only stents with participants</label>
							<input type="checkbox" name="Show_All" id="Show_All" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<br/>
						
						
						<!Checkbox!>
						<?php
						if($_SESSION["Show_Unpaid"] == true)
						{
						?>
							<label for="Show_Unpaid">Show Patients Who Have Not PAID</label>
							<input type="checkbox" name="Show_Unpaid" id="Show_Unpaid" value="true" checked="checked" onclick="this.form.submit();"/>
						<?php
						}
						else
						{
						?>
							<label for="Show_Unpaid">Show PAID and UNPAID patients</label>
							<input type="checkbox" name="Show_Unpaid" id="Show_Unpaid" value="true" onclick="this.form.submit();"/>
						<?php
						}
						?>
						<br/>
						<br/>
					
					<label for="search">General Search</label>
					<input class="boxshadow" type="text" name="search" id="search" value="<?php echo "" . $_SESSION['search']; ?>" />
					<br/>
					<br/>
					<label for="search">     Search Patient ID</label>
					<input class="boxshadow" type="text" name="searchMatric" id="searchMatric" value="<?php echo "" . $_SESSION['searchMatric']; ?>" />
					
					<input type="checkbox" name="Show_All" id="Show_All" value="true" onclick="this.form.submit();"/>
				
						
						<br/><br/>
<?php
	accessRulesDisp();
?>

<P>

	
</form>


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
		global $changeValue;
		global $total_Credits;
		
		global $No;
		global $Programmes;
		global $Date;
		global $Year;
		global $registered;
		global $Credits;
		global $Attendance;
		global $AttendanceStudent;
		global $Evaluationform;
		global $changeValue;
		global $student_id;
		global $student_user_id;
		global $CGPA;
		global $Paid;
		global $Paid_Date;
		global $Paid_Number;
		global $Cost;
		global $Time;
		global $Total_Payment_Due;
		global $Total_Payment_Paid;
		
		$totalNumberOfAttendanceSlots = 0;
		$actualNumberOfAttendanceSlots = 0;
		
		$Actual_Cost = 0;
		
		$genaralVariable = "";
		
		$my_little_counter = 0;
		$my_little_counter_disp = 1;
 
		
			//user_data($session_user_id, 'user_id', 'username', 'password',  'first_name', 'last_name', 'email', 'active', 'role', 'Title', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');
			
			$extraSQLQueryFINAL = "";
			$searchExists = false;
			$extraSQLQuery = "";
			
			$extraMatricSQLQuery = "";
			
			if(isset($_SESSION["searchMatric"]))
			{
				if($_SESSION["searchMatric"] == "" || $_SESSION["searchMatric"] == null || $_SESSION["searchMatric"] == "null" || $_SESSION["searchMatric"] == "NULL")
				{
				}
				else
				{
					$extraMatricSQLQuery = " AND Matric_Number LIKE '%" . $_SESSION["searchMatric"] . "%'";
				}
			}
			else
			{
				$extraMatricSQLQuery = "";
			}
			
			if(isset($_SESSION["search"]))
			{
				if($_SESSION["search"] == "" || $_SESSION["search"] == null || $_SESSION["search"] == "null" || $_SESSION["search"] == "NULL")
				{
				}
				else
				{
					$searchString = str_replace ("'", "\'", $_SESSION['search']);
					$extraSQLQuery = " AND (Programmes LIKE '%" . $searchString . 
										"%' OR Date LIKE '%" . $searchString . 
										"%' OR Cost LIKE '%" . $searchString . 
										"%' OR Attendance LIKE '%" . $searchString .
										"%' OR Year LIKE '%" . $searchString .
										"%' OR Credits LIKE '%" . $searchString .
										"%')";
						
					$extraSQLQueryB = "SELECT * FROM seru_students.seru_courses WHERE Date != 'DELETED'" . $extraSQLQuery . " ORDER BY Year DESC;";
					
					$sql = mysql_query($extraSQLQueryB);

					$searchExists = false;
					try
					{
						if(!empty($sql))
						{	
							while($row = mysql_fetch_assoc($sql))
							{
								$searchExists = true;
								echo "<br/>" . $row['Programmes'];
							}
						}
						else
						{
							$searchExists = false;
							$extraSQLQuery = "";
						}
					}
					catch( PDOException $e)
					{
						echo "Query failed:".$e->getMessage();
					}
					
					if($searchExists == false)
					{				
						$extraSQLQuery = "";
						
						if($extraMatricSQLQuery == "")
						{
							$extraSQLQueryB = "SELECT user_id FROM users WHERE username LIKE '%" . $searchString . 
																			"%' or first_name LIKE '%" . $searchString .  
																			"%' or last_name LIKE '%" . $searchString .  
																			"%' or Title LIKE '%" . $searchString .  
																			"%' or email LIKE '%" . $searchString .  
																			"%' or active LIKE '%" . $searchString .  
																			"%' or CGPA LIKE '%" . $searchString .
																			"%';";
						}
						else
						{
							$extraSQLQueryB = "SELECT user_id FROM users WHERE (username LIKE '%" . $searchString . 
																			"%' or first_name LIKE '%" . $searchString .  
																			"%' or last_name LIKE '%" . $searchString .  
																			"%' or Title LIKE '%" . $searchString .  
																			"%' or email LIKE '%" . $searchString .  
																			"%' or active LIKE '%" . $searchString .  
																			"%' or CGPA LIKE '%" . $searchString .
																			"%') " . $extraMatricSQLQuery . ";";
						}
						
						$sql = mysql_query($extraSQLQueryB);
						
						//echo "<br/>" . $extraSQLQueryB;

						$searchExists = false;
						$extraSQLQueryFINAL = "";
						try
						{
							if(!empty($sql))
							{	
								while($row = mysql_fetch_assoc($sql))
								{
									$mini_user_search = intval($row["user_id"]);
						
									if($extraSQLQueryFINAL == "")
									{
										$extraSQLQueryFINAL = " AND (user_id = '" . $mini_user_search . "'";
									}
									else
									{
										$extraSQLQueryFINAL = $extraSQLQueryFINAL . " OR user_id = '" . $mini_user_search . "'";
									}
								}//end while($row = mysql_fetch_assoc($sql))
							}
							else
							{
								$searchExists = false;
							}
						}
						catch( PDOException $e)
						{
							echo "Query failed:".$e->getMessage();
						}
						
						
						if($extraSQLQueryFINAL == "")
						{
						}
						else
						{
							$extraSQLQueryFINAL = $extraSQLQueryFINAL . ")";
						}
					}//end if($searchExists == false)
				}//end else for if($_SESSION["search"] == "" || $_SESSION["search"] == null || $_SESSION["search"] == "null" || $_SESSION["search"] == "NULL")
			}//end if(isset($_SESSION["search"]))
			
			$extraSQLQueryB = "SELECT * FROM seru_students.seru_courses WHERE Date != 'DELETED'" . $extraSQLQuery . " ORDER BY Year DESC;";
			
			//echo "<br/><br/>MAIN = " . $extraSQLQueryB . "<br/>";
			
			$sql = mysql_query($extraSQLQueryB);
			
//$sql = mysql_query("SELECT * FROM users WHERE role = 'student' ORDER BY first_name;");
//$sql = mysql_query("SELECT * FROM users WHERE role like '%student%'");

			try
			{
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{		
				
					$No = $row["No"];
					$Programmes = $row["Programmes"];
					$Date = $row["Date"];
					$Year = $row["Year"];
					$Credits = $row["Credits"];
					$Attendance = $row["Attendance"];
					$Cost = $row["Cost"];
					$Time = $row["Time"];
					
					
					$Actual_Cost = extract_numbers("" . $Cost);
					$Total_Payment_Due = 0;
					$Total_Payment_Paid = 0;
					
					//echo "<br/>Number " . $Cost . " =" . $Actual_Cost . "=";

					$AttendanceCurrentCount = 0;
					
					$extraSQLQuery = "";
					
					if($_SESSION["Show_Unpaid"] == false && $Actual_Cost > 0)
					{
						$extraSQLQuery = " AND Paid = '0'";
					}
					
					
					$extraSQLQueryB = "SELECT * FROM students WHERE courses = '" . $No . "'" . $extraSQLQuery . $extraSQLQueryFINAL . " AND registered != 'notregistered' ORDER BY student_id;";
					
					//echo "<br/> SUB = " . $extraSQLQueryB . "<br/>";
					
					$sql2 = mysql_query($extraSQLQueryB);
					
					$sqlCheck = mysql_query($extraSQLQueryB);
					$ContainsParticipants = 0;
					try
					{
						if(!empty($sql2))
						{
							while($row = mysql_fetch_assoc($sqlCheck))
							{
								$ContainsParticipants++;
							}
						}
					}
					catch( PDOException $e)
					{
						echo "Query failed:".$e->getMessage();
					}
					
					try
					{
						if((!empty($sql2) && $ContainsParticipants > 0 && $_SESSION["Show_All"] == false) || 
							(!empty($sql2) && $_SESSION["Show_All"] == true))
						{
						
						
				?>
				<table class="ep_tm_main"><tr><td align="left">
					<h1 class="ep_tm_pagetitle"><?php echo "". $Programmes;?> </h1>

					<h2>(Year: <?php echo "". $Year;?>, Date: <?php echo "". $Date;?>, Time: <?php echo "". $Time;?>, Age: <?php echo "". $Credits;?>, Cost: <?php echo "". $Cost;?>)</h2>

				<table class="display nowrap table table-striped" style="width: 100%">
					<thead>
					<tr>
						<td><strong>No</strong></td> 
						<?php
						if($_SESSION["Show_Username"] == true)
						{
							?>
							<td><strong>Patient name</strong></td> 
							<?php
						}
						if($_SESSION["Show_First_Name"] == true)
						{
							?>
							<td><strong>Patient First Name</strong></td>
							<?php
							//<td><strong>First Name</strong></td>
						}
						else if($_SESSION["Show_Last_Name"] == true)
						{
							?>
							<td><strong>Patient Last Name</strong></td>
							<?php
							//<td><strong>Last Name</strong></td>
						}
						if($_SESSION["Show_Email"] == true)
						{
							?>
							<td><strong>Email</strong></td>
							<?php
						}
						if($_SESSION["Show_Active"] == true)
						{
							?>
							<td><strong>Active</strong></td>
							<?php
						}
						if($_SESSION["Show_Title"] == true)
						{
							?>
							<td><strong>Gender</strong></td>
							<?php
						}
						if($_SESSION["Show_IC_Number"] == true)
						{
							?>
							<td><strong>IC Number</strong></td>
							<?php
						}
						if($_SESSION["Show_Matric_Number"] == true)
						{
							?>
							<td><strong>Patient ID</strong></td>
							<?php
						}
						if($_SESSION["Show_Contact_Number"] == true)
						{
							?>
							<td><strong>Contact Number</strong></td>
							<?php
						}
						if($_SESSION["Show_Residential_College"] == true)
						{
							?>
							<td><strong>Address</strong></td>
							<?php
						}
						if($_SESSION["Show_CGPA"] == true)
						{
							?>
							<td><strong>pH</strong></td>
							<?php
						}
						if($_SESSION["Show_Attendance"] == true)
						{
							$AttendanceCurrentCount = 1;
							$totalNumberOfAttendanceSlots = $Attendance;
							while($AttendanceCurrentCount <= $Attendance)
							{
								?>
								<td><strong>Check Up <?php echo "". $AttendanceCurrentCount;?></strong></td> 
								<?php
								$AttendanceCurrentCount++;
							}
							?>
								<td><strong>Total Check Ups</strong></td> 
							<?php
						}
						if($_SESSION["Show_Evaluation_Form"] == true)
						{
							?>
							<td><strong>Evaluation Form Submitted</strong></td> 
							<?php
						}
						if($_SESSION["Show_Paid"] == true)
						{
							?>
							<td><strong>Payment Submitted</strong></td> 
							<?php
						}
						if($_SESSION["Show_Completed_Status"] == true)
						{
							?>
							<td><strong>Status</strong></td>
							<?php
						}
						?>
						
					</tr>
					</thead>	
				<?php
						$count_ = 0;
				
							while($row = mysql_fetch_assoc($sql2))
							{
								
								$student_user_id = $row["user_id"];
								$registered = $row["registered"];
								$AttendanceStudent = $row["Attendance"];
								$Evaluationform = $row["Evaluationform"];
								$Paid = $row["Paid"];
								$Paid_Date = $row["Paid_Date"];
								$Paid_Number = $row["Paid_Number"];
								
								if($Paid == 1)
								{
									$Total_Payment_Paid = $Total_Payment_Paid + $Actual_Cost;
								}
								else
								{
									$Total_Payment_Due = $Total_Payment_Due + $Actual_Cost;
								}
								
								
								$sql3 = mysql_query("SELECT * FROM seru_students.users WHERE user_id = '" . $student_user_id . "'" . $extraMatricSQLQuery . 
													" ORDER BY first_name;");
								
								try
								{
									if(!empty($sql3))
									{	
										while($row = mysql_fetch_assoc($sql3))
										{
											$count_++;
											if(($count_ % 2) == 1)
											{
												$color = "#e6e6fa";
											}
											else
											{
												$color = "#ffffff";
											}
											
											$username = $row["username"];
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
											
											$genaralVariable = "";
											
											echo "<td bgcolor=\"".$color."\" width=\"3%\">";
											printf("%.0f" , $count_);
											echo "</td>\r\n";
											
											
											if($_SESSION["Show_Username"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $username . "</td>\r\n";
											}
											if($_SESSION["Show_First_Name"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $first_name . " " . $last_name . "</td>\r\n";
											}
											else if($_SESSION["Show_Last_Name"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $first_name . " " . $last_name . "</td>\r\n";
											}
											if($_SESSION["Show_Email"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $email . "</td>\r\n";
											}
											if($_SESSION["Show_Active"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $active . "</td>\r\n";
											}
											if($_SESSION["Show_Title"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Title . "</td>\r\n";
											}
											if($_SESSION["Show_IC_Number"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $IC_number . "</td>\r\n";
											}
											if($_SESSION["Show_Matric_Number"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Matric_Number . "</td>\r\n";
											}
											if($_SESSION["Show_Contact_Number"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Hand_Phone_Number . "</td>\r\n";
											}
											if($_SESSION["Show_Residential_College"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Kolej_Kediaman . "</td>\r\n";
											}
											if($_SESSION["Show_CGPA"] == true)
											{
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $CGPA . "</td>\r\n";
											}
											if($_SESSION["Show_Attendance"] == true)
											{
												$AttendanceCurrentCount = 1;
												$actualNumberOfAttendanceSlots = 0;
												while($AttendanceCurrentCount <= $Attendance)
												{
													$AttendanceArray = explode(";" , $AttendanceStudent);
													$AttendanceArrayCount = 0;
						
													//echo "<br/>my_little_counter_Attendance = " . $my_little_counter_Attendance;
													//echo "<br/>AttendanceStudent = " . $AttendanceStudent;
													if($AttendanceArray[$AttendanceCurrentCount - 1])
													{
														//echo "<br/>AttendanceArray[" . $AttendanceCurrentCount ."] = " . $AttendanceArray[$AttendanceCurrentCount - 1];
														if(preg_match("/" . $AttendanceArray[$AttendanceCurrentCount - 1] . "/i" , "1") == 1)
														{
															$AttendanceArrayCount = 1;
														}
													}
													
													$genaralVariable = "No";
													if($AttendanceArrayCount == 1)
													{
														$genaralVariable = "Yes";
														$actualNumberOfAttendanceSlots++;
													}
													echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $genaralVariable . "</td>\r\n";
													$AttendanceCurrentCount++;
												}
												
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $actualNumberOfAttendanceSlots . " / " . 
																									$totalNumberOfAttendanceSlots . "</td>\r\n";
											}
											if($_SESSION["Show_Evaluation_Form"] == true)
											{
												$genaralVariable = "No";
												
												if($Evaluationform == 1)
												{
													$genaralVariable = "Yes";
												}
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $genaralVariable . "</td>\r\n";
											}
											if($_SESSION["Show_Paid"] == true)
											{
												$genaralVariable = "No";
												
												if($Paid == 1)
												{
													$genaralVariable = "Yes:" . "<br/>" . $Paid_Date . "<br/>" . $Paid_Number;
												}
												echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $genaralVariable . "</td>\r\n";
											}
											if($_SESSION["Show_Completed_Status"] == true)
											{
												if($registered == "incomplete")
												{
													echo "<td bgcolor=\"".$color."\" width=\"2%\">INCOMPLETE</td>\r\n";
												}
												else if($registered == "completed")
												{
													echo "<td bgcolor=\"".$color."\" width=\"2%\">COMPLETED</td>\r\n";
												}
												else if($registered == "unregistered")
												{
													echo "<td bgcolor=\"".$color."\" width=\"2%\">DROPPED</td>\r\n";
												}
												else
												{
													echo "<td bgcolor=\"".$color."\" width=\"2%\">REGISTERED</td>\r\n";
												}
												
											}
											
											echo "</tr>\r\n";
										}
									}
								}
								catch( PDOException $e)
								{
									echo "Query failed:".$e->getMessage();
								}
							}
							
				?>
				</table>
				
			<h3>(Total Payment Due: <?php echo "". $Total_Payment_Due;?>, Total Payment Collected: <?php echo "". $Total_Payment_Paid;?>)</h3>
				
				</td></tr></table>
				<?php
						
				echo "<br/><br/>";	//SPACER
						}
					}
					catch( PDOException $e)
					{
						echo "Query failed:".$e->getMessage();
					}
					
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
					//echo "" . $my_little_counter_disp . ") ";
					
					//$_SESSION["user_id" . $my_little_counter] = $user_id;
					//$_SESSION["password" . $my_little_counter] = $password;
															
					
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
			
   }//end function accessRulesDisp()
   
   
   
	function extract_numbers($string)
	{
		$match = 0;
		
		$str = $string . "x0";
		preg_match_all('!\d+(?:\.\d+)?!', $str, $matches);
		$floats = array_map('floatval', $matches[0]);
		
		//print_r($floats);
		
		$match = $floats[0];
		
		//echo "" . $match;

		/*//METHOD BASIC
		$match = 0;
		
		$string = preg_replace("/[^0-9]/", '', $string);
		
		if($string == "" || $string == null)
		{
		}
		else
		{
			$match = intval($string);
		}
		/**/

		return $match;
	}//end function extract_numbers($string)
	
	
   
	function getCreditsRegistered($student_id_here, $reprocess)
	{
			if(isset($_SESSION["studentCreditsRegistered" . $student_id_here]) && $reprocess == "false")
			{
				//echo "BASIC";
				$maxID = $_SESSION["studentCreditsRegistered" . $student_id_here];
			}
			else
			{
			$finalcounter = 0;
			$maxID = 0;
			$hereUser_ID = $student_id_here;
			$theQueryHere = "SELECT * FROM students WHERE user_id = '" . $hereUser_ID . "' AND registered = 'registered';";
			//echo "" . $theQueryHere;
			$sql = mysql_query($theQueryHere);
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["credits"];
						$maxID = $maxID + $finalcounter;
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
			
			$_SESSION["studentCreditsRegistered" . $hereUser_ID] = $maxID;
			
				//echo "REPROSES =" . $_SESSION["studentCreditsCompleted" . $hereUser_ID] . "=  id = " . $hereUser_ID;
			}
			
			return $maxID;
	}//end function getCreditsRegistered()
	
	
	function getCreditsCompleted($student_id_here, $reprocess)
	{
			if(isset($_SESSION["studentCreditsCompleted" . $student_id_here]) && $reprocess == "false")
			{
				//echo "BASIC";
				$maxID = $_SESSION["studentCreditsCompleted" . $student_id_here];
			}
			else
			{
			$finalcounter = 0;
			$maxID = 0;
			$hereUser_ID = $student_id_here;
			
			$theQueryHere = "SELECT * FROM students WHERE user_id = '" . $hereUser_ID . "' AND registered = 'completed';";
			//echo "" . $theQueryHere;
			$sql = mysql_query($theQueryHere);
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["credits"];
						$maxID = $maxID + $finalcounter;
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
			
			$_SESSION["studentCreditsCompleted" . $hereUser_ID] = $maxID;
			
				//echo "REPROSES =" . $_SESSION["studentCreditsCompleted" . $hereUser_ID] . "=  id = " . $hereUser_ID;
			}
			
			return $maxID;
	}//end function getCreditsCompleted()
   
   
   
   
			mysql_close($dbconn) or die ("could not close database");
   
   ?>

   </body>
		<script>
			$(document).ready(function() {
    		$('table.display').DataTable( {
        		"scrollX": true
    			} );
			} );
		</script>
</html>