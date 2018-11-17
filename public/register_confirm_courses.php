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

 if($user_data['role'] == 'student')
{
	header("location: register_student_course.php");
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
	$Cost;
	$CGPA;
	$Matric_Number;
	$Paid;
	$Paid_Date;
	$Paid_Number;
	
	$studentName;
	
	$mainMessage = "STENT";
	
	
	
if( isset( $_POST['submit2'] ))
{
	$_SESSION['student_select'] = $_POST["student_select_choice"];
	$_SESSION['course_select'] = $_POST["course_select_choice"];
	$_SESSION['registered_status'] = $_POST["registered_status_choice"];
	$_SESSION['search'] = $_POST["search"];
	//echo "<br/>" . $_POST["registered_status_choice"];
}
else if( isset( $_POST['submit'] ))
{
	
	$_SESSION['student_select'] = $_POST["student_select_choice"];
	$_SESSION['course_select'] = $_POST["course_select_choice"];
	$_SESSION['registered_status'] = $_POST["registered_status_choice"];
	$_SESSION['search'] = $_POST["search"];
	
	if(isset( $_POST['userResponse'] ))
	{
		$_SESSION['counter2'] = $_SESSION['counter2'] + 1;
	}
	$counter = $_SESSION['counter2'];
	$arrayIndex = $counter - 2;
	
	//echo "Counter =" . $counter; 
	
	$my_little_counter = 0;
	
	while($my_little_counter < $_SESSION['counterMax'])
	{	
		//echo "<br/>LASTA = " . $_POST['Year2'] . "=   <br/>";
		//echo "<br/>LAST = " . $_POST["Year1"] . "=   ";
	
					
		$changeValue = "" . $_POST["changeValue". $my_little_counter];
				
		//echo "<br/>CHANGE = " . $changeValue . "=   CounterMax =" . $_SESSION['counterMax'] . "=";
		
			$Evaluationform = 0;
			
			if(isset($_POST["EvaluationFormReceived" . $my_little_counter]))
			{
				if($_POST["EvaluationFormReceived" . $my_little_counter] == true)
				{
					$Evaluationform = 1;
				}
			}
			
			
			if(isset($_POST["Paid_Number" . $my_little_counter]))
			{
					$_SESSION["Paid_Number" . $my_little_counter] = $_POST["Paid_Number" . $my_little_counter];
					$mainMessage = "PAYMENT";
					//echo "<br/>SESSION = " . $_SESSION["Paid_Number" . $my_little_counter];
			}
			
			
			$my_little_counter_Attendance = 1;
			$AttendanceStudent = "";
			
			while($my_little_counter_Attendance <= $_SESSION["Attendance" . $my_little_counter])
			{
				$Attendance = 0;
				if(isset($_POST[$my_little_counter_Attendance . "Attendance" . $my_little_counter]))
				{
					if($_POST[$my_little_counter_Attendance . "Attendance" . $my_little_counter] == true)
					{
						$Attendance = 1;
					}
				}
				$AttendanceStudent = $AttendanceStudent . $Attendance . ";";
				$my_little_counter_Attendance++;
			}
			
			
			$Paid = 0;
			
			if(isset($_POST["Paid" . $my_little_counter]))
			{
				if($_POST["Paid" . $my_little_counter] == true)
				{
					$Paid = 1;
					
				}
			}
			
			$mainMessage = "STENT";
			
		if($_POST["registered". $my_little_counter] != $_SESSION["registeredOri" . $my_little_counter] ||
			$_SESSION["Evaluationform" . $my_little_counter] != $Evaluationform ||
			$_SESSION["AttendanceOri" . $my_little_counter] != $AttendanceStudent ||
			$_SESSION["Paid" . $my_little_counter] != $Paid)
		{
				if($user_data['role'] == 'administrator'|| $user_data['role'] == 'doctor')
				{
					//echo "<br/> Changed";
					$_SESSION["Evaluationform" . $my_little_counter] = $Evaluationform;
					$_SESSION["AttendanceOri" . $my_little_counter] = $AttendanceStudent;
					if($_SESSION["Paid" . $my_little_counter] != $Paid)
					{
						if($Paid == 0)
						{
							$_SESSION["Paid_Date" . $my_little_counter] = "0";
							
							$_SESSION["Paid_Number" . $my_little_counter] = "0";
						}
						else
						{
							$_SESSION["Paid_Date" . $my_little_counter] = "" . $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'];
							$_SESSION["Paid_DateORI" . $my_little_counter] = $_SESSION["Paid_Date" . $my_little_counter];
							
							
							if($_SESSION["Paid_Number" . $my_little_counter] == null)
							{
								$_SESSION["Paid_Number" . $my_little_counter] = 0;
							}
							$_SESSION["Paid_NumberORI" . $my_little_counter] = $_SESSION["Paid_Number" . $my_little_counter];
							
							$mainMessage = "PAYMENT";
						}
					}
					$_SESSION["Paid" . $my_little_counter] = $Paid;
					
					//echo "<br/>SESSION = " . $_SESSION["Paid_Number" . $my_little_counter];
					
					updateUsers($my_little_counter);
				}
		}//end if($changeValue == true)
			
		if($_SESSION["Paid" . $my_little_counter] == 1 && $_SESSION["Paid_DateORI" . $my_little_counter] == "0")
		{
			$_SESSION["Paid_Date" . $my_little_counter] = "" . $_SESSION['currentDate'] . "-" . $_SESSION['currentMonth'] . "-" . $_SESSION['currentYear'];
			echo "<br/>UPDATED PAYMENT RECEIVED DATE";
			updateUsers($my_little_counter);
		}
		
		if($_SESSION["Paid" . $my_little_counter] == 1)
		{
			if($_SESSION["Paid_NumberORI" . $my_little_counter] == $_SESSION["Paid_Number" . $my_little_counter])
			{
				
			}
			else
			{
							if($_SESSION["Paid_Number" . $my_little_counter] == null)
							{
								$_SESSION["Paid_Number" . $my_little_counter] = 0;
							}
							$_SESSION["Paid_NumberORI" . $my_little_counter] = $_SESSION["Paid_Number" . $my_little_counter];
							
			echo "<br/>UPDATED PAYMENT RECEIPT NUMBER";
			
			updateUsers($my_little_counter);
			}
		}
	
		$my_little_counter++;
	}//end while($my_little_counter < $_SESSION['counterMax'])
	
}//end if( isset( $_POST['submit'] ))
else
{
	$_SESSION['search'] = "";
	//$_SESSION['search'] = "internship";
	//$_SESSION['search'] = getLatestCourseID();
	
	
	$_SESSION['search_user_id'] = "";
	$_SESSION['student_select'] = "all";
	
	//$_SESSION['course_select'] = "all";
	$_SESSION['course_select'] = getLatestCourseID();
	
	
	$_SESSION['registered_status'] = "all";
	
	
	$_SESSION['userID_select'] = 1;
	$_SESSION['courseID_select'] = 1;
	
	$_SESSION['numglobalMax'] = 0;
	$_SESSION['cfglobal'] = 0;
	$_SESSION['cfglobalMax'] = 0;
	$_SESSION['ActualCFFinal'] = 0;
	$_SESSION['counter2'] = 1;
	$_SESSION['counterMax'] = 1;
	
	
	$_SESSION['student_id'] = 0;
	$_SESSION['user_id'] = $user_data['user_id'];
	
	//echo "" . $user_data['user_id'];
	
	//echo "Setting Counter!!!";
	
	$_SESSION['answer'] = array();
	$_SESSION['answer_Literal'] = array();
	
}
mainDisplay();



function mainDisplay()
{
?>
</br>
</br>
<div style="width: 80%">
<form name ="formOne" method ="Post" action ="register_confirm_courses.php">
<?php
	accessRulesDisp();
?>

<P>

	
</form>
</div>

<!--
<h1> <?php echo $user_data['Date'];?> You have answered <?php echo $counter-1;?> question and total marks accumulated <?php echo $_SESSION['ActualCFFinal'];?> <?php echo $_SESSION['numglobalMax'];?> </h1>
-->



   <?php 
   }//end function mainDisplay()
   
   include 'includes/overall/footer.php';
   
    
   function accessRulesDisp()
   {
		global $mainMessage;
		global $counter;
		global $user_data;
		global $total;
		
		
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
		global $studentName;
		global $student_user_id;
		global $CGPA;
		global $Matric_Number;
		global $Paid;
		global $Paid_Date;
		global $Paid_Number;
		global $Cost;
		
		$totalNumberOfAttendanceSlots = 0;
		$actualNumberOfAttendanceSlots = 0;
		
		
		$theCompletedCredits;
		$theRegisteredCredits;
		
		$AttendanceArray = array();
		$AttendanceArrayCount = 0;
		$AttendanceArrayCounter = 0;
		
		
		while($AttendanceArrayCounter < 100)
		{
			$AttendanceArray[$AttendanceArrayCounter] = "0";
			$AttendanceArrayCounter++;
		}
		
		$my_little_counter = 0;
		$my_little_counter_disp = 1;
		
		$my_little_counter_Attendance = 0;;
 
		?>
		<h1> STENT REGISTRATION PAGE</h1>
		
		<?php		
		
				$selectedAlready = false;
				
					$sql_mini = mysql_query("SELECT * FROM users WHERE Registration_Date LIKE '%" . $_SESSION['currentYear'] . "%' ORDER BY first_name;");
					?>
				
					<!Multi Select!>
					<label for="<?php echo "student_select_choice"?>">SELECT PATIENT:</label>
					<select class="boxshadow" name = "<?php echo "student_select_choice";?>" id = "<?php echo "student_select_choice";?>" size = "0" >
					<?php
					
					if(!empty($sql_mini))
					{	
						while($row = mysql_fetch_assoc($sql_mini))
						{
							$studentName = $row["first_name"];
							$studentName = $studentName . " " . $row["last_name"];
							
							if($_SESSION['student_select'] == $studentName && $selectedAlready == false)
							{
								$selectedAlready = true;
								$_SESSION['userID_select'] = $row["user_id"];
								?>
								<option value = "<?php echo "" . $studentName;?>" selected = "selected"><?php echo "" . $studentName;?></option>
								<?php
							}
							else
							{
								?>
								<option value = "<?php echo "" . $studentName;?>"><?php echo "" . $studentName;?></option>
								<?php
							}
						}//end while($row = mysql_fetch_assoc($sql_mini))
					}//end if(!empty($sql_mini))
					
					if($selectedAlready == false)
					{
								?>
								<option value = "all" selected = "selected">All</option>
								<?php
					}
					else
					{
								?>
								<option value = "all">All</option>
								<?php
					}
		
					?>
					</select>
					<br/>
					<br/>
					
		<?php
				$selectedAlready = false;
				
					$sql_mini = mysql_query("SELECT * FROM seru_courses WHERE date != 'DELETED' ORDER BY Programmes;");
					
					
					?>
				
					<!Multi Select!>
					<label for="<?php echo "course_select_choice"?>">SELECT STENT</label>
					<select class="boxshadow" name = "<?php echo "course_select_choice";?>" id = "<?php echo "course_select_choice";?>" size = "0">
					<?php
					
					if(!empty($sql_mini))
					{	
						while($row = mysql_fetch_assoc($sql_mini))
						{
							$studentName = $row["Programmes"];
							
							if($_SESSION['course_select'] == $studentName && $selectedAlready == false)
							{
								$selectedAlready = true;
								$_SESSION['courseID_select'] = $row["No"];
								?>
								<option value = "<?php echo "" . $studentName;?>" selected = "selected"><?php echo "" . $studentName;?></option>
								<?php
							}
							else
							{
								?>
								<option value = "<?php echo "" . $studentName;?>"><?php echo "" . $studentName;?></option>
								<?php
							}
						}//end while($row = mysql_fetch_assoc($sql_mini))
					}//end if(!empty($sql_mini))
					
					if($selectedAlready == false)
					{
								?>
								<option value = "all" selected = "selected">All</option>
								<?php
					}
					else
					{
								?>
								<option value = "all">All</option>
								<?php
					}
		
					?>
					</select>
					
					<br/>
					<br/>
					<!Multi Select!>
					<label for="<?php echo "registered_status_choice"?>">SELECT REGISTERED STATUS</label>
					<select class="boxshadow" name = "<?php echo "registered_status_choice";?>" id = "<?php echo "registered_status_choice";?>" size = "0">
					<?php
					if($_SESSION['registered_status'] == "all")
					{
						?>
						<option value = "all" selected = "selected">ALL</option>
						<option value = "registered">REGISTERED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "completed">COMPLETED</option>
						<option value = "unregistered">DROPPED</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "registered")
					{
						?>
						<option value = "registered" selected = "selected">REGISTERED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "unregistered">DROPPED</option>
						<option value = "all">ALL</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "unregistered")
					{
						?>
						<option value = "unregistered" selected = "selected">DROPPED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "registered">REGISTERED</option>
						<option value = "all">ALL</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "completed")
					{
						?>
						<option value = "completed" selected = "selected">COMPLETED</option>
						<option value = "registered">REGISTERED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "unregistered">DROPPED</option>
						<option value = "all">ALL</option>
						<?php
					}
					else if($_SESSION['registered_status'] == "incomplete")
					{
						?>
						<option value = "incomplete" selected = "selected">INCOMPLETE</option>
						<option value = "completed">COMPLETED</option>
						<option value = "registered">REGISTERED</option>
						<option value = "unregistered">DROPPED</option>
						<option value = "all">ALL</option>
						<?php
					}
					
					?>
					</select>
					
					<br/>
					<br/>
					<label for="search">Search</label>
					<input class="boxshadow" type="text" name="search" id="search" value="<?php echo "" . $_SESSION['search']; ?>" />
					<br/>
					<br/>
					<input class="button2 width90 p5" type = "submit" name = "submit2" value = "Filter" />
					
		
		<?php
		
			$_SESSION['search_user_id'] = "";
			
			$mini_user_search = 0;
			
			if($_SESSION['search'] == "" || strToLower($_SESSION['search']) == "all" || preg_match('/^[1-9]\d{3}$/', $_SESSION['search']) ||
				preg_match('/January/',$_SESSION['search']) ||
				preg_match('/February/',$_SESSION['search']) ||
				preg_match('/March/',$_SESSION['search']) ||
				preg_match('/April/',$_SESSION['search']) ||
				preg_match('/May/',$_SESSION['search']) ||
				preg_match('/June/',$_SESSION['search']) ||
				preg_match('/July/',$_SESSION['search']) ||
				preg_match('/August/',$_SESSION['search']) ||
				preg_match('/September/',$_SESSION['search']) ||
				preg_match('/October/',$_SESSION['search']) ||
				preg_match('/November/',$_SESSION['search']) ||
				preg_match('/December/',$_SESSION['search']))
			{
				$_SESSION['search_user_id'] = "";
			}
			else
			{
				$the_here_query = "SELECT user_id FROM users WHERE username LIKE '%" . $_SESSION['search'] . 
																			"%' or first_name LIKE '%" . $_SESSION['search'] .  
																			"%' or last_name LIKE '%" . $_SESSION['search'] .  
																			"%' or Title LIKE '%" . $_SESSION['search'] .  
																			"%' or email LIKE '%" . $_SESSION['search'] .  
																			"%' or active LIKE '%" . $_SESSION['search'] .  
																			"%' or CGPA LIKE '%" . $_SESSION['search'] .
																			"%' or Matric_Number LIKE '%" . $_SESSION['search'] .
																			"%';";
			}
			
				//echo "<br/>USER<br/>" . $the_here_query;
			
			$sql = mysql_query($the_here_query);
			

			try
			{
				if(!empty($sql))
				{	
					while($row = mysql_fetch_assoc($sql))
					{
						$mini_user_search = intval($row["user_id"]);
						
						if($_SESSION['search_user_id'] == "")
						{
							$_SESSION['search_user_id'] = " AND (user_id = '" . $mini_user_search . "'";
						}
						else
						{
							$_SESSION['search_user_id'] = $_SESSION['search_user_id'] . " OR user_id = '" . $mini_user_search . "'";
						}
					}//end while($row = mysql_fetch_assoc($sql))
				}
				else
				{
					//echo "EMPTY...";
				}
			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
			
			
			if($_SESSION['search_user_id'] == "")
			{
				$mini_user_search = 0;
			
				if($_SESSION['search'] == "")
				{
					$the_here_query = "SELECT No FROM seru_courses WHERE Year LIKE '%" . $_SESSION['currentYear'] .  "%';";
				}
				else if(strToLower($_SESSION['search']) == "all")
				{
					$_SESSION['search_user_id'] = "";
				}
				else
				{
					$the_here_query = "SELECT No FROM seru_courses WHERE Programmes LIKE '%" . $_SESSION['search'] . 
																			"%' or Date LIKE '%" . $_SESSION['search'] .  
																			"%' or Year LIKE '%" . $_SESSION['search'] .  
																			"%' or Credits LIKE '%" . $_SESSION['search'] .  
																			"%' or Attendance LIKE '%" . $_SESSION['search'] .  
																			"%' or Cost LIKE '%" . $_SESSION['search'] . 
																			"%';";
				}
				//echo "<br/>PROGRAMME<br/>" . $the_here_query;
			
				$sql = mysql_query($the_here_query);

				try
				{
					if(!empty($sql))
					{	
						while($row = mysql_fetch_assoc($sql))
						{
							$mini_user_search = intval($row["No"]);
						
							if($_SESSION['search_user_id'] == "")
							{
								$_SESSION['search_user_id'] = " AND (courses = '" . $mini_user_search . "'";
							}
							else
							{
								$_SESSION['search_user_id'] = $_SESSION['search_user_id'] . " OR courses = '" . $mini_user_search . "'";
							}
						}//end while($row = mysql_fetch_assoc($sql))
					}
					else
					{
						//echo "EMPTY...";
					}
				}
				catch( PDOException $e)
				{
					echo "Query failed:".$e->getMessage();
				}
			}//end if($_SESSION['search_user_id'] == "")
			
			
			if($_SESSION['search_user_id'] == "")
			{
			}
			else
			{
				$_SESSION['search_user_id'] = $_SESSION['search_user_id'] . ")";
			}
			
			
			//echo "<br/>TOTAL CREDITS REGISTERED: " . getCreditsRegistered();
			//echo "<br/>TOTAL CREDITS COMPLETED: " . getCreditsCompleted();
		
			//user_data($session_No, 'No', 'Programmes', 'password',  'Date', 'Year', 'email', 'active', 'role', 'Credits', 'IC_number', 'Matric_Number', 'Hand_Phone_Number', 'Kolej_Kediaman');
			
			$the_here_query = "";
			
			if($_SESSION['registered_status'] == "all")
			{
				$the_here_query = "SELECT * FROM students WHERE (registered = 'registered' OR registered = 'completed' OR registered = 'incomplete' OR registered = 'unregistered')";
			}
			else
			{
				$the_here_query = "SELECT * FROM students WHERE registered = '" . $_SESSION['registered_status'] . "'";
			}
			
			if($_SESSION['course_select'] == "all")
			{
			}
			else
			{
				$the_here_query = $the_here_query . " AND courses = '" . $_SESSION['courseID_select'] . "'";
			}
			
			if($_SESSION['student_select'] == "all")
			{
			}
			else
			{
				$the_here_query = $the_here_query . " AND user_id = '" . $_SESSION['userID_select'] . "'";
			}
			
			if($_SESSION['search_user_id'] == "")
			{
			}
			else
			{
				$the_here_query = $the_here_query . $_SESSION['search_user_id'];
			}
			
			
			$the_here_query = $the_here_query . ";";
			
			//echo "<br/>" . $the_here_query;
			
			$sql = mysql_query($the_here_query);

			try
			{
					?>
				</br>
				</br>
					<table class="ep_tm_main"><tr><td align="left">
					<h1 class="ep_tm_pagetitle"><?php echo "PATIENT STENTS";?> </h1>

			<div>
				<table id="patient_stents" class="display nowrap table table-striped" style="width: 100%">
					<thead>
						<tr>
							<td><strong>No</strong></td> 
							<td><strong>Patient:</strong></td> 
							<td><strong>Patient ID:</strong></td> 
							<td><strong>pH:</strong></td> 
							<td><strong>Total Check Ups Registered:</strong></td>
							<td><strong>Total Check Ups Completed:</strong></td>		
							<td><strong>Program:</strong></td>					
							<td><strong>Duration:</strong></td>					
							<td><strong>Year:</strong></td>					
							<td><strong>Age:</strong></td>			
							<td><strong>Cost:</strong></td>					
							<td><strong>Registered Status:</strong></td>
							<td><strong>Left Stent:</strong></td>
							<td><strong>Right Stent:</strong></td>				
							<td><strong>Check Up:</strong></td>					
							<td><strong>Evaluation Form Received:</strong></td>					
							<td><strong>Payment Received:</strong></td>					
						</tr>
					</thead>	
					<?php
					
				if(!empty($sql))
				{	
				while($row = mysql_fetch_assoc($sql))
				{			
					//$row_Val = $row["symptoms"];
					//$row_Val2 = $row["diagnose"];
					//$_SESSION['cfglobal'] = $row["CF"];
					
					
					$student_id = $row["student_id"];
					$student_user_id = $row["user_id"];
					$registered = $row["registered"];
					$AttendanceStudent = $row["Attendance"];
					$Evaluationform = $row["Evaluationform"];
					$No = $row["courses"];
					$Paid = $row["Paid"];
					$Paid_Date = $row["Paid_Date"];
					$Paid_Number = $row["Paid_Number"];
					$Left_Stent = $row["Left_Stent"];
					$Right_Stent = $row["Right_Stent"];

					
					$theRegisteredCredits = getCreditsRegistered($student_user_id, "false");
					$theCompletedCredits = getCreditsCompleted($student_user_id, "false");
					
					$sql_mini = mysql_query("SELECT * FROM seru_courses WHERE No = '" . $No . "';");
					
					if(!empty($sql_mini))
					{	
						while($row = mysql_fetch_assoc($sql_mini))
						{
							$row_Val = $row["Programmes"];
					
					
							$Programmes = $row["Programmes"];
							$Date = $row["Date"];
							$Year = $row["Year"];
							$active = $row["active"];
							$Credits = $row["Credits"];
							$Attendance = $row["Attendance"];
							$Cost = $row["Cost"];
						}//end while($row = mysql_fetch_assoc($sql_mini))
					}//end if(!empty($sql_mini))
					
						//echo "<br/>ATTENDANCE IS " . $Attendance;
						
					if($Attendance < 0 || $Attendance == null)
					{
						$Attendance = 0;
					}
					
					$totalNumberOfAttendanceSlots = $Attendance;
					
					$_SESSION["Attendance" . $my_little_counter] = $Attendance;
					
					$sql_mini = mysql_query("SELECT * FROM users WHERE user_id = '" . $student_user_id . "';");
					
					
					if(!empty($sql_mini))
					{	
						while($row = mysql_fetch_assoc($sql_mini))
						{
							$studentName = $row["first_name"];
							$studentName = $studentName . " " . $row["last_name"];
							$CGPA = $row["CGPA"];
							$Matric_Number = $row["Matric_Number"];
						}//end while($row = mysql_fetch_assoc($sql_mini))
					}//end if(!empty($sql_mini))
					
					
					$_SESSION["registeredOri" . $my_little_counter] = $registered;
					$_SESSION["student_id" . $my_little_counter] = $student_id;
					$_SESSION["student_user_id" . $my_little_counter] = $student_user_id;
					$_SESSION["AttendanceOri" . $my_little_counter] = $AttendanceStudent;
					$_SESSION["Evaluationform" . $my_little_counter] = $Evaluationform;
					$_SESSION["Paid" . $my_little_counter] = $Paid;
					$_SESSION["Paid_Date" . $my_little_counter] = $Paid_Date;
					$_SESSION["Paid_DateORI" . $my_little_counter] = $Paid_Date;
					$_SESSION["Paid_Number" . $my_little_counter] = $Paid_Number;
					$_SESSION["Paid_NumberORI" . $my_little_counter] = $Paid_Number;
			/*
			echo "<br/>TEST LAST = " . $Date . "=   ";
			echo "<br/>TEST LAST = " . $Year . "=   ";
			echo "<br/>TEST LAST = " . $registered . "=   ";
			echo "<br/>TEST LAST = " . $Credits . "=   ";
			/**/
					
					
					$my_little_counter_disp = $my_little_counter + 1;
					
					$count_ = $my_little_counter_disp;
					
					
											if(($count_ % 2) == 1)
											{
												$color = "#e6e6fa";
											}
											else
											{
												$color = "#ffffff";
											}
											
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $my_little_counter_disp .  "</td>\r\n";
					
					$_SESSION["No" . $my_little_counter] = $No;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $studentName .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Matric_Number .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $CGPA .  "</td>\r\n";
					
					$_SESSION["studentName" . $my_little_counter] = $studentName;
					
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $theRegisteredCredits .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $theCompletedCredits .  "</td>\r\n";
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Programmes .  "</td>\r\n";
					
					$_SESSION["Programmes" . $my_little_counter] = $Programmes;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Date .  "</td>\r\n";
					
					$_SESSION["Date" . $my_little_counter] = $Date;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Year .  "</td>\r\n";
					
					$_SESSION["Year" . $my_little_counter] = $Year;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Credits .  "</td>\r\n";
					
					$_SESSION["Credits" . $my_little_counter] = $Credits;
					
					echo "<td bgcolor=\"".$color."\" width=\"2%\">" . $Cost .  "</td>\r\n";
					
					?>				
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					<!Multi Select!>
					<select name = "<?php echo "registered" . $my_little_counter;?>" id = "<?php echo "registered" . $my_little_counter;?>">
					<?php
					if($registered == "incomplete")
					{
						?>
						<option value = "incomplete" selected = "selected">INCOMPLETE</option>
						<option value = "registered">REGISTER</option>
						<option value = "completed">COMPLETED</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<?php
					}
					else if($registered == "registered")
					{
						?>
						<option value = "registered" selected = "selected">REGISTERED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<?php
					}
					else if($registered == "unregistered")
					{
						?>
						<option value = "unregistered" selected = "selected">DROPPED</option>
						<option value = "registered">REGISTERED</option>
						<option value = "notregistered">NOT REGISTERED</option>
						<option value = "completed">COMPLETED</option>
						<option value = "incomplete">INCOMPLETE</option>
						<?php
					}
					else if($registered == "completed")
					{
						?>
						<option value = "completed" selected = "selected">COMPLETED</option>
						<option value = "registered">REGISTERED</option>
						<?php
					}
					
					?>
					</select>
					</td><?php echo "\r\n"; ?>
					
					<td bgcolor=" <?php echo "". $color;?>" width="3%"> <!-- left Stent -->
						
						<select>
						  <option value="zero0">0</option>
						  <option value="one1">1</option>
						  <option value="two2">2</option>
						  <option value="three3">3</option>
						  <option value="four4">4</option>
						  <option value="five5">5</option>
						  <option value="six6">6</option>
						  <option value="seven7">7</option>
						  <option value="eight8">8</option>
						  <option value="nine9">9</option>
						  <option value="ten10">10</option>
						</select>
				
					</td><?php echo "\r\n"; ?>

					<td bgcolor=" <?php echo "". $color;?>" width="3%"> <!-- Right Stent -->
						<select>
						  <option value="zero0">0</option>
						  <option value="one1">1</option>
						  <option value="two2">2</option>
						  <option value="three3">3</option>
						  <option value="four4">4</option>
						  <option value="five5">5</option>
						  <option value="six6">6</option>
						  <option value="seven7">7</option>
						  <option value="eight8">8</option>
						  <option value="nine9">9</option>
						  <option value="ten10">10</option>
						</select>
					
					</td><?php echo "\r\n"; ?>

					<td bgcolor=" <?php echo "". $color;?>" width="3%">
					<?php
					
					$my_little_counter_Attendance = 1;
					
					$actualNumberOfAttendanceSlots = 0;
					
					while($my_little_counter_Attendance <= $_SESSION["Attendance" . $my_little_counter])
					{
						if($my_little_counter_Attendance ==1)
						{
							//echo "<br/>";
						}
						
						if($registered == "completed" || $registered == "incomplete")
						{	
						}
						else
						{
					?>
					
							<!Checkbox!>
						
							<label for="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>">   CHECK UP <?php echo "" . $my_little_counter_Attendance;?></label>
					<?php
						}
						$AttendanceArray = explode(";" , $_SESSION["AttendanceOri" . $my_little_counter]);
						$AttendanceArrayCount = 0;
						
						//echo "<br/>my_little_counter_Attendance = " . $my_little_counter_Attendance;
						//echo "<br/>AttendanceStudent = " . $AttendanceStudent;
						if($AttendanceArray[$my_little_counter_Attendance - 1])
						{
							//echo "<br/>AttendanceArray[" . $my_little_counter_Attendance ."] = " . $AttendanceArray[$my_little_counter_Attendance - 1];
							if(preg_match("/" . $AttendanceArray[$my_little_counter_Attendance - 1] . "/i" , "1") == 1)
							{
								$AttendanceArrayCount = 1;
							}
						}
						
						
							if($AttendanceArrayCount == 1)
							{
								$actualNumberOfAttendanceSlots++;
								
						if($registered == "completed" || $registered == "incomplete")
						{
							?>
		
								<input type="checkbox" name="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" id="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" value="true" checked="checked" style="display:none"/>
							<?php
						}
						else
						{
							?>
						
								<input type="checkbox" name="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" id="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" value="true" checked="checked"/>
							<?php
						}
							}
							else
							{
						if($registered == "completed" || $registered == "incomplete")
						{
							?>
								<input type="checkbox" name="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" id="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" value="true " style="display:none"/>
							<?php
						}
						else
						{
							?>
								<input type="checkbox" name="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" id="<?php echo $my_little_counter_Attendance . "Attendance" . $my_little_counter;?>" value="true"/>
							<?php
						}
							}
						
						$my_little_counter_Attendance++;
					}//end while($my_little_counter_Attendance < $_SESSION["Attendance" . $my_little_counter])
						
					
					echo "<br/><br/>TOTAL CHECKUPS: " . $actualNumberOfAttendanceSlots . "/" . $totalNumberOfAttendanceSlots;
					?>
				
					
					</td><?php echo "\r\n"; ?>
					
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					
						<!Checkbox!>
						<label for="<?php echo "EvaluationFormReceived" . $my_little_counter;?>">   Evaluation form Received </label>
						<?php
						if($Evaluationform == 1)
						{
						?>
							<input type="checkbox" name="<?php echo "EvaluationFormReceived" . $my_little_counter;?>" id="<?php echo "EvaluationFormReceived" . $my_little_counter;?>" value="true" checked="checked"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="<?php echo "EvaluationFormReceived" . $my_little_counter;?>" id="<?php echo "EvaluationFormReceived" . $my_little_counter;?>" value="true" />
						<?php
						}
						?>
					
					</td><?php echo "\r\n"; ?>
					
					
					<td bgcolor=" <?php echo "". $color;?>" width="2%">
					
						<!Checkbox!>
						<label for="<?php echo "Paid" . $my_little_counter;?>"><?php echo "   Payment Received :<br/>" . $Paid_Date;?></label>
						<?php
						if($Paid == 1)
						{
						?>
							<input type="checkbox" name="<?php echo "Paid" . $my_little_counter;?>" id="<?php echo "Paid" . $my_little_counter;?>" value="true" checked="checked"/>
						<?php
						}
						else
						{
						?>
							<input type="checkbox" name="<?php echo "Paid" . $my_little_counter;?>" id="<?php echo "Paid" . $my_little_counter;?>" value="true" />
						<?php
						}
						?>
						<input type="text" name="<?php echo "Paid_Number" . $my_little_counter;?>" id="<?php echo "Paid_Number" . $my_little_counter;?>" value="<?php echo "" . $_SESSION["Paid_Number" . $my_little_counter];?>" />
					
					
					<br/>
					<br/>
					<input class="button2 p5 width90" type = "submit" name = "submit" value = "Submit" />
					
					</td><?php echo "\r\n"; ?>
					
					
					<?php
										
					
					//echo "User ".$row_Val . "<br/>";
					$my_little_counter++;
					$_SESSION['counterMax'] = $my_little_counter;
					
					echo "</tr>\r\n";
				}//end while($row = mysql_fetch_assoc($sql))
				}
				else
				{
					echo "EMPTY...";
				}
				
				?>
				</td></tr></table>
			</div>
				<?php

			}
			catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
			
   }//end function accessRulesDisp()
   
   
   
   
   function updateUsers($my_little_counter)
   {		
		global $No;
		global $Programmes;
		global $Date;
		global $Year;
		global $registered;
		global $Credits;
		global $Attendance;
		global $AttendanceStudent;
		global $Evaluationform;
		global $student_id;
		global $Paid;
		global $Paid_Date;
		global $Paid_Number;
		global $mainMessage;
		
		$theQueryToExecute = "";
		
 			
			
			$No = $_SESSION["No" . $my_little_counter];
			$Programmes = $_SESSION["Programmes" . $my_little_counter];
			$Date = $_SESSION["Date". $my_little_counter];
			$Year = $_SESSION["Year". $my_little_counter];
			$Credits = $_SESSION["Credits". $my_little_counter];
			$registered = $_POST["registered". $my_little_counter];
			$student_id = $_SESSION["student_id" . $my_little_counter];
			$hereUser_ID = $_SESSION["student_user_id" . $my_little_counter];
			$AttendanceStudent = $_SESSION["AttendanceOri" . $my_little_counter];
			$Evaluationform = $_SESSION["Evaluationform" . $my_little_counter];
			$Paid = $_SESSION["Paid" . $my_little_counter];
			$Paid_Date = $_SESSION["Paid_Date" . $my_little_counter];
			$Paid_Number = $_SESSION["Paid_Number" . $my_little_counter];
			/*
			echo "<br/>LAST Programmes= " . $Programmes . "=   ";
			echo "<br/>LAST No= " . $No . "=   ";
			echo "<br/>LAST Date= " . $Date . "=   ";
			echo "<br/>LAST Year= " . $Year . "=   ";
			echo "<br/>LAST registered= " . $registered . "=   ";
			echo "<br/>LAST Credits= " . $Credits . "=   ";
			
			/**/
			
			/*//TO PREVENT FORM FROM BEING UPDATED IF EVALUATION FORM HAS NOT BEEN SUBMITTED
			if($registered == "completed")
			{
				if($Evaluationform != 1)
				{
					$registered = "registered";
					echo "<br/>Student cannot be listed as COMPLETED course until evaluation form has been submitted.";
				}
			}
			/**/
 
			if($Programmes == "")
			{
				echo "<br/>Programmes cannot be NULL";
			}
			else if($Date == "")
			{
				echo "<br/>Date cannot be NULL";
			}
			else if($Year == "")
			{
				echo "<br/>Year cannot be NULL";
			}
			else if($Credits == "")
			{
				echo "<br/>registered cannot be NULL";
			}
			else
			{
				if($student_id == -100)
				{
					$student_id = getMaxStudentID() + 1;
					$theQueryToExecute = "INSERT INTO `seru_students`.`students`".
										" (`student_id`, `user_id`, `courses`, ".
										"`registered`, `credits`, `Attendance`, `Evaluationform`, `Paid`, `Paid_Date`, `Paid_Number`) ".
										"VALUES ('" . $student_id . "', '" . $hereUser_ID . "', '" . $No . "', ".
										"'" . $registered . "', '" . $Credits . "', '" . $AttendanceStudent . "', " .
										"'" . $Evaluationform . "', '" . $Paid . "', '" . $Paid_Date . "', '" . $Paid_Number . "');";
					//echo "<br/>" . $theQueryToExecute;
										
					$sql = mysql_query($theQueryToExecute);
					
										
					if($sql == null)
					{
						echo "<br/><br/>";
						?>
						<h1><font color="red">could not add <?php echo "" . $mainMessage;?></font></h1>
						<?php
					}
					else
					{
						echo "<br/>";
						?>
						<h1><font color="red">NEW <?php echo "" . $mainMessage;?> ADDED</font></h1>
						<?php
					}
				}//end if($student_id == -100)
				else
				{	
					$theQueryToExecute = "UPDATE students SET registered = '". $registered .
																"', credits = '". $Credits .
																"', Attendance = '". $AttendanceStudent .
																"', Evaluationform = '". $Evaluationform .
																"', Paid = '". $Paid .
																"', Paid_Date = '". $Paid_Date .
																"', Paid_Number = '". $Paid_Number .
																"' WHERE student_id = '" . $student_id . 
																"' AND user_id = '" . $hereUser_ID . 
																"' AND courses = '" . $No . "';";
																
					//echo "<br/>" . $theQueryToExecute . "<br/>";
					
					$sql = mysql_query($theQueryToExecute);
											
					if($sql == null)
					{
						echo "<br/><br/>";
						?>
						<h1><font color="red">could not update <?php echo "" . $mainMessage;?></font></h1>
						<?php
					}
					else
					{
						echo "<br/>";
						?>
						<h1><font color="red"><?php echo "" . $mainMessage;?> UPDATED</font></h1>
						<?php
					}
				}//end else for if($sqlTest == null)
			}
			
			getCreditsRegistered($hereUser_ID, "true");
			getCreditsCompleted($hereUser_ID, "true");
   }//end function updateUsers()
   
   
	function getMaxUserID()
	{
			$finalcounter = 0;
			$sql = mysql_query("SELECT * FROM seru_courses");
			
			try
			{
				if(!empty($sql))
				{	
					$_SESSION['numIDMax'] = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["No"];
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
	
	function getMaxStudentID()
	{
			$finalcounter = 0;
			$maxID = 0;
			$sql = mysql_query("SELECT * FROM students");
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter= $row["student_id"];
						if($finalcounter > $maxID)
						{
							$maxID = $finalcounter;
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
			
			return $maxID;
	}//end function getMaxStudentID()
	
		
	function getLatestCourseID()
	{
			$finalcounter = 0;
			$maxID = 0;
			$theCurrentCourse = "internship";
			$TheLastCourse = "internship";
			$sql = mysql_query("SELECT * FROM seru_courses WHERE date != 'DELETED'");
			
			try
			{
				if(!empty($sql))
				{	
					$maxID = 0;
					while($row = mysql_fetch_assoc($sql))
					{			
						$finalcounter = $row["No"];
						$theCurrentCourse = $row["Programmes"];
						if($finalcounter > $maxID)
						{
							$maxID = $finalcounter;
							$TheLastCourse = $theCurrentCourse;
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
			
			return $TheLastCourse;
	}//end function getLatestCourseID()
	
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
    		$('#patient_stents').DataTable( {
        		"scrollX": true
    			} );
			} );
		</script>
</html>